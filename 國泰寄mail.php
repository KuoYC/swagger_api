<?
    ini_set('display_errors', 'On');

       include("inc/class.phpmailer.php");
       // $temp_mail_to = "";
       $temp_mail_to = "nsspao@gmail.com";
     
       $temp_mail_subject=" 簽核文件通知 ";
       $subject = "=?UTF-8?B?" . base64_encode($temp_mail_subject) . "?=";

       $message = "XX主管 您有新的簽核文件";

      $mail= new PHPMailer(); //建立新物件 
       $mail->IsSMTP(); //設定使用SMTP方式寄信 
       $mail->SMTPAuth = true; //設定SMTP需要驗證 
       //$mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線 
       $mail->Host = "202.154.197.40"; //Gamil的SMTP主機 
       // $mail->Port = 465; //Gamil的SMTP主機的SMTP埠位為465埠。 
       $mail->CharSet = "UTF-8"; //設定郵件編碼 

       $mail->Username = "itsharing@cathayholdings.com.tw"; //設定驗證帳號 
       $mail->Password = "Abc12345"; //設定驗證密碼 

       $mail->From = "itsharing@cathayholdings.com.tw"; //設定寄件者信箱 
       $mail->FromName = "itsharing"; //設定寄件者姓名 

       $mail->Subject = $subject; //設定郵件標題 
       $mail->Body = $message; //設定郵件內容 
       $mail->IsHTML(true); //設定郵件內容為HTML 
       $mail->AddAddress($temp_mail_to, "Simon"); //設定收件者郵件及名稱 

       $result = $mail->Send();
	   
	   echo "RESULT = ".$result;

?>	   