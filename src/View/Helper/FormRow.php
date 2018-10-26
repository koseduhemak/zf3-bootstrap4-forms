<?php

namespace Zf3Bootstrap4Forms\View\Helper;


use Zend\Form\Element\Button;
use Zend\Form\Element\Captcha;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\MonthSelect;
use Zend\Form\Element\Submit;
use Zend\Form\ElementInterface;
use Zend\Form\LabelAwareInterface;

class FormRow extends \Zend\Form\View\Helper\FormRow
{
    protected $inputErrorClass = 'is-invalid';

    public function render(ElementInterface $element, $labelPosition = null)
    {
        if ($element instanceof Checkbox) {
            // default label to append
            $element->setLabelOption('label_position', $element->getLabelOption('label_position') ?: \Zend\Form\View\Helper\FormRow::LABEL_APPEND);
        }

        // get form layout
        $formLayout = $element->getOption('formLayout');

        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $labelHelper = $this->getLabelHelper();
        $elementHelper = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();

        $label = $element->getLabel();
        $inputErrorClass = $this->getInputErrorClass();

        if (is_null($labelPosition)) {
            $labelPosition = $this->labelPosition;
        }

        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
        }

        // Does this element have errors ?
        if ($element->getMessages() && $inputErrorClass) {
            $classAttributes = ($element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '');
            $classAttributes = $classAttributes . $inputErrorClass;

            $element->setAttribute('class', $classAttributes);
        }

        if ($this->partial) {
            $vars = [
                'element' => $element,
                'label' => $label,
                'labelAttributes' => $this->labelAttributes,
                'labelPosition' => $labelPosition,
                'renderErrors' => $this->renderErrors,
            ];

            return $this->view->render($this->partial, $vars);
        }

        if ($this->renderErrors) {
            $elementErrors = $elementErrorsHelper->render($element);
        }

        $elementString = $elementHelper->render($element);

        // hidden elements do not need a <label> -https://github.com/zendframework/zf2/issues/5607
        $type = $element->getAttribute('type');
        if (isset($label) && '' !== $label && $type !== 'hidden') {
            $labelAttributes = [];

            if ($element instanceof LabelAwareInterface) {
                $labelAttributes = $element->getLabelAttributes();
            }

            if (!$element instanceof LabelAwareInterface || !$element->getLabelOption('disable_html_escape')) {
                $label = $escapeHtmlHelper($label);
            }

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }

            // add form-group wrapper
            if ($formLayout === Form::LAYOUT_HORIZONTAL) {
                $formGroupHtml = '<div class="form-group row">%s</div>';
            } else {
                $formGroupHtml = '<div class="form-group">%s</div>';
            }

            // render errors
            if ($this->renderErrors && isset($elementErrors)) {
                $formGroupHtml = sprintf($formGroupHtml, '%s'.$elementErrors);
            }

            // Multicheckbox elements have to be handled differently as the HTML standard does not allow nested
            // labels. The semantic way is to group them inside a fieldset
            if ($type === 'multi_checkbox'
                || $type === 'radio'
                || $element instanceof MonthSelect
                || $element instanceof Captcha
            ) {
                $elementString = sprintf($formGroupHtml, $elementString);
                $markup = sprintf(
                    '<fieldset><legend>%s</legend>%s</fieldset>',
                    $label,
                    $elementString
                );
            } else {
                // Ensure element and label will be separated if element has an `id`-attribute.
                // If element has label option `always_wrap` it will be nested in any case.
                if ($element->hasAttribute('id')
                    && ($element instanceof LabelAwareInterface && !$element->getLabelOption('always_wrap'))
                ) {
                    $labelOpen = '';
                    $labelClose = '';
                    $label = $labelHelper->openTag($element) . $label . $labelHelper->closeTag();
                } else {
                    $labelOpen = $labelHelper->openTag($labelAttributes);
                    $labelClose = $labelHelper->closeTag();
                }

                if ($label !== '' && (!$element->hasAttribute('id'))
                    || ($element instanceof LabelAwareInterface && $element->getLabelOption('always_wrap'))
                ) {
                    $label = '<span>' . $label . '</span>';
                }

                // Button element is a special case, because label is always rendered inside it
                if ($element instanceof Button || $element instanceof Submit || $element instanceof Checkbox) {
                    $labelOpen = $labelClose = $label = '';
                }

                if ($element instanceof LabelAwareInterface && $element->getLabelOption('label_position')) {
                    $labelPosition = $element->getLabelOption('label_position');
                }

                if ($formLayout === Form::LAYOUT_HORIZONTAL && $element->getOption('column-size')) {
                    $elementString = sprintf('<div class="col-%s">%s</div>', $element->getOption('column-size'), $elementString);
                }

                if ($formLayout === Form::LAYOUT_FLOATING_LABLES) {
                    $labelPosition = self::LABEL_APPEND;
                }

                switch ($labelPosition) {
                    case self::LABEL_APPEND:
                        $markup = $labelOpen . $elementString . $label . $labelClose;
                        break;
                    case self::LABEL_PREPEND:
                    default:
                        $markup = $labelOpen . $label . $elementString . $labelClose;
                        break;
                }

                $markup = sprintf($formGroupHtml, $markup);
            }
        } else {
            if ($this->renderErrors) {
                $markup = $elementString . $elementErrors;
            } else {
                $markup = $elementString;
            }
        }

        return $markup;
    }

}