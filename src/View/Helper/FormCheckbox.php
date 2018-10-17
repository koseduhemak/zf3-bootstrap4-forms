<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\Element\Checkbox;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Checkbox as CheckboxElement;
use Zend\Form\Exception;
use Zend\Form\View\Helper\FormRow;

class FormCheckbox extends \Zend\Form\View\Helper\FormCheckbox
{
    public function render(ElementInterface $element)
    {
        if (! $element instanceof CheckboxElement) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s requires that the element is of type Zend\Form\Element\Checkbox',
                __METHOD__
            ));
        }

        $name = $element->getName();
        if (empty($name) && $name !== 0) {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

        $attributes            = $element->getAttributes();
        $attributes['name']    = $name;
        $attributes['type']    = $this->getInputType();
        $attributes['value']   = $element->getCheckedValue();
        $closingBracket        = $this->getInlineClosingBracket();

        if ($element->isChecked()) {
            $attributes['checked'] = 'checked';
        }

        $rendered = sprintf(
            '<input %s%s',
            $this->createAttributesString($attributes),
            $closingBracket
        );

        /*// Add label markup
        $sLabelOpen = $sLabelClose = '';
        $sLabelContent = $this->getLabelContent($element);
        if($sLabelContent) {
            $oLabelHelper = $this->getLabelHelper();
            $sLabelOpen = $oLabelHelper->openTag($oElement->getLabelAttributes() ? : null);
            $sLabelClose = $oLabelHelper->closeTag();
        }

        if ($this->getLabelPosition($element) === FormRow::LABEL_PREPEND) {
            $sElementContent = $sLabelOpen .
                ($sLabelContent ? rtrim($sLabelContent) . ' ' : '') .
                $sElementContent .
                $sLabelClose;
        } else {
            $sElementContent = $sLabelOpen .
                $sElementContent .
                ($sLabelContent ? ' ' . ltrim($sLabelContent) : '') .
                $sLabelClose;
        }*/


        if ($element->useHiddenElement()) {
            $hiddenAttributes = [
                'disabled' => isset($attributes['disabled']) ? $attributes['disabled'] : false,
                'name'     => $attributes['name'],
                'value'    => $element->getUncheckedValue(),
            ];

            $rendered = sprintf(
                    '<input type="hidden" %s%s',
                    $this->createAttributesString($hiddenAttributes),
                    $closingBracket
                ) . $rendered;
        }

        return $rendered;
    }

    public function getLabelPosition(Checkbox $oElement)
    {
        return $oElement->getLabelOption('position')? : FormRow::LABEL_APPEND;
    }

}