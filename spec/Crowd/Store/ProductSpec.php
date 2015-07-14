<?php

namespace spec\Crowd\Store;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Crowd\Store\Product');
    }

    function it_should_have_a_name(){
        $this->getName()->shouldReturn("TestProductName");
    }

    function it_should_have_a_sku(){
        $this->getSku()->shouldReturn("12345");
    }
}