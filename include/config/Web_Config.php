<?php
/**
 * =============================================================================
 * 標　　題: %DocumentRoot%/include/config/Web_Config.php
 * 系統名稱: Web_Config
 * 功能描述: 前台用設定檔
 * 頁面描述: PHP
 * 作　　者:
 * 撰寫日期: 2010-10-29
 * 修改描述:
 * =============================================================================
**/
    header('Content-type: text/html; charset=utf-8');
    include 'Config.php';
    session_start();
    include INCLUDE_PATH.'class/ConnManager.class.php';

    $default_path = 'web';

    define('DEFAULT_TITLE', 'JU-House 哲宇玩具');
    define('DEFAULT_BEST_URL', 'http://www.ju-house.ks/');
    define('DEFAULT_PUB', 'JU-House');

    //check post & get value
//    foreach ($_POST as $k => $v) {
//        if (!in_array($k, array('FS', 'IP', 'CODE', 'TIME'))) {
//            if (is_array($v)) {
//                for ($i = 0; $i < sizeof($v); $i++) {
//                    $_POST[$k][$i] = htmlspecialchars($v[$i], ENT_QUOTES, 'UTF-8', FALSE);
//                }
//            }
//            else {
//                $_POST[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8', FALSE);
//            }
//        }
//    }
//    foreach ($_GET as $k => $v) {
//        if (!in_array($k, array('FS', 'IP', 'CODE', 'TIME'))) {
//            if (is_array($v)) {
//                for ($i = 0; $i < sizeof($v); $i++) {
//                    $_GET[$k][$i] = htmlspecialchars($v[$i], ENT_QUOTES, 'UTF-8', FALSE);
//                }
//            }
//            else {
//                $_GET[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8', FALSE);
//            }
//        }
//    }
?>
