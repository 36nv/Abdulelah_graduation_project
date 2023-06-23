<?php

if (isset($_SESSION['login_forwarding']) && $_SESSION['login_forwarding'] == true) {// يتحقق الشرط التالي اذا كانت تم ارسال المرسل من صفحة تسجيل الدخول  للتوجييه الى صفحة الهوم 
    $_SESSION['otp_verified_home'] = true;//true يتطلب ان يكون المتغيير  home شرط السماح للدخول الى صفحة  
    header('location:home.php');// التوجيه الى الصفحة
    exit();
};
if (isset($_SESSION['register_forwarding']) && $_SESSION['register_forwarding'] == true) {//يتحقق الشرط التالي اذا كانت تم ارسال المرسل من صفحة التسجيل يتم ارساله الى صفحة تسجيل الدخول
  $hashed_pass = md5($pass); //md5 شفر كلمة المرور باستخدام
     $insert = "INSERT INTO user_form(email, password) VALUES('$email','$hashed_pass')";  //  اضف الى قاعدة البيانات   الايميل وكلمة المرور مشفرة 
     mysqli_query($conn, $insert);
     $insert_logging = "INSERT INTO logging(email,my_datetime,operation) VALUES('$email',now(),'تسجيل جديد')";
     mysqli_query($conn, $insert_logging);  
     header('location:login_form.php');
     exit();

};
if (isset($_SESSION['forgot_forwarding']) && $_SESSION['forgot_forwarding'] == true) {//passwordreset يتم توجييه الى صفحة  forgotالتحقق اذا كان تم توجييه المرسل من صفحة 
    $_SESSION['otp_verified_reset'] = true;//trueيجب ان يكون  passwordreset  شرط السماح للدخول الى صفحة 
    header('location:passwordreset.php');
    exit();
};
if (isset($_SESSION['register_admin_forwarding']) && $_SESSION['register_admin_forwarding'] == true) {//add_admin_ok يتم توجييه الى صفحة  add_admin اذا كان تم توجييه المرسل من صفحة 
  $_SESSION['otp_verified_admin'] = true;//شرط السماح لتسجيل مستخدم رئيسي 
  $hashed_pass = md5($pass); //md5 شفر كلمة المرور باستخدام
  $insert = "INSERT INTO admin_form(email, password) VALUES('$email','$hashed_pass')";  //  اضف الى قاعدة البيانات   الايميل وكلمة المرور مشفرة 
  mysqli_query($conn, $insert);
  $insert_logging = "INSERT INTO logging(email,my_datetime,operation) VALUES('$email',now(),' تسجيل مستخدم رئيسي جديد')";
  mysqli_query($conn, $insert_logging);
  header('location:add_admin_ok.php');
  exit();
};
if (isset($_SESSION['login_admin_forwarding']) && $_SESSION['login_admin_forwarding'] == true) {//admin_page يتم توجييه الى صفحة  login اذا كان تم توجييه المرسل من صفحة 
$_SESSION['otp_verified_admin'] = true;//شرط السماح لتسجيل دخول مستخدم رئيسي 
header('location:admin_page.php');
exit();
};
?>