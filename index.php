<?php
//    $str ='[ { "time": "2023-09-05 08:45:45", "msg": "test" }, { "time": "2023-09-05 08:45:45", "msg": "test2" }, { "time": "2023-09-05 08:45:45", "msg": "test3" } ]';
    $str = '';
    $conLog = NULL;
    $msg_log = array('time' => date('Y-m-d H:i:s'), 'msg' => 'test'. date('Y-m-d H:i:s'));
    if ('' != $str) {
        $conLog = json_decode($str, TRUE);
        array_unshift($conLog, $msg_log);
    }
    else {
        $conLog[] = $msg_log;
    }

    echo '<pre>';
    var_dump($conLog);
    echo '</pre>';
die;
