<?php

namespace Columnis\Model;

use Exception;
use GlobIterator;
use Zend\Cache\Exception\RuntimeException;
use Zend\Cache\Storage\Adapter\Filesystem;
use Zend\Cache\Storage\Adapter\FilesystemOptions;
use Zend\Cache\Storage\Adapter\FilesystemIterator;
use ArrayObject;

class HtmlCache extends Filesystem
{
    protected string $extension = '.html';

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    public function setOptions($options)
    {
        if (!$options instanceof FilesystemOptions) {
            $options = new FilesystemOptions($options);
        }

        return parent::setOptions($options);
    }

    public function getOptions(): FilesystemOptions
    {
        if (!$this->options) {
            $this->setOptions(new FilesystemOptions());
        }
        return $this->options;
    }

    public function flush(): bool
    {
        $flags = GlobIterator::SKIP_DOTS | GlobIterator::CURRENT_AS_PATHNAME;
        $dir = $this->getOptions()->getCacheDir();

        $clearFolder = function (string $dir) use (&$clearFolder, $flags): void {
            $it = new GlobIterator($dir . DIRECTORY_SEPARATOR . '*', $flags);
            foreach ($it as $pathname) {
                if (is_dir($pathname)) {
                    $clearFolder($pathname);
                    rmdir($pathname);
                } else {
                    unlink($pathname);
                }
            }
        };

        try {
            $clearFolder($dir);
        } catch (Exception $e) {
            throw new RuntimeException("Flushing directory '{$dir}' failed", 0, $e);
        }

        return true;
    }

    public function clearExpired(): bool
    {
        $options = $this->getOptions();
        $namespace = $options->getNamespace();
        $prefix = ($namespace === '') ? '' : $namespace . $options->getNamespaceSeparator();

        $flags = GlobIterator::SKIP_DOTS | GlobIterator::CURRENT_AS_FILEINFO;
        $path = $options->getCacheDir()
            . str_repeat(DIRECTORY_SEPARATOR . $prefix . '*', $options->getDirLevel())
            . DIRECTORY_SEPARATOR . $prefix . '*' . $this->getExtension();
        $glob = new GlobIterator($path, $flags);
        $time = time();
        $ttl = $options->getTtl();

        try {
            foreach ($glob as $entry) {
                $mtime = $entry->getMTime();
                if ($time >= $mtime + $ttl) {
                    $pathname = $entry->getPathname();
                    unlink($pathname);

                    $tagPathname = substr($pathname, 0, -4) . '.tag';
                    if (file_exists($tagPathname)) {
                        unlink($tagPathname);
                    }
                }
            }
        } catch (Exception $e) {
            $result = false;
            return $this->triggerException(
                __FUNCTION__,
                new ArrayObject(),
                $result,
                new RuntimeException('Failed to clear expired items', 0, $e)
            );
        }

        return true;
    }

    public function clearByTags(array $tags, $disjunction = false): bool
    {
        if (empty($tags)) {
            return true;
        }

        $tagCount = count($tags);
        $options = $this->getOptions();
        $namespace = $options->getNamespace();
        $prefix = ($namespace === '') ? '' : $namespace . $options->getNamespaceSeparator();

        $flags = GlobIterator::SKIP_DOTS | GlobIterator::CURRENT_AS_PATHNAME;
        $path = $options->getCacheDir()
            . str_repeat(DIRECTORY_SEPARATOR . $prefix . '*', $options->getDirLevel())
            . DIRECTORY_SEPARATOR . $prefix . '*.tag';
        $glob = new GlobIterator($path, $flags);

        foreach ($glob as $pathname) {
            $diff = array_diff(
                $tags,
                explode("\n", $this->getFileContent($pathname))
            );

            $rem = $disjunction ? count($diff) < $tagCount : empty($diff);

            if ($rem) {
                unlink($pathname);

                $datPathname = substr($pathname, 0, -4) . $this->getExtension();
                if (file_exists($datPathname)) {
                    unlink($datPathname);
                }
            }
        }

        return true;
    }

    public function getIterator(): FilesystemIterator
    {
        $options = $this->getOptions();
        $namespace = $options->getNamespace();
        $prefix = ($namespace === '') ? '' : $namespace . $options->getNamespaceSeparator();
        $path = $options->getCacheDir()
            . str_repeat(DIRECTORY_SEPARATOR . $prefix . '*', $options->getDirLevel())
            . DIRECTORY_SEPARATOR . $prefix . '*' . $this->getExtension();
        return new FilesystemIterator($this, $path, $prefix);
    }

    protected function internalGetItem(&$normalizedKey, &$success = null, &$casToken = null)
    {
        if (!$this->internalHasItem($normalizedKey)) {
            $success = false;
            return null;
        }

        try {
            $filespec = $this->getFileSpec($normalizedKey);
            $data = $this->getFileContent($filespec . $this->getExtension());

            if (func_num_args() > 2) {
                $casToken = filemtime($filespec . $this->getExtension()) . filesize($filespec . $this->getExtension());
            }
            $success = true;
            return $data;
        } catch (Exception $e) {
            $success = false;
            throw $e;
        }
    }

    protected function internalGetItems(array &$normalizedKeys): array
    {
        $keys = $normalizedKeys;
        $result = [];
        while ($keys) {
            $nonBlocking = count($keys) > 1;
            $wouldblock = null;

            foreach ($keys as $i => $key) {
                if (!$this->internalHasItem($key)) {
                    unset($keys[$i]);
                    continue;
                }

                $filespec = $this->getFileSpec($key);
                $data = $this->getFileContent(
                    $filespec . $this->getExtension(),
                    $nonBlocking,
                    $wouldblock
                );
                if ($nonBlocking && $wouldblock) {
                    continue;
                }

                unset($keys[$i]);
                $result[$key] = $data;
            }
        }

        return $result;
    }

