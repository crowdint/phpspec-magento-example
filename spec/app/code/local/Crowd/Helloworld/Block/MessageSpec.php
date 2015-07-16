<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Crowd_Helloworld_Block_MessageSpec extends ObjectBehavior
{
    function let(\Crowd_Helloworld_Adapter_State $adapter)
    {
      $this->beConstructedWith(array('state_adapter' => $adapter));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crowd_Helloworld_Block_Message');
    }

    function it_should_tell_you_that_you_most_register($adapter)
    {
        $adapter->isLoggedIn()->willReturn(false);
        $this->message()->shouldReturn('Hello guest, Please register with us for special offers');
    }

    function it_should_tell_you_a_welcome_message($adapter)
    {
        $adapter->isLoggedIn()->willReturn(true);
        $this->message()->shouldReturn('Hello registered user');
    }
}
