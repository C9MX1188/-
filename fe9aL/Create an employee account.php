<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Create an employee account.css" />
    <link rel="shortcut icon" href="img/S1S.png" type="image/png" />
    <title>Create Employee Account</title>
</head>
<body>
    
    <!--       <div id="prelloader"></div>   شغلته بس عشان شاشت لودنق  -->
    <div id="prelloader"></div>
    <header>
        <nav>
            <img id="icon" src="img/S1S.png" alt="" class="logo" />
            <ul>
          <li><a href="1Services website.html ">الرئيسية</a></li>
          <li><a href="1Services website.html  #section2">نبذة عنا</a></li>
          <li><a href="1Services website.html #text2">الخدمات</a></li>
          <li><a href="1Services website.html #footer">اتصل بنا</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <div class="container">
            <form id="employee-signup-form" method="POST" action="">
                <h2>Create Employee Account</h2>
                
                <!-- Employee ID -->
                <label for="employeeId">رقم الموظف:</label>
                <input type="text" id="employeeId" name="employeeId" required />

                <!-- Employee Name -->
                <label for="employeeName">اسم الموظف:</label>
                <input type="text" id="employeeName" name="employeeName" required />

                <!-- Profession/Service Provided -->
                <label for="professionService">المهنة/الخدمة المقدمة:</label>
                <input type="text" id="professionService" name="professionService" required />

                <!-- Employee Email -->
                <label for="employeeEmail">البريد الإلكتروني للموظف:</label>
                <input type="email" id="employeeEmail" name="employeeEmail" required />

                <!-- Employee Password -->
                <label for="employeePassword">كلمة المرور:</label>
                <input type="password" id="employeePassword" name="employeePassword" required />

                <!-- Submit Button -->
                <button type="submit">إنشاء حساب الموظف</button>
            </form>
        </div>
    </section>
    <script>
      var loader = document.getElementById("prelloader");
      window.addEventListener("load", function () {
        loader.style.display = "none";
      });
    </script>
</body>
</html>

<?php
include_once 'db_connection.php';

// تحقق من وجود طلب POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employeeId'];
    $employeeName = $_POST['employeeName'];
    $professionService = $_POST['professionService'];
    $employeeEmail = $_POST['employeeEmail'];
    $employeePassword = password_hash($_POST['employeePassword'], PASSWORD_DEFAULT);

    // التحقق من صحة البريد الإلكتروني
    if (filter_var($employeeEmail, FILTER_VALIDATE_EMAIL)) {
        // استخدام استعلام معلمة للحماية من حقن SQL
        $query = "INSERT INTO Employees (employee_id, employee_name, profession_service, employee_email, employee_password) 
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);

        // ربط المتغيرات بالاستعلام
        mysqli_stmt_bind_param($stmt, "sssss", $employeeId, $employeeName, $professionService, $employeeEmail, $employeePassword);

        // تنفيذ الاستعلام
        $result = mysqli_stmt_execute($stmt);

        // التحقق من نجاح الاستعلام وإظهار رسالة مناسبة
        if ($result) {
            echo "تم إنشاء حساب الموظف بنجاح. #Success";
            
              // التوجيه إلى صفحة تسجيل الدخول بعد إنشاء الحساب
              header("Location:Log in as an employee.php");
              exit();
        } else {
            echo "حدث خطأ أثناء إنشاء حساب الموظف: " . mysqli_error($connection) . " #Error";
        }

        // إغلاق الاستعلام
        mysqli_stmt_close($stmt);
    } else {
        echo "يرجى إدخال بريد إلكتروني صالح. #InvalidEmail";
    }

    // إغلاق اتصال قاعدة البيانات
    mysqli_close($connection);
}
?>
