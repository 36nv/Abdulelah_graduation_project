<?php
// الكود الخاص بتسجيل خروج المستخدم وتدمير الجلسه
session_start();
@include 'config.php';// الاتصال بقاعدة البيانات
$email = $_SESSION['usermail'];
$now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));//تعيين التوقيت بتوقيت الرياض 
$nowFormatted = $now->format('Y-m-d H:i:s');// عرض التاريخ والوقت بالفورمات او الشكل التالي 
$insert_logging = "INSERT INTO logging(email, my_datetime, operation) VALUES ('$email','$nowFormatted', 'تسجيل الخروج')";// تسجيل في قاعدة البيانات على انه تم تسجيل الخروج
mysqli_query($conn, $insert_logging);
session_unset();// تدمير الجلسة
session_destroy();
header('location:login_form.php');// التوجيه الى الصفحة المحددة

?>