<?php
    
    class Session {
        function start($sessionName) {
            if(!ctype_alnum($sessionName)) throw new FirmwareException("Expected alnum, got other", 55);
            
            session_name($sessionName);
            return session_start();
        }
        
        function get($key = null) {
            if($key == null) throw new FirmwareException("Missing key parameter", 50);
            
            if(isset($_SESSION[$key])) return $_SESSION[$key];
            return null;
        }
        
        function set($key = null, $value = null) {
            if($key == null) throw new FirmwareException("Missing key parameter", 50);
            if($value == null) throw new FirmwareException("Missing value parameter", 50);
            
            $_SESSION[$key] = $value;
            return true;
        }
    }

?>