<?php

/**
 * Observes specific controller actions to remove NewRelic's real user monitoring (RUM) JavaScript.
 * This JavaScript can prevent Magento from operating correctly in some cases.  This is the case when loading new email
 * templates from the admin.  The NR agent embeds a JS snippit in the JSON response which causes Magento to fail to parse it.
 * See NR ticket #88658
 *
 * @category  Aligent
 * @package   Aligent_NewRelicFix
 * @author    Andrew Dwyer <andrew@aligent.com.au>
 * @copyright 2014 Aligent Consulting.
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      http://www.aligent.com.au/
 */
class Aligent_NewRelicFix_Model_Observer
{

    public function removeRumCode($observer) {
        if (extension_loaded('newrelic')) {
            newrelic_disable_autorum();
        }
    }
}