    protected function internalHasItem(&$normalizedKey): bool
    {
        $file = $this->getFileSpec($normalizedKey) . $this->getExtension();
        if (!file_exists($file)) {
            return false;
        }

        $ttl = $this->getOptions()->getTtl();
        if ($ttl) {
            $mtime = @filemtime($file);
            if ($mtime === false) {
                throw new RuntimeException("Error getting mtime of file '{$file}'");
            }

            if (time() >= ($mtime + $ttl)) {
                return false;
            }
        }

        return true;
    }

    public function getMetadata($key): array|bool
    {
        $options = $this->getOptions();
        if ($options->getReadable() && $options->getClearStatCache()) {
            clearstatcache();
        }

        return parent::getMetadata($key);
    }

    public function getMetadatas(array $keys, array $options = []): array
    {
        $options = $this->getOptions();
        if ($options->getReadable() && $options->getClearStatCache()) {
            clearstatcache();
        }

        return parent::getMetadatas($keys);
    }

    protected function internalGetMetadata(&$normalizedKey): array|bool
    {
        if (!$this->internalHasItem($normalizedKey)) {
            return false;
        }

        $options = $this->getOptions();
        $filespec = $this->getFileSpec($normalizedKey);
        $file = $filespec . $this->getExtension();

        $metadata = [
            'filespec' => $filespec,
            'mtime'    => filemtime($file)
        ];

        if (!$options->getNoCtime()) {
            $metadata['ctime'] = filectime($file);
        }

        if (!$options->getNoAtime()) {
            $metadata['atime'] = fileatime($file);
        }

        return $metadata;
    }

    protected function internalGetMetadatas(array &$normalizedKeys): array
    {
        $options = $this->getOptions();
        $result = [];

        foreach ($normalizedKeys as $normalizedKey) {
            $filespec = $this->getFileSpec($normalizedKey);
            $file = $filespec . $this->getExtension();

            $metadata = [
                'filespec' => $filespec,
                'mtime'    => filemtime($file),
            ];

            if (!$options->getNoCtime()) {
                $metadata['ctime'] = filectime($file);
            }

            if (!$options->getNoAtime()) {
                $metadata['atime'] = fileatime($file);
            }

            $result[$normalizedKey] = $metadata;
        }

        return $result;
    }

    protected function internalSetItem(&$normalizedKey, &$value): bool
    {
        $filespec = $this->getFileSpec($normalizedKey);
        $this->prepareDirectoryStructure($filespec);

        $wouldblock = null;
        $this->putFileContent(
            $filespec . $this->getExtension(),
            $value,
            true,
            $wouldblock
        );

        $this->unlink($filespec . '.tag');

        if ($wouldblock) {
            $this->putFileContent($filespec . $this->getExtension(), $value);
        }

        return true;
    }

    protected function internalSetItems(array &$normalizedKeyValuePairs): array
    {
        $contents = [];
        foreach ($normalizedKeyValuePairs as $key => &$value) {
            $filespec = $this->getFileSpec($key);
            $this->prepareDirectoryStructure($filespec);

            $contents[$filespec . $this->getExtension()] = &$value;

            $this->unlink($filespec . '.tag');
        }

        while ($contents) {
            $nonBlocking = count($contents) > 1;
            $wouldblock = null;

            foreach ($contents as $file => &$content) {
                $this->putFileContent($file, $content, $nonBlocking, $wouldblock);
                if (!$nonBlocking || !$wouldblock) {
                    unset($contents[$file]);
                }
            }
        }

        return [];
    }

    public function checkAndSetItem($token, $key, $value): bool
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            clearstatcache();
        }

        return parent::checkAndSetItem($token, $key, $value);
    }

    protected function internalCheckAndSetItem(&$token, &$normalizedKey, &$value): bool
    {
        if (!$this->internalHasItem($normalizedKey)) {
            return false;
        }

        $file = $this->getFileSpec($normalizedKey) . $this->getExtension();
        $check = filemtime($file) . filesize($file);
        if ($token !== $check) {
            return false;
        }

        return $this->internalSetItem($normalizedKey, $value);
    }

    public function touchItem($key): bool
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            clearstatcache();
        }

        return parent::touchItem($key);
    }

    public function touchItems(array $keys): array
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            clearstatcache();
        }

        return parent::touchItems($keys);
    }

    protected function internalTouchItem(&$normalizedKey): bool
    {
        if (!$this->internalHasItem($normalizedKey)) {
            return false;
        }

        $filespec = $this->getFileSpec($normalizedKey);

        if (!touch($filespec . $this->getExtension())) {
            throw new RuntimeException("Error touching file '{$filespec}.{$this->getExtension()}'");
        }

        return true;
    }

    public function removeItem($key): bool
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            clearstatcache();
        }

        return parent::removeItem($key);
    }

    public function removeItems(array $keys): array
    {
        $options = $this->getOptions();
        if ($options->getWritable() && $options->getClearStatCache()) {
            clearstatcache();
        }

        return parent::removeItems($keys);
    }

    protected function internalRemoveItem(&$normalizedKey): bool
    {
        $filespec = $this->getFileSpec($normalizedKey);
        if (!file_exists($filespec . $this->getExtension())) {
            return false;
        }

        $this->unlink($filespec . $this->getExtension());
        $this->unlink($filespec . '.tag');

        return true;
    }

    protected function getFileSpec($normalizedKey): string
    {
        $options = $this->getOptions();
//        $namespace = $options->getNamespace();
//        $prefix = ($namespace === '') ? '' : $namespace;
        $path = $options->getCacheDir() . DIRECTORY_SEPARATOR;
        return $path . $normalizedKey;
    }
}