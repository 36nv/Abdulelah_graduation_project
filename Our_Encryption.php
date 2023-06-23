<?php
include 'config.php';// الاتصال بقواعد البيانات
session_start();// بدايه الجلسة 
include 'Session_verification.php';//   ونشاط المستخدمOTPالاتصال بالصفحة الخاصه بالتحقق من الايميل في الجلسه وحاله 
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
  <head>
    <meta charset="UTF-8">
    <title>Our Encryption تشفيرنا</title>
    <link rel="stylesheet" href="css/style_Our_Encryption.css">
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
    <h1>تشفيرنا </h1>

    <label for="text-input">ادخل النص:</label>
    <input type="text" id="text-input" /><br /><br />

    <button onclick="encrypt()">تشفير</button>
    <button onclick="decrypt()">فك التشفير</button>
    <br /><br />
    <label for="output">النتيجة:</label>
    <textarea id="output" rows="10" cols="50"></textarea>
    <script src="javascript/Our_Encryption.js"></script><!-- الاتصال بالكود الخاص بجافا سكريبت -->

  </body>
</html>