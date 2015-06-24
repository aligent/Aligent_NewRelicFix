<?php
/**
 * Although this file is never copied into Magento, still good to make sure it is not being executed using includes or through web interface
 *
 * Tried to run without shell and directly in PHP but had trouble auto-loading composer classes in magento
 *
 */
if (isset($_SERVER['SCRIPT_NAME'])
    && (strpos(__FILE__, $_SERVER['SCRIPT_NAME']) !== false)
    && (php_sapi_name() == 'cli')
) {
    require_once dirname(__FILE__) . '/NewRelicMagentoInstaller.php';
    $newRelicMagentoInstaller = new NewRelicMagentoInstaller();
    $newRelicMagentoInstaller->install();
}