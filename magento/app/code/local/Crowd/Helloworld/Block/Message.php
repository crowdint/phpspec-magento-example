<?php

class Crowd_Helloworld_Block_Message extends Mage_Core_Block_Abstract
{
    private $_stateAdapter;

    public function __construct(array $services = array()){
        if (isset($services['state_adapter'])) {
            $this->_stateAdapter = $services['state_adapter'];
        }
        if (!$this->_stateAdapter instanceof Crowd_Helloworld_Adapter_State) {
            $this->_stateAdapter = new Crowd_Helloworld_Adapter_State();
        }
    }

    public function message(){

        $state = $this->_stateAdapter;

        if($state->isLoggedIn()){
            return 'Hello registered user';
        } else {
            return 'Hello guest, Please register with us for special offers';
        }
        
    }
}