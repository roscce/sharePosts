<?php

    // Load Config
    require_once 'config/config.php';

    // Load helpers
    require_once 'helpers/url_helper.php';
    require_once 'helpers/session_helper.php';


    /* The requires below are replaced with the spl_autoload
     * It WORKS ONLY IF the class names are the same as the file names

     * require_once 'libraries/Core.php';
     * require_once 'libraries/Controller.php';
     * require_once 'libraries/Database.php';

    */

    // Autoload Core Libraries
    // Because of this you can just instatiate a new class and this will require the library
    spl_autoload_register(function($className){
        require_once 'libraries/'. $className .'.php';
    });