<?php
session_start();
include_once 'db_connection.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = mysqli_real_escape_string($conn, $_POST['employeeId']);
    $employeePassword = mysqli_real_escape_string($conn, $_POST['employeePassword']);

    if (empty($employeeId) || empty($employeePassword)) {
        $error_message = "الرجاء إدخال رقم الموظف وكلمة المرور.";
    } else {
        $query = "SELECT * FROM Employees WHERE employee_id = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $employeeId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                if (password_verify($employeePassword, $row['employee_password'])) {
                    $_SESSION['employee_id'] = $employeeId;
                    header('Location: Employee page.php');
                    exit();
                } else {
                    $error_message = "خطأ في كلمة المرور.";
                }
            } else {
                $error_message = "خطأ في رقم الموظف.";
            }

            mysqli_stmt_close($stmt);
        } else {
            $error_message = "خطأ في تحضير الاستعلام.";
        }
    }
}
?>

<!-- ... الجزء الباقي من الصفحة ... -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Log in as an employee.css" />
    <link rel="shortcut icon" href="img/S1S.png" type="image/png" />
    <title>Employee Login</title>
</head>

<body>
    
    <!--       <div id="prelloader"></div>   شغلته بس عشان شاشت لودنق  -->
    <div id="prelloader"></div>
    <header>
        <nav>
            <img id="icon" src="img/S1S.png" alt="" class="logo" />
            <ul>
                <li><a href="1Services website.html">الرئيسية</a></li>
                <li><a href="1Services website.html#section2">نبذة عنا</a></li>
                <li><a href="1Services website.html#text2">الخدمات</a></li>
                <li><a href="1Services website.html#footer">اتصل بنا</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <div class="container">
            <form id="employee-login-form" method="POST" action="">
                <h2>Employee Login</h2>

                <!-- Employee ID -->
                <label for="employeeId">رقم الموظف:</label>
                <input type="text" id="employeeId" name="employeeId" required />

                <!-- Employee Password -->
                <label for="employeePassword">كلمة المرور:</label>
                <input type="password" id="employeePassword" name="employeePassword" required />

                <!-- Submit Button -->
                <button type="submit">تسجيل الدخول</button>
            </form>

            <!-- عرض رسالة الخطأ -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <!-- Links -->
            <ul>
                <li><a href="Create an employee account.php">إنشاء حساب موظف جديد</a></li>
                <li><a href="#">نسيت كلمة المرور</a></li>
            </ul>
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
