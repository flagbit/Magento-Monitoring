<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:17
 * To change this template use File | Settings | File Templates.
 */


class Flagbit_Monitoring_Model_ReportScanner {

    protected $_reportDirectory = null;
    protected $_lastReport = null;
    protected $_count = null;

    public function __construct() {
       $this->_reportDirectory = Mage::getBaseDir('var').'/report' ;
    }

    public function run() {
        $this->_scan();
        if( $this->_count == 0 ) {
            return NULL;
        } else {
            return $this->_getLastReport();
        }
    }

    protected function _scan()
    {
        $dir = new DirectoryIterator( $this->_reportDirectory );
        foreach( $dir as $file ){
            if( $file->isDot() ) continue;

            if( NULL !== $this->_lastReport ) {
              if( $this->_lastReport->getMTime() < $file->getMTime() ) {
                  $this->_lastReport = clone $file;
              }
            } else {
               $this->_lastReport = clone $file;
            }
            $this->_count++;
        }
    }

    protected function _getLastReport()
    {
        return file_get_conents($this->_lastReport->getPathname());
    }
}