<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Log extends Zend_Log_Writer_Stream {

    const EXCEPTION_LOG = 'exception.log';

    /**
     * @var Stream|null
     */
    protected $_logfile = NULL;

    /**
     * @var boolean|null
     */
    protected $_shouldLog = NULL;

    /**
     * overload parent::__construct
     *
     * @param Stream $logFile
     * @param string|null $mode
     */
    public function __construct($logFile, $mode = NULL)
    {
        $this->_logfile = $logFile;
        return parent::__construct($logFile, $mode );
    }

    /**
     * should log?
     *
     * @return bool
     */
    protected function _shouldLog()
    {
        if($this->_shouldLog === NULL){
            $this->_shouldLog = Mage::helper('flagbit_monitoring')->isModuleActive('Hackathon_Logger') ? FALSE : TRUE;
        }
        return $this->_shouldLog;
    }

    /**
     * log writter
     *
     * @param array $event
     * @return void
     */
    protected function _write($event)
    {
        if($this->_shouldLog()){
            parent::_write($event);
        }

        if( FALSE !== strpos( $this->_logfile, self::EXCEPTION_LOG )) {
            $message = strtok($event['message'], "\n");
            if(!empty($message)){
                Mage::getSingleton('flagbit_monitoring/agent')->send($message, Mage::helper('flagbit_monitoring')->getMapping('EXCEPTION') );
            }
        }
    }
}