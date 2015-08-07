<?php

class Aligent_NewRelicFix_TriggerController extends Mage_Core_Controller_Front_Action
{
    protected function isEnabled()
    {
        return Mage::getStoreConfigFlag('aligent_newrelicfix/trigger_error/enable');
    }

    public function noticeAction()
    {
        if ($this->isEnabled()) {
            trigger_error('Aligent NewRelic notice', E_USER_NOTICE);
        }
    }

    public function warningAction()
    {
        if ($this->isEnabled()) {
            trigger_error('Aligent NewRelic warning', E_USER_WARNING);
        }
    }

    public function errorAction()
    {
        if ($this->isEnabled()) {
            trigger_error('Aligent NewRelic error', E_USER_ERROR);
        }
    }

    public function exceptionAction()
    {
        if ($this->isEnabled()) {
            throw (new Exception('Aligent NewRelic Exception'));
        }
    }

    public function fatalAction()
    {
        if ($this->isEnabled()) {
            //a fatal error
            $nothing->method();
        }
    }
}