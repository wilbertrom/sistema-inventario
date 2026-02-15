<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class MY_DB_mysqli_driver extends CI_DB_mysqli_driver {
    
    public $failover = array();  // Propiedad declarada explícitamente
    public $save_queries = TRUE;
    
    public function __construct($params) {
        parent::__construct($params);
    }
}