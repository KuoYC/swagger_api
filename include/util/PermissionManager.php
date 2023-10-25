<?php

    /**
     * =============================================================================
     * 標　　題: %DocumentRoot%/Cosmos/include/util/Utility.php
     * 系統名稱: Cosmos
     * 功能描述: 資料處理相關
     * 頁面描述: PHP
     * 作　　者:
     * 撰寫日期: 2013-08-28
     * 修改描述:
     * =============================================================================
     */
    class PermissionManager
    {
        //check page permission
        public function ckPagePermission($bid, $ac = NULL)
        {
            //check page
            if (!isset($_GET['bid']) || $_GET['bid'] != $bid) {
                header('Location:./404.php');
                die();
            }
            if (!empty($ac)) {
                if (!isset($_GET['ac']) || $_GET['ac'] != $ac) {
                    header('Location:./404.php');
                    die;
                }
            }
            //=============
            //check admin
            if (!isset($_SESSION['admin']) || '' == $_SESSION['admin']) {
                header('Location:./404.php');
                die;
            }
            //=============
            //check purview
            if (CMS_ADM_COMPETENCE && (!isset($_SESSION['admin']['AG_Purview']) || '1' != $_SESSION['admin']['AG_Purview'][$bid.(!empty($ac) ? '_'.$ac : '')])) {
                header('Location:./404.php');
                die;
            }
            //=============
            return TRUE;
        }

        //取得JSON值
        private function GetJsonValue($json_string, $var)
        {
            if (is_array($json_string)) {
                return isset($json_string[$var]) ? $json_string[$var] : 'ERROR';
            }
            else {
                $str_arr = json_decode($json_string, TRUE);
                if ('' != $var) {
                    $arr_var = explode('->', $var);
                    $arr = '';
                    $arr = $str_arr;
                    foreach ($arr_var as $value) {
                        if (!is_array($arr)) {
                            $arr = 'ERROR';
                            break;
                        }
                        else {
                            if (isset($arr[$value])) {
                                $arr = $arr[$value];
                            }
                            else {
                                $arr = 'NULL';
                                break;
                            }
                        }
                    }
                    return $arr;
                }
                else {
                    return 'ERROR';
                }
            }
        }

        //設定session
        public function setSearchSession($SessionTitle, $array_string)
        {
            if (is_array($array_string)) {
                foreach ($array_string as $value) {
                    $_SESSION[$SessionTitle.$value] = $_POST[$value];
                }
            }
            $this->ckUsePageSession($SessionTitle, 1);
        }

        //清除session
        public function unsetSearchSession($SessionTitle, $array_string)
        {
            if (is_array($array_string)) {
                foreach ($array_string as $value) {
                    if (isset($_SESSION[$SessionTitle.$value])) {
                        unset($_SESSION[$SessionTitle.$value]);
                    }
                }
            }
            $this->ckUsePageSession($SessionTitle, 1);
        }

        //page session
        public function ckUsePageSession($SessionTitle, $setPage = NULL)
        {
            $redirect = FALSE;
            if (CMS_PAGE_SESSION) {
                $_SESSION[$SessionTitle.'Page'] = isset($_GET['page']) && $_GET['page'] != '' && is_numeric($_GET['page']) ? $_GET['page'] : $_SESSION[$SessionTitle.'Page'];
                $page = $_SESSION[$SessionTitle.'Page'];
            }
            $page = isset($_GET['page']) && $_GET['page'] != '' ? $_GET['page'] : (isset($_SESSION[$SessionTitle.'Page']) && CMS_PAGE_SESSION ? $_SESSION[$SessionTitle.'Page'] : 1); //目前頁數
            if ($page != $_GET['page']) {
                $redirect = TRUE;
            }
            if ($setPage) {
                $_SESSION[$SessionTitle.'Page'] = $setPage;
                $redirect = TRUE;
            }
            return $redirect;
        }

        public function getPageSession($SessionTitle, $setPage = NULL)
        {
            $page = NULL;
            if (CMS_PAGE_SESSION) {
                $_SESSION[$SessionTitle.'Page'] = isset($_GET['page']) && $_GET['page'] != '' && is_numeric($_GET['page']) ? $_GET['page'] : $_SESSION[$SessionTitle.'Page'];
                $page = $_SESSION[$SessionTitle.'Page'];
            }
            $page = isset($_GET['page']) && $_GET['page'] != '' ? $_GET['page'] : (isset($_SESSION[$SessionTitle.'Page']) && CMS_PAGE_SESSION ? $_SESSION[$SessionTitle.'Page'] : 1); //目前頁數
            if ($setPage) {
                $page = $setPage;
                $_SESSION[$SessionTitle.'Page'] = $setPage;
            }
            return $page;
        }

        private function test()
        {
            if (isset($_SESSION['for']) && is_numeric($_SESSION['for'])) {
                $_SESSION['for'] += 1;
            }
            else {
                $_SESSION['for'] = 1;
            }
        }
    }

?>
