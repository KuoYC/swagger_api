<?php
    /**
     * =============================================================================
     * 標　　題: %DocumentRoot%/include/config/Backend_Config.php
     * 系統名稱: Backend_Config
     * 功能描述: 後台用設定檔
     * 頁面描述: PHP
     * 作　　者:
     * 撰寫日期: 2010-10-29
     * 修改描述:
     * =============================================================================
     **/
    header('Content-type: text/html; charset=utf-8');
    include 'Config.php';
    include TWIG_DIR.'autoload.php';
    session_start();
    include INCLUDE_PATH.'class/ConnManager.class.php';
    include INCLUDE_PATH.'util/PermissionManager.php';
    $PermissionMgr = new PermissionManager();

    //    include INCLUDE_PATH.'class/FBannerManager.class.php';
    //    $BannerMgr = new FBannerManager();
    //    $a_list = $BannerMgr->queryBanner(array('B_NO'), '', ',1, 2, 3,4,9', '', '', '');
    //    print_r($a_list);
    //    echo '<br/>';
    //    $b_list = $BannerMgr->queryBanner(array('B_NO'), '', ',3,', '', '', '');
    //    print_r($b_list);die;
    //    for ($i = 0; $i < $a_list['count']; $i++) {
    //        print_r($a_list[$i]);
    //        echo '<br/>';
    //    }
    //    die;
    //    $Conn = new ConnManager();
    //    $sql = " SELECT ".$Conn->getFiledRow(array('Admin_NO', 'Admin_Account')).' FROM admin where `Admin_Account` REGEXP :key OR `Admin_NO` REGEXP :key
    //             AND Admin_Cookies_Status = :status '.$Conn->getLimit(0, 2);
    //    $arrPar = array('key' => 'a', 'status' => '0');
    //    print_r($Conn->pramGetAll($sql, $arrPar));
    //    //$DomMgr->queryDomClass();

    $default_path = 'backend';

    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;
    use Twig\TwigFilter;

    $loader = new FilesystemLoader(TWIG_TEMPLATES.$default_path);
    $twig = new Environment($loader);

    //backend setup
    //    define('ADMIN_ID', 'admin');
    //    define('ADMIN_PW', 'demo');
    $cms_config = array(['CMS_TITLE', 'TWIG CMS', NULL],
                        ['CMS_DESIGN', 'Design by KS', NULL],
                        ['CMS_DESIGN_URL', '#', NULL],
                        ['CMS_URL', '#', NULL],
                        ['CMS_COPYRIGHT', 'Copyright @ 2023', NULL],
                        ['CMS_URI', urlencode($_SERVER['REQUEST_URI']), NULL],
                        ['CMS_DARK_SKIN', TRUE, NULL],//是否開始黑暗模式
                        ['CMS_LIST_BUTTON_SIZE', 'fa-lg', NULL],//列表按鈕大小 fa-lg, fa-2x, fa-3x, fa-4x, fa-5x, 空白
                        ['CMS_LIST_NUMBERING', TRUE, NULL],//列表是否顯示序號
                        ['CMS_LIST_SERNO', TRUE, NULL],//列表是否顯示編號
                        ['CMS_REDIRECT_SEL', TRUE, NULL],//新增或修改完轉址至查看頁
                        ['CMS_CONFIG_TRANSLATE', TRUE, NULL],//配置文件名稱
                        ['CMS_CONFIG_LANGUAGE', 'zh_TW', NULL],//配置文件語言
                        ['CMS_LANGUAGE', 'zh_TW', NULL],//語言
                        ['CMS_GMT', '+8 hours', NULL],//時區
                        ['CMS_MENU_PATH', TRUE, NULL],//是否顯示頁面路徑
                        ['CMS_BID_STRLEN', 3, NULL],//設定bid字串長度
                        ['CMS_AC_STRLEN', 2, NULL],//設定ac字串長度
                        ['CMS_ADM_COMPETENCE', TRUE, NULL],//是否使用權限設定(群組)
                        ['CMS_ADM_COMPLETE', TRUE, NULL],//是否使用完整版管理者
                        ['CMS_ADM_COOKIES', FALSE, NULL],//是否使用Cookies登入
                        ['CMS_ADM_COOKIES_NAME', 'admuid', NULL],//Cookies名稱
                        ['CMS_ADM_COOKIES_DAYS', 1, NULL],//使用Cookies登入限制天數0為不限制
                        ['CMS_ADM_LOCK', FALSE, NULL],//是否使用時間鎖
                        ['CMS_ADM_LOCK_TIME', 1 * 60, NULL],//超過N秒中自動鎖定
                        ['CMS_ADM_LOCK_OUT', 1 * 60, NULL],//超過N秒中自動登出
                        ['CMS_PAGE_SESSION', TRUE, NULL],//是否紀錄列表頁次
                        ['CMS_PAGE_SELECT', TRUE, NULL],//頁次下拉選單
                        ['CMS_PAGE_THREE', TRUE, NULL],
                        ['CMS_PAGE_FIVE', TRUE, NULL],
                        ['CMS_PAGE_TEN', TRUE, NULL],
                        ['CMS_PAGE_SIZE', 10, NULL],//預設後台分頁數 (<<, <, >, >>)
                        ['CMS_PAGE_RANGE_SIZE', 5, NULL],//預設後台分頁數 (1,2,3,4,5...)
    );
    if (!empty($cms_config) && is_array($cms_config)) {
        foreach ($cms_config as $val) {
            !defined($val[0]) ? define($val[0], $val[1]) : $val[2];
            $twig->addGlobal($val[0], $val[1]);
        }
    }
    //check post & get value
    foreach ($_POST as $k => $v) {
        if (!in_array($k, array('FS', 'IP', 'CODE', 'TIME', 'uri'))) {
            if (is_array($_POST[$k])) {
                for ($i = 0; $i < count($_POST[$k]); $i++) {
                    $_POST[$k][$i] = htmlspecialchars($_POST[$k][$i], ENT_QUOTES, 'UTF-8', FALSE);
                }
            }
            else {
                $_POST[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8', FALSE);
            }
        }
    }
    foreach ($_GET as $k => $v) {
        if (!in_array($k, array('FS', 'IP', 'CODE', 'TIME', 'uri'))) {
            if (is_array($_GET[$k])) {
                for ($i = 0; $i < count($_GET[$k]); $i++) {
                    $_GET[$k][$i] = htmlspecialchars($_GET[$k][$i], ENT_QUOTES, 'UTF-8', FALSE);
                }
            }
            else {
                $_GET[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8', FALSE);
            }
        }
    }
?>
