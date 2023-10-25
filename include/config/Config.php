<?php
    /**
     * =============================================================================
     * 標　　題: %DocumentRoot%/include/config/Config.php
     * 系統名稱: Config
     * 功能描述: 系統參數設定
     * 頁面描述: PHP
     * 作　　者:
     * 撰寫日期: 2010-10-29
     * 修改描述:
     * =============================================================================
     **/
    header('Content-type: text/html; charset=utf-8');
    //default
    $dir = 'default';//預設路徑


    $exception_arr = array('backend', 'httpd');
    $arrScriptPath = preg_split('[\/]', dirname($_SERVER['SCRIPT_FILENAME']));
    $max_dir_count = count($arrScriptPath);
    if ($max_dir_count < 1) {
        die("define error");
    }
    foreach ($arrScriptPath as $key => $val) {
        if ($val == 'http') {
            $max_dir_count = $key;
            unset($arrScriptPath[$key]);
        }
        elseif (in_array($val, $exception_arr)) {
            unset($arrScriptPath[$key]);
            $max_dir_count = $key;
        }
        elseif ($key > $max_dir_count) {
            unset($arrScriptPath[$key]);
        }
        elseif ($key > $max_dir_count) {
            unset($arrScriptPath[$key]);
        }
    }

    $arrRootPath = $arrScriptPath;


    if (file_exists(implode('/', $arrRootPath).'/include'.'/config'.'/'.$dir.'/define_path.php')) {
        include(implode('/', $arrRootPath).'/include'.'/config'.'/'.$dir.'/define_path.php');
    }
    else {
        $definefile = '<?php '."\n";
        $definefile .= '!defined(\'SITE_ROOT\')?                        define(\'SITE_ROOT\',                       \''.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'ROOT_PATH\')?                        define(\'ROOT_PATH\',                       \''.implode('/', $arrRootPath).'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'BACKEND_PATH\')?                     define(\'BACKEND_PATH\',                    \''.implode('/', $arrRootPath).'/backend/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'FBILL_PATH\')?                       define(\'FBILL_PATH\',                      \''.implode('/', $arrRootPath).'/fbill/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'API_PATH\')?                         define(\'API_PATH\',                        \''.implode('/', $arrRootPath).'/api/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'API_LOG_PATH\')?                     define(\'API_LOG_PATH\',                    \''.implode('/', $arrRootPath).'/'.'log/apilog'.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'DB_LOG_PATH\')?                      define(\'DB_LOG_PATH\',                     \''.implode('/', $arrRootPath).'/'.'log/dblog'.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'INCLUDE_PATH\')?                     define(\'INCLUDE_PATH\',                    \''.implode('/', $arrRootPath).'/'.'include'.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_DIR\')?                         define(\'TWIG_DIR\',                        \''.implode('/', $arrRootPath).'/'.'include'.'/'.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_TEMPLATES\')?                   define(\'TWIG_TEMPLATES\',                  \''.implode('/', $arrRootPath).'/'.'include'.'/'.'templates'.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_TEMPLATES_CACHE\')?             define(\'TWIG_TEMPLATES_CACHE\',            \''.implode('/', $arrRootPath).'/'.'include'.'/'.'templates'.'/'.'cache'.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_TEMPLATES_COMPILES\')?          define(\'TWIG_TEMPLATES_COMPILES\',         \''.implode('/', $arrRootPath).'/'.'include'.'/'.'templates'.'/'.'compiles'.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_TEMPLATES_CONFIGS\')?           define(\'TWIG_TEMPLATES_CONFIGS\',          \''.implode('/', $arrRootPath).'/'.'include'.'/'.'templates'.'/'.'configs'.'/'.'\'):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_LEFT_DELIMITER\')?              define(\'TWIG_LEFT_DELIMITER\',             \'{\'):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_RIGHT_DELIMITER\')?             define(\'TWIG_RIGHT_DELIMITER\',            \'}\'):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_DEBUGGING\')?                   define(\'TWIG_DEBUGGING\',                  FALSE):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_CACHING\')?                     define(\'TWIG_CACHING\',                    FALSE):\'\';'."\n";
        $definefile .= '!defined(\'TWIG_CACHING_LIFETIME\')?            define(\'TWIG_CACHING_LIFETIME\',           0):\'\';'."\n";
        $definefile .= '!defined(\'DEFAULT_BACKEND\')?                  define(\'DEFAULT_BACKEND\',                 \'backend\'):\'\';'."\n";
        $definefile .= '!defined(\'DEFAULT_WEB\')?                      define(\'DEFAULT_WEB\',                     \'web\'):\'\';'."\n";
        $definefile .= '?>';
        $fp = fopen(implode('/', $arrRootPath).'/include'.'/config'.'/'.$dir.'/define_path.php', "w");
        fwrite($fp, $definefile);
        include(implode('/', $arrRootPath).'/include'.'/config'.'/'.$dir.'/define_path.php');
    }

    //Time Zone
    if (version_compare(phpversion(), '5.1.0', '>=')) {
        date_default_timezone_set('Asia/Taipei'); //PHP5
    }
    else {
        putenv("TZ=Asia/Taipei"); //PHP4
    }

    //database setup
    !defined('DB_PORT') ? define('DB_PORT', '3306') : NULL;
    !defined('DB_HOST') ? define('DB_HOST', 'localhost') : NULL;
    !defined('DB_NAME') ? define('DB_NAME', 'cathay') : NULL;
    !defined('DB_USER') ? define('DB_USER', 'root') : NULL;
    !defined('DB_PASS') ? define('DB_PASS', 'mysql') : NULL;
//    !defined('DB_NAME') ? define('DB_NAME', 'ju-house_com_cathayhong') : NULL;
//    !defined('DB_USER') ? define('DB_USER', 'ju-house_com_cathayhong') : NULL;
//    !defined('DB_PASS') ? define('DB_PASS', 'Uerh4151*') : NULL;
    !defined('DB_DEBUG') ? define('DB_DEBUG', FALSE) : NULL;
    !defined('DB_DEBUG_ECHO') ? define('DB_DEBUG_ECHO', TRUE) : NULL;
    !defined('DB_DEBUG_LOG') ? define('DB_DEBUG_LOG', TRUE) : NULL;
    !defined('DB_CHARSET') ? define('DB_CHARSET', 'utf8') : NULL;
    !defined('CACHE_PATH') ? define('CACHE_PATH', ROOT_PATH.'temp/') : NULL;

    //smarty setup
    //    define('TWIG_DIR', ROOT_PATH.'include/smarty/');//本機用
    //    define('TWIG_DIR', ROOT_PATH.'include/smarty/');//線上用
    define('TWIG_RESOURCE_CHAR_SET', 'UTF-8');
?>
