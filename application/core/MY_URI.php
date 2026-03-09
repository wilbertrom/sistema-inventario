<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class MY_URI extends CI_URI {
    
    public $config;
    
    public function __construct() {
        parent::__construct();
    }
}