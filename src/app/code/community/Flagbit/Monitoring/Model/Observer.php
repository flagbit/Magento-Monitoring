<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:17
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Observer {

    /**
     * register shutdown function
     *
     * @param Varien_Event_Observer $event
     */
    public function registerShutdown(Varien_Event_Observer $event)
    {
        register_shutdown_function(array('Flagbit_Monitoring_Model_Observer', 'shutdownHandler'));
    }

    /**
     * Hook to php shutdown handler
     *
     * This method is registered via register_shutdown_handler and
     * is used to grab fatal errors and handly them gracefully where
     * possible
     *
     * @return void
     */
    public static function shutdownHandler()
    {
        $error = error_get_last();
        if ($error && (
            ($error['type'] == E_ERROR) ||
                ($error['type'] == E_PARSE) ||
                ($error['type'] == E_RECOVERABLE_ERROR))) {
            $msg = $error['message'] . "\nLine: " . $error['line'] . ' - File: ' . $error['file'];

            if (class_exists('Mage')) {
                $typeString = null;
                switch($error['type']){

                    case E_ERROR:
                        $typeString = 'E_ERROR';
                        break;

                    case E_PARSE:
                        $typeString = 'E_PARSE';
                        break;

                    case E_RECOVERABLE_ERROR:
                        $typeString = 'E_RECOVERABLE_ERROR';
                        break;
                }
                if(!empty($typeString)){
                    Mage::getSingleton('flagbit_monitoring/agent')->send($msg, Mage::helper('flagbit_monitoring')->getMapping( $typeString));
                }
            }
        }
    }

    /**
     * scan Magento report directory and send the newest Report to the monitoring Agent
     *
     * @param Varien_Event_Observer $event
     */
    public function reportScanner(Varien_Event_Observer $event)
    {
        $reportScanner = Mage::getModel('flagbit_monitoring/report_scanner');
        $msg = $reportScanner->run();
        if( NULL !== $msg ) {
            Mage::getSingleton('flagbit_monitoring/agent')->send($msg, Mage::helper('flagbit_monitoring')->getMapping( 'REPORT' ) );
        }
    }
}