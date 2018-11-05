<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\ElementInterface;

class FormPassword extends \Zend\Form\View\Helper\FormPassword
{
    public function __construct()
    {
        // add minlength attribute to valid attributes
        $this->validTagAttributes = array_merge($this->validTagAttributes, [
            'minlength' => true
        ]);
    }
}