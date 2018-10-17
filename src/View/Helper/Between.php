<?php


namespace Zf3Bootstrap4Forms\View\Helper;


use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class Between extends AbstractHelper
{
    protected $script = 'form-element/between';

    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        // return nothing if there is no element assigned to either from- or toElement
        if (!$element->getOption('fromElement') instanceof ElementInterface && !$element->getOption('toElement') instanceof ElementInterface) {
            return '';
        }

        return $this->render($element);
    }

    public function render(ElementInterface $element)
    {
        if ($element->getOption('toElement')) {
            $vars = [
                'fromElement' => $element,
                'toElement' => $element->getOption('toElement')
            ];
        } else {
            $vars = [
                'fromElement' => $element->getOption('fromElement'),
                'toElement' => $element
            ];
        }

        return $this->getView()->render($this->script, $vars);
    }

}