<?php
include 'config.php';//الاتصال بقواعد البيانات

session_start();//بدايه الجلسة 
if (!isset($_SESSION['email']) || !isset($_SESSION['otp_verified_home']) || $_SESSION['otp_verified_home'] !== true) {// اذا لم تحمل الجلسه ايميل ولم يتم التحقق من حاله كود التحقق يتم الرفض والتحويل الى الصفحة
    header('Location: login_form.php');
    exit();
 }
 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>File Encryption تشفير الملفات </title>
    <link rel="stylesheet" href="css/style_File_Encryption.css">
    <html dir="rtl" lang="ar">

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

    <h1>تشفير الملفات</h1>
    <input type="file" id="fileInput" />
    <button onclick="encryptFile()">تشفير الملف</button>
    <button onclick="decryptFile()">فك تشفير الملف</button>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script><!--  الاتصال بالكود الخاص بجافا سكريبت الخاص بمكتبه كريبتو جي اس التي يتم من خلالها التشفير-->
    <script src="javascript/File_Encryption.js"></script><!-- الاتصال بالكود الخاص بجافا سكريبت -->

</body>
</html>


