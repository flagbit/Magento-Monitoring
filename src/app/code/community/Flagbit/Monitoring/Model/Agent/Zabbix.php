<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:11
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Agent_Zabbix extends Mage_Core_Model_Abstract implements Flagbit_AMonitoring_Model_Agent_Interface {

    const NAME = 'Zabbix';

    public function send($msg, $type) {
        Mage::log("$type\n$msg",null,'monitoring.log',true);
    }

}