<?php

namespace Zf3Bootstrap4Forms;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'view_helpers' => [
        'factories' => [
            View\Helper\FormElement::class => InvokableFactory::class,
            View\Helper\FormButton::class => InvokableFactory::class
        ],
        'aliases' => [
            'formElement' => View\Helper\FormElement::class,
            'form_element' => View\Helper\FormElement::class,
            'formelement' => View\Helper\FormElement::class,

            'formButton' => View\Helper\FormButton::class,
            'form_button' => View\Helper\FormButton::class,
            'formbutton' => View\Helper\FormButton::class,
        ]
    ]
];
