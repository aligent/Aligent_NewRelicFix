#Aligent NewRelic fix

##Rum Fix
Observes specific controller actions to remove NewRelic's real user monitoring (RUM) JavaScript.
This JavaScript can prevent Magento from operating correctly in some cases.  This is the case when loading new email templates from the admin.  The NR agent embeds a JS snippit in the JSON response which causes Magento to fail to parse it.
See NR ticket #88658

## Injected code in error report
* To inject error reporting add following line at the end of errors/report.php
`@(new Aligent_NewRelicFix_Helper_Overwrite())->injectErrorReport(compact('e', 'reportData'));`
* Upgrading magento can overwrite these settings. To avoid this add following in your composer.json

```
"scripts": {
    "post-install-cmd": [
      "php vendor/aligent/new-relic-fix/scripts/install.php"
    ]
  },
```