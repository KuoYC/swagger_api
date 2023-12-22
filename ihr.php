<?php
    $directory = '/Users/kh164362/Desktop/www/swagger_api/reserveroom/';

    $files = scandir($directory);

    $files = array_diff($files, array('..', '.'));

    foreach ($files as $file) {
        echo $file . '<br>';
    }
    $firstTxtFile = null;
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'txt') {
            $firstTxtFile = $file;
            break;
        }
    }

    if ($firstTxtFile !== null) {
        $filePath = $directory . '/' . $firstTxtFile;
        $fileContent = file_get_contents($filePath);

        echo $fileContent;
    } else {
        echo "No .txt files found in $directory";
    }
?>
