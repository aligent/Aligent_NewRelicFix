<?php

/**
 * Class NewRelicMagentoInstaller
 *
 * This class is never copied or used in magento, it stays in vendor folder
 *
 * There is no good way to inject code in error report. Some approaches include overwriting Mage core files
 * like https://github.com/ProxiBlue/NewRelic/blob/master/app/code/local/Mage/Core/Exception.php
 *
 * This module can modify errors/report.php directly via composer post install script
 * Add following in your root composer.json
 *
 * "scripts": {
 *  "post-install-cmd": [
 *  "php vendor/aligent/new-relic-fix/scripts/install.php"
 *  ]
 *  },
 *
 * It can re-install it-self in-case your upgrade your magento installation
 *
 */

class NewRelicMagentoInstaller
{
    function install()
    {
        $this->patchReport();
    }
    function patchReport()
    {
        if (!$this->isReportPatched()){
            $vErrorReportPath = $this->getErrorReportPath();
            $vContents = file_get_contents($vErrorReportPath);
            //add following line in errors/report.php
            $vContents.= "\n\n(new Aligent_NewRelicFix_Helper_Overwrite())->injectErrorReport(compact('e', 'reportData'));";
            file_put_contents($vErrorReportPath,$vContents);
        }
    }
    function isReportPatched()
    {
        $vErrorReportPath =  $this->getErrorReportPath();
        $vContents = file_get_contents($vErrorReportPath);
        if (strpos($vContents,'Aligent_NewRelicFix')){
            return true;
        }
        return false;
    }

    function getErrorReportPath()
    {
        $vMagentoDir = $this->getMagentoDirectory();
        $vErrorReportPath = rtrim($vMagentoDir,'/') . '/errors/report.php';
        return $vErrorReportPath;
    }

    function getMagentoDirectory()
    {
        //vendor folder
        $vVendorFolder = dirname(dirname(dirname(dirname(__FILE__))));
        //Assume magento folder is parent of vendor, unless a different path is specified in composer.json
        $vMageFolder = dirname($vVendorFolder);
        $vComposerPath = $vMageFolder . '/composer.json';
        if (file_exists($vComposerPath) && is_readable($vComposerPath)) {
            $vComposer = @file_get_contents($vComposerPath);
            $aComposer = @json_decode($vComposer, true);
            //detect if magento root directory is different than composer root directory
            if (isset($aComposer['extra']) && isset($aComposer['extra']['magento-root-dir'])) {
                $vRootDir = $aComposer['extra']['magento-root-dir'];
                //if not specified or if it is . composer root is magento root
                if ($vRootDir && ($vRootDir != '.')) {
                    //absolute magento path specified in composer.json
                    if (strpos($vRootDir, '/') === 0) {
                        $vMageFolder = $vRootDir;
                    }
                    //relative path specified in composer.json
                    else {
                        $vMageFolder = rtrim($vMageFolder, '/') . '/' . $vRootDir;
                    }
                }
            }
        }
        return $vMageFolder;
    }
}