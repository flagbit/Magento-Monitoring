<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:11
 * To change this template use File | Settings | File Templates.
 */

interface Flagbit_Monitoring_Model_Agent_Interface {

    public function send($msg, $type);

}