<?php

class Aligent_NewRelicFix_Helper_Data extends Mage_Core_Helper_Abstract {
    //abstract extension loaded and cache
    /** @var  Boolean extension loaded cached variable */
    protected $_bExtensionLoaded;
    public function isExtensionLoaded()
    {
        if (is_null($this->_bExtensionLoaded)){
            $this->_bExtensionLoaded = extension_loaded('newrelic');
        }
        return $this->_bExtensionLoaded;
    }
    public function reportException(Exception $e)
    {
        if ($this->isExtensionLoaded()){
            newrelic_notice_error($e->getMessage(),$e);
        }
    }
    public function reportParameters(array $aParam)
    {
        foreach ($aParam as $key => $value) {
            newrelic_add_custom_parameter($key, $value);
        }
    }
}