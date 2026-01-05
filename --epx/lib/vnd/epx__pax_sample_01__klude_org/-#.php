<?php


class epx__pax_sample_01__klude_org {
    
    public static function _() { static $i;  return $i ?: ($i = new static()); }
    
    public function __construct(){
        
    }
    
    public function __invoke(){
        echo __METHOD__.":".__FILE__;
    }
}