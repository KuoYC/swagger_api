<?php

    // 取得從 Vue.js 送來的資料
    $apiUrl = $_GET['apiUrl'];
    $requestData = json_decode($_GET['requestData'], true);
    $requestMethod = $_GET['requestMethod'];

    // 初始化 cURL
    $ch = curl_init($apiUrl);

    // 根據 Vue.js 傳來的請求方法設定 cURL 選項
    if ($requestMethod === 'GET') {
        // 如果是 GET，則在 URL 中加上參數
        $apiUrl .= '?' . http_build_query($requestData);
    } elseif ($requestMethod === 'POST') {
        // 如果是 POST，則設定 POST 選項
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
    } elseif ($requestMethod === 'PUT') {
        // 如果是 PUT，則設定相應的選項
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));
    } elseif ($requestMethod === 'DELETE') {
        // 如果是 DELETE，則設定相應的選項
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));
    }

    // 設定其他 cURL 選項
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // 執行 cURL 並取得結果
    $response = curl_exec($ch);

    // 關閉 cURL 連線
    curl_close($ch);

    // 輸出 API 回應
    echo $response;
?>
