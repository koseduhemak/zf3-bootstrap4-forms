<?php

namespace Zf3Bootstrap4Forms;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'view_helpers' => [
        'factories' => [
            View\Helper\Form::class => InvokableFactory::class,
            View\Helper\FormCollection::class => InvokableFactory::class,
            View\Helper\FormRow::class => InvokableFactory::class,
            View\Helper\FormRowHorizontal::class => InvokableFactory::class,
            View\Helper\FormElement::class => InvokableFactory::class,
            View\Helper\FormInput::class => InvokableFactory::class,
            View\Helper\FormLabel::class => InvokableFactory::class,
            View\Helper\FormErrors::class => InvokableFactory::class,
            View\Helper\FormElementErrors::class => InvokableFactory::class,
            View\Helper\FormSelect::class => InvokableFactory::class,
            View\Helper\FormButton::class => InvokableFactory::class,
            View\Helper\FormCheckbox::class => InvokableFactory::class,
            View\Helper\FormPassword::class => InvokableFactory::class,
            View\Helper\DateRange::class => InvokableFactory::class,
            View\Helper\Between::class => InvokableFactory::class,
        ],
        'aliases' => [
            'form' => View\Helper\Form::class,

            'formCollection' => View\Helper\FormCollection::class,
            'form_collection' => View\Helper\FormCollection::class,
            'formcollection' => View\Helper\FormCollection::class,

            'formRow' => View\Helper\FormRow::class,
            'form_row' => View\Helper\FormRow::class,
            'formrow' => View\Helper\FormRow::class,

            'formRowHorizontal' => View\Helper\FormRowHorizontal::class,
            'form_row_horizontal' => View\Helper\FormRowHorizontal::class,
            'formrowhorizontal' => View\Helper\FormRowHorizontal::class,

            'formElement' => View\Helper\FormElement::class,
            'form_element' => View\Helper\FormElement::class,
            'formelement' => View\Helper\FormElement::class,

            'formInput' => View\Helper\FormInput::class,
            'form_input' => View\Helper\FormInput::class,
            'forminput' => View\Helper\FormInput::class,

            'formLabel' => View\Helper\FormLabel::class,
            'form_label' => View\Helper\FormLabel::class,
            'formlabel' => View\Helper\FormLabel::class,

            'formErrors' => View\Helper\FormErrors::class,
            'form_errors' => View\Helper\FormErrors::class,
            'formerrors' => View\Helper\FormErrors::class,

            'formElementErrors' => View\Helper\FormElementErrors::class,
            'form_element_errors' => View\Helper\FormElementErrors::class,
            'formelementerrors' => View\Helper\FormElementErrors::class,

            'formSelect' => View\Helper\FormSelect::class,
            'form_select' => View\Helper\FormSelect::class,
            'formselect' => View\Helper\FormSelect::class,

            'formButton' => View\Helper\FormButton::class,
            'form_button' => View\Helper\FormButton::class,
            'formbutton' => View\Helper\FormButton::class,

            'formSubmit' => View\Helper\FormButton::class,
            'form_submit' => View\Helper\FormButton::class,
            'formsubmit' => View\Helper\FormButton::class,

            'formCheckbox' => View\Helper\FormCheckbox::class,
            'form_checkbox' => View\Helper\FormCheckbox::class,
            'formcheckbox' => View\Helper\FormCheckbox::class,

            'formPassword' => View\Helper\FormPassword::class,
            'form_password' => View\Helper\FormPassword::class,
            'formpassword' => View\Helper\FormPassword::class,

            'form_date_range' => View\Helper\DateRange::class,
            'formDateRange' => View\Helper\DateRange::class,
            'formdaterange' => View\Helper\DateRange::class,

            'form_between' => View\Helper\Between::class,
            'formBetween' => View\Helper\Between::class,
            'formbetween' => View\Helper\Between::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../assets',
            ],
        ],
    ],
];
