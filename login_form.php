<?php
$saudiArabiaTimeZone = new DateTimeZone('Asia/Riyadh');

session_start();// بدايه الجلسة 

if(isset($_POST['submit'])){//اذا تم الضغط 

   include 'config.php';// اتصل بقواعد البيانات 

   $email = mysqli_real_escape_string($conn, $_POST['usermail']);//لتعقيم البياناتٍ mysqli_real_escape_string  تخزين قيمه المتغيير ايميل مع استخدام داله
   $pass = md5($_POST['password']);// يتم تشفير كلمة المرور المدخله 

   $admin_select = "SELECT * FROM admin_form WHERE email = '$email' && password = '$pass'";//التاكد اذا كان المستخدم من جدول الادمن
   $admin_result = mysqli_query($conn, $admin_select);//اتمام الطلب

   if(mysqli_num_rows($admin_result) > 0){//اذا كان من جدول الادمن 
      $_SESSION['usermail'] = $email;//اجعل قيمه ايميل الجلسه الايميل 
      $now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));//تعيين التوقيت بتوقيت الرياض 
      $nowFormatted = $now->format('Y-m-d H:i:s');// عرض التاريخ والوقت بالفورمات او الشكل التالي 
      $insert_logging = "INSERT INTO logging(email,my_datetime,operation) VALUES('$email','$nowFormatted','تسجيل دخول مستخدم رئيسي')";//تسجيل انه تم تسجيل الدخول من خلال جدول اتسجيلات 
      mysqli_query($conn, $insert_logging);//اتمام الطلب
      include 'send_otp.php';  // otp الاتصال بالصفحة الخاصه بارسال رمز           

      if($mail->send()){
         $insert_query = mysqli_query($conn,"insert into tbl_otp_check set otp='$otp', is_expired='0', email='$email'");
         $_SESSION['email'] = $email;
         $_SESSION['login_admin_forwarding'] = true;//وادخله المستخدم بشكل صحيح  OTP يتم تخزين هذه القيمه كشرط انه تم ارسال رمز  
         header('location: verification.php'); //التوجيه الى الصفحة
         exit();
      }else{
         $error[] = "لم يتم ارسال الايميل";
      }
      exit();//خروج
      
   }

   $user_select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";//user_form اذا لم يتم الشرط السابق يتم الانتقال الى الشرط الحالي  يتم التاكد ان الايميل من الجدول 
   $user_result = mysqli_query($conn, $user_select);// اتمام الطلب


   if(mysqli_num_rows($user_result) > 0){//اكمل الخطوات التالية user_formاذا كان من  
      $_SESSION['usermail'] = $email;
      $now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));//تعيين التوقيت بتوقيت الرياض 
      $nowFormatted = $now->format('Y-m-d H:i:s');// عرض التاريخ والوقت بالفورمات او الشكل التالي 
      $insert_logging = "INSERT INTO logging(email,my_datetime,operation) VALUES('$email','$nowFormatted','تسجيل دخول')";
      mysqli_query($conn, $insert_logging);
        include 'send_otp.php';  // otp الاتصال بالصفحة الخاصه بارسال رمز     
      if($mail->send()){
         $insert_query = mysqli_query($conn,"insert into tbl_otp_check set otp='$otp', is_expired='0', email='$email'");// مع اضافه صفر لحالته بحيث صفر لم يتم استخدمه و 1 تم استخدامه  tbl_otp_check اضق الرقم الؤقت مع الايميل في الجدول 
         $_SESSION['email'] = $email;
         $_SESSION['login_forwarding'] = true;//وادخله المستخدم بشكل صحيح  OTP يتم تخزين هذه القيمه كشرط انه تم ارسال رمز  
         header('location: verification.php');// اذا تم يتم التوجه الى الصفحة التالية
         exit();
      }else{
         $error[] = "لم يتم ارسال الايميل ";
      }
      
   }else{
      $error[] = 'الايميل او كلمة المرور خطاء';
      $now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));//تعيين التوقيت بتوقيت الرياض 
      $nowFormatted = $now->format('Y-m-d H:i:s');// عرض التاريخ والوقت بالفورمات او الشكل التالي 
      $insert_logging = "INSERT INTO logging(email, my_datetime, operation) VALUES ('$email', '$nowFormatted', 'تسجيل دخول خاطئ')";
      mysqli_query($conn, $insert_logging);
   }

   mysqli_close($conn);

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_login_register_Verification.css">
    <title>Login تسجيل الدخول </title>

</head>
<body>
   
<div class="form-container">
<form action="" method="post">
    <h3 class="title">سجل دخولك</h3>
    <?php
     if(isset($error)){
        foreach($error as $error){
           echo '<span class="error-msg">'.$error.'</span>';
        }
     }
  ?>
    <input type="text" name="usermail" placeholder="ادخل الايميل الخاص بك" class="box" required>
    <input type="password" name="password" placeholder="ادخل كلمة المرور " class="box" required>
    <input type="submit" value="سجل دخولك" class="form-btn" name="submit">
    <p>ليس لديك حساب؟ <a href="register_form.php">سجل الان</a></p>
    <p>نسيت كلمة المرور؟ <a href="forgot.php">اعد تعيينها</a></p>
</form>
</div>
</body>
</html>