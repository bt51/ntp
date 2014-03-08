# NTP
-------

Package ntp is a simple NTP client. It supports NTP version 4 and SNTP. Note that this client currently does not take network delay into account. This means the time that is received will not be accurate to the nanosecond.

## Installation
------------

Create a composer.json in your project

    {
        "require": {
            "bt51/ntp": "dev-master"
        }
    }

Read more on composer here: http://getcomposer.org

## Usage
Getting the current time from an ntp server is simple.

``` php
<?php

use Bt51\NTP\Socket;
use Bt51\NTP\Client;

$socket = new Socket('0.pool.ntp.org', 123); 
$ntp = new Client($socket);
$time = $ntp->getTime();
var_dump($time);

```

The current time returned from the ntp server will be converted to a DateTime object. The timezone will always be UTC.

License
-------

MIT
