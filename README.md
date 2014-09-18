Aligent_NewRelicFix
==============

Observes specific controller actions to remove NewRelic's real user monitoring (RUM) JavaScript.
This JavaScript can prevent Magento from operating correctly in some cases.  This is the case when loading new email templates from the admin.  The NR agent embeds a JS snippit in the JSON response which causes Magento to fail to parse it.
See NR ticket #88658

