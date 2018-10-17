<?php

namespace Zf3Bootstrap4Forms;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'view_helpers' => [
        'factories' => [
            View\Helper\FormElement::class => InvokableFactory::class,
            View\Helper\FormButton::class => InvokableFactory::class,
            View\Helper\DateRange::class => InvokableFactory::class,
            View\Helper\Between::class => InvokableFactory::class,
        ],
        'aliases' => [
            'formElement' => View\Helper\FormElement::class,
            'form_element' => View\Helper\FormElement::class,
            'formelement' => View\Helper\FormElement::class,

            'formButton' => View\Helper\FormButton::class,
            'form_button' => View\Helper\FormButton::class,
            'formbutton' => View\Helper\FormButton::class,

            'form_date_range' => View\Helper\DateRange::class,
            'formDateRange' => View\Helper\DateRange::class,
            'formdaterange' => View\Helper\DateRange::class,

            'form_between' => View\Helper\Between::class,
            'formBetween' => View\Helper\Between::class,
            'formbetween' => View\Helper\Between::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
    ]
];
