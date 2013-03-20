<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matthaeus.mueller
 * Date: 12.03.13
 * Time: 16:11
 * To change this template use File | Settings | File Templates.
 */

class Flagbit_Monitoring_Model_Agent {

    /**
     * @var array
     */
    protected $_agents = array();

    /**
     *
     */
    public function __construct()
    {
        $this->addAgent( Mage::getModel('flagbit_monitoring/agent_zabbix'));
    }

    /**
     * send msg to each added agent
     *
     * @param string $msg
     * @param string $type
     */
    public function send($msg, $type)
    {
        foreach( $this->_agents as $agent ) {
            $agent->send($msg, $type);
        }
    }

    /**
     * add Agent
     *
     * @param Flagbit_Monitoring_Model_Agent_Interface $agent
     * @return $this
     */
    public function addAgent(Flagbit_Monitoring_Model_Agent_Interface $agent)
    {
        $this->_agents[$agent::NAME] = $agent;

        return $this;
    }

}