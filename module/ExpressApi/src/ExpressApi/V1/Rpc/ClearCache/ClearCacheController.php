<?php

namespace ExpressApi\V1\Rpc\ClearCache;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class ClearCacheController extends AbstractActionController
{
    private array $dirsWhiteList = [
        'api',
        'module',
    ];

    public function clearCacheAction()
    {
        $params = $this->bodyParams();
        $dirs = $params['dir'] ?? '';
        $dirs = is_string($dirs) ? explode(';', $dirs) : [];

        // Ensure public_html/pages is always included
        $dirs[] = 'public_html/pages';

        $result = ['success' => true];

        foreach ($dirs as $dir) {
            $cacheDir = $this->resolveCacheDir($dir);

            if (!$cacheDir) {
                return new ApiProblemResponse(
                    new ApiProblem(400, "The dir '$dir' is not allowed.")
                );
            }

            if (!$this->clearCacheDir($cacheDir)) {
                $result['success'] = false;
            }
        }

        return $result;
    }

    private function resolveCacheDir(string $dir): ?string
    {
        if ($dir === 'public_html/pages') {
            return realpath(__DIR__ . '/../../../../../../../public_html/pages/');
        }

        if (in_array($dir, $this->dirsWhiteList, true)) {
            return $this->getCacheDir() . DIRECTORY_SEPARATOR . $dir;
        }

        return null;
    }

    private function getCacheDir(): string
    {
        return realpath(__DIR__ . '/../../../../../../../data/cache/') ?: '';
    }

    private function clearCacheDir(string $cacheDir): bool
    {
        if (!is_dir($cacheDir)) {
            return false;
        }

        $dirContent = array_diff(scandir($cacheDir) ?: [], ['.', '..']);

        foreach ($dirContent as $cacheNode) {
            $cacheRealPath = $cacheDir . DIRECTORY_SEPARATOR . $cacheNode;

            if (is_dir($cacheRealPath)) {
                if (!$this->deleteFolder($cacheRealPath)) {
                    return false;
                }
            } else {
                if (!unlink($cacheRealPath)) {
                    return false;
                }
            }
        }

        return true;
    }

    private function deleteFolder(string $dir): bool
    {
        $files = array_diff(scandir($dir) ?: [], ['.', '..']);

        foreach ($files as $file) {
            $filePath = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                if (!$this->deleteFolder($filePath)) {
                    return false;
                }
            } else {
                if (!unlink($filePath)) {
                    return false;
                }
            }
        }

        return rmdir($dir);
    }
}
