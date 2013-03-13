<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Log extends Zend_Log_Writer_Stream {

    public function __construct($logFile) {

        if( $logFile == 'exception.log' ) {
            return Mage::getModel('flagbit_monitoring/log_writer', array( 'logFile' => $logFile ));
        }
        return new Zend_Log_Writer_Stream($logFile);

    }
}