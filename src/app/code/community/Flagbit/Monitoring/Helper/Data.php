<?php


class Flagbit_Monitoring_Helper_Data extends Mage_Core_Helper_Abstract {


    const SERVER = 'monitoring/server';
    const PORT = 'monitoring/port';
    const HOSTNAME = 'monitoring/hostname';


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

    public function getServer() {
        return Mage::getStoreConfig( self::SERVER );
    }

    public function getPort() {
        return Mage::getStoreConfig( self::PORT );
    }

    public function getHostname() {
        return Mage::getStoreConfig( self::HOSTNAME );
    }


}