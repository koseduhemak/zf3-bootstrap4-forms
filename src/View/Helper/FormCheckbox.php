<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\Element\Checkbox;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Checkbox as CheckboxElement;
use Zend\Form\Exception;
use Zend\Form\View\Helper\FormLabel;
use Zend\Form\View\Helper\FormRow;

class FormCheckbox extends \Zend\Form\View\Helper\FormCheckbox
{
    protected $labelHelper;

    public function render(ElementInterface $element)
    {
        if (!preg_match('/(^|[^a-z]+)form-check-input($|[^a-z-]+)/i', $element->getAttribute('class'))) {
            $element->setAttribute('class', trim('form-check-input '.$element->getAttribute('class')));
        }

        $labelAtributes = $element->getOption('label_attributes') ?: [];
        if (!is_array($labelAtributes) || !array_key_exists('class', $labelAtributes) || !preg_match('/(^|[^a-z]+)form-check-label($|[^a-z-]+)/i', $labelAtributes['class'])) {
            $labelAtributes['class'] = array_key_exists('class', $labelAtributes) ? $labelAtributes['class'] : '';
            $labelAtributes["class"] = $labelAtributes['class'].trim(' form-check-label');
        }

        $elementMarkup = parent::render($element);

        $label = $this->getLabelHelper()->__invoke($element);

        /**
         * @SEE https://www.bootstraptoggle.com/
         * do only add form-check class if not toggler element.
         */
        if (!$element->getAttribute('data-toggle')) {
            $markup = '<div class="form-check">%s%s</div>';
        } else {
            $markup = '%s%s';
        }

        $markup = sprintf($markup, $elementMarkup, $label);

        return $markup;
    }

    /**
     * Retrieve the FormLabel helper
     * @return FormLabel
     */
    protected function getLabelHelper()
    {
        if ($this->labelHelper) {
            return $this->labelHelper;
        }
        if (method_exists($this->view, 'plugin')) {
            $this->labelHelper = $this->view->plugin('form_label');
        }
        if (!($this->labelHelper instanceof FormLabel)) {
            $this->labelHelper = new FormLabel();
        }
        if ($this->hasTranslator()) {
            $this->labelHelper->setTranslator($this->getTranslator(), $this->getTranslatorTextDomain());
        }
        return $this->labelHelper;
    }
}