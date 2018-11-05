<?php

namespace Zf3Bootstrap4Forms;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    const CONFIG_KEY = 'zf3-bootstrap4-forms';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
