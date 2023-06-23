<?php
include 'config.php';//اتصال قاعدة البيانات 

session_start();//بدايه الجلسه 
include 'Session_verification.php';//   ونشاط المستخدمOTPالاتصال بالصفحة الخاصه بالتحقق من الايميل في الجلسه وحاله 

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style_caesar_cipher.css">
    <html dir="rtl" lang="ar">
      <title>Caesar Cipher شفره قيصر</title>
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

    <h1>خوارزمية قيصر</h1>

    <label for="message">ادخل النص:</label><br>
    <textarea id="message" rows="5"></textarea><br>

    <label for="shift">مقدار الازاحة:</label>
    <input type="text" id="shift"><br>

    <button onclick="encrypt()">تشفير</button>
    <button onclick="decrypt()">فك التشفير</button><br>

    <label for="output">الناتج:</label><br>
    <textarea id="output" rows="5" readonly></textarea>

    <script src="javascript/Caesar_Cipher.js"></script><!-- الاتصال بالكود الخاص بجافا سكريبت -->
  </body>
</html>