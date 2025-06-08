<?php
    namespace App\Helpers;

    use Illuminate\Http\Request;

    class IpHelper
    {
        public static function getClientIp(Request $request): ?string {
            $headers = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
            foreach ($headers as $header) {
                if ($serverIp = $request->server($header)) {    
                    $ip = trim(explode(',', $serverIp)[0]);
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
            return $request->ip();
        }

        public static function ipInCidr(string $ip, string $cidr): bool
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) || strpos($cidr, '/') === false) {
            return false;
        }

        list($subnet, $mask) = explode('/', $cidr);

        if (!filter_var($subnet, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) || !is_numeric($mask) || $mask < 0 || $mask > 32) {
            return false;
        }

        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);
        $maskLong = -1 << (32 - (int)$mask); 
        $maskLong = $maskLong & 0xFFFFFFFF;


        if ($ipLong === false || $subnetLong === false) {
            return false;
        }
        
        return ($ipLong & $maskLong) == ($subnetLong & $maskLong);
    }

    public static function isIpInOfficeNetwork(string $ip, array $cidrList): bool
    {
        foreach ($cidrList as $cidr) {
            if (self::ipInCidr($ip, $cidr)) {
                return true;
            }
        }
        return false;
    }
    }