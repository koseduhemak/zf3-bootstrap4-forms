<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\ElementInterface;

class FormButton extends \Zend\Form\View\Helper\FormButton
{
    public function render(ElementInterface $element, $buttonContent = null)
    {
        if (null === $buttonContent) {
            $buttonContent = $element->getLabel();

            if (null !== $buttonContent && null !== ($translator = $this->getTranslator())) {
                $buttonContent = $translator->translate(
                    $buttonContent,
                    $this->getTranslatorTextDomain()
                );
            }
        }

        // add btn class
        if (!preg_match('/(^|[^a-z]+)btn($|[^a-z-]+)/i', $element->getAttribute('class'))) {
            $element->setAttribute('class', trim('btn '.$element->getAttribute('class')));
        }

        if (!preg_match('/(^|[^a-z]+)btn-($|[^a-z]+)/i', $element->getAttribute('class'))) {
            $element->setAttribute('class', trim($element->getAttribute('class').' btn-primary'));
        }

        if ($icon = $element->getOption('fontawesome')) {
            $label = '<i class="%s"></i> ';
            $label = sprintf($label, $icon);

            $element->setLabelOption('disable_html_escape', true);

            $buttonContent = $label . $buttonContent;

            return parent::render($element, $buttonContent);
        } else {
            return parent::render($element, $buttonContent);
        }
    }

}