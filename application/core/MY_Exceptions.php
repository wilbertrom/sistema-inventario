<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class MY_Exceptions extends CI_Exceptions {
    public function __construct() {
        parent::__construct();
    }
}