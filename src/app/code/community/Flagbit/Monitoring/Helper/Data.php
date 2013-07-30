<?php


class Flagbit_Monitoring_Helper_Data extends Mage_Core_Helper_Abstract {


    const ACTIVE = 'dev/flagbit_monitoring/enabled';
    const SERVER = 'dev/flagbit_monitoring/zabbix_server';
    const PORT = 'dev/flagbit_monitoring/port';
    const HOSTNAME = 'dev/flagbit_monitoring/host';

    const DATAFLOW_INTERVAL =  'dev/flagbit_monitoring_dataflow/interval';

    const DATAFLOW = 'dev/flagbit_monitoring_mapping/dataflow';
    const REPORT = 'dev/flagbit_monitoring_mapping/report';
    const EXCEPTION = 'dev/flagbit_monitoring_mapping/exception';
    const E_RECOVERABLE_ERROR = 'dev/flagbit_monitoring_mapping/recoverable_error';
    const E_ERROR = 'dev/flagbit_monitoring_mapping/error';
    const E_PARSE = 'dev/flagbit_monitoring_mapping/parse_error';

    /**
     * returns Module Status by Module Code
     *
     * @param string $code Module Code
     * @return boolean
     */
   public function isModuleActive($code)
   {
       $module = Mage::getConfig()->getNode("modules/$code");
       $model = Mage::getConfig()->getNode("global/models/$code");
       return $module && $module->is('active') || $model;
   }

    /**
     * returns zabbix's server domain
     *
     * @return string
     */
    public function getServer()
    {
       return Mage::getStoreConfig( self::SERVER );
    }

    /**
     * returns zabbix's server port
     *
     * @return string
     */
    public function getPort()
    {
        return Mage::getStoreConfig( self::PORT );
    }

    /**
     * returns server's hostname
     *
     * @return string
     */
    public function getHostname()
    {
        return Mage::getStoreConfig( self::HOSTNAME );
    }


    public function getDataflowInterval()
    {
        return Mage::getStoreConfig( self::DATAFLOW_INTERVAL );
    }

    /**
     * returns error alias
     *
     * @param string identifier
     * @return string
     */
    /**
     * @TODO: adding fallback in case StoreConfig is empty
     */
    public function getMapping($identifier)
    {
        $value = null;
        $identifiers = Mage::getConfig()->getNode('flagbit_monitoring/identifers');
        $identifierConfig = $identifiers->{$identifier};
        if (!$identifierConfig || !$identifierConfig->mapping) {
            $value = $identifiers->DEFAULT->mapping->value;
        } else {
            if( $identifierConfig->mapping->config ) {
                $value = Mage::getStoreConfig( $identifierConfig->mapping->config );
            } elseif( $identifierConfig->mapping->value ) {
                $value = Mage::getStoreConfig( $identifierConfig->mapping->value );
            } else {
                $value = $identifiers->DEFAULT->mapping->value;
            }
        }
        return $value;
    }
}