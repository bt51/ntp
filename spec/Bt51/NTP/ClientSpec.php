<?php

namespace spec\Bt51\NTP;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Bt51\NTP\Socket;

class ClientSpec extends ObjectBehavior
{
    public function let()
    {
        $socket = new Socket('0.pool.ntp.org', 123, 5);
        $this->beConstructedWith($socket);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Bt51\NTP\Client');
    }

    public function it_should_get_the_current_time()
    {
        $this->getTime()->shouldBeAnInstanceOf('DateTime');
    }
}

