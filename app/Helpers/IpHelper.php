<?php
    namespace App\Helpers;

    class IpHelper
    {
        public static function ipInRange($ip, $cidr) 
        {
            list($subnet, $mask) = explode('/', $cidr);

            $ipLong = ip2long($ip);
            $subnetLong = ip2long($subnet);
            $maskLong = -1 << (32 - $mask);

            return ($ipLong & $maskLong) === ($subnetLong & $maskLong);
        }
    }