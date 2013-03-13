<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Log extends Zend_Log_Writer_Stream {

    /**
     * @param Stream $logFile
     * @return Zend_Log_Writer_Abstract
     */
    public function __construct($logFile)
    {
        // added monitoring to exception log
        if( $logFile == 'exception.log' ) {
            return Mage::getModel('flagbit_monitoring/log_writer', array( 'logFile' => $logFile ));
        }

        // send all Data to null if Hackathon_Logger is enabled
        if(Mage::helper('flagbit_monitoring')->isModuleActive('Hackathon_Logger')){
            return Mage::getModel('flagbit_monitoring/log_null', array( 'logFile' => $logFile ));
        }

        // return default Log Writer
        return new Zend_Log_Writer_Stream($logFile);

    }
}