<?php

    /**
     * Class CoonManager
     * @see pramGetOne($sql, $input_parameters) 獲取單行資料
     * @see pramGetAll($sql, $input_parameters) 獲取所有資料
     * @see pramExecute($sql, $input_parameters) 執行帶參數SQL操作
     * @see pramScalar 獲取首行首列資料
     * @see getDatabaseName 獲取當前所有庫名
     * @see getTables($like) 獲取當前庫的所有表名
     * @see getFields($table) 獲取資料表裡的欄位
     * @see getLastId() 獲得最後INSERT的主鍵ID
     * @see getLimit($anum, $num) 獲取取得筆數
     * @see getFiledRow($rows) 獲取要查詢的欄位
     *
     * ex:  SELECT $connMgr->getFiledRow($rows) FROM table_name
     *          WHERE 1=1
     *          AND ( `A` REGEXP :key
     *                OR `B` REGEXP :key)
     *          AND `C` = :word
     *          $connMgr->getLimit($anum, $num)
     *      $arrPar = array('key'  => $connMgr->UtilCheckNotNull($key) ? $connMgr->getRegexpString($key, '|') : NULL,
     *                      'word' => $connMgr->UtilCheckNotNullIsNumeric($word) ? trim($word) : NULL);
     *      $aryData = $connMgr->pramGetAll($sql, $arrPar);
     *
     * ex:  INSERT INTO table_name(`A`, `B`, `C`) VALUES(:a, :b, NOW())
     *      $arrPar = array('a'  => $connMgr->UtilCheckNotNull($a) ? trim($a) : '',
     *                      'b'  => $connMgr->UtilCheckNotNull($b) ? trim($b) : '');
     *      $aryExecute = $connMgr->pramExecute($sql, $arrPar);
     *      if ($aryExecute) { return $connMgr->getLastId(); }
     *      else { return $aryExecute; }
     */
    Class ConnManager
    {
        private static $DB_Type    = '';
        private static $DB_Host    = '';
        private static $DB_Port    = '';
        private static $DB_Name    = '';
        private static $DB_User    = '';
        private static $DB_Pass    = '';
        private static $DB_Charset = '';
        private static $stmt       = NULL;
        private static $DB         = NULL;
        private static $DB_Connect = FALSE; //是否長連接
        private static $debug      = FALSE;
        private static $debug_echo = FALSE;
        private static $debug_log  = FALSE;
        private static $parms      = array();
        private static $note       = '';

        /**
         * @param null $db_host
         * @param null $db_port
         * @param null $db_name
         * @param null $db_user
         * @param null $db_pass
         * @param null $db_charset
         *
         * @todo:建構子
         *
         */
        public function __construct($db_host = NULL, $db_port = NULL, $db_name = NULL, $db_user = NULL, $db_pass = NULL, $db_charset = 'utf8')
        {
            self::$DB_Type = 'mysql';
            self::$DB_Host = $db_host ? $db_host : DB_HOST;
            self::$DB_Port = $db_port ? $db_port : DB_PORT;
            self::$DB_Name = $db_name ? $db_name : DB_NAME;
            self::$DB_User = $db_user ? $db_user : DB_USER;
            self::$DB_Pass = $db_pass ? $db_pass : DB_PASS;
            self::$DB_Connect = NULL; //ISCONNECT
            self::$DB_Charset = $db_charset ? $db_charset : DB_CHARSET; //CHARSET
            self::$debug = DB_DEBUG;
            self::$debug_echo = DB_DEBUG_ECHO;
            self::$debug_log = DB_DEBUG_LOG;
            self::connect();
            self::$DB->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
            self::$DB->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE); //false
            self::$DB->setAttribute(PDO::ATTR_PERSISTENT, TRUE);
            //self::execute('SET NAMES '.self::$DB_Charset);
            self::$note = '';
        }

        /**
         * @todo:解構子
         **/
        public function __destruct() { self::close(); }

        //錯誤處理=======================================================================//

        /**
         * @param string $sql       SQL語法
         * @param string $errorCode SQL錯誤碼
         * @param array  $errorInfo SQL錯誤訊息
         *
         * @return string
         * @todo:捕獲PDO錯誤資訊
         *
         * @see self::errorFile 顯示出錯資訊
         */
        private function getPDOError($sql)
        {
            if (self::$debug) {
                if (self::$DB->errorCode() != '00000') {
                    $info = (self::$stmt) ? self::$stmt->errorInfo() : self::$DB->errorInfo();
                    self::errorFile($sql, self::$DB->errorCode().'/PDO', json_encode($info));
                    echo(self::sqlError('mySQL Query Error', $info[2], $sql));
                    exit();
                }
                else {
                    if (self::$debug_log) {
                        self::errorFile($sql, self::$DB->errorCode().'/PDO', NULL);
                    }
                }
            }
        }

        /**
         * @param string $sql       SQL語法
         * @param string $errorCode SQL錯誤碼
         * @param array  $errorInfo SQL錯誤訊息
         *
         * @return string
         * @todo:捕獲STMT錯誤資訊
         *
         * @see self::errorFile 顯示出錯資訊
         */
        private function getSTMTError($sql)
        {
            if (self::$debug) {
                if (self::$stmt->errorCode() != '00000') {
                    $info = (self::$stmt) ? self::$stmt->errorInfo() : self::$DB->errorInfo();
                    self::errorFile($sql, self::$stmt->errorCode().'/STMT', json_encode($info));
                    echo(self::sqlError('mySQL Query Error', $info[2], $sql));
                    exit();
                }
                else {
                    if (self::$debug_log) {
                        self::errorFile($sql, self::$DB->errorCode().'/STMT', NULL);
                    }
                }
            }
        }

        /**
         * @param string $message
         * @param string $info
         * @param string $sql
         *
         * @return string 運行錯誤資訊和SQL語句
         * @todo:運行錯誤資訊
         *
         * @see self::errorFile 顯示出錯資訊
         */
        private function sqlError($message = '', $info = '', $sql = '')
        {
            $html = '<!DOCTYPE html><html lang="en">';
            $html .= '<head><title>mySQL Message</title><meta charset="UTF-8"><style type="text/css">body {margin:0px;color:#555555;font-size:12px;background-color:#efefef;font-family:Verdana}ol {margin:0px;padding:0px;}.w {width:800px;margin:100px auto;padding:0px;border:1px solid #cccccc;background-color:#ffffff;}.h {padding:8px;background-color:#ffffcc;}li {height:auto;padding:5px;line-height:22px;border-top:1px solid #efefef;list-style:none;overflow:hidden;}</style></head>';
            $html .= '<body><div class="w"><ol>';
            if ($message) {
                $html .= '<div class="h">'.$message.'</div>';
            }
            $html .= '<li>Date: '.date('Y-m-d\TH:i:sP').'</li>';
            if ($info) {
                $html .= '<li>SQLID: '.$info.'</li>';
            }
            if ($sql) {
                $html .= '<li>Error: '.$sql.'</li>';
            }
            $html .= '</ol></div></body></html>';
            self::errorFile($sql, self::$DB->errorCode().'/STMT', NULL);
            return $html;
        }

        /**
         * @param string $sql       SQL語法
         * @param string $errorCode SQL錯誤碼
         * @param array  $errorInfo SQL錯誤訊息
         *
         * @todo:寫入錯誤日志
         *
         */
        private function errorFile($sql, $errorCode, $errorInfo)
        {
            if (self::$debug_echo) {
                echo $sql.'<br />';
            }
            if ($errorInfo != NULL) {
                if (is_array($errorInfo)) {
                    $errorInfo = "\n".json_encode($errorInfo);
                }
                else {
                    $errorInfo = "\n".$errorInfo;
                }
            }
            else {
                $errorInfo = '';
            }
            $errorFile = DB_LOG_PATH.date('Ymd').'.log';
            $errorMsg = date('[Y-m-d\TH:i:sP]').'['.self::getClientIP().']'.'['.$errorCode.']'.str_replace(array("\n", "\r", "\t", " ", " ", ""), array(" ", " ", " ", " ", " ", " "), $sql).$errorInfo;
            if (!file_exists($errorFile)) {
                file_put_contents($errorFile, $errorMsg);
            }
            else {
                file_put_contents($errorFile, "\n".$errorMsg, FILE_APPEND);
            }
        }

        /**
         * @return string
         * @todo:get Client IP
         */
        private function getClientIP()
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
        //=======================================================================錯誤處理//

        //基本方法=======================================================================//
        /**
         * @todo:連結資料庫
         **/
        private function connect()
        {
            try {
                //self::$DB = new PDO(self::$DB_Type.':host='.self::$DB_Host.';port='.self:: $DB_Port.';dbname='.self::$DB_Name, self::$DB_User, self::$DB_Pass, array(PDO:: ATTR_PERSISTENT => self::$DB_Connect));
                self::$DB = new PDO(self::$DB_Type.':host='.self::$DB_Host.';port='.self:: $DB_Port.';dbname='.self::$DB_Name, self::$DB_User, self::$DB_Pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.self::$DB_Charset, PDO:: ATTR_PERSISTENT => self::$DB_Connect));
            } catch (PDOException $e) {
                die("Connect Error Infomation:".$e->getMessage());
            }
        }

        /**
         * @todo:關閉資料庫
         **/
        private function close() { self::$DB = NULL; }

        /**
         * @return array
         * @todo:獲取當前所有庫名
         */
        public function getDatabaseName()
        {
            self::$stmt = self::$DB->query('SHOW DATABASES');
            $result = self::$stmt->fetchAll(PDO::FETCH_NUM);
            self::$stmt = NULL;
            return $result;
        }

        /**
         * @param string $like 包含字串
         *
         * @return array 當前庫的所有表名
         * @todo:獲取當前庫的所有表名
         *
         */
        public function getTables($like)
        {
            self::$stmt = self::$DB->query('SHOW TABLES FROM `'.self::$DB_Name.'`'.('' != $like ? " LIKE '%$like%'" : ''));
            $result = self::$stmt->fetchAll(PDO::FETCH_NUM);
            self::$stmt = NULL;
            return $result;
        }

        /**
         * @param string $have 包含字串
         *
         * @return array 當前庫的所有表名
         * @todo:獲取當前庫的單一表名
         *
         */
        public function getTablesHave($have)
        {
            self::$stmt = self::$DB->query('SHOW TABLES FROM `'.self::$DB_Name.'`'.('' != $have ? " LIKE '$have'" : ''));
            $result = self::$stmt->fetchAll(PDO::FETCH_NUM);
            self::$stmt = NULL;
            return $result;
        }

        /**
         * @param string $table 資料表名
         *
         * @return array
         * @todo:獲取資料表裡的欄位
         *
         */
        public function getFields($table)
        {
            self::$stmt = self::$DB->query('SHOW FIELDS FROM `'.$table.'`');
            $result = self::$stmt->fetchAll(PDO::FETCH_ASSOC);
            self::$stmt = NULL;
            return $result;
        }


        /*************************************************
         * 下面的例子開始一個事務和問題的兩個語句修改資料庫回傳的變化之前。
         * 然而，在MySQL中，DROP TABLE語句自動提交事務，所以在交易中沒有任何的變化都將回傳。
         * 資料表必須是支援Transaction 的 engine，比如 InnoDB。
         * Begin a transaction, turning off autocommit
         * $dbh->beginTransaction();
         *
         * // Change the database schema and data
         * $sth = $dbh->exec("DROP TABLE fruit");
         * $sth = $dbh->exec("UPDATE dessert
         * SET name = 'hamburger'");
         *
         * // Recognize mistake and roll back changes
         * $dbh->rollBack();
         *
         * // Database connection is now back in autocommit mode
         *************************************************/
        /**
         * @todo:事務開始
         **/
        public function autocommit() { self::$DB->beginTransaction(); }

        /**
         * @todo:事務提交
         **/
        public function commit() { self::$DB->commit(); }

        /**
         * @todo:交易復原
         **/
        public function rollback() { self::$DB->rollback(); }

        /**
         * @param string $sql SQL語法
         *
         * @return number|boolean 執行語句影響行數
         * @todo:執行不返回結果的SQL
         *      INSERT\UPDATE\DELETE
         *
         */
        public function execute($sql)
        {
            self::getPDOError($sql);
            return self::$DB->exec($sql);
        }

        /**
         * @return Number 最後INSERT的主鍵ID
         * @todo:獲得最後INSERT的主鍵ID
         *
         */
        public function getLastId()
        {
            return self::$DB->lastInsertId();
        }

        /**
         * @param array $args
         *
         * @return string 合併後的SQL語句
         * @todo:獲取要操作的資料
         *
         */
        private function getCode($args)
        {
            $code = '';
            if (is_array($args)) {
                foreach ($args as $k => $v) {
                    if ($v == '') {
                        continue;
                    }
                    $code .= "`$k`='$v',";
                }
            }
            $code = substr($code, 0, -1);
            return $code;
        }

        /**
         * @param int $anum 第N筆
         * @param int $num  筆數
         *
         * @return string LIMIT SQL語法
         * @todo:獲取取得筆數
         *
         */
        public function getLimit($anum, $num)
        {
            $str_limit = '';
            if (!is_null($anum) && is_numeric($anum) && !is_null($num) && is_numeric($num)) {
                $str_limit = " LIMIT ".(string)$anum.", ".(string)$num;
            }
            return $str_limit;
        }

        /**
         * @param array $rows
         *
         * @return string 調整後的SQl語句
         * @todo:獲取要查詢的欄位
         *
         */
        public function getFiledRow($rows)
        {
            $code = '';
            if (is_null($rows) || (is_string($rows) && '' == trim($rows))) {
                $code = ' * ';
            }
            else if ('0' == $rows) {
                $code = 0;
            }
            else if (is_array($rows)) {
                foreach ($rows as $k => $v) {
                    if ($v == '') {
                        continue;
                    }
                    else {
//                    if (!strpos(strtoupper($v), ' AS ')) {
//                        if (!strpos(strtoupper($v), '.')) {
//                        }
//                        else {
//                        }
//                    }
//                    else {
//                        $code.= "`$v`,";
//                    }
                        if (!strpos(strtoupper($v), '.')) {
                            if (!strpos(strtoupper($v), ' AS ')) {
                                $code .= '`'.str_replace('`', '', $v).'`,';
                            }
                            else {
                                $arr_as = explode(' ', $v);
                                $code .= '`'.str_replace('`', '', $arr_as[0]).'` AS `'.str_replace('`', '', $arr_as[2]).'`,';
                            }
                        }
                        else {
                            $arr = explode('.', $v);
                            if ('*' == trim(str_replace('`', '', $arr[1]))) {
                                $code .= str_replace('`', '', $arr[0]).'.'.'*'.',';
                            }
                            elseif (!strpos(strtoupper($arr[1]), '*')) {
                                if (!strpos(strtoupper($v), ' AS ')) {
                                    $code .= str_replace('`', '', $arr[0]).'.'.'`'.str_replace('`', '', $arr[1]).'`'.',';
                                }
                                else {
                                    $arr_as = explode(' ', $arr[1]);
                                    $code .= str_replace('`', '', $arr[0]).'.'.'`'.str_replace('`', '', $arr_as[0]).'` AS `'.str_replace('`', '', $arr_as[2]).'`,';
                                }
                            }
                            else if (!strpos(strtoupper($arr[1]), ' AS ')) {
                                $code .= str_replace('`', '', $arr[0]).'.`'.str_replace('`', '', $arr[1]).'`,';
                            }
                            else {
                                $arr_as = explode(' ', $arr[1]);
                                $code .= str_replace('`', '', $arr[0]).'.`'.str_replace('`', '', $arr_as[0]).'` AS `'.str_replace('`', '', $arr_as[2]).'`,';
                            }
                        }
                    }
                }
                $code = substr($code, 0, -1);
            }
            else {
                $code = ' * ';
            }
            return $code;
        }

        /**
         * @param string $sql
         * @param int    $type 執行類型
         *                     0:第一筆
         *                     1:全部
         *                     2:取得第一筆資料的第一列的值;取得總筆數
         *                     3:取得第一筆資料的欄位數
         *
         * @return array|int 運行結果
         * @todo:執行具體SQL操作
         *
         */
        private function _fetch($sql, $type)
        {
            $result = array();
            self::$stmt = self::$DB->query($sql);
            self::getPDOError($sql);
            self::$stmt->setFetchMode(PDO::FETCH_ASSOC);
            switch ($type) {
                case '0':
                    $result = self::$stmt->fetch();
                    break;
                case '1':
                    $result = self::$stmt->fetchAll();
                    break;
                case '2':
                    if ($sql) {
                        $result = self::$stmt->fetchColumn();
                    }
                    elseif (self::$stmt) {
                        $result = self::$stmt->rowCount();
                    }
                    else {
                        $result = 0;
                    }
                    break;
                case '3':
                    if (self::$stmt) {
                        $result = self::$stmt->columnCount();
                    }
                    else {
                        $result = 0;
                    }
                    break;
            }
            self::$stmt = NULL;
            return $result;
        }
        //=======================================================================基本方法//

        /**
         * @param string $value
         *
         * @return bool
         * @todo:判斷資料是否存在且不為空白
         *
         */
        public function UtilCheckNotNull($value)
        {
//            if (NULL != $value && 0 != strlen(trim($value)) && '' != trim($value)) {
            if (NULL != $value) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        /**
         * @param string $value
         *
         * @return bool
         * @todo:判斷資料是否存在且不為空白且為Email
         *
         */
        public function UtilCheckNotNullIsEmail($value)
        {
            if (NULL != $value && 0 != strlen(trim($value)) && filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        /**
         * @param string $value
         *
         * @return bool
         * @todo:判斷資料是否存在且不為空白且為數字
         *
         */
        public function UtilCheckNotNullIsNumeric($value)
        {
            if (!is_array($value) && !is_null($value) && 0 != strlen(trim($value)) && is_numeric(trim($value))) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        /**
         * @param string $value
         *
         * @return bool
         * @todo:判斷是否為日期
         *
         */
        public function UtilCheckNotNullIsDate($value)
        {
            if ($value) {
                if (is_numeric($value) && 8 == strlen($value)) {
                    if (checkdate(substr($value, 4, 2), substr($value, 6, 2), substr($value, 0, 4))) {
                        return TRUE;
                    }
                    else {
                        return FALSE;
                    }
                }
                else if (!is_null($value) && '' != $value) {
                    $date = explode('-', $value);
                    if (count($date) >= 3 && checkdate($date[1], $date[2], $date[0])) {
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
            else {
                return FALSE;
            }
        }

        /**
         * @param string $value
         *
         * @return bool
         * @todo:判斷是否為日期時間
         *
         */
        public function UtilCheckNotNullIsDateTime($value)
        {
            if (!is_null($value) && '' != $value) {
                if (date('Y-m-d H:i:s', strtotime($value)) == $value) {
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

        /**
         * @param string $value
         *
         * @return bool
         * @todo:判斷是否為時間
         *
         */
        public function UtilCheckNotNullIsTime($value)
        {
            if (!is_null($value) && '' != $value) {
                if (preg_match('/(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])/', $value)) {
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

        /**
         * @param string $value
         *
         * @return string
         * @todo:判斷語言文字
         *
         */
        public function UtilCheckLanguageString($value)
        {
            $arr_language = array('CN', 'JP', 'TW');
            return in_array($value, $arr_language) ? $value : 'JP';
        }

        /**
         * @param int $table
         *
         * @return bool
         * @todo:判斷table名稱用(年月日 YYYYMMDD)
         *
         */
        public function UtilCheckTableDate($value)
        {
            if (!is_null($value) && '' != $value) {
                if (date('Ymd', strtotime($value)) == $value) {
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

        /**
         * @param string $value
         *
         * @return string
         * @todo:htmlspecialchars
         *
         */
        public function UtilHtmlSpecialChars($value)
        {
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', FALSE);
        }

        /**
         * @param string $str
         *
         * @return string
         * @todo:對字串進行轉義
         *
         */
        public function quote($str)
        {
            return self::$DB->quote($str);
        }

        /**
         * @param string $value
         *
         * @return string
         * @todo:置換危險字段
         *
         */
        public function SQLDefense($value)
        {
            //$return = htmlspecialchars($value, ENT_NOQUOTES);
            $return = htmlspecialchars($value, ENT_QUOTES, 'UTF-8', FALSE);
//            $find = array('/*', '*/', 'select', 'update', 'delete', 'information_schema', 'undefined');//'union'
//            $return = str_ireplace($find, '', $return);
            return $return;
        }

        /**
         * @param string $str
         * @param string $action
         *
         * @return string
         * @todo:取得REGEXP使用字串 $str = "1 2  3", $action = "|"  --->"1|2|3"
         *
         */
        public function getRegexpString($str, $action = '|')
        {
            $str_regexp = '';
            if ('' != $str) {
                if ('^' == $action) {
                    $str_regexp = $action.$str;
                }
                else {
                    $arr_str = explode(" ", $str);
                    foreach ($arr_str as $k => $v) {
                        if ('' != $v) {
                            $str_regexp .= $v.$action;
                        }
                    }
                    $str_regexp = substr($str_regexp, 0, -1);
                }
            }
            return $str_regexp;
        }

        /**
         * @param string $str
         * @param string $action
         *
         * @return string
         * @todo:取得REGEXP使用字串 $str = "1 2  3", $action = ","  --->"1,2,3"
         *
         */
        public function getFindInSetString($str, $action = ',')
        {
            $str_find_in_set = '';
            if ('' != $str) {
                $str = str_replace(" ", ",", $str);
                $arr_str = explode(",", $str);
                foreach ($arr_str as $k => $v) {
                    if ('' != $v) {
                        $str_find_in_set .= trim($v).$action;
                    }
                }
                $str_find_in_set = substr($str_find_in_set, 0, -1);
            }
            return $str_find_in_set;
        }
        //=======================================================================utility//

        //Pram操作方法===================================================================//
        /**
         * @param string $sql
         * @param array  $input_parameters
         *
         * @return array
         **@todo:獲取單行資料
         *
         */
        public function pramGetOne($sql, $input_parameters)
        {
            return self::_pramfetch($sql, $input_parameters, $type = '0');
        }

        /**
         * @return int
         * @todo:取得筆數
         *
         */
        public function pramGetRowCount()
        {
            $return_arr = $this->pramGetOne('SELECT FOUND_ROWS() AS `CT`', NULL);
            if (isset($return_arr) && isset($return_arr['CT'])) {
                return $return_arr['CT'];
            }
            else {
                return 0;
            }
        }

        /**
         * @param string $sql
         * @param array  $input_parameters
         *
         * @return array
         **@todo:獲取所有資料
         *
         */
        public function pramGetAll($sql, $input_parameters)
        {
            return self::_pramfetch($sql, $input_parameters, $type = '1');
        }

        /**
         * @param array $arrPar
         * @param array $sql
         *
         * @todo:取得sql
         *
         */
        public function getSQL($arrPar, $sql)
        {
            if ('' != $arrPar && count($arrPar)) {
                krsort($arrPar);
                foreach ($arrPar as $key => $val) {
                    $sql = str_replace(':'.$key, "'".$val."'", $sql);
                }
                return $sql;
            }
            else {
                return $sql;
            }
        }

        /**
         * @param string $sql
         * @param array  $input_parameters
         *
         * @return int
         **@todo:執行帶參數SQL操作
         *
         */
        public
        function pramExecute($sql, $input_parameters)
        {
            return self::_pramfetch($sql, $input_parameters, $type = '2');
        }

        /**
         * @param string $sql
         * @param array  $input_parameters
         * @param string $fieldname
         *
         * @return value
         **@todo:獲取首行首列資料
         *
         */
        public
        function pramScalar($sql, $input_parameters, $fieldname)
        {
            $row = self::_pramfetch($sql, $input_parameters, $type = '0');
            return $row[$fieldname];
        }

        /**
         * @param string $sql
         * @param array  $input_parameters
         * @param int    $type
         *
         * @return array|int
         **@todo:執行帶參數SQL操作
         *
         */
        private
        function _pramfetch($sql, $input_parameters, $type)
        {
            $result = array();
            $new_input_parameters = array();
            self::$stmt = self::$DB->prepare($sql);
            self::getPDOError($sql);
            if ('' != $input_parameters) {
                foreach ($input_parameters as $key => $value) {
                    if (NULL !== $value) {
                        $new_input_parameters[$key] = self::SQLDefense($value);
                    }
                }
            }
            $input_parameters = $new_input_parameters;
//		for ($i=0;$i<count($input_parameters);$i++) {
//			if ('' == $input_parameters[$i]) {
//				if (is_int($input_parameters[$i])) {
//					$input_parameters[$i] = 0;
//				}
//				else {
//					$input_parameters[$i] = NULL;
//				}
//			}
//		}
            self::$stmt->execute($input_parameters);
            self::getSTMTError($sql);
            self::$stmt->setFetchMode(PDO::FETCH_ASSOC);
            switch ($type) {
                case '0':
                    $result = self::$stmt->fetch();
                    break;
                case '1':
                    $result = self::$stmt->fetchAll();
                    break;
                case '2':
                    if (self::$stmt) {
                        $result = self::$stmt->rowCount();
                    }
                    else {
                        $result = 0;
                    }
                    break;
            }
            self::$stmt = NULL;
            return $result;
        }

        /**
         * @param $parameter
         * @param $variable
         * @param $data_type
         * @param $length
         *
         * @todo:添加參數
         *
         */
        public
        function pramadd($parameter, $variable, $data_type, $length)
        {
            array_push(self::$parms, array($parameter, $variable, $data_type, $length));
        }

        /**
         * @todo:清除所有參數
         **/
        public
        function pramclear()
        {
            self::$parms = array();
        }

        //===================================================================Pram操作方法//
        //Proc操作方法===================================================================//
        /**
         * @param string $sql
         *
         * @return array
         **@todo:獲取單行資料
         *
         */
        public
        function procGetOne($sql)
        {
            return self::_procfetch($sql, $type = '0');
        }

        /**
         * @param string $sql
         *
         * @return array
         **@todo:獲取所有資料
         *
         */
        public
        function procGetAll($sql)
        {
            return self::_procfetch($sql, $type = '1');
        }

        /**
         * @param string $sql
         *
         * @return int
         **@todo:執行一個預存程序過程
         *
         */
        public
        function procExecute($sql)
        {
            return self::_procfetch($sql, $type = '2');
        }

        /**
         * @todo:獲取out型的return
         **/
        public
        function getReturn()
        {
            return self::scalar("select @ireturn AS iReturn", "iReturn");
        }

        /**
         * @param string $sql
         * @param int    $type
         *
         * @return array|int
         **@todo:執行帶參數SQL操作
         *
         */
        private
        function _procfetch($sql, $type)
        {
            $result = array();
            self::$stmt = self::$DB->prepare($sql);
            self::getPDOError($sql);
            foreach (self::$parms as $pram) {
                self::$stmt->bindParam($pram[0], $pram[1], $pram[2], $pram[3]);
            }
            self::$stmt->execute();
            self::getSTMTError($sql);
            self::$stmt->setFetchMode(PDO::FETCH_ASSOC);
            switch ($type) {
                case '0':
                    $result = self::$stmt->fetch();
                    break;
                case '1':
                    // do{
                    // $result[] = self::$stmt->fetchAll();
                    // }while (self::$stmt->nextRowset());
                    $result = self::$stmt->fetchAll();
                    self::$stmt->closeCursor();
                    break;
                case '2':
                    if (self::$stmt) {
                        $result = self::$stmt->rowCount();
                    }
                    else {
                        $result = 0;
                    }
                    break;
            }
            self::$stmt = NULL;
            return $result;
        }

        /**
         * @todo:全為測試使用,目前沒有辦法獲取到OUT參數.
         *    另外在一存講過程中若有rowset,同時還有OUT參數時,
         *    即使$db->scalar("select @Rcount AS Rcount", "Rcount")這種方式仍然獲得不到,
         *    執行時會出現下面的錯誤:
         *    Cannot execute queries while other unbuffered queries are active. Consider using
         *    PDOStatement::fetchAll(). Alternatively, if your code is only ever going to run against mysql, you may
         *    enable query buffering by setting the PDO::MYSQL_ATTR_USE_BUFFERED_QUERY attribute.
         **/
        public
        function procExecOut()
        {
            $colour = 'red';//
            self::$stmt = self::$DB->prepare('CALL puree_fruit(?)');
            self::$stmt->bindParam(1, $colour, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 4000);
            self::$stmt->execute();
            print("After pureeing fruit, the colour is: $colour");
        }

        //===================================================================Proc操作方法//

        //SQL基本操作====================================================================//
        /**
         * @param string $table
         * @param array  $args
         *
         * @return array
         **@todo:插入資料 $db->insert('$table',array('title'=>'Zxsv'))
         *
         */
        public
        function insert($table, $args)
        {
            $sql = "INSERT INTO `$table` SET ";
            $code = self::getCode($table, $args);
            $sql .= $code;
            return self::execute($sql);
        }

        /**
         * @param string $table
         * @param array  $args
         * @param string $where
         *
         * @return int
         **@todo:修改資料 $db->update($table,array('title'=>'Zxsv'),array('id'=>'1'),$where ='id=3');
         *
         */
        public
        function update($table, $args, $where)
        {
            $code = self::getCode($table, $args);
            $sql = "UPDATE `$table` SET ";
            $sql .= $code;
            $sql .= " WHERE $where";
            return self::execute($sql);
        }

        /**
         * @param string $table
         * @param string $where
         *
         * @return int
         **@todo:刪除資料 $db->delete($table,$condition = null,$where ='id=3')
         *
         */
        public
        function delete($table, $where)
        {
            $sql = "DELETE FROM `$table` WHERE $where";
            return self::execute($sql);
        }

        /**
         * @param string      $table
         * @param string      $field
         * @param string|bool $where
         *
         * @return array
         **@todo:獲取單行資料 $db->fetOne($table,$condition = null,$field = '*',$where ='')
         *
         */
        public
        function fetOne($table, $field = '*', $where = FALSE)
        {
            $sql = "SELECT {$field} FROM `{$table}`";
            $sql .= ($where) ? " WHERE $where" : '';
            return self::_fetch($sql, $type = '0');
        }

        /**
         * @param string @sql
         *
         * @return array
         **@todo:獲取單行資料 select * from table where id='1'
         *
         */
        public
        function getOne($sql)
        {
            return self::_fetch($sql, $type = '0');
        }

        /**
         * @param string $sql
         * @param string $fieldname
         *
         * @return string
         **@todo:獲取首行首列資料 select `a` from table where id='1'
         *
         */
        public
        function scalar($sql, $fieldname)
        {
            $row = self::_fetch($sql, $type = '0');
            return $row[$fieldname];
        }

        /**
         * @param string $sql
         * @param string $field
         * @param string $where
         *
         * @return int
         **@todo:獲取記錄總數 $db->fetRow('$table',$condition = '',$where ='');
         *
         */
        public
        function fetRowCount($table, $field = '*', $where = FALSE)
        {
            $sql = "SELECT COUNT({$field}) AS num FROM `$table`";
            $sql .= ($where) ? " WHERE $where" : '';
            return self::_fetch($sql, $type = '2');
        }

        /**
         * @param string $sql
         *
         * @return int
         **@todo:獲取記錄總 select count(*) from table數
         *
         */
        public
        function getRowCount($sql)
        {
            return self::_fetch($sql, $type = '2');
        }

        /**
         * @param string      $table
         * @param string      $field
         * @param string|bool $orderby
         * @param string|bool $where
         *
         * @return array
         **@todo:獲取所有資料 $db->fetAll('$table',$condition = '',$field = '*',$orderby = '',$limit = '',$where='')
         *
         */
        public
        function fetAll($table, $field = '*', $orderby = FALSE, $where = FALSE)
        {
            $sql = "SELECT {$field} FROM `{$table}`";
            $sql .= ($where) ? " WHERE $where" : '';
            $sql .= ($orderby) ? " ORDER BY $orderby" : '';
            return self::_fetch($sql, $type = '1');
        }

        /**
         * @param string      $table
         * @param string      $field
         * @param string|bool $where
         * @param string|bool $orderby
         * @param int         $pagesize
         * @param int         $page
         * @param int         $pagecount
         * @param int         $recordcount
         *
         * @return array
         * @todo:獲取分頁資料
         *
         */
        public
        function fetPageAll($table, $field = '*', $where = FALSE, $orderby = FALSE, $pagesize, &$page, &$pagecount, &$recordcount)
        {
            $sql = "SELECT {$field} FROM `{$table}`";
            $sql .= ($where) ? " WHERE $where" : '';
            return self::getPageAll($sql, $orderby, $pagesize, $page, $pagecount, $recordcount);
        }

        /**
         * @param string $sql
         *
         * @return array
         **@todo:獲取所有資料 select * from table
         *
         */
        public
        function getAll($sql)
        {
            return self::_fetch($sql, $type = '1');
        }

        /**
         * @param string      $sql
         * @param string|bool $orderby
         * @param int         $pagesize
         * @param int         $page
         * @param int         $pagecount
         * @param int         $recordcount
         *
         * @return array
         * @todo:獲取分頁資料
         *
         */
        public
        function getPageAll($sql, $orderby = FALSE, $pagesize, &$page, &$pagecount, &$recordcount)
        {
            $sqlcount = "SELECT COUNT(1) AS `recordcount` FROM ($sql) AS DT;";
            $recordcount = self::scalar($sqlcount, 'recordcount');
            self::count($pagesize, $page, $pagecount, $recordcount);
            $start = ($page - 1) * $pagesize;
            $sql .= ($orderby) ? " ORDER BY $orderby" : '';
            $sql .= " limit $start,$pagesize";
            return self::_fetch($sql, $type = '1');
        }

        /**
         * @todo:連結其他server並且在當前database產生同步的資料表
         *    參數:$sql = CREATE TABLE federated_table (
         *                    id INT(20) NOT NULL AUTO_INCREMENT,
         *                    name VARCHAR(32) NOT NULL DEFAULT '',
         *                    other INT(20) NOT NULL DEFAULT '0',
         *                    PRIMARY KEY (id),
         *                    INDEX name (name),
         *                    INDEX other_key (other)
         *                )
         *         $sql ENGINE=FEDERATED $connection='mysql://$db_user:$db_pass@$db_host:$db_port/$db_name/$db_table'
         *    備註:5.0.13版以前，要用COMMENT代替CONNECTION
         **/
        public
        function setFederatedTable($sql, $db_user, $db_pass, $db_host, $db_name, $db_table, $connection = 'CONNECTION', $db_port = '3306')
        {
            $sql = "$sql ENGINE=FEDERATED $connection='mysql://$db_user:$db_pass@$db_host:$db_port/$db_name/$db_table'";
            return self::$DB->exec($sql);
        }

        //====================================================================SQL基本操作//
        //mysql_query===================================================================//
        /**********************************************************************
         * function INSERT/UPDATE/DELETE($par1, $par2, ...) {
         * //open connection
         * $connMgr = new ConnManager();
         * $conn = $connMgr->openConn();
         * if (!$conn) {
         * return false;
         * }
         * //do update
         * $result = mysql_query($sql);
         * $connMgr->closeConn();
         * return $result;
         * }
         *
         * function query($par1, $par2, ...) {
         * //open connection
         * $connMgr = new ConnManager();
         * $conn = $connMgr->openConn();
         * if (!$conn) {
         * return false;
         * }
         * //do query
         * $result = mysql_query($sql);
         * $aryData = $connMgr->resourceToArray($result);
         * mysql_free_result($result);
         * $connMgr->closeConn(); //close connection
         * return $aryData;
         * }
         **********************************************************************/
        /**
         * @todo:資料庫連結
         **/
        public
        function openConn()
        {
            //open connection
            $link = mysql_connect(self::$DB_Host, self::$DB_User, self::$DB_Pass);
            mysql_query("SET NAMES 'utf8'");
            if (!$link) {
                error_log('Open connection failed..'.mysql_error());
                return FALSE;
            }
            //selected database
            $isDBSelected = mysql_select_db(self::$DB_Name, $link);
            if (!$isDBSelected) {
                error_log('Can not use'.self::$DB_Name.'..'.mysql_error());
                return FALSE;
            }
            return TRUE;
        }

        /**
         * @todo:關閉資料庫連結
         **/
        public
        function closeConn()
        {
            return mysql_close();
        }

        /**
         * @param array $result
         *
         * @return array類型:陣列
         **@todo:重整資料陣列
         *
         */
        public
        function resourceToArray($result)
        {
            $aryData = array();
            $cnt = 0;
            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                foreach ($row as $key => $val) {
                    $aryData[$cnt][$key] = $val;
                }
                $cnt++;
            }

            return $aryData;
        }
        //===================================================================mysql_query//
    }
