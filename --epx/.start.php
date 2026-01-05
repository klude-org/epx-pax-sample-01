<?php 
#####################################################################################################################
#region
    /* 
                                               EPX-PAX-START
    PROVIDER : KLUDE PTY LTD
    PACKAGE  : EPX-PAX
    AUTHOR   : BRIAN PINTO
    RELEASED : 2025-03-11
    
    */
#endregion
# ###################################################################################################################
# i'd like to be a tree - pilu (._.) // please keep this line in all versions - BP
namespace { (function(){
    try {  
        \defined('_\MSTART') OR \define('_\MSTART', \microtime(true));
        $_SERVER['_']['IS_CLI'] = empty($_SERVER['HTTP_HOST']);
        $_SERVER['_']['OB_OUT'] = \ob_get_level();
        $_SERVER['_']['IS_CLI'] OR \ob_start();
        $_SERVER['_']['OB_TOP'] = \ob_get_level();
        $_SERVER['_']['PHP_TSP_DEFAULTS'] = [
            'handler' => 'spl_autoload',
            'extensions' => \spl_autoload_extensions(),
            'path' =>  \get_include_path(),
        ];
        $_SERVER['_']['INTFC'] = $intfc = $_SERVER['FW__INTFC']
            ?? ($_SERVER['_']['IS_CLI'] 
                ? 'cli'
                : $_SERVER['HTTP_X_REQUEST_INTERFACE'] ?? 'web'
            )
        ;
        $_SERVER['_']['START_FILE'] = \str_replace('\\','/', __FILE__);
        $_SERVER['_']['START_DIR'] =  \str_replace('\\','/', __DIR__);
        \spl_autoload_extensions("-#{$intfc}.php,/-#{$intfc}.php,-#.php,/-#.php");
        \spl_autoload_register();
        \set_include_path("{{$_SERVER['_']['START_DIR']}/.local/vnd}".PATH_SEPARATOR.get_include_path());
        \spl_autoload_register(function($n){
            if(!\preg_match(
                "#^epx__(?<w_repo>.*?)__(?<w_owner>[^/]+)#",
                $p = \str_replace('\\','/', $n),
                $m
            )){
                return;
            }
            if(!\is_file($f_path = "{$_SERVER['_']['START_DIR']}/.local/vnd/{$p}/-#.php")){
                \extract($m = \array_filter($m, fn($k) => !is_numeric($k), ARRAY_FILTER_USE_KEY)); 
                $w_owner = \str_replace('_','-',$w_owner);
                $w_repo = "epx-".\str_replace('_','-',$w_repo);
                $u_path = "{$p}/".\urlencode('-#.php');
                $url = "https://raw.githubusercontent.com/{$w_owner}/{$w_repo}/main/--epx/lib/vnd/{$u_path}";
                if(!($contents = \file_get_contents($url))){
                    throw new \Exception("Failed: Unable to download type '{$n}'");
                }
                \is_dir($d = \dirname($f_path)) OR @mkdir($d,0777,true);
                \file_put_contents($f_path, $contents);
            }
            include $f_path;
        },true,false);
        \set_error_handler(function($severity, $message, $file, $line){
            throw new \ErrorException(
                $message, 
                0,
                $severity, 
                $file, 
                $line
            );
        });
        $GLOBALS['_O'] = ($GLOBALS['_O'] ?? null ?: \epx__pax_alpha__klude_org\v0\origin::class)::_();
        return $GLOBALS['_O'];
    } catch (\Throwable $ex) {
        switch($_SERVER['_']['INTFC'] ?? 'web'){
            case 'cli':{
                echo "\033[91m\n"
                    .$ex::class.": {$ex->getMessage()}\n"
                    ."File: {$ex->getFile()}\n"
                    ."Line: {$ex->getLine()}\n"
                    ."\033[31m{$ex}\033[0m\n"
                ;
                exit(1);
            } break;
            case 'web':{
                \http_response_code(500);
                while(\ob_get_level() > 0){ @\ob_end_clean(); }
                \defined('_\SIG_ABORT') OR \define('_\SIG_ABORT', -1);
                if (preg_match('#^application/json\b#i', $_SERVER['CONTENT_TYPE'] ?? '')) {
                    // It's JSON
                    \header('Content-Type: application/json');
                    echo \json_encode([
                        'status' => "error",
                        'message' => $ex->getMessage(),
                    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); 
                } else {
                    echo <<<HTML
                        <style>
                            body{ background-color: #121212; color: #e0e0e0; font-family: sans-serif; margin: 0; padding: 20px;}
                            pre{ overflow:auto; color:red;border:1px solid red;padding:5px; background-color: #1e1e1e; max-height: calc(100vh-25px); }
                            /* Scrollbar styles for WebKit (Chrome, Edge, Safari) */
                            ::-webkit-scrollbar { width: 12px; height: 12px;}
                            ::-webkit-scrollbar-track { background: #1e1e1e; }
                            ::-webkit-scrollbar-thumb { background-color: #555; border-radius: 6px; border: 2px solid #1e1e1e; }
                            ::-webkit-scrollbar-thumb:hover { background-color: #777; }
                            /* Firefox scrollbar (limited support) */
                            * { scrollbar-width: thin; scrollbar-color: #555 #1e1e1e;}
                        </style>
                        <pre>{$ex}</pre>
                        HTML;
                }
                exit(1);
            } break;
            default:{
                \http_response_code(500);
                while(\ob_get_level() > 0){ @\ob_end_clean(); }
                \defined('_\SIG_ABORT') OR \define('_\SIG_ABORT', -1);
                \header('Content-Type: application/json');
                echo \json_encode([
                    'status' => "error",
                    'message' => $ex->getMessage(),
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); 
                exit(1);
            } break;
        }
    }
})->bindTo((object)[])()(); }

