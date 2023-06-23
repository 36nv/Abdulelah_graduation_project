<?php
include 'config.php';
$_SESSION['otp_verified_reset'] = false;

session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['otp_verified_reset']) || $_SESSION['otp_verified_reset'] !== true) {
    header('Location: forgot.php');
    $_SESSION['otp_verified_resets'] = false;
    exit();
}
  
if(isset($_POST['submit'])) {//اذا تم الضغط 
    if(isset($_SESSION['email'])) {//اذا كات الجلسه تحتوي على ايميل 
        $email = $_SESSION['email'];

        $password = mysqli_real_escape_string($conn, $_POST['password']);// الحصول على كلمة المرور المدخله بعد تعقيمها لتخزينها في قاعدة البيانات
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);// الحصول على كلمة المرور المدخله بعد تعقيمها لتخزينها في قاعدة البيانات

        if($password === $cpassword) {//اذا كانت كلمة المرور مطابقه للاعادة كلمة المرور 
            if (isPasswordComplex($password)) { // التحقق من تعقيد كلمة المرور
                $password = md5($password);//md5 شفر كلمة المرور باستخدام
                $update_query = mysqli_query($conn, "UPDATE user_form SET password='$password' WHERE email='$email'");//حدث كلمة المرور في قاعد ة البيانات 
                $now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));
                $nowFormatted = $now->format('Y-m-d H:i:s');
                $insert_logging = "INSERT INTO logging(email, my_datetime, operation) VALUES('$email', '$nowFormatted', 'تغيير كلمة المرور')";// اضف الى جدول التسجيل انه تم تغيير كلمة المرور 
                mysqli_query($conn, $insert_logging);// تنفيذ امر التسجيل 

                if($update_query) {// اذا تم تحديث كلمة المرور 
                    unset($_SESSION['email']);//  يحذف متغير الجلسه ايميل لكي لا يستخدم مره اخرى
                    $success = "تم تحديث كلمة المرور بنجاح. الرجاء تسجيل الدخول باستخدام كلمة المرور الجديدة";//عرض رساله نجاح 
                     header('location:the_password_is_reset.php'); 
                } else {
                    $error = "حدث خطأ أثناء تحديث كلمة المرور";// غير ذالك عرض رساله خطا 
                }
            } else {
                $error = "كلمة المرور يجب أن تحتوي على حروف كبيرة وصغيرة وأرقام وأحرف خاصة، وتكون طولها على الأقل 8 أحرف.";//اذا كانت كلمة المرور غير معقدة يتم عرض هذه الرساله 
            }
        } else {
            $error = "كلمتي المرور غير متطابقتين";// اذا كانت كلمتي المرور غير متطابقه يتم عرض هذه الرساله 
        }
    } 
}

function isPasswordComplex($password) {
   $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';// الداله الخاصه بالتاكد من ان كلمة المرور معقدة وتحتوي على التنسيق التالي
   return preg_match($pattern, $password);
}
?>

<html>
<head>
    <title>إعادة تعيين كلمة المرور</title>
    <link rel="stylesheet" href="css/style_login_register_Verification.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h3 class="title"> استرجاع كلمة المرور </h3>
            <?php
                if(isset($error)){
                    echo '<div style="color:red;">'.$error.'</div>';
                }
                if(isset($success)){
                    echo '<div style="color:green;">'.$success.'</div>';
                }
            ?>
            <input type="password" name="password" placeholder="ادخل كلمة المرور الجيدة " class="box" required>
            <input type="password" name="cpassword" placeholder=" اعد ادخل كلمة المرور الجيدة " class="box" required>
            <input type="submit" value=" استرجاع كلمة المرور " class="form-btn" name="submit">
            <p>تذكرت كلمة المرور؟ <a href="login_form.php">سجل دخولك</a></p>
        </form>
    </div>
</body>
</html>
