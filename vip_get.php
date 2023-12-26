<?php
    $data = json_decode(file_get_contents('php://input'), TRUE); // 解析 JSON 資料
    echo '123';
var_dump($data);
