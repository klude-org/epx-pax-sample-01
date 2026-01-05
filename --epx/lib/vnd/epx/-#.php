<?php

final class epx {

    public readonly string $SITE_DIR;
    public readonly string $PPLEX_DIR;
    public readonly string $SPLEX_DIR;
    private $TSP_LIST = [];
    
    public static function _(...$args) { static $i;  return $i ?: ($i = new static(...$args)); }
    
    private function __construct(){
        $this->SITE_DIR = ($_SERVER['FW__SITE_DIR'] = \str_replace('\\','/', empty($_SERVER['HTTP_HOST'])
            ? \realpath($_SERVER['FW__SITE_DIR'] ?? \getcwd())
            : \realpath(\dirname($_SERVER['SCRIPT_FILENAME'])) 
        ));
        $this->PPLEX_DIR = \str_replace('\\','/', \dirname(__DIR__,2));
        $this->SPLEX_DIR = "{$this->SITE_DIR}/--epx";
    }
    
    private function resolve($path){
        if($d = \glob($r[] = "{$this->SPLEX_DIR}/*/{$path}",GLOB_ONLYDIR)[0] ?? null){
            return \strtr($d, '\\','/');
        } else if($d = \glob($r[] = "{$this->PPLEX_DIR}/*/{$path}",GLOB_ONLYDIR)[0] ?? null){
            return \strtr($d, '\\','/');
        } else if(\is_dir($d = $r[] = "{$this->SPLEX_DIR}/.local/{$path}")){
            return \strtr($d, '\\','/');
        } else if(\is_dir($d = $r[] = "{$this->PPLEX_DIR}/.local/{$path}")){
            return \strtr($d, '\\','/');
        }
    }
    
    public function module(string $path, string $source = null, string $version = 'main'){
        if(($path[0]??'')=='/' || ($path[1]??'')==':'){
            if(\is_dir($path)){
                $this->TSP_LIST[\strtr($path, '\\','/')] = true;
            }
        } else if($source) {
            $p = \strtr($path.'-('.$source.'~'.$version.')','/','~');
            switch(\strtok($source, '/')){
                case 'github':{
                    if($d  = $this->resolve($p)){
                        $this->TSP_LIST[\strtr($d, '\\','/')] = true;
                    } else if(
                        \class_exists($c = \epx\module_installer\github::class)
                        && ($c::_()($d = "{$this->PPLEX_DIR}/.local/{$p}", $path, $source,$version))
                    ){
                        $this->TSP_LIST[\strtr($d, '\\','/')] = true;
                    }
                } break;
            }
        }
        return $this;
    }
    
    public function execute(){
        
    }
}