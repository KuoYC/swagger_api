<?php

    /**
     * =============================================================================
     * 標　　題: %DocumentRoot%/Cosmos/include/util/UtilityManager.class.php
     * 系統名稱: Cosmos
     * 功能描述: 資料處理相關
     * 頁面描述: PHP
     * 作　　者:
     * 撰寫日期: 2013-08-28
     * 修改描述:
     * =============================================================================
     */
    class UtilityManager
    {
        //@param $ip 127.0.0.1
        public function iptolong($ip)
        {
            list($a, $b, $c, $d) = explode('.', $ip);;
            return (($a * 256 + $b) * 256 + $c) * 256 + $d;
            //return sprintf("%u", ip2long('192.168.1.2'));
        }

        //編碼 &[&amp;] '[&#039;] "[&quot;] <[&lt;] >[&gt;]
        //@param $quotestyle { ENT_COMPAT:&"<> | ENT_QUOTES:&'"<> | ENT_NOQUOTES:&<> }
        public function SpecialString($string, $quotestyle = ENT_QUOTES, $double_encode = FALSE)
        {
            return str_replace(':', '&#58;', htmlspecialchars($string, $quotestyle, 'UTF-8', $double_encode));
        }

        //置換get參數
        //@param $query_string 原始字串 $query 參數名稱  $string 置換內容
        public function ReplaceQueryString($query_string, $query, $string)
        {
            $new_query_string = '';
            $arr_query_string = explode('&', trim($query_string));
            for ($i = 0; $i < count($arr_query_string); $i++) {
                $arr_string = explode('=', trim($arr_query_string[$i]));
                if ($query == $arr_string[0]) {
                    if ('' != $string) {
                        $new_query_string .= $arr_string[0].'='.$string.'&';
                    }
                }
                else {
                    $new_query_string .= $arr_query_string[$i].'&';
                }
            }
            return substr($new_query_string, 0, -1);
        }

        //刪除get參數
        //@param $query_string 原始字串 $query 參數名稱  $string 置換內容
        public function DeleteQueryString($query_string, $arr_query)
        {
            $new_query_string = '';
            $arr_query_string = explode('&', trim($query_string));
            for ($i = 0; $i < count($arr_query_string); $i++) {
                $arr_string = explode('=', trim($arr_query_string[$i]));
                $ck_arr_query = FALSE;
                foreach ($arr_query as $value) {
                    if ($arr_string[0] == $value) {
                        $ck_arr_query = TRUE;
                    }
                }
                if (!$ck_arr_query) {
                    $new_query_string .= $arr_query_string[$i].'&';
                }
            }
            return substr($new_query_string, 0, -1);
        }

        //置換get參數
        //@param $query_string 原始字串 $query 參數名稱
        public function GetQueryStringValue($query_string, $query)
        {
            $value = '';
            $arr_query = explode('&', trim($query_string));
            for ($i = 0; $i < count($arr_query); $i++) {
                $arr_string = explode('=', trim($arr_query[$i]));
                if ($query == $arr_string[0]) {
                    $value = $arr_string[1];
                    break;
                }
            }
            return $value;
        }

        //取得url參數並且編碼 &[&amp;] '[&#039;] "[&quot;] <[&lt;] >[&gt;]
        //@param $query_string 原始字串
        //@param $quotestyle { ENT_COMPAT:&"<> | ENT_QUOTES:&'"<> | ENT_NOQUOTES:&<> }
        public function GetUrlQueryString($query_string, $quotestyle = ENT_QUOTES)
        {
            if ('' != $query_string) {
                return str_replace(':', '&#58;', htmlspecialchars(rawurldecode($query_string), $quotestyle, 'UTF-8'));
            }
        }

        //判斷資料是否存在且不為空白
        public function UtilCheckNotNull($value)
        {
            if (NULL != $value && 0 != strlen(trim($value))) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        //判斷資料是否存在且不為空白且為數字
        public function UtilCheckNotNullIsNumeric($value)
        {
            if (NULL != $value && 0 != strlen(trim($value)) && is_numeric(trim($value))) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        //判斷是否為日期格式
        public function UtilCheckDate($date)
        {
            return (date('Y-m-d', strtotime($date)) == $date);
        }

        //判斷是否為日期時間格式
        public function UtilCheckDateTime($datetime)
        {
            return (date('Y-m-d H:i:s', strtotime($datetime)) == $datetime);
        }

        //電子信箱驗證
        public function PregMatchEmail($string)
        {
            $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
            if (preg_match($regex, $string)) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        //帳號密碼驗證
        public function PregMatchPasswordAccount($string)
        {
            $regex = '/^[0-9\-()+]{3,20}$/';
            if (preg_match($regex, $string)) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }

        //取得JSON值
        public function GetJsonValue($json_string, $var)
        {
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

        //將Json轉成Array
        function Json2Array($jsonObj)
        {
            $result = array();
            foreach ($jsonObj as $key => $val) {
                if (is_object($val) || is_array($val)) {
                    $result[$key] = $this->Json2Array($val);
                }
                else {
                    $result[$key] = $val;
                }
            }
            return $result;
        }

        //設定分頁
        public function SetNowPage($page, $page_size)
        {
            return (string)($page == '' || $page == '0' || !is_numeric($page) ? '0' : ($page - 1) * $page_size);
        }

        //置換潛藏回顯關鍵字
        function quotes($content)
        {
            $return = "";
            if (!get_magic_quotes_gpc()) {
                $content = addslashes($content);
            }
//		$content = str_replace(" ","",$content);
            if (is_numeric(stripos($content, "/*"))) {
            }
            elseif (is_numeric(stripos($content, "*/"))) {
            }
            elseif (is_numeric(stripos($content, "select"))) {
            }
            elseif (is_numeric(stripos($content, "update"))) {
            }
            elseif (is_numeric(stripos($content, "delete"))) {
            }
            elseif (is_numeric(stripos($content, "union"))) {
            }
            elseif (is_numeric(stripos($content, "information_schema"))) {
            }
            elseif (is_numeric(stripos($content, "undefined"))) {
            }
            else {
                $return = $content;
            }
            return $return;
        }

        function check_mobile()
        {
            $regex_match = "/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
            $regex_match .= "htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
            $regex_match .= "blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
            $regex_match .= "symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
            $regex_match .= "jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
            $regex_match .= ")/i";
            return preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
        }

        function useEncode($string = '', $skey = '123qweASDZXC.')
        {
            $strArr = str_split(base64_encode($string));
            $strCount = count($strArr);
            foreach (str_split($skey) as $key => $value)
                $key < $strCount && $strArr[$key] .= $value;
            return str_replace(array('=', ' ', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
        }

        function useDecode($string = '', $skey = '123qweASDZXC.')
        {
            $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', ' ', '/'), $string), 2);
            $strCount = count($strArr);
            foreach (str_split($skey) as $key => $value)
                $key < $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
            return base64_decode(join('', $strArr));
        }

        function setTempFile($file_name, $str, $file_path = ROOT_PATH)
        {
            $file = fopen($file_path.'tmp/'.$file_name, 'w');
            fwrite($file, $str);
            fclose($file);
            return file_exists($file_path.'tmp/'.$file_name);

        }

        function getTempFile($file_name, $file_path = ROOT_PATH)
        {
            $str = '';
            if (file_exists($file_path.'tmp/'.$file_name)) {
                $str = file_get_contents($file_path.'tmp/'.$file_name);
            }
            else {
                return FALSE;
            }
            return $str;
        }

        /**
         * @param $url
         *
         * @return string
         * @todo:取得curl cookies
         */
        function getCurlCookies($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36');
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); //設定CURL是否跟隨HEADER發送的LOCATION
            $result = curl_exec($ch);
            list($header, $body) = explode("\r\n\r\n", $result, 2);
            $end = strpos($header, 'Content-Type');
            $start = strpos($header, 'Set-Cookie');
            $parts = explode('Set-Cookie:', substr($header, $start, $end - $start));
            $cookies = array();
            foreach ($parts as $co) {
                $cd = explode(';', $co);
                if (!empty($cd[0]))
                    $cookies[] = $cd[0];
            }
            return implode(';', $cookies);
        }

        /**
         * @param $url
         *
         * @return string
         * @todo:取得https curl cookies
         */
        function getCurlHttpsCookies($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36');
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); //設定CURL是否跟隨HEADER發送的LOCATION
            $result = curl_exec($ch);
            list($header, $body) = explode("\r\n\r\n", $result, 2);
            $end = strpos($header, 'Content-Type');
            $start = strpos($header, 'Set-Cookie');
            $parts = explode('Set-Cookie:', substr($header, $start, $end - $start));
            $cookies = array();
            foreach ($parts as $co) {
                $cd = explode(';', $co);
                if (!empty($cd[0]))
                    $cookies[] = $cd[0];
                echo $cd[0];
            }
            return implode(';', $cookies);
        }

        /**
         * @param $ch
         *
         * @return mixed|string
         * @todo:轉碼
         */
        function curl_exec_utf8($ch)
        {
            $data = curl_exec($ch);
            if (!is_string($data))
                return $data;

            unset($charset);
            $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

            /* 1: HTTP Content-Type: header */
            preg_match('@([\w/+]+)(;\s*charset=(\S+))?@i', $content_type, $matches);
            if (isset($matches[3]))
                $charset = $matches[3];

            /* 2: <meta> element in the page */
            if (!isset($charset)) {
                preg_match('@<meta\s+http-equiv="Content-Type"\s+content="([\w/]+)(;\s*charset=([^\s"]+))?@i', $data, $matches);
                if (isset($matches[3]))
                    $charset = $matches[3];
            }

            /* 3: <xml> element in the page */
            if (!isset($charset)) {
                preg_match('@<\?xml.+encoding="([^\s"]+)@si', $data, $matches);
                if (isset($matches[1]))
                    $charset = $matches[1];
            }

            /* 4: PHP's heuristic detection */
            if (!isset($charset)) {
                $encoding = mb_detect_encoding($data);
                if ($encoding)
                    $charset = $encoding;
            }

            /* 5: Default for HTML */
            if (!isset($charset)) {
                if (strstr($content_type, "text/html") === 0)
                    $charset = "ISO 8859-1";
            }

            /* Convert it if it is anything but UTF-8 */
            /* You can change "UTF-8"  to "UTF-8//IGNORE" to
              ignore conversion errors and still output something reasonable */
            if (isset($charset) && strtoupper($charset) != "UTF-8")
                $data = iconv($charset, 'UTF-8', $data);

            return $data;
        }

        /**
         * todo:curl
         *
         * @param $url
         * @param $clientIP
         * @param $extraHeader
         * @param $postData
         *
         * @return mixed|string
         */
        function fetchURL($url, $clientIP, $extraHeader, $postData, $timeout = 30)
        {
            $result = '';
            if (is_null($url) || empty($url)) {
                return '';
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 7.0.4; Galaxy Build/IMM76B) AppleWebKit/535.19 (KHTML, like Gecko) Chrome'.$clientIP);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "REMOTE_ADDR: $clientIP",
                "X_FORWARDED_FOR: $clientIP",
                $extraHeader
            ));
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            if (!empty($postData)) {
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            }
            $result = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
                $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($result, 0, $headerSize);
                $body = substr($result, $headerSize);
                if ('' == $header) {
                    list($header, $body) = explode("\r\n\r\n", $result, 2);
                }
            }
            curl_close($ch);
            if (isset($header) && isset($body)) {
                $result = array('header' => $header,
                                'body'   => $body,
                                'all'    => $result);
            }
            else {
                $result = array('body' => $result,
                                'all'  => $result);
            }
            return $result;
        }

        function special_str($string, $quotestyle = ENT_QUOTES)
        {
            return str_replace(':', '&#58;', htmlspecialchars($string, $quotestyle, 'UTF-8', FALSE));
        }

        function special_str_de($string, $quotestyle = ENT_QUOTES)
        {
            return str_replace('&#58;', ':', htmlspecialchars_decode($string, $quotestyle));
        }
    }

?>
