<?php

namespace spec\Bt51\NTP;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SocketSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('pool.ntp.org', 123, 5);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Bt51\\NTP\\Socket');
    }

    public function it_should_write_to_socket()
    {
        $packet = $this->getPacket();
        $this->write($packet);
    }

    public function it_should_read_from_socket()
    {
        $packet = $this->getPacket();
        $this->write($packet);
        $this->read()->shouldBeString();
    }

    public function it_should_be_connected()
    {
        $this->isConnected()->shouldBe(true);
    }

    public function it_should_get_address()
    {
        $this->getAddress()->shouldBeValidIp();
    }

    public function getMatchers()
    {
        return array(
            'beValidIp' => function ($subject) {
                $ip = explode(':', $subject);
                return is_string($ip[0]) ? true : false;
            }
        );
    }

    protected function getPacket()
    {
        return chr(0x1B) . str_repeat(chr(0x00), 47);
    }
}

