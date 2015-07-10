<?php

namespace Columnis\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Columnis\Service\PageBreakpointService;
use \Smarty;

class PageBreakpointServiceFactory implements FactoryInterface {

    /**
     * {@inheritDoc}
     *
     * @return PageBreakpointService
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $smarty = new Smarty();
        $templatesPathStack = array();
        $AssetsManagerPaths = array();

        $config = $serviceLocator->get('Config');

        if(isset($config['view_manager']['template_path_stack'])) {
            $templatesPathStack = $config['view_manager']['template_path_stack'];
        }

        if(isset($config['asset_manager']['resolver_configs']['paths'])) {
            $AssetsManagerPaths = $config['asset_manager']['resolver_configs']['paths'];
        }
        return new PageBreakpointService($smarty, $templatesPathStack, $AssetsManagerPaths);
    }
}
