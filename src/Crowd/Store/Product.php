<?php

namespace Crowd\Store;

class Product
{

    protected $_name;
    protected $_sku;

    public function __construct($name = '', $sku = '')
    {
        $this->_name    = $name;
        $this->_sku     = $sku;
    }

    public function getName()
    {
        return $this->_name; 
    }

    public function getSku()
    {
        return $this->_sku;
    }
}
