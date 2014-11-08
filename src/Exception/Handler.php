<?php
    function titaniaFirmwareErrorHandler($errno, $errstr, $errfile, $errline) {
        global $out;
        if (error_reporting() === 0) return;
?>
<div style="font-family: Arial, sans-serif; font-size: 14px; color: #fff; background: #333; border: 1px solid #000; padding: 30px;">
    <strong>Application Error</strong>
    <br>
    <p>[<?php echo $errno; ?>] <?php echo $errstr; ?></p>
    <!-- <?php echo $errfile; ?> on line <?php echo $errline; ?> -->
    
    <p>Below is the last few lines of console output:</p>
    
    <div style="margin-top: 20px; background: #555; border: 1px solid #000; padding: 15px;">
        <?php
            $console = $out->Read();
            $console = explode("\n", $console);
            $lines = array_slice($console, -4, 4, true);
            
            $i = 0;
            foreach($lines as $line) {
                $i++;
                echo $line;
                if($i < count($lines)) echo "<br>";
            }
        ?>
    </div>
</div>
<?php
        exit;
    }
    
    function titaniaFirmwareExceptionHandler(Exception $e) {
        global $out;
        if (error_reporting() === 0) return;
        
        $message = $e->getMessage();
        if(isset($e->firmwareException)) {
            $message = $e->__getMessage() . " (exitcode " . $e->__getCode() . ")";
        }
?>
<div style="font-family: Arial, sans-serif; font-size: 14px; color: #fff; background: #333; border: 1px solid #000; padding: 30px;">
    <strong>Application Exception</strong>
    <br>
    <p><?php echo $message; ?></p>
    <!-- <?php echo $e->__toString(); ?> -->
    <p>Below is the last few lines of console output:</p>
    
    <div style="margin-top: 20px; background: #555; border: 1px solid #000; padding: 15px;">
        <?php
            $console = $out->Read();
            $console = explode("\n", $console);
            $lines = array_slice($console, -4, 4, true);
            
            $i = 0;
            foreach($lines as $line) {
                $i++;
                echo $line;
                if($i < count($lines)) echo "<br>";
            }
        ?>
    </div>
</div>
<?php
    }

    function titaniaFirmwareFatalShutdownHandler() {
        $error = error_get_last();
        if($error["type"] == E_ERROR)
            titaniaFirmwareErrorHandler($error["type"], $error["message"], $error["file"], $error["line"]);
    }

?>