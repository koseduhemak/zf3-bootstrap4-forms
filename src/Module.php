<?php

namespace Zf3Bootstrap4Forms;



class Module implements ConfigProviderInterface, BootstrapListenerInterface
{
    const CONFIG_KEY = 'zf3-bootstrap4-forms';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
