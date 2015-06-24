<?php
/**
 * Class Aligent_NewRelicFix_Helper_Overwrite
 *
 * This class is just to help and remind how to overwrite /extend new relic reporting.
 *
 * error/report.php uses new Aligent_NewRelicFix_Helper_Overwrite()
 * instead of using Mage::helper('aligent_newrelicfix')->functionName()
 *
 * The reason we cannot use Mage::helper('aligent_newrelicfix') in error/report.php is config might not be loaded
 * It is the case if exception occurs before configuration is loaded and merged
 *
 * using Autoload is safe, because Error reporting is triggered after Mage::run()
 * Autoload is configured as a part of including file app/etc/Mage.php
 * Which is before Mage::run
 *
 * This class should remain empty
 *
 */
class Aligent_NewRelicFix_Helper_Overwrite extends Aligent_NewRelicFix_Helper_Data {

}