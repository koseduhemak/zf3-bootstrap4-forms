<?php

namespace Zf3Bootstrap4Forms\View\Helper;


use Zend\Form\ElementInterface;
use Zend\Form\Factory;

class FormElement extends \Zend\Form\View\Helper\FormElement
{
    const ADDON_PREPEND = 'add-on-prepend';
    const ADDON_APPEND = 'add-on-append';

    const ADDON_OPTION_ELEMENT = 'element';
    const ADDON_OPTION_TEXT = 'text';

    protected $ignoredViewHelpers = [
        'radio',
        'checkbox',
        'file',
        'button',
        'submit',
    ];

    public function __construct()
    {
        // TODO: in module config
        $this->addClass(\Zf3Bootstrap4Forms\Form\Element\DateRange::class, 'formDateRange');

        $this->addClass(\Zf3Bootstrap4Forms\Form\Element\Between::class, 'formBetween');
    }


    public function render(ElementInterface $element)
    {
        $type = $element->getAttribute('type');

        // if not ignored or contains class selectpicker (renderer is compatible with: https://developer.snapappointments.com/bootstrap-select/)
        if (!in_array($type, $this->ignoredViewHelpers) && !preg_match('/(^| )selectpicker($| )/', $element->getAttribute('class')) && !preg_match('/(^| )form-control($| )/', $element->getAttribute('class'))) {
            $element->setAttribute('class', trim($element->getAttribute('class') . ' form-control'));
        }

        if ($element->getMessages()) {
            if (!preg_match('/(^| )is-invalid($| )/', $element->getAttribute('class'))) {
                $element->setAttribute('class', trim($element->getAttribute('class') . ' is-invalid'));
            }
        }

        $markup = parent::render($element);

        // render input group
        $markup = $this->renderInputGroup($element, $markup);

        // render helpBlock
        if ($element->getOption('help-block')) {
            $markup .= sprintf('<small id="passwordHelpBlock" class="form-text text-muted">%s</small>', $element->getOption('help-block'));
        }

        return $markup;
    }

    public function renderInputGroup(ElementInterface $element, $elementMarkup)
    {
        $newMarkup = '<div class="input-group">';

        $addonPrepend = $element->getOption(static::ADDON_PREPEND);
        $addonAppend = $element->getOption(static::ADDON_APPEND);

        if ($addonPrepend || $addonAppend) {
            // Addon prepend
            if ($addonPrepend) {
                $elementMarkupPrepend = $this->renderAddons($addonPrepend, $elementMarkup, static::ADDON_PREPEND);
                $newMarkup .= $elementMarkupPrepend;
            }

            $newMarkup .= $elementMarkup;

            if ($element->getOption('formLayout') === Form::LAYOUT_FLOATING_LABLES) {
                $label = $this->getView()->formLabel($element);
                $newMarkup .= $label;
            }

            // Addon append
            if ($addonAppend) {
                $elementMarkupAppend = $this->renderAddons($addonAppend, $elementMarkup, static::ADDON_APPEND);
                $newMarkup .= $elementMarkupAppend;
            }

            $newMarkup .= '</div>';

            $elementMarkup = $newMarkup;
        }

        return $elementMarkup;
    }

    public function renderAddons($addonOptions, $elementMarkup, $position)
    {

        $addonContainer = ($position === static::ADDON_PREPEND) ? '<div class="input-group-prepend">%s</div>' : '<div class="input-group-append">%s</div>';

        $addonMarkup = [];
        $formElementfactory = new Factory();
        foreach ($addonOptions as $addonType => $addonElement) {
            switch (true) {
                case $addonElement instanceof ElementInterface:
                    $addonMarkup[] = $this->render($addonElement);
                    break;
                case is_array($addonElement) || $addonElement instanceof \Traversable:
                    $addonCreatedElement = $formElementfactory->create($addonElement);
                    $addonMarkup[] = $this->render($addonCreatedElement);
                    break;
                case is_string($addonElement):
                    $addonMarkup[] = sprintf('<div class="input-group-text">%s</div>', $addonElement);
                    break;
            }
        }

        $finalMarkup = sprintf($addonContainer, implode(PHP_EOL, $addonMarkup));

        return $finalMarkup;
    }
}