<?php
    
    define('TITANIA_FIRMWARE_PATH', dirname(dirname(__FILE__)));
    define('TITANIA_FIRMWARE_BIN_PATH', dirname(dirname(__FILE__)) . "\bin");
    define('TITANIA_FIRMWARE_SRC_PATH', dirname(dirname(__FILE__)) . "\src");
    
    require TITANIA_FIRMWARE_SRC_PATH . "\Drivers\Debug\Console.php";

    require TITANIA_FIRMWARE_SRC_PATH . "\Functions\Array.php";

    require TITANIA_FIRMWARE_SRC_PATH . "\Exception\FirmwareException.php";
    require TITANIA_FIRMWARE_SRC_PATH . "\Exception\HttpException.php";
    require TITANIA_FIRMWARE_SRC_PATH . "\Exception\Handler.php";

    require TITANIA_FIRMWARE_SRC_PATH . "\Titania\Firmware.php";
    require TITANIA_FIRMWARE_SRC_PATH . "\Runtime\Headers.php";
    require TITANIA_FIRMWARE_SRC_PATH . "\Runtime\Session.php";
    
    require TITANIA_FIRMWARE_SRC_PATH . "\Common\Enum.php";

    global $out;
    global $session;
    global $headers;
    
    // Initialize error handler //
    
    set_error_handler('titaniaFirmwareErrorHandler');
    set_exception_handler("titaniaFirmwareExceptionHandler");
    register_shutdown_function("titaniaFirmwareFatalShutdownHandler");
    @ini_set("display_errors", "off");
    
    // Start the console //

    $out = new Console();
    $out->WriteLn("Starting Titania Web Application Framework version " . TITANIA_FIRMWARE_VERSION);
    $out->Write("Starting drivers... ");

    // Load the drivers //
    
    require TITANIA_FIRMWARE_SRC_PATH . "\Drivers\Network\Http.php";
    require TITANIA_FIRMWARE_SRC_PATH . "\Drivers\Parser\HtmlDom.php";
    require TITANIA_FIRMWARE_SRC_PATH . "\Drivers\SQL\MySQL.php";
    
    $out->WriteLn("done.");
    $out->Write("Configuring runtime headers... ");
    
    // Enable output buffering //
    
    $headers = new Headers();
    $operation01 = $headers->OutputBuffering(true);

    if($operation01) $out->WriteLn("success.");
    else $out->WriteLn("success.");
    
    // Begin the user cookie session //
    
    $out->Write("Starting user session... ");
    
    $session = new Session();
    $operation02 = $session->start("TITANIAWAF");
    
    if($operation02) $out->WriteLn("success.");
    else {
        $out->WriteLn("\nFailed to initiate user session.\nTerminating...");
        throw new FirmwareException("Session error, see console", 70);
    }
    
    // Activate extensions //
    
    $out->WriteLn("Now activating extensions...");

    $files = glob(dirname(__FILE__) . '/Extend/*.php');

    foreach ($files as $file) {
        $out->Write("Activating: " . str_replace(".php", "", str_replace(array("-","_"), " ", basename($file))) . "... ");
        require_once($file);
        $out->WriteLn("done.");
    }

    $out->WriteLn("Application setup complete. Executing...");
?>