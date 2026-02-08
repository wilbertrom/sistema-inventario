<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Libraries IdEncrypt
 *
 * This Libraries for ...
 * 
 * @package		CodeIgniter
 * @category	Libraries
 * @author    
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class IdEncrypt
{


  
  // ------------------------------------------------------------------------

  public function __construct()
  {
    if (!extension_loaded('openssl')) {
      show_error('La extensión OpenSSL no está habilitada. Habilita la extensión en tu servidor para usar esta librería.');
    }
    
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------

  public function index()
  {
    // 
  }

  public function encrypt($id)
  {
    $encrypted = openssl_encrypt($id, 'AES-256-ECB', 'key231');
    return base64_encode($encrypted);
  }

  public function decrypt($id)
  {
    $decoded = base64_decode($id);
    return openssl_decrypt($decoded, 'AES-256-ECB', 'key231');
  }
  // ------------------------------------------------------------------------
}

/* End of file IdEncrypt.php */
/* Location: ./application/libraries/IdEncrypt.php */