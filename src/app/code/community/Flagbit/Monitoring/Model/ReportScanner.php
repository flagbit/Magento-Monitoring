<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:17
 * To change this template use File | Settings | File Templates.
 */


class Flagbit_Monitoring_Model_ReportScanner {

    const REPORT_DIRECTORY = '/var/report';
    protected $_lastReport = null;
    protected $_count = null;

    public function isDirectoryEmpty()
    {
        return $this->_scan();
    }

    protected function _scan()
    {
        $dir = new DirectoryIterator( Flagbit_Monitoring_Model_ReportScanner::REPORT_DIRECTORY );

        foreach($dir as $file ){
            if( isset($this->_lastReport) ) {
              if( $this->_lastReport->getMTime() < $file->getMTime() ) {
                  $this->_lastReport = $file;
              }
            } else {
               $this->_lastReport = $file;
            }
            $this->_count++;
        }
    }

    public function getCount()
    {
        return $this->_count;
    }

    public function getLastreport()
    {
        $report = serialize(file_get_contents($this->_lastReport->getFilename()));
    }
}