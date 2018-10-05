<?php

class Request {
    
    /**
     *@var array Array to store HTTP headers
     */
    public $header = array();

    /**
     *@var array Array to store route parameters
     */
    public $params = array();

    /**
     *@var array Array to store HTTP POST data sent
     */
    public $body = array();

    /**
     *@var array Array to contain COOKIES set
     */
    public $cookies = array();

    /**
     *@var array Array to contain SESSION data
     */
    public $session = array();

    /**
     *@var array Array to contain HTTP GET data
     */
    public $query = array();

    /**
     *@var string Contains current request URI
     */
    public $uri;
    
    /**
     * Setup Request Object
     * @author Victor Aremu
     */
    public function __construct() {    
        
        /**
         * Get the HTTP headers
         */
        $this->get_http_header();

        /**
         * Set the session
         */
        $session_status = session_status();
        if($session_status==1) {

            /**
             * Implies session as not been initiated using session_start()
             */
            $this->session = null;
        } else if($session_status==2) {

            /**
             * Implies session_start() as been invoked, set up the session wrapper
             */
            $this->session = $_SESSION;
        }

        /**
         * Get the COOKIES
         */
        $this->get_cookies();

        /**
         * Get the request URI
         */
         $this->uri = $_SERVER['REQUEST_URI'];

        /**
         * Set some vars to NULL based on the HTTP REQUEST type
         * Set some vars based on the HTTTP REQUEST type
         */
         switch($_SERVER['REQUEST_METHOD']) {
             case 'POST':

             	 /**
             	  * HTTP REQUEST TYPE => POST
             	  * Set the POST data to @var body
             	  */
                 $this->body = $_POST;
                 break;
             case 'GET':

             	 /**
             	  * HTTP REQUEST TYPE => GET
             	  * Set @var body to NULL
             	  * Set the GET data to @var query
             	  */
                  $this->body = null;
                  $this->query = $_GET;
                  break;
         }
    }
    
    /**
     * Set @var header the HTTP HEADERS in the following format:
     * 		array('HEADER_NAME' => 'VALUE');
     */
    public function get_http_header() {

        /**
         * headers_list() @return HTTP HEADERS in the following format:
         * 		array('HEADER_NAME:VALUE');
         */
        $headers = headers_list();

        /**
         * Loop through $headers
         */
        for($i=0; $i < count($headers); $i++) {

            /**
             * Explode ':' in the current index's value
             */
            $chunks = explode(':', $headers[$i]);

            /**
             * Set $chunks[0] as key and $chunks[1] value of element in @var header
             */
            $this->header[$chunks[0]] = $chunks[1];
        }

    }
    
    /**
     * Updates HTTP headers list of @var header
     * Useful for updating @var header when new HTTP Headers are set
     */
    public function updateHttpHeadersList() {
            $this->get_http_header();
    }
    
    /**
     * Sets @var cookies to $_COOKIES
     */
    public function get_cookies() {
        $this->cookies = $_COOKIE;
    }

    /**
     * Sets @var session to $_SESSION
     */
    public function get_session() {
        $this->session = $_SESSION;
    }
    
    /**
     * Adds a new element to @var params in the following format
     * 		array('KEY', 'VALUE');
     */
    public function set_params($key, $value) {
       $this->params[$key] = $value;
    }
}
