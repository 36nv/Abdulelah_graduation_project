<?php
include_once('config.php');// الاتصال بفاعدة البيانات
session_start();// بدايه الجلسه
include "Session_verification_admin.php"; // الاتصال بالكود الذي يتححق من ايميل الجلسه يمكنك الحصول على معلومات اكثر اذا زرت الصفحة


if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['usermail']);//  mysqli_real_escape_string للحقول الثلاثه التاليه يتم اخذهم لارسالهم الى قاعدة البيانات مع استخدام التعقيم باستخدام الداله 
   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);

   $select = "SELECT * FROM admin_form WHERE email = '$email'"; // امر الاستعلام الخاص  في قاعدة البيانات لاسترداد القييم
   $result = mysqli_query($conn, $select);// تنفيذ الامر السابق
   $error = []; //مصفوفه فارغه للاخاطاء
   if (mysqli_num_rows($result) > 0) { // اذا تواجد الايميل في قاعدة البيانات
      $error[] = 'تم تسجيل الايميل من قبل';
   } else {
      if ($pass != $cpass) { //اذا كانت كلمة المرور غير متطابقة
         $error[] = 'كلمة المرور غير متطابقة';
      } else {

         if (!isPasswordComplex($pass)) {   // التحقق من تعقيد كلمة المرور
            $error[] = 'كلمة المرور يجب أن تحتوي على حروف كبيرة وصغيرة وأرقام وأحرف خاصة، وتكون طولها على الأقل 8 أحرف.';
         }


         if (count($error) === 0) {// التحقق من عدم وجود اخطاء 
            include 'send_otp.php';  // otp الاتصال بالصفحة الخاصة بارسال رمز           

            if ($mail->send()) {
               $insert_query = mysqli_query($conn, "INSERT INTO tbl_otp_check SET otp='$otp', is_expired='0', email='$email'");
               $_SESSION['email'] = $email;
               $_SESSION['pass'] = $pass;
               $_SESSION['register_admin_forwarding'] = true; //وادخله المستخدم بشكل صحيح  OTP يتم تخزين هذه القيمة كشرط أنه تم ارسال رمز  
               header('location: verification.php'); //التوجيه الى الصفحة
               exit();
            } else {
               $error[] = "لم يتم ارسال الايميل";
            }
         }
      }
   }
}
function isPasswordComplex($password) {
   $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';// داله تتاكد اذا كانت كلمة المرور معقدة ام لا 
   return preg_match($pattern, $password);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style_login_register_Verification.css">
   <title>Register for admin تسجيل مستخدم رئيسي</title>

</head>
<body>
    
<div class="form-container">
   <form action="" method="post">
      <h3 class="title"> سجل مستخدم رئيسي</h3>
      <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            }
         }
      ?>
            <input type="email" name="usermail" placeholder="ادخل ايميل المستخدم الرئيسي " class="box" required>
            <input type="password" name="password" placeholder="ادخل كلمة مرور جديدة" class="box" required>
            <input type="password" name="cpassword" placeholder="اعد ادخال كلمة المرور " class="box">
            <input type="submit" value="سجل" class="form-btn" name="submit">
            <p>لديك حساب؟ <a href="login_form.php">سجل دخولك</a></p>
   </form>
</div>

</body>
</html>
