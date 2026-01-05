<?php

final class epx {

    public readonly string $SITE_DIR;
    public readonly string $PPLEX_DIR;
    public readonly string $SPLEX_DIR;
    private $TSP_LIST = [];
    
    public static function _() {  static $i;  return $i ?? ($i = new static);  }
    
    public function __construct(){
        $this->SITE_DIR = $_SERVER['_']['SITE_DIR'];
        $this->PPLEX_DIR = $_SERVER['_']['START_DIR'];
        $this->SPLEX_DIR = "{$_SERVER['_']['SITE_DIR']}/--epx";
        foreach(\explode(PATH_SEPARATOR, \get_include_path()) as $dir){
            $this->TSP_LIST[\strtr($dir, '\\','/')] = true;
        }
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
                $this->TSP_LIST = [\strtr($path, '\\','/') => true] + $this->TSP_LIST;
            }
        } else if($source) {
            $p = \strtr($path.'-('.$source.'~'.$version.')','/','~');
            switch(\strtok($source, '/')){
                case 'github':{
                    if($d  = $this->resolve($p)){
                        $this->TSP_LIST = [\strtr($d, '\\','/') => true] + $this->TSP_LIST;
                    } else if(
                        \class_exists($c = \epx\module_installer\github::class)
                        && ($c::_()($d = "{$this->PPLEX_DIR}/.local/{$p}", $path, $source, $version))
                    ){
                        $this->TSP_LIST = [\strtr($d, '\\','/') => true] + $this->TSP_LIST;
                    }
                } break;
            }
        } else {
            if($d  = $this->resolve($path)){
                $this->TSP_LIST = [\strtr($d, '\\','/') => true] + $this->TSP_LIST;
            }
        }
        \set_include_path(\implode(PATH_SEPARATOR, \array_keys(\array_filter($this->TSP_LIST))));
        return $this;
    }
    
    public function execute(){ }
}