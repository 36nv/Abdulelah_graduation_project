<?php
@include 'config.php';//الاتصال بقاعدة البيانات 
session_start();//بدايه الجلسه 

include "Session_verification_admin.php"; // الاتصال بالكود الذي يتححق من ايميل الجلسه يمكنك الحصول على معلومات اكثر اذا زرت الصفحة

?>
<html>
<head>
<link rel="stylesheet" href="css/style_admin_page.css">
    <title>صفحة الإدارة</title>
    <meta charset="utf-8">
  

</head>
<body>
<nav>
    <ul>
      <li><a href="admin_page.php">الرئيسة</a></li>
      <li><a href="logging.php">سلوك المستخدم</a></li>
      <li><a href="add_admin.php">اضافه مستخدم رئيسي جديد</a></li>
    </ul>
  </nav>
  

    <h1>صفحة سلوك المستخدم</h1>
    <a href="logout.php" class="logout">تسجيل الخروج</a>
    
    <form action="" method="get">
    <label for="filter">تصفية النتائج حسب:</label>
    <select name="filter" id="filter">
        <option value="all">الكل</option>
        <option value="admin_login">تسجيل دخول مستخدم رئيسي</option>
        <option value="Admin_Register">تسجيل مستخدم رئيسي جديد</option>
        <option value="delete"> حذف المستخدم من قبل مستخدم رئيسي</option>
        <option value="reset_admin"> تغيير كلمة المرور من قبل مستخدم رئيسي</option>
        <option value="login">تسجيل دخول</option>
        <option value="Register">تسجيل جديد</option>
        <option value="logout">تسجيل الخروج</option>
        <option value="mistake">تسجيل دخول خاطئ</option>
        <option value="reset">تغيير كلمة المرور</option>
    </select>
    <button type="submit">تصفية</button>
</form>
</body>
</html>


<?php
include 'config.php'; //الاتصال بقاعدة البيانات 

$filter = $_GET['filter'] ?? 'all';// الكود الخاص بالفلتر داخل الصفحة 

switch ($filter) {
    case 'admin_login':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation = 'تسجيل دخول مستخدم رئيسي' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على تسجيل دخول مستخدم رئيسي
        break;
    case 'Admin_Register':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation =' تسجيل مستخدم رئيسي جديد' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على تسجيل مستخدم رئيسي جديد  
        break;
    case 'delete':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation = 'حذف المستخدم من قبل مستخدم رئيسي' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على  حذف المستخدم من قبل مستخدم رئيسي  
        break;
    case 'reset_admin':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation = ' تغيير كلمة المرور من قبل مستخدم رئيسي' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على تغيير كلمة المرور من قبل مستخدم رئيسي 
        break;
    case 'Register':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation = 'تسجيل جديد' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على تسجيل جديد  
        break;
    case 'login':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation = 'تسجيل دخول' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على تسجيل دخول
        break;
    case 'logout':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation = 'تسجيل الخروج' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على تسجيل خروج
        break;
    case 'mistake':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation = 'تسجيل دخول خاطئ' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على تسجيل دخول خاطئ
        break;
    case 'reset':
        $sql = "SELECT email, my_datetime, operation FROM logging WHERE operation = 'تغيير كلمة المرور' ORDER BY my_datetime DESC";// اعرض فقط التي تحتوي على تغيير كلمة المرور 
        break;
        
    default:
    $sql = "SELECT email, my_datetime, operation FROM logging ORDER BY my_datetime DESC";// اعرض الكل
    break;
}

$result = mysqli_query($conn, $sql);// اتمام الطلب

echo "<table>";
echo "<tr><th>البريد الإلكتروني</th><th>التاريخ والوقت</th><th>العملية</th></tr>";

while($row = mysqli_fetch_assoc($result)) {// التكرار بالعدد الموجود في الجدول لعرض جميع النتايج داخل جدول
    $email = $row['email'];
    $my_datetime = $row['my_datetime'];
    $operation = $row['operation'];
    echo "<tr><td>$email</td><td>$my_datetime</td><td>$operation</td></tr>";
}

echo "</table>";

mysqli_close($conn);
?>
