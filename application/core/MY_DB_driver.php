<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class MY_DB_driver extends CI_DB_driver {
    
    public $failover = array();
    public $save_queries = TRUE;
    public $dbdriver = 'mysqli';
    public $_escape_char = array('"', '"');
    
    public function __construct($params) {
        parent::__construct($params);
    }
}