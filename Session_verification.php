<?php

//  من خلال الجلسه والتحقق من نشاط المستخدم OTP الصفحة الحاليه تحتوي على الكود الخاص بالتحقق من الايميل و حاله  
if (!isset($_SESSION['email']) || !isset($_SESSION['otp_verified_home']) || $_SESSION['otp_verified_home'] !== true) {// اذا لم تحمل الجلسه ايميل ولم يتم التحقق من حاله كود التحقق يتم الرفض والتحويل الى الصفحة
    header('Location: login_form.php');
    $_SESSION['otp_verified_home'] = false;
    exit();
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