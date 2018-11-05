<?php

namespace Zf3Bootstrap4Forms\View\Helper;

use Zend\Form\FormInterface;
use Zend\Form\View\Helper\AbstractHelper;


class FormErrors extends AbstractHelper
{
    protected $defaultErrorText = 'There were errors in the form submission';
    protected $messageOpenFormat = '<h4>%s</h4><ul><li>';
    protected $messageCloseString = '</li></ul>';
    protected $messageSeparatorString = '</li><li>';

    /**
     * Invoke as function
     * @param \Zend\Form\FormInterface $oForm
     * @param string $sMessage
     * @param string $bDismissable
     * @return string|null
     */
    public function __invoke(FormInterface $oForm = null, $sMessage = null, $bDismissable = false)
    {
        if (!$oForm) {
            return $this;
        }
        if (!$sMessage) {
            $sMessage = $this->defaultErrorText;
        }
        if ($oForm->hasValidated() && !$oForm->isValid()) {
            return $this->render($oForm, $sMessage, $bDismissable);
        }
        return null;
    }

    /**
     * Renders the error messages.
     * @param \Zend\Form\FormInterface $oForm
     * @return string
     */
    public function render(FormInterface $oForm, $sMessage, $bDismissable = false)
    {
        // TODO: FIX
        $errorHtml = sprintf($this->messageOpenFormat, $sMessage);
        $sMessagesArray = [];
        foreach ($oForm->getMessages() as $fieldName => $sMessages) {
            foreach ($sMessages as $sMessage) {
                if ($oForm->get($fieldName)->getAttribute('id')) {
                    $sMessagesArray[] = sprintf(
                        '<a href="#%s">%s</a>',
                        $oForm->get($fieldName)->getAttribute('id'),
                        $oForm->get($fieldName)->getLabel() . ': ' . $sMessage
                    );
                } else {
                    $sMessagesArray[] = $oForm->get($fieldName)->getLabel() . ': ' . $sMessage;
                }
            }
        }

        $html = sprintf('<div class="alert alert-danger">%s</div>', $errorHtml);

        return sprintf($html,
            implode($this->messageSeparatorString, $sMessagesArray) .
            $this->messageCloseString,
            $bDismissable
        );
    }
}