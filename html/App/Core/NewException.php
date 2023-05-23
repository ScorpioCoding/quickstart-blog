<?php

namespace App\Core;

use Exception;



/** THE CUSTOM EXCEPTION
 * 
 */
class NewException extends Exception
{

  public function getErrorMsg()
  {
    $msg = '';
    $msg .= 'Error in File : ' . $this->getFile();
    $msg .= '<br/>';
    $msg .= 'Error on line : ' . $this->getLine();
    $msg .= '<br/>';
    $msg .= $this->getMessage();
    $msg .= '<br/><br/>';

    return $msg;
  }

  //
  //END CLASS
}
