<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Log_Null extends Zend_Log_Writer_Abstract {

    public function __construct($options, $mode = NULL)
    {
        return parent::__construct($options['logFile'], $mode );
    }

    /**
     * Create a new instance of Flagbit_Monitoring_Model_Log_Null
     *
     * @param  array|Zend_Config $config
     * @return Zend_Log_Writer_Null
     * @throws Zend_Log_Exception
     */
    static public function factory($config)
    {
        return new self($config);
    }

    protected function _write($event)
    {
        // do nothing
    }

}