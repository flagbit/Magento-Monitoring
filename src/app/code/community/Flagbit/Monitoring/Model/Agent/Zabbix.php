<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:11
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Agent_Zabbix extends Flagbit_Monitoring_Model_Agent_abstract {

    /**
     * Agent's Name
     */
    const NAME = 'zabbix';

    public function __construct()
    {

        $this->_body = (object)array(
            "request" => "sender data",
            "data" => array(),
        );

        parent::__construct();
    }

    /**
     * build a body
     *
     * @param $data
     */
    protected function _setData($data)
    {

        $body = $this->_body;

        foreach( $data as $key => $value ) {
            array_push( $body->data, (object)array(
                    "host" => $this->_hostname,
                    "key" => $key,
                    "value" => $value,
                )
            );
        }

        $this->_body = json_encode($body);
        $size = strlen( $this->_body );
        $this->_request = pack( "a4CV2a*", "ZBXD", 1, $size, ( $size >> 32 ), $this->_body );
    }

    /**
     * send data to zabbix
     *
     * @param string $msg
     * @param string $type
     */
    public function send($msg, $type)
    {
        $this->_setData( array($type => $msg) );

        try {
            fputs( $this->_getSocket(), $this->_request);
            // 13 byte header
            for( $bytesRead = 0; $bytesRead < 13 && !feof( $this->_getSocket() ); $bytesRead++ ) {
                    $this->_header .= fread( $this->_getSocket(), 1 );
            }

            list( $ZBX, , $sizeL, $sizeH ) = array_values( unpack( 'a4zbx/Csep/Vh/Vl', $this->_header ) );
            $msgSize = ( $sizeL + ( $sizeH >> 32 ) );
            while( !feof( $this->_socket ) ) {
                $this->_return .= fread( $this->_socket, $msgSize );
            }

            if( $this->_return = json_decode($this->_return,true) ) {
                $status = preg_split( "/([A-Z][a-z ]*)\s+(\S+)\s*/",
                    $this->_return["info"], -1,
                    PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
                for( $i = 0; $i < count( $status ); $i += 2 ) {
                    $key = $status[$i];
                    $val = $status[$i+1];
                    $this->_return["status"][$key] = $val;
                }
            } else {

                // connection failed

                $this->_return = array(
                        "response" => "failed",
                        "info" => "Invalid response",
                    );
                     Mage::log( $this->_return, null, 'monitoring_'.self::NAME.'.log', true);
            }
        } catch (Exception $e) {

            // socket couldn't been initialized

            Mage::log( $e, null, 'monitoring_'.self::NAME.'.log', true);
        }
    }

}