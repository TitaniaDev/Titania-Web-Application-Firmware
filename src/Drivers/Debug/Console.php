<?php
    
    class Console {
        private $data = "";
        
        function WriteLn($text = "") {
            $this->data .= $text . "\n";
        }
        function Write($text=null) {
            if($text == null) throw new FirmwareException("Missing text argument", 50);
            
            $this->data .= $text;
        }
        
        function Read() {
            return $this->data;
        }
    }
    
?>