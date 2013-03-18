<?php

abstract class Flagbit_Monitoring_Model_Agent_Abstract implements Flagbit_Monitoring_Model_Agent_Interface {

    /**
     * @var string|null
     */
    protected $_server = null;

    /**
     * @var int|null
     */
    protected $_port = null;

    /**
     * @var string|null
     */
    protected $_hostname = null;

    /**
     * @var ressource|null
     */
    protected $_socket = null;

    /**
     * @var int|null
     */
    protected $_errnum = null;

    /**
     * @var null
     */
    protected $_errstr = null;

    /**
     * @var int|null
     */
    protected $_timeout = null;

    protected $_request = null;
    protected $_header = null;
    protected $_body = null;
    protected $_return = null;


    public function __construct() {

        $helper = Mage::helper('flagbit_monitoring');
        $this->_server = $helper->getServer();
        $this->_port = $helper->getPort();
        $this->_hostname = $helper->getHostname();
        $this->_timeout = 15;

    }

    protected function _getSocket() {
        if( NULL === $this->_socket  ) {
            $this->_socket = @fsockopen($this->_server,$this->_port,$this->_errnum,$this->_errstr,$this->_timeout);
        }
        if( !is_resource( $this->_socket ) )  {
            $exception = (self::NAME . "Socket Exception #$this->_errnum : $this->_errstr");
            throw new Exception( $exception );
        }
        return $this->_socket;
    }

}