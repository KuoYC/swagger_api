<?php

    /**
     * Class Verification
     *
     * @param number  $VF_IP      來源IP
     * @param number  $VF_TIME    來源時間
     * @param string  $VF_CK_CODE 來源驗證碼
     * @param string  $APP_KEY    金鑰
     * @param boolean $error_log  是否存入log檔
     */
    class Verification
    {
        private static $VF_IP;
        private static $VF_TIME;
        private static $VF_CK_CODE;
        private static $APP_KEY;
        private static $error_log = NULL;

        public function __construct()
        {
            self::$VF_IP = 0;
            self::$VF_TIME = 0;
            self::$VF_CK_CODE = '';
            self::$APP_KEY = API_CODE;
            self::$error_log = API_DEBUG_LOG;
        }

        public function setIP($ip)
        {
            self::$VF_IP = $ip;
        }

        public function setTIME($time)
        {
            self::$VF_TIME = $time;
        }

        public function setCODE($ck_code)
        {
            self::$VF_CK_CODE = $ck_code;
        }

        public function checkCode()
        {
            if (is_numeric(self::$VF_IP) && is_null(self::$VF_TIME)) {
                $ip = long2ip(self::$VF_IP);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    $md5_code = strtoupper(md5($ip.self::$APP_KEY.self::$VF_TIME));
                    self::errorFile();
                    if ($md5_code == self::$VF_CK_CODE) {
                        return TRUE;
                    }
                    else {
                        return FALSE;
                    }
                }
                else {
                    return FALSE;
                }
            }
        }

        /**
         * 寫入錯誤日志
         *
         * @param array $_REQUEST 所有參數值
         */
        private function errorFile()
        {
            if (self::$error_log) {
                $errorFile = API_LOG_PATH.date('Ymd').'.log';
                $errorMsg = date('[Y-m-d\TH:i:sP]').'['.self::getClientIP().']'.'['.json_encode($_REQUEST).']';
                if (!file_exists($errorFile)) {
                    file_put_contents($errorFile, $errorMsg);
                }
                else {
                    file_put_contents($errorFile, "\n".$errorMsg, FILE_APPEND);
                }
            }
        }

        /**
         * get Client IP
         * @return string
         */
        private
        function getClientIP()
        {
            $ipaddress = '';
            if ($_SERVER['HTTP_CLIENT_IP'])
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if ($_SERVER['HTTP_X_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if ($_SERVER['HTTP_FORWARDED_FOR'])
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if ($_SERVER['HTTP_FORWARDED'])
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if ($_SERVER['REMOTE_ADDR'])
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }
    }