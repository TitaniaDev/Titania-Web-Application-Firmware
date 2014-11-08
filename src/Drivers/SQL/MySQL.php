<?php
    
    class MySQLd {
        private $ch;
        private $connected = false;
        
        function connect($host = null, $username = null, $password = null, $database = null, $port = 3306) {
            global $out;
            if($host === null || $username === null || $password === null || $database === null) throw new FirmwareException("Missing parameters", 50);
            
            if($this->useImproved()) {
                $out->WriteLn("[SQL] Connecting to driver over: improved...");
                $c = mysqli_connect($host, $username, $password, $database, $port);
                
                if(mysqli_connect_error()) {
                    $out->WriteLn("[SQL] Failed to connect to SQL driver. Error (" . mysqli_connect_errno() . "): " . mysqli_connect_error());
                    throw new FirmwareException("SQL driver failure", 0);
                }
                
                $out->WriteLn("[SQL] Connection established to database.");
                $this->connected = true;
                $this->ch = $c;
                return true;
            }
            else {
                $out->WriteLn("[SQL] Connecting to driver over: standard...");
                
                $c = mysql_connect($host . ":" . $port, $username, $password);
                if(!$c) {
                    $out->WriteLn("[SQL] Failed to connect to SQL driver. Error: " . mysql_error());
                    throw new FirmwareException("SQL driver failure", 0);
                }
                
                $select = mysql_select_db($database, $c);
                if(!$select) {
                    $out->WriteLn("[SQL] Connected to SQL driver, but could not connect to database.");
                    throw new FirmwareException("SQL driver failure", 0);
                }
                
                $this->connected = true;
                $this->ch = $c;
            }
        }
        
        function query($query) {
            if($this->useImproved()) {
                $result = $this->ch->query($query);
                
                if($result === false) return false;
                if($result === true) return true;
                
                $rrs = new MySQL_Result();
                $rrs->importi($result);
                
                return $rrs;
            }
            else {
                $result = mysql_query($query, $this->ch);
                if($result === false) return false;
                if($result === true) return true;
                
                $rrs = new MySQL_Result();
                $rrs->import($result);
                
                return $rrs;
            }
        }
        
        function sanitize($str) {
            if($this->useImproved()) {
                return mysqli_real_escape_string($this->ch, $str);
            }
            return mysql_real_escape_string($str, $this->ch);
        }
        
        function useImproved() {
            return function_exists('mysqli_connect');
        }
    }
    
    class MySQL_Result {
        private $resource;
        private $i = false;
        public $num_rows;
        
        function import($res) {
            $this->num_rows = mysql_num_rows($res);
            $this->resource = $res;
        }
        function importi($res) {
            $this->num_rows = $res->num_rows;
            $this->resource = $res;
            $this->i = true;
        }
        
        function fetch_array() {
            if($this->i) {
                return $this->resource->fetch_array();
            }
            return mysql_fetch_array($this->resource);
        }
    }

?>