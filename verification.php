<?php
session_start();

include_once('config.php');

if (isset($_REQUEST['otp_verify'])) {
    $otp = $_REQUEST['otp'];
    $email = $_SESSION['email'];

    $select_query = mysqli_query($conn, "SELECT * FROM tbl_otp_check WHERE otp='$otp' AND email='$email' AND is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 2 MINUTE)");
    $count = mysqli_num_rows($select_query);

    if ($count > 0) {
        $select_query = mysqli_query($conn, "UPDATE tbl_otp_check SET is_expired=1 WHERE otp='$otp'");//حدث القيمه على انه تم استعمال رمز التحقق 
        
        if (isset($_SESSION['login_forwarding']) && $_SESSION['login_forwarding'] == true) {// وهكذا للبقية home.phpيتنقل الى الصفحة  trueيحمل القيمه  login_forwardingاذا كان المتغغير في الجلسة 
          $_SESSION['otp_verified_home'] = true;
          header('location: home.php');
          exit();
      }
      
      if (isset($_SESSION['forgot_forwarding']) && $_SESSION['forgot_forwarding'] == true) {
          $_SESSION['otp_verified_reset'] = true;
          header('location: passwordreset.php');
           $_SESSION['forgot_forwarding'] = false;
          exit();
      }
        if (isset($_SESSION['pass'])) {
            $pass = $_SESSION['pass'];
            if (isset($_SESSION['register_forwarding']) && $_SESSION['register_forwarding'] == true) {
                $_SESSION['otp_verified_register'] = true;
                $hashed_pass = md5($pass);//تشفير كلمة المرور
                $insert = "INSERT INTO user_form (email, password) VALUES ('$email', '$hashed_pass')";//اضفت البريد الالكتروني لقاعدة البيانات مع الرمز بشكل مشفر 
                mysqli_query($conn, $insert);
                $now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));//تعيين التوقيت بتوقيت الرياض 
                $nowFormatted = $now->format('Y-m-d H:i:s');// عرض التاريخ والوقت بالفورمات او الشكل التالي 
                $insert_logging = "INSERT INTO logging (email, my_datetime, operation) VALUES ('$email', '$nowFormatted', 'تسجيل جديد')";// اضافه انه تم تسجيل مستخدم جديد للجدول الخاص بتجميع اللوقز
                mysqli_query($conn, $insert_logging);
                unset($_SESSION['pass']);
                header('location: login_form.php');
                exit();
            }
            
            if (isset($_SESSION['register_admin_forwarding']) && $_SESSION['register_admin_forwarding'] == true) {
                $_SESSION['otp_verified_register_admin'] = true;
                $hashed_pass = md5($pass);
                $insert = "INSERT INTO admin_form (email, password) VALUES ('$email', '$hashed_pass')";
                mysqli_query($conn, $insert);
                $now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));//تعيين التوقيت بتوقيت الرياض 
                $nowFormatted = $now->format('Y-m-d H:i:s');// عرض التاريخ والوقت بالفورمات او الشكل التالي 
                $insert_logging = "INSERT INTO logging (email, my_datetime, operation) VALUES ('$email', '$nowFormatted', 'تسجيل مستخدم رئيسي جديد')";
                mysqli_query($conn, $insert_logging);
                unset($_SESSION['pass']);
                header('location: add_admin_ok.php');
                exit();
            }
          }
            
              if (isset($_SESSION['login_admin_forwarding']) && $_SESSION['login_admin_forwarding'] == true) {
                  $_SESSION['otp_verified_admin'] = true;
                  header('location: admin_page.php');
                  exit();
              }
           
   
        

    } else {
        $msg = "كلمة المرور المؤقتة خطأ";
    }
}
?>

<html>
<head>
<title>OTP Verify التحقق</title>
<link rel="stylesheet" href="css/style_login_register_Verification.css">
</head>
<body>
<div class="form-container">
    <form action="" method="post">
        <h3 class="title">ادخل كلمة المرور المؤقتة</h3>
        <input type="text" name="otp" id="otp" placeholder="كلمة المرور المؤقتة" required data-parsley-type="otp"
            data-parsley-trigger="keyup" class="box" />
        <input type="submit" id="submit" name="otp_verify" value="ارسال" class="form-btn" />
        <p class="error"><?php if (!empty($msg)) { echo $msg; } ?></p>
    </form>
</div>
</body>
</html>
