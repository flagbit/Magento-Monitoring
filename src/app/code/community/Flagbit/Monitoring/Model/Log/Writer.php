<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Log_Writer extends Zend_Log_Writer_Stream {

    public function __construct($options, $mode = NULL)
    {
        return parent::__construct($options['logFile'], $mode );
    }


    protected function _write($event)
    {
        $line = $this->_formatter->format($event);
        Mage::getSingleton('flagbit_monitoring/agent')->send($line, 'Exception');

        // add compatibility to Hackathon_Logger
        if(!Mage::helper('flagbit_monitoring')->isModuleActive('Hackathon_Logger')){
            parent::_write($event);
        }
    }

}