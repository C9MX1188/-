<?php
session_start();
include_once 'db_connection.php';

// تعريف متغير لتخزين رسالة الخطأ
$error_message = '';

// التحقق من أن الطلب قد تم بواسطة الطريقة POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التحقق وتنظيف إدخال المستخدم
    $login_username = mysqli_real_escape_string($conn, $_POST['username']);
    $login_password = mysqli_real_escape_string($conn, $_POST['password']);

    // تجنب استخدام كلمات المرور على شكل نص مفتوح، استخدم تقنية التجزئة (Hashing)
    $hashed_password = password_hash($login_password, PASSWORD_DEFAULT);

    // استعلام لاسترجاع بيانات المستخدم من قاعدة البيانات
    $login_query = $conn->prepare("SELECT * FROM accounts WHERE username=?");
    $login_query->bind_param("s", $login_username);
    $login_query->execute();
    $result = $login_query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // التحقق من صحة كلمة المرور باستخدام تقنية التجزئة
        if (password_verify($login_password, $row['password'])) {
            echo "تم تسجيل الدخول بنجاح!";
            
            // إذا كانت صحيحة، يتم تعيين اسم المستخدم في الجلسة
            $_SESSION['customer_username'] = $login_username;

            // توجيه المستخدم إلى صفحة معينة بعد تسجيل الدخول
            header("Location: Customer page.php");
            exit();
        } else {
            $error_message = "فشل تسجيل الدخول. الرجاء التحقق من اسم المستخدم وكلمة المرور.";
        }
    } else {
        $error_message = "فشل تسجيل الدخول. الرجاء التحقق من اسم المستخدم وكلمة المرور.";
    }
}

// إغلاق اتصال قاعدة البيانات
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Customer login.css" />
    <link rel="shortcut icon" href="img/S1S.png" type="image/png" />

    <title>Customer Login</title>
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
        <form id="login-form" method="post">
          <h2>Customer Login</h2>
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required />

          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />

          <button type="submit">Login</button>
        </form>
        <ul>
          <li>
            <a href="Create a customer account.php">Create a account</a>
          </li>
          <li><a href="#">I forgot the password</a></li>
        </ul>
  
        <?php
      // عرض رسالة الخطأ في المكان الذي تختاره
      if (!empty($error_message)) {
          echo "<div class='error-message'>$error_message</div>";
      }
      ?>

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
