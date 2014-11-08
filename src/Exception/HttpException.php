<?php
    
    abstract class AbstractHttpException extends Exception implements IException {
        protected $message = 'Unknown exception';
        private   $string;
        protected $code    = 0;
        protected $file;
        protected $line;
        private   $trace;
        
        public $firmwareException = true;
        public function __getMessage() { return $this->message; }
        public function __getCode() { return $this->code; }
        public function __getFile() { return $this->file; }
        public function __getLine() { return $this->line; }
        public function __getTrace() { return $this->trace; }
        
        public function __construct($message = null, $code = 0)
        {
            if (!$message) {
                throw new $this('Unknown '. get_class($this));
            }
            parent::__construct($message, $code);
        }
        
        public function __toString()
        {
            return get_class($this) . " '{$this->message}' (exception {$this->code}) in "
                                    . "{$this->getTraceAsString()}";
        }
    }

    class HttpException extends AbstractHttpException {}
?>