<?php
$otp = rand(10000, 99999);//يتم من خلال الداله راندوم توليد رقم عشوائي من 10000 الى 99999

include_once("SMTP/class.phpmailer.php");//phpmailerاتصال مع مكتبة 
include_once("SMTP/class.smtp.php");//phpmailerاتصال مع مكتبة 
$message = '<div>         
<p><b>اهلا</b></p>
<p>كود التحقق الخاص بك </p>
   <br>
   <p><b>'.$otp.'</b></p>
</div>';//الجزء السابق الخاص بالرساله المرسلة للمستخدم
   
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPAuth = true;                       
$mail->Host = 'smtp.gmail.com';//المستضيف
$mail->Username = ''; //  ايميل المرسل اضف ايميلك
$mail->Password = '';// اضف كلمة المرور الخاصة بك 
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;// المنفذ المستخدم
$mail->FromName = "Encryption and decryption site";//الاسم الذي يظهر كمرسل للمستخدم 
$mail->AddAddress($email);// ايميل المرسل الية 
$mail->Subject = "OTP";
$mail->isHTML( TRUE );
$mail->Body = $message;//الرساله
?>