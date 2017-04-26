<?php 

namespace Hcode\Sql;

class Exception extends \Exception {

	public function __construct($message = '', $code = 0) {
     
        return parent::__construct($message, $code);
        
    }

}

 ?>