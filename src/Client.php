<?php

/**
 * This file is part of NTP
 *
 * (c) Ben Tollakson <btollakson.os@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bt51\NTP;

/**
 * NTP client
 *
 * This is the main interface for getting
 * the current time from an ntp server.
 *
 * @author Ben Tollakson <btollakson.os@gmail.com>
 */
class Client
{
    /**
     * @var Socket
     */
    protected $socket;

    /**
     * Build a new instance of the ntp client
     *
     * @param Socket $socket The socket used for the connection
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    /**
     * Sends a request to the remote ntp server for the current time.
     * The current time returned is UTC.
     *
     * @return \DateTime
     */
    public function getTime()
    {
        $packet = $this->buildPacket();
        $this->write($packet);

        $time = $this->unpack($this->read());
        $time -= 2208988800;

        $this->socket->close();

        return \DateTime::createFromFormat('U', $time, new \DateTimeZone('UTC'));
    }

    /**
     * Write a request packet to the remote ntp server
     *
     * @param string $packet The packet to send
     *
     * @return void
     */
    protected function write($packet)
    {
        $this->socket->write($packet); 
    }

    /**
     * Reads data returned from the ntp server
     *
     * @return void
     */
    protected function read()
    {
        return $this->socket->read();
    }

    /**
     * Builds the request packet for the current time
     *
     * @return string
     */
    protected function buildPacket()
    {
        $packet = chr(0x1B);
        $packet .= str_repeat(chr(0x00), 47);

        return $packet;
    }

    /**
     * Unpacks the binary data that was returned
     * from the remote ntp server
     * 
     * @param string $binary The binary from the response
     *
     * @return string
     */
    protected function unpack($binary)
    {
        $data = unpack('N12', $binary);
        return sprintf('%u', $data[9]);

    }
}

