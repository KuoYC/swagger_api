<?php
    $acc = explode(',', 'A123456789,B234567890,C345678901,E567890123,F678901234,G789012345,H890123456,I901234567,K123456789,L234567890,M345678901,N456789012,O567890123,P678901234,Q789012345,R890123456,T012345678,U123456789,V234567890,W345678901,X456789012,Y567890123,Z678901234,A789012345,B890123456,C901234567,D012345678');
    $data = NULL;
    $no = 37;
    $arr_0 = explode(',', 'D456789012,J012345678,S901234567');
    for ($i = 1; $i <= $no; $i++) {
        $arr = $acc;
        for ($j = 1; $j <= rand(3, 4); $j++) {
            $p = NULL;
            $p['no'] = $i;
            if ($j == 1) {
                $p['LV0'] = $arr_0[rand(0, count($arr_0))];
                $p['S'] = 0;
            }
            else if ($j<3) {
                $p['LV0'] = $arr[rand(0, count($arr))];
                $p['S'] = 1;
                $target = $p['LV0'];
                $index = array_search($target, $arr);
                if ($index !== FALSE) {
                    unset($arr[$index]);
                    $arr = array_values($arr);
                }
            }
            else {
                $p['LV0'] = $arr[rand(0, count($arr))];
                $p['S'] = 2;
                $target = $p['LV0'];
                $index = array_search($target, $arr);
                if ($index !== FALSE) {
                    unset($arr[$index]);
                    $arr = array_values($arr);
                }
            }
            $p['LV1'] = $arr[rand(0, count($arr))];
            $target = $p['LV1'];
            $index = array_search($target, $arr);
            if ($index !== FALSE) {
                unset($arr[$index]);
                $arr = array_values($arr);
            }
            $p['LV2'] = $arr[rand(0, count($arr))];
            $target = $p['LV2'];
            $index = array_search($target, $arr);
            if ($index !== FALSE) {
                unset($arr[$index]);
                $arr = array_values($arr);
            }
            $data[] = $p;
        }
    }

    for ($i=0;$i<count($data);$i++) {
        echo 'INSERT INTO `member`(`CT_ID`, `MB_Type`, `SS_ID`, `MB_Department`, `MB_Branch`, `MB_LV0`, `MB_LV0Status`, `MB_LV0Time`, `MB_LV1`, `MB_LV1Status`, `MB_LV1Time`, `MB_LV2`, `MB_LV2Status`, `MB_LV2Time`, `MB_Status`, `MB_Now`, `MB_Log`)';
        echo ' VALUE (\''.$data[$i]['no'].'\', \''.$data[$i]['S'].'\', \''.rand(1, 9).'\', \'\', \'\', \''.$data[$i]['LV0'].'\', '.(0 == $data[$i]['S'] ? 0 : -1).', null, \''.$data[$i]['LV1'].'\', -1, null, \''.$data[$i]['LV2'].'\', -1, null, '.(0 == $data[$i]['S'] ? 0 : -1).', \''.(0 == $data[$i]['S'] ? $data[$i]['LV0'] : '').'\', \'\');';
        echo '<br>';
    }
