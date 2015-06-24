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
}