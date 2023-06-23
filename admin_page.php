<?php
@include 'config.php';//الاتصال بقاعدة البيانات 
session_start();//بدايه الجلسه 
include "Session_verification_admin.php"; // الاتصال بالكود الذي يتححق من ايميل الجلسه يمكنك الحصول على معلومات اكثر اذا زرت الصفحة

?>
<!DOCTYPE html>
<html>
<head>
    <title>صفحة الإدارة</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style_admin_page.css">

</head>
<body>
    <nav>
    <ul>
      <li><a href="admin_page.php">الرئيسة</a></li>
      <li><a href="logging.php">سلوك المستخدم</a></li>
      <li><a href="add_admin.php">اضافه مستخدم رئيسي جديد</a></li>

    </ul>
  </nav>
    <h1>صفحة الإدارة</h1>
    <a href="logout.php" class="logout">تسجيل الخروج</a>

    <?php
include 'config.php';//اتصال قاعدة البيانات 

$select_query = mysqli_query($conn,"SELECT email FROM user_form");//user_form الجمله الخاصه بعرض الايميلات من الجدول 

echo "<table>";//جدول 
echo "<tr><th>المستخدمون</th><th> التحكم</th></tr>";//صفوف واعمدة 

while($row = mysqli_fetch_array($select_query)){//تكرار الشرط التالي لعرض الايميلات من الجدول بعددها 
    $email = $row['email'];
    echo "<tr><td>$email</td><td><form action='' method='post'><input type='hidden' name='email' value='$email'><input type='text' name='new_password' placeholder='الرمز الجديد'><input type='submit' name='change_password' value='تغيير كلمة المرور'><input type='submit' name='delete' value='حذف'></form></td></tr>";
}

echo "</table>";

if(isset($_POST['delete'])){//اذا تم الضغط على حذف 
    $now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));//تعيين التوقيت بتوقيت الرياض 
    $nowFormatted = $now->format('Y-m-d H:i:s');// عرض التاريخ والوقت بالفورمات او الشكل التالي 
    $insert_logging = "INSERT INTO logging(email,my_datetime,operation) VALUES('$email','$nowFormatted','حذف المستخدم من قبل مستخدم رئيسي')";//الجمله الخاصه التي تضيف  الى جدول اللوقز انه تم حذف المستخدم
    $delete_query = mysqli_query($conn,"DELETE FROM user_form WHERE email='$email'");//الجمله الخاصه بحذف المستخدم من الجدول 
    $insert_query = mysqli_query($conn, $insert_logging);//اتمام العملية 
    
    if($delete_query && $insert_query){//اذا تم الحذف 
        echo "تم حذف المستخدم بنجاح";
    } else {
        echo "حدث خطأ أثناء حذف المستخدم";
    }
}
if(isset($_POST['change_password'])){//اذا تم الضغط على تغير كلمة المرور
    $email = mysqli_real_escape_string($conn,$_POST['email']);//يتم تحديد المستخدم 
    $new_password = mysqli_real_escape_string($conn,$_POST['new_password']);//يتم حفظ كلمة المرور الجديد من خلال المدخل في متغيير 
    $hashed_password = md5($new_password);//تشفير كلمة المرور 
    $update_query = mysqli_query($conn,"UPDATE user_form SET password='$hashed_password' WHERE email='$email'");//الامر الخاص بتحديث كلمة المرور 
    $now = new DateTime('now', new DateTimeZone('Asia/Riyadh'));
    $nowFormatted = $now->format('Y-m-d H:i:s');
    $insert_logging = "INSERT INTO logging(email,my_datetime,operation) VALUES('$email','$nowFormatted',' تغيير كلمة المرور من قبل مستخدم رئيسي')";//الجمله الخاصه التي تضيف الى جدول اللوقز انه تم تغيير كلمة مرور المستخدم من قبل مستخدم رئيسي 
    mysqli_query($conn, $insert_logging);//اتمام العملية 
    if($update_query){//اذا تم التحديث 
        echo "تم تحديث كلمة المرور بنجاح";
    } else {
        echo "حدث خطأ أثناء تحديث كلمة المرور";
    }
}
?> 
