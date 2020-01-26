<?php
    /*
     * App Core Class
     * Creates URL & loads core controller
     * URL FORMAT - /controller/method/params
     */

    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod     = 'index';
        protected $params            = [];

        public function __construct(){
            //print_r($this->getUrl());

            $url = $this->getUrl();

            // Look in controllers for first value
            // It always begins in public/index.php, so we need to move out hence the ../app/etc

            if($url) {
                if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                    $this->currentController = ucwords($url[0]);
                    //unset 0 index
                    unset($url[0]);
                }    
            }
            
            // Require the controller
            require_once '../app/controllers/' . $this->currentController. '.php';

            // Instantiate the controller class
            $this->currentController = new $this->currentController;

            // Check for second part of url
            if (isset($url[1])) {
                // Check to see if method exists
                if (method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];

                    // Unset url index 1
                    unset($url[1]);
                }
            }

            // Get parameters
            $this->params = $url ? array_values($url) : [];

            // Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl() {
            if (isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);

                return $url;
            }
        }
    }
?>

