<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Exception\InvalidArgumentException;

class FormButton extends \Zend\Form\View\Helper\FormButton
{
    const ICON_PREPREND = 'prepend';
    const ICON_APPEND   = 'append';

    public function render(ElementInterface $element, $buttonContent = null)
    {
        if (null === $buttonContent) {
            $buttonContent = $element->getLabel();

            // if no label check value for label
            if (null === $buttonContent) {
                $buttonContent = $element->getValue();
            }

            if (null !== $buttonContent && null !== ($translator = $this->getTranslator())) {
                $buttonContent = $translator->translate(
                    $buttonContent,
                    $this->getTranslatorTextDomain()
                );
            }
        }

        // add btn class
        if (! preg_match('/(^|[^a-z]+)btn-($|[^a-z]+)/i', $element->getAttribute('class'))) {
            $element->setAttribute('class', 'btn-primary '.trim($element->getAttribute('class')));
        }

        if (! preg_match('/(^|[^a-z]+)btn($|[^a-z-]+)/i', $element->getAttribute('class'))) {
            $element->setAttribute('class', trim('btn ' . $element->getAttribute('class')));
        }

        if ($fontAwesome = $element->getOption('fontawesome')) {
            $position = static::ICON_PREPREND;

            if (is_array($fontAwesome)) {
                if (array_key_exists('position', $fontAwesome) && $fontAwesome['position'] === static::ICON_APPEND) {
                    $position = static::ICON_APPEND;
                }

                if (! array_key_exists('icon', $fontAwesome)) {
                    throw new InvalidArgumentException(sprintf('No icon provided. Please provide an icon (class) to show for element "%s".', $element->getName()));
                }

                $iconClass = $fontAwesome['icon'];
            } else {
                $iconClass = $fontAwesome;
            }

            $label = '<i class="%s"></i> ';
            $label = sprintf($label, $iconClass);

            $element->setLabelOption('disable_html_escape', true);

            switch ($position) {
                case static::ICON_APPEND:
                    $buttonContent = $buttonContent . $label;
                    break;
                case static::ICON_PREPREND:
                default:
                    $buttonContent = $label . $buttonContent;
            }

            return parent::render($element, $buttonContent);
        }

        return parent::render($element, $buttonContent);
    }
}
