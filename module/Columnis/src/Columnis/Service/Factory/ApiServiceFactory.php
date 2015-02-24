<?php

namespace Columnis\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Cache\StorageFactory;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Cache\Zf2CacheAdapter;
use Columnis\Exception\Api\ClientNumberNotSetException;
use Columnis\Exception\Api\ApiBaseUrlNotSetException;
use Columnis\Service\ApiService;

class ApiServiceFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     *
     * @return ApiService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        
        $columnisConfig = isset($config['columnis']) ? $config['columnis'] : array();

        $apiConfig = isset($columnisConfig['api_settings']) ? $columnisConfig['api_settings'] : array();
        
        if (!isset($apiConfig['client_number'])) {
            throw new ClientNumberNotSetException("There is no client_number set in local.php config file.");
        }
        if (!isset($apiConfig['api_base_url'])) {
            throw new ApiBaseUrlNotSetException("There is no api_base_url set in local.php config file.");
        }
        
        $clientNumber = $apiConfig['client_number'];
        $apiUrl = $apiConfig['api_base_url'];
        $httpClient = new GuzzleClient($apiUrl);
        
        $cacheConfig = isset($config['guzzle_cache']) ? $config['guzzle_cache'] : array();
        if (isset($cacheConfig['adapter'])) {
            $cache = StorageFactory::factory($cacheConfig);
            $adapter = new Zf2CacheAdapter($cache);
            $cachePlugin = new CachePlugin($adapter);
            $httpClient->addSubscriber($cachePlugin);
        }
        
        return new ApiService($httpClient, $clientNumber);
    }
}
