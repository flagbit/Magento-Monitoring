<?php


class Flagbit_Monitoring_Helper_Data extends Mage_Core_Helper_Abstract {


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

}