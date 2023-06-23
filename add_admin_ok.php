<?php
include('config.php');// الاتصال بفاعدة البيانات
session_start();// بدايه الجلسه
include "Session_verification_admin.php"; // الاتصال بالكود الذي يتححق من ايميل الجلسه يمكنك الحصول على معلومات اكثر اذا زرت الصفحة

//admin_formمن قاعدة البيانات حيث الكود الحالي يمنع اي مستخدم من الدخول الى الصفحات من دون ايميل و ليس من الجدول  admin_formالكود الحالي يتاكد ان الجلسه تحتوي على ايميل وان الايميل الموجود في الجلسه من الجدول 
if(!isset($_SESSION['usermail'])|| !isset($_SESSION['otp_verified_register_admin']) || $_SESSION['otp_verified_register_admin'] !== true){
    header('location:login_form.php');//شرط اذا لم تحمل الجسله ايميل حولها الى هذه الصفحة 
    $_SESSION['otp_verified_register_admin'] = false;
    exit();
 }
 
 $email = $_SESSION['usermail'];//تعريف متغيير يحمل الايميل
 $sql = "SELECT * FROM admin_form WHERE email = '$email'";//تعريف متغيير يحمل الاتصال بفاعدة البيانات 
 $result = mysqli_query($conn, $sql);//الاتصال بقاعدة البيانات
 
 if(mysqli_num_rows($result) != 1){
     header('location:login_form.php'); //حوله الى الصفحة  admin_form   الشرط التالي اذا لم يكن الايميل من الجدول
 }
 
 $sessionExpired = false;
 if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] > 600) { // من خلال الشرط التالي يتم التحقق اذا كان المستخدم نشط ام لا اذا لم يكن المتسخدم نشط لمدة 600 ثانية ا ي 10 دقايق يتم اغلاق الجلسة وتدميرها
     $sessionExpired = true;
     session_unset();
     session_destroy();
     header('Location: login_form.php');
     
     exit();
 }
 
 $_SESSION['LAST_ACTIVITY'] = time();// time يتم حساب الوقت من خلال الداله 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_login_register_Verification.css">
    <title>تم تسجيل المستخدم الرئيسي بنجاح </title>

</head>
<body>
   
<div class="form-container">
<form action="" method="post">
    <h3 class="title">تم تسجيل المستخدم الرئيسي بنجاح </h3>
    <p>التوجه الى <a href="admin_page.php">صفحه المستخدم الرئيسي</a></p>

</form>
</div>
</body>
</html>