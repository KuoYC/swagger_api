<?php

    $url = "https://api-uat.cathayholdings.com.tw/cxl-mwp-get-all-manager-list/v1/getAllManagerListWithUpperClass_API";
    $headers = array(
        "Content-Type: application/json",
        "Consumer-Secret: NO4Q5NwxyyGHxeE9VH3aEv5EWyQZhOJx1UBAE6atCoDLwe46PTP8CE9beuIZ9rx1",
        "x-api-key: HUySxhLAt889ssBfpysMNeCrBTBmPSp8Cp24mlxNgWHYx8cP"
    );

    $data = array(
        "COMP_ID"     => isset($_GET['comp']) ? $_GET['comp'] : "A0",
        "DIV_NO"      => isset($_GET['no']) ? $_GET['no'] : "9300800",
        "ID_TYPE"     => "1",
        "ID"          => isset($_GET['id']) ? $_GET['id'] : "T15439777L",
        "UPPER_CLASS" => isset($_GET['class']) ? $_GET['class'] : "1"
    );

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error: '.curl_error($ch);
    }

    curl_close($ch);

//    echo $response;
//    $response = '{
//  "returnCode": "O",
//  "returnMsg": "API success",
//  "detail": [
//    [
//      {
//        "ID_NO": "L10777096K",
//        "POS_ID": "",
//        "POSITION_FULL_NAME": "經理",
//        "EMPLOYEE_ID": "L107770S6K",
//        "DIV_FULL_NAME": "資資訊湖人事行政資訊科",
//        "SRC": "C",
//        "SEX": "1",
//        "INSTITUTION_PHONE1": "02",
//        "INSTITUTION_PHONE2": "0227551399",
//        "EMAIL": "XXXXX@cathlife.com.tw",
//        "NICK_NAME": "",
//        "AREA_CODE": "TW-O1",
//        "STATUS_NAME": "改新",
//        "SUP_DIV_NO": "",
//        "INSTITUTION_PHONE3": "26900",
//        "DIV_SHORT_NAME": "人事資訊科",
//        "POSITION": "22",
//        "EMP_NAME": "陳o丹",
//        "VR_DIV": "",
//        "EMP_RMK": "",
//        "LOGIN_ID": "L10777096K",
//        "ASSIGN_CODE": "2",
//        "NTL_TYPE": "L",
//        "POSITION_NAME": "經理",
//        "CATHAY_NO": "00636655",
//        "PAR_CODE": "0",
//        "USER_CATHAY_ID": "A003",
//        "COMP_NAME": "國泰人壽",
//        "ENG_LNM": "BoR JOU",
//        "OLD_CATHAY_NO": "AOL10777096K",
//        "ENG_MNM": "",
//        "NTL_CODE": "TW",
//        "ENG_FNM": "CHoN",
//        "MARY": "l",
//        "COMP_ID": "AO",
//        "STS_RMK": "",
//        "DIV_NO": "9300800",
//        "POS_RANK": "",
//        "CELLULAR_PHONE": "0916125456",
//        "DEGREE": ""
//      }
//    ],
//    [
//      {
//        "ID_NO": "L10777096K",
//        "POS_ID": "",
//        "POSITION_FULL_NAME": "經理",
//        "EMPLOYEE_ID": "L107770S6K",
//        "DIV_FULL_NAME": "資資訊湖人事行政資訊科",
//        "SRC": "C",
//        "SEX": "1",
//        "INSTITUTION_PHONE1": "02",
//        "INSTITUTION_PHONE2": "0227551399",
//        "EMAIL": "XXXXX@cathlife.com.tw",
//        "NICK_NAME": "",
//        "AREA_CODE": "TW-O1",
//        "STATUS_NAME": "改新",
//        "SUP_DIV_NO": "",
//        "INSTITUTION_PHONE3": "26900",
//        "DIV_SHORT_NAME": "人事資訊科",
//        "POSITION": "22",
//        "EMP_NAME": "陳o丹",
//        "VR_DIV": "",
//        "EMP_RMK": "",
//        "LOGIN_ID": "L10777096K",
//        "ASSIGN_CODE": "2",
//        "NTL_TYPE": "L",
//        "POSITION_NAME": "經理",
//        "CATHAY_NO": "00636655",
//        "PAR_CODE": "0",
//        "USER_CATHAY_ID": "A003",
//        "COMP_NAME": "國泰人壽",
//        "ENG_LNM": "BoR JOU",
//        "OLD_CATHAY_NO": "AOL10777096K",
//        "ENG_MNM": "",
//        "NTL_CODE": "TW",
//        "ENG_FNM": "CHoN",
//        "MARY": "l",
//        "COMP_ID": "AO",
//        "STS_RMK": "",
//        "DIV_NO": "9300800",
//        "POS_RANK": "",
//        "CELLULAR_PHONE": "0916125456",
//        "DEGREE": ""
//      }
//    ]
//  ],
//  "UUID": ""
//}
//';
    $parsedResponse = json_decode($response, true);
    if (isset($parsedResponse['detail'])) {
        foreach ($parsedResponse['detail'] as $v) {
            echo $v[0]['ID_NO'];
        }
    }
//    var_dump($parsedResponse);
?>
