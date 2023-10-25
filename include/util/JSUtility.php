<?php

    /**
     * =============================================================================
     * 標　　題: %DocumentRoot%/Cosmos/include/util/JSUtility.php
     * 系統名稱: Cosmos
     * 功能描述: JavaScript 處理相關
     * 頁面描述: PHP
     * 作　　者: Trully.Tsai
     * 撰寫日期: 2008-11-18
     * 修改描述:
     * =============================================================================
     */
    Class JSUtility
    {
        /**
        * javascript alert
        *
        * @param $msg 顯示訊息
        */
        function jsAlert($msg)
        {
        print <<< _HTML_1
        <html>
        <head>
        <meta http-equiv="Content-Language" content="zh-tw">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <body>
        <script language="Javascript">
        alert("$msg");
        </script>
        </body>
        </html>
_HTML_1;
        }

        /**
        * javascript location.href & alert
        *
        * @param $url
        * @param $msg [optional] 顯示訊息
        */
        function jsRedirect($url, $msg = '')
        {
        print <<< _HTML_1
        <html>
        <head>
        <meta http-equiv="Content-Language" content="zh-tw">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <body>
        <script language="Javascript">
        <!--

_HTML_1;

        if (strlen($msg) > 0) {
        print <<< _HTML_2
        alert("$msg");
_HTML_2;
        }

        print <<< _HTML_3
        location.href = "$url";
        //-->
        </script>
        </body>
        </html>
_HTML_3;
        }

        function jsBack($msg)
        {
        print <<< _HTML_1
        <html>
        <head>
        <meta http-equiv="Content-Language" content="zh-tw">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <body>
        <script language="Javascript">
        <!--

_HTML_1;

        if (strlen($msg) > 0) {
        print <<< _HTML_2
        alert("$msg");
_HTML_2;
        }

        print <<< _HTML_3
        history.back();
        //-->
        </script>
        </body>
        </html>
_HTML_3;
        }

        function jsCleanParent($id)
        {
        print <<< _HTML_1
        <html>
        <head>
        <meta http-equiv="Content-Language" content="zh-tw">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <body>
        <script language="Javascript">
        <!--

_HTML_1;

        if (strlen($id) > 0) {
        print <<< _HTML_2
        window.parent.document.getElementById("$id").value = "";
_HTML_2;
        }

        print <<< _HTML_3
        //-->
        </script>
        </body>
        </html>
_HTML_3;
        }

        function jsCallParentFunction($function)
        {
        print <<< _HTML_1
        <html>
        <head>
        <meta http-equiv="Content-Language" content="zh-tw">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <body>
        <script language="Javascript">
        <!--

_HTML_1;

        if (strlen($function) > 0) {
        print <<< _HTML_2
        parent.$function;
_HTML_2;
        }

        print <<< _HTML_3
        //-->
        </script>
        </body>
        </html>
_HTML_3;
        }

        function jsParentReload()
        {
            print <<< _HTML_1
        <html>
        <head>
        <meta http-equiv="Content-Language" content="zh-tw">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        </head>
        <body>
        <script language="Javascript">
        <!--
        parent.location.reload();
        //-->
        </script>
        </body>
        </html>
_HTML_1;
        }
    }

?>
