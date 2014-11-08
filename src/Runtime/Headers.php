<?php
    
    class Headers {
        public function OutputBuffering($status = null) {
            if($status == null) throw new FirmwareException("Missing parameter", 50);
            if(!is_bool($status)) throw new FirmwareException("Expected boolean, got " . gettype($status), 55);
            
            if($status) {
                return ob_start();
            }
            else {
                return ob_end_flush();
            }
        }
        
        public function Redirect($uri = null, $code = 301) {
            if($uri == null) throw new FirmwareException("Missing parameter", 50);
            if(!is_string($uri)) throw new FirmwareException("Expected string, got " . gettype($status), 55);
            if(!is_numeric($code)) throw new FirmwareException("Expected number, got " . gettype($code), 55);
            
            header("Location: " . $uri, true, $code);
            echo "<h1>Resource Moved</h1><p>The requested resource has moved to <a href='$uri'>here</a></p>";
            exit;
        }
    }
    
?>