Magento Monitoring
=============

Short description
-------------
An open-source monitoring solution for Magento written in PHP follwing the Zend Framework Coding Convention.


Long description
-------------
Magento Monitoring is a lightweighted highly-extensible Magento extension developed by Flagbit GmbH & KG.
It can be used to monitor Magento's logging, Magento's report-generating PHP specific error constants, and much more... (feel free to hack around ;) )
There is already an interface to communicate with Zabbix, but any other agent-based Monitoring System can be supported.

Predefined items
-------------
* magento.e\_exception
> hooking Magento's Mage::logException().

* magento.e\_report
> using DirectoyIterator to get the newest Magento report stored in var/report/.

* magento.e\_error
> alias for PHP error constant E\_ERROR

* magento.e\_parse\_error
> alias for PHP error constant E\_PARSE

* magento.e\_recoverable\_error
> alias for PHP error constant E\_RECOVERABLE\_ERROR

Installation
-------------
Magento Monitoring can be easily installed using modman.