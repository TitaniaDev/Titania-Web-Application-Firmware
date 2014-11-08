<?php
    
    function array_encode($arr) {
        return base64_encode(serialize($arr));
    }
    function array_decode($string) {
        return unserialize(base64_decode($arr));
    }
    
?>