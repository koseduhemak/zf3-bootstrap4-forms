<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\Element;
use Zend\Form\ElementInterface;
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
            /*if ($form->getAttributes('class')) {
                if (!preg_match('/(^| )'.preg_quote($type).'($| )/', $form->getAttribute('class'))) {
                    $form->setAttribute('class', trim($type.' '.$form->getAttribute('class')));
                }
            } else {
                $form->setAttribute('class', $type);
            }*/

            $form = $this->addClass($form, $type);

            if ($type === static::LAYOUT_FLOATING_LABLES) {
                $this->getView()->headLink()->prependStylesheet('/css/form/main.css');
            }
        }

        return parent::__invoke($form);
    }

    protected function addClass(ElementInterface $element, $class)
    {
        // add class to form
        if ($element->getAttributes('class')) {
            if (!preg_match('/(^| )'.preg_quote($class).'($| )/', $element->getAttribute('class'))) {
                $element->setAttribute('class', trim($class.' '.$element->getAttribute('class')));
            }
        } else {
            $element->setAttribute('class', $class);
        }

        return $element;
    }
}