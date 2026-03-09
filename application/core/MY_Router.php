<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class MY_Router extends CI_Router {
    
    public $uri;
    
    public function __construct() {
        parent::__construct();
    }
}