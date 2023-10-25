<?php
    /**
     * =============================================================================
     * 標　　題: %DocumentRoot%/Cosmos/include/util/FileProcess.php
     * 系統名稱: Cosmos
     * 功能描述: 檔案處理相關
     * 頁面描述: PHP
     * 作　　者:
     * 撰寫日期: 2008-11-17
     * 修改描述:
     * =============================================================================
     */
    header('Content-type: text/html; charset=utf-8');

    class FileProcess
    {
        /**
         * 執行檔案上傳
         *
         * @param $uploadPath
         * @param $file
         * @param $fileName
         *
         * @return string/false
         */
        function doUpload($uploadPath, $file, $fileName, $newfileName = '')
        {
            $rand = rand(0, 99);
            //若目的資料夾不存在, 則新增該目錄
            if (!file_exists($uploadPath)) {
                if (!mkdir($uploadPath, 0777)) {
                    return FALSE;
                }
            }
            //copy file
            if (!copy($file, $uploadPath.'/'.$rand.$fileName)) {
                return FALSE;
            }
            else {
                $newName = $this->setName2Timestamp($rand.$fileName, $uploadPath, $newfileName);
                return $newName;
            }
        }

        /**
         * 檢查是否為圖檔
         *
         * @param $file
         *
         * @return true/false
         */
        function isImageFile($file)
        {
            $result = FALSE;
            list($fWith, $fHeight, $fType) = getimagesize($file['tmp_name']);
            switch ($fType) {
                case '1': //gif
                    $result = TRUE;
                    break;
                case '2': //jpeg
                    $result = TRUE;
                    break;
                case '3': //png
                    $result = TRUE;
                    break;
            }
            return $result;
        }

        /**
         * 更改檔案名稱為時間戳記, 以避免檔名重覆
         *
         * @param string $fileName 原檔案名稱
         * @param string $path     檔案路徑
         *
         * @return string/false
         */
        function setName2Timestamp($fileName, $path, $newfileName = '')
        {
            $newName = (!empty($newfileName) ? $newfileName : date('Ymd-His', time())).$this->getExtend($fileName);
            if (rename($path.'/'.$fileName, $path.'/'.$newName)) {
                return $newName;
            }
            else {
                return FALSE;
            }
        }

        /**
         * 取出副檔名
         *
         * @param string $fileName 檔案名稱
         *
         * @return string
         */
        function getExtend($fileName)
        {
            $extend = strrchr($fileName, ".");
            $extend = '.jpeg' == $extend ? '.jpg' : $extend;
            return $extend;
        }

        /**
         * 寫檔
         *
         * @param object $filePath
         * @param object $content
         *
         * @return number of bytes written, or FALSE on error
         */
        function fileWrite($filePath, $content)
        {
            $fd = fopen($filePath, 'w+') or die('Can not open file : '.$filePath);
            $f_out = fwrite($fd, $content);
            fclose($fd);
            return $f_out;
        }

        /**
         * 處理圖片尺寸並存檔
         *
         * 抓取要縮圖的比例, 下述只處理 jpeg
         * $from_filename : 來源路徑, 檔名, ex: /tmp/xxx.jpg
         * $save_filename : 縮圖完要存的路徑, 檔名, ex: /tmp/ooo.jpg
         * $in_width : 縮圖預定寬度
         * $in_height: 縮圖預定高度
         * $quality  : 縮圖品質(1~100)
         *
         * Usage:
         *   ImageResize('ram/xxx.jpg', 'ram/ooo.jpg');
         */
        function ImageResize($from_filename, $save_filename, $in_width, $in_height, $quality)
        {
            $allow_format = array('jpeg', 'png', 'gif');
            $sub_name = $t = '';

            // Get new dimensions
            $img_info = getimagesize($from_filename);
            $width = $img_info['0'];
            $height = $img_info['1'];
            $imgtype = $img_info['2'];
            $imgtag = $img_info['3'];
            $bits = $img_info['bits'];
            $channels = $img_info['channels'];
            $mime = $img_info['mime'];
            list($t, $sub_name) = preg_split('[/]', $mime);
            if (strtolower($sub_name) == 'jpg' || strtolower($sub_name) == 'jpeg') {
                $sub_name = 'jpeg';
            }

            if (!in_array($sub_name, $allow_format)) {
                return FALSE;
            }

            // 取得縮在此範圍內的比例
            $percent = $this->getResizePercent($width, $height, $in_width, $in_height);
            $new_width = $width * $percent;
            $new_height = $height * $percent;

            // Resample
            $image_new = imagecreatetruecolor($new_width, $new_height);

            // $function_name: set function name
            //   => imagecreatefromjpeg, imagecreatefrompng, imagecreatefromgif
            /*
            // $sub_name = jpeg, png, gif
            $function_name = 'imagecreatefrom'.$sub_name;
            $image = $function_name($filename); //$image = imagecreatefromjpeg($filename);
            */
//		$image = imagecreatefromjpeg($from_filename);
//
//		imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            switch ($sub_name) {
                case 'jpeg':
                    $image = imagecreatefromjpeg($from_filename);
                    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    return imagejpeg($image_new, $save_filename, $quality);
                    imagedestroy($image_new);
                    break;
                case 'png':
                    imagealphablending($image_new, FALSE);
                    imagesavealpha($image_new, TRUE);
                    $image = imagecreatefrompng($from_filename);
                    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    return imagepng($image_new, $save_filename, $quality / 10 - 1);
                    imagedestroy($image_new);
                    break;
                case 'gif':
                    imagealphablending($image_new, FALSE);
                    imagesavealpha($image_new, TRUE);
                    $image = imagecreatefromgif($from_filename);
                    imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    return imagegif($image_new, $save_filename, $quality / 10 - 1);
                    imagedestroy($image_new);
                    break;
            }
        }

        /**
         * 抓取要縮圖的比例
         * $source_w : 來源圖片寬度
         * $source_h : 來源圖片高度
         * $inside_w : 縮圖預定寬度
         * $inside_h : 縮圖預定高度
         *
         * Test:
         *   $v = (getResizePercent(1024, 768, 400, 300));
         *   echo 1024 * $v . "\n";
         *   echo  768 * $v . "\n";
         */
        function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
        {
            if ($source_w < $inside_w && $source_h < $inside_h) {
                return 1; // Percent = 1, 如果都比預計縮圖的小就不用縮
            }

            $w_percent = $inside_w / $source_w;
            $h_percent = $inside_h / $source_h;

            return ($w_percent > $h_percent) ? $h_percent : $w_percent;
        }

        /**
         * 上傳檔案
         *
         * @param $type       1:圖檔 2:其他檔案
         * @param $file       $_FILE['file']
         * @param $uploadPath 設定圖片存放位置'../file_pic'
         * @param $fileSize   尺寸 ex:2x3, 4x5=>2.3,4.5
         * @param $newName    上傳後檔案名稱
         * @param $fileName   檔案名稱(刪除時用)
         * @param $action     up:上傳 dl:刪除
         *
         * @return bool/string
         */
        function doFileUpload($type, $file, $uploadPath, $fileSize = '', $newName = '', $fileName = '', $action = 'up')
        {
            $type = '' != $fileSize ? '1' : $type;
            $result = NULL;
            switch ($action) {
                case 'up':
                    switch ($type) {
                        case '1':
                            //上傳之檔案型態為圖檔
                            if ($this->isImageFile($file)) {
                                $newName = strtolower($this->doUpload($uploadPath, $file['tmp_name'], strtolower($file['name']), $newName));
                                //上傳其他檔案大小的圖檔
                                $check_other_size = TRUE;//判斷其他檔案大小
                                if ('' != $fileSize) {

                                    $str_arr_fileSize = explode(',', $fileSize);
                                    for ($i = 0; $i < count($str_arr_fileSize); $i++) {
                                        $arr_fileSize[] = explode('.', $str_arr_fileSize[$i]);
                                    }
                                    $extend = $this->getExtend($file['name']);
                                    if (strtolower($extend) == '.jpg' || strtolower($extend) == '.png' || strtolower($extend) == '.gif')// || strtolower($extend) == '.png' || strtolower($extend) == '.gif'
                                    {
                                        //修改圖案大小並另存新檔
                                        $img = getimagesize($uploadPath.'/'.$newName);
                                        //Array ( [0] => 1024 [1] => 800 [2] => 2 [3] => width="1024" height="800" [bits] => 8 [channels] => 3 [mime] => image/jpeg )
                                        $ImageSize = new ImageSize();
                                        for ($i = 0; $i < count($arr_fileSize); $i++) {
                                            if ($arr_fileSize[$i][0] > 0 && $arr_fileSize[$i][1] > 0) {
                                                $im = $ImageSize->getResizePercent($img[0], $img[1], $arr_fileSize[$i][0], $arr_fileSize[$i][1]);
                                                if (count($str_arr_fileSize) == 1) {
                                                    $do_im = $ImageSize->ImageResize($uploadPath.'/'.$newName, $uploadPath.'/'.$newName, $arr_fileSize[$i][0], $arr_fileSize[$i][1], 100);
                                                }
                                                else {
                                                    $do_im = $ImageSize->ImageResize($uploadPath.'/'.$newName, $uploadPath.'/'.$arr_fileSize[$i][0]."x".$arr_fileSize[$i][1]."_".$newName, $arr_fileSize[$i][0], $arr_fileSize[$i][1], 100);
                                                }
                                            }
                                        }
                                    }
                                    else {
                                        for ($i = 0; $i < count($arr_fileSize); $i++) {
                                            if ($arr_fileSize[$i][0] > 0 && $arr_fileSize[$i][1] > 0) {
                                                copy($file['tmp_name'], $uploadPath.'/'.$arr_fileSize[$i][0]."x".$arr_fileSize[$i][1]."_".$newName);
                                            }
                                        }
                                    }
                                    //=======================================
                                }
                                if (!$newName) {
                                    $result = FALSE;
                                }
                                else {
                                    $result = $newName;
                                }
                            }
                            else {
                                $result = FALSE;
                            }
                            break;
                        case '2':
                            //上傳之檔案為其他檔案(不限制條件)
                            $extend = $this->getExtend($file['name']);
                            if ($extend == '.php') {
                                $result = FALSE;
                            }
                            else {
                                $newName = $this->doUpload($uploadPath, $file['tmp_name'], $file['name']);
                                if (!$newName) {
                                    $result = FALSE;
                                }
                                else {
                                    $result = $newName;
                                }
                            }
                            break;
                    }
                    break;
                case 'dl':
                    $fullPath = $uploadPath.'/'.$fileName;
                    if ('' != $fileSize) {
                        $str_arr_fileSize = explode(',', $fileSize);
                        for ($i = 0; $i < count($str_arr_fileSize); $i++) {
                            $arr_fileSize[] = explode('.', $str_arr_fileSize[$i]);
                        }

                        for ($i = 0; $i < count($arr_fileSize); $i++) {
                            $fullPath_otherSize = $uploadPath.'/'.$arr_fileSize[$i][0].'x'.$arr_fileSize[$i][1].'_'.$fileName;
                            if (file_exists($fullPath_otherSize)) {
                                unlink($fullPath_otherSize);
                            }
                        }
                        //=======================================
                    }
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                    break;
            }
            return $result;
        }
    }

?>
