<?php

namespace ExpressApi\V1\Rpc\GenerateConfig;

use Zend\Mvc\Controller\AbstractActionController;

class GenerateConfigController extends AbstractActionController {

    const CLIENT_ID = 'express';

    public function generateConfigAction() {
        $params = $this->bodyParams();
        $configDir = $this->getConfigurationPath();
        $configFile = $configDir.'local.php';
        $response = array(
            'success' => false
        );
        $dbName = $this->getParam($params, 'dbname');
        $dbUser = $this->getParam($params, 'dbuser');
        $dbPassword = $this->getParam($params, 'dbpassword');
        $clientCode = $this->getParam($params, 'client_number');
        $apiBaseUrl = $this->getParam($params, 'api_base_url');
        $apiVersion = $this->getParam($params, 'api_version');
        if(!file_exists($configFile)) {
            $replaces = array(
                '<%client_number%>' => $clientCode,
                '<%api_base_url%>' => $apiBaseUrl,
                '<%api_version%>' => $apiVersion,
                '<%db_name%>' => $dbName,
                '<%db_user%>' => $dbUser,
                '<%db_password%>' => $dbPassword
            );
            $generateConfig = new GenerateConfig($configFile, $replaces);
            $response['success'] = $generateConfig->generate();
        }
        return $response;
    }

    private function getConfigurationPath() {
        return __DIR__.'/../../../../../../../config/autoload/';
    }

    private function getParam(Array $params, $key) {
        if(array_key_exists($key, $params)) {
            return $params[$key];
        }
        return '';
    }
}
