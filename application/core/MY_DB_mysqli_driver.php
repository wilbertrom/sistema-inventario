<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class MY_DB_mysqli_driver extends CI_DB_mysqli_driver {
    
    public $failover = array();
    public $save_queries = TRUE;
    public $dbdriver = 'mysqli';
    
    public function __construct($params) {
        parent::__construct($params);
    }
}