<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\LabelAwareInterface;
use Zend\Form\View\Helper\FormLabel;

class FormCheckbox extends \Zend\Form\View\Helper\FormCheckbox
{
    protected $labelHelper;

    public function render(ElementInterface $element)
    {
        if (! preg_match('/(^|[^a-z]+)form-check-input($|[^a-z-]+)/i', $element->getAttribute('class'))) {
            $element->setAttribute('class', trim('form-check-input ' . $element->getAttribute('class')));
        }

        if ($element instanceof LabelAwareInterface) {
            $labelAttributes = $element->getLabelAttributes();
            if (array_key_exists('class', $labelAttributes)) {
                if (!preg_match('/(^|[^a-z]+)form-check-label($|[^a-z-]+)/i', $labelAttributes['class'])) {
                    $labelAttributes['class'] = $labelAttributes['class'] . ' form-check-label';
                }
            } else {
                $labelAttributes['class'] = 'form-check-label';
            }
            $element->setLabelAttributes($labelAttributes);
        }

        $elementMarkup = parent::render($element);

        $label = $this->getLabelHelper()->__invoke($element);

        /**
         * @SEE https://www.bootstraptoggle.com/
         * do only add form-check class if not toggler element.
         */
        if (! $element->getAttribute('data-toggle')) {
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
        if (! ($this->labelHelper instanceof FormLabel)) {
            $this->labelHelper = new FormLabel();
        }
        if ($this->hasTranslator()) {
            $this->labelHelper->setTranslator($this->getTranslator(), $this->getTranslatorTextDomain());
        }

        return $this->labelHelper;
    }
}
