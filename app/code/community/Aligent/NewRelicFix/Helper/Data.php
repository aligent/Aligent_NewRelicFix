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
    public function reportException(Exception $e ,$vMessage = null)
    {
        if ($this->isExtensionLoaded()){
            if (is_null($vMessage)){
                $vMessage = $e->getMessage();
            }
            newrelic_notice_error($vMessage,$e);
        }
    }
    public function reportParameters(array $aParam)
    {
        if (!$this->isExtensionLoaded()){
            return ;
        }
        foreach ($aParam as $key => $value) {
            newrelic_add_custom_parameter($key, $value);
        }
    }

    public function reportErrorMessage($vMessage)
    {
        if ($this->isExtensionLoaded()){
            newrelic_notice_error($vMessage);
        }
    }
    /**
     * At the end of error/report.php add following line
     * (new Aligent_NewRelicFix_Helper_Overwrite())->injectErrorReport(compact('e','reportData'));
     *
     * @param array $aCompact
     */
    public function injectErrorReport(array $aCompact)
    {
        if (isset($aCompact['e'])){
            $e = $aCompact['e'];
            if ($e instanceof Exception){
                $this->reportException($e);
            }
            else{
                $this->reportErrorMessage('error variable reported is not of exception type');
            }
        }
        else{
            $this->reportErrorMessage('error reported injected without provide Exception object');
        }
        if (isset($aCompact['reportData'])){
            $aReportData = $aCompact['reportData'];
            if (is_array($aReportData)){
                $this->reportParameters($aReportData);
            }
            else{
                $this->reportErrorMessage('Passed reportData is not an array');
            }
        }
        else{
            $this->reportErrorMessage('error reported injected without provide reportData array');
        }
    }
}