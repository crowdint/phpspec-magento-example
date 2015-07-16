<?php

class Crowd_Helloworld_Adapter_State {

    public function isLoggedIn(){

        if(Mage::getSingleton('customer/session')->isLoggedIn()){
            return true;
        } else {
            return false;
        }
    }
}