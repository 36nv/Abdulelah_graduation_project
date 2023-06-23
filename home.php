<?php
include 'config.php';// الاتصال بقاعدة البيانات 

session_start();// بدايه الجلسة 

include 'Session_verification.php';//   ونشاط المستخدمOTPالاتصال بالصفحة الخاصه بالتحقق من الايميل في الجلسه وحاله 
 
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
   <title> HOME الرئيسة</title>
</head>
<body>
<nav>
    <ul>
      <li><a href="home.php">الرئيسة</a></li>
      <li><a href="Our_Encryption.php">تشفيرنا</a></li>
      <li><a href="Caesar_Cipher.php">خوارزمية قيصر</a></li>
      <li><a href="File_Encryption.php"> تشفير الملفات</a></li>
    </ul>
  </nav>
<div class="container">
   <div class="content">
      <h3>مرحباً بك</h3>
      <p>التشفير هو أفضل حل لضمان السرية</p>
      <p>بريدك الإلكتروني: <span><?php echo $_SESSION['usermail'] // يتم طباعه الايميل المتواجد في الجلسة للترحيب به ; ?></span></p>
      <a href="logout.php" class="logout">تسجيل الخروج</a>
   </div>
</div>



</body>
</html>
