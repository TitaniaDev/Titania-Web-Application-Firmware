<?php
    
    class Http {
        function Get($url, $timeout = 10, $agent = "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36") {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            
            $data = curl_exec($ch);
            if(curl_errno($ch) > 0) throw new HttpException(curl_error($ch), curl_errno($ch));
            
            curl_close($ch);
            return $data;
        }
        function GetFollow($url, $timeout = 10, $agent = "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36") {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            
            $ch = curl_exec_follow_nr($ch, $timeout, $agent);
            $data = curl_exec($ch);
            if(curl_errno($ch) > 0) throw new HttpException(curl_error($ch), curl_errno($ch));
            
            curl_close($ch);
            return $data;
        }
    }

?>