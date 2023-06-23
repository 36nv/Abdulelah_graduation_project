<?php
@include 'config.php';// الاتصال بقاعدة البيانات 

session_start();// بدايه الجلسة 

if(isset($_POST['submit'])){//اذا تم الضغط على ارسال 
   $email = mysqli_real_escape_string($conn,$_REQUEST['usermail']);//لتعقيم المدخلات mysqli_real_escape_string يتم اخذ الايميل وحفظه في المتغيير مع استخدام 
   
   $check_email = mysqli_query($conn, "SELECT email FROM user_form WHERE email = '$email'");//يتم التاكد اذا كان الايميل موجود في قاعدة البيانات
   $res = mysqli_num_rows($check_email);

   if($res > 0){//اذا نعم 
       $_SESSION['usermail'] = $email;//يتم تخزين الايميل في المتغير ايميل 

       include 'send_otp.php';  // otp الاتصال بالصفحة الخاصه بارسال رمز           

        
     if($mail->send()){// اذا تم ارسال الايميل 
        $insert_query = mysqli_query($conn,"insert into tbl_otp_check set otp='$otp', is_expired='0', email='$email'"); // مع اضافه صفر لحالته بحيث صفر لم يتم استخدمه و 1 تم استخدامه  tbl_otp_check اضق الرقم الؤقت مع الايميل في الجدول 
        $_SESSION['email'] = $email;
        $_SESSION['forgot_forwarding'] = true;//وادخله المستخدم بشكل صحيح  OTP يتم تخزين هذه القيمه كشرط انه تم ارسال رمز  
        header('location: verification.php');// اذا تم يتم التوجه الى الصفحة التالية

        exit();
     }else{
        $error[] = "لم يتم ارسال الايميل ";//يتم عرض الخطا التالي اذا حدثت مشكله اثناء الارسال 
     }
     
  }else{
     $error[] = 'الايميل غير موجود';//user_formيتم عرض الخطا التالي اذا كانالايميل الخاص بالمستخدم غير مسجل في الجدول 
  }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_login_register_Verification.css">
    <title>forgot password استرجاع كلمة المرور </title>

</head>
<body>
   
<div class="form-container">
<form action="" method="post">
    <h3 class="title"> استرجاع كلمة المرور </h3>
    <?php
     if(isset($error)){
        foreach($error as $error){
           echo '<span class="error-msg">'.$error.'</span>';
        }
     }
  ?>
    <input type="email" name="usermail" placeholder="ادخل الايميل الخاص بك" class="box" required>
    <input type="submit" value=" استرجاع كلمة المرور " class="form-btn" name="submit">
    <p>تذكرت كلمة المرور؟ <a href="login_form.php">سجل دخولك</a></p>
</form>
</div>
</body>
</html>