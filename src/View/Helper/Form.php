<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\Element;
use Zend\Form\FormInterface;

class Form extends \Zend\Form\View\Helper\Form
{
    const LAYOUT_DEFAULT = 'default';
    const LAYOUT_HORIZONTAL = 'horizontal';
    const LAYOUT_FLOATING_LABLES = 'form-floating-labels';

    protected $layouts = [
        self::LAYOUT_DEFAULT,
        self::LAYOUT_FLOATING_LABLES,
        self::LAYOUT_HORIZONTAL
    ];

    public function __invoke(FormInterface $form = null, $type = null)
    {
        // render elemnts and fieldsets accordingly
        if (in_array($type, $this->layouts)) {
            // elements
            /** @var Element $element */
            foreach ($form->getElements() as $element) {
                $element->setOption('formLayout', $type);
            }

            // fieldsets
            foreach ($form->getFieldsets() as $fieldset) {
                $fieldset->setOption('formLayout', $type);
            }

            // add class to form
            if ($form->getAttributes('class')) {
                if (!preg_match('/(^| )'.preg_quote($type).'($| )/', $form->getAttribute('class'))) {
                    $form->setAttribute('class', trim($type.' '.$form->getAttribute('class')));
                }
            } else {
                $form->setAttribute('class', $type);
            }

            if ($type === static::LAYOUT_FLOATING_LABLES) {
                $this->getView()->headLink()->prependStylesheet('/css/form/main.css');
            }
        }

        return parent::__invoke($form);
    }

}