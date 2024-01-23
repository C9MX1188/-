<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="Create a customer account.css" /> <!-- رابط لملف الأنماط -->
  <link rel="shortcut icon" href="img/S1S.png" type="image/png" /> <!-- رابط لرمز الموقع -->
  <title>Create Account</title> <!-- عنوان الصفحة -->
</head>
<body>
  
    <!--       <div id="prelloader"></div>   شغلته بس عشان شاشت لودنق  -->
    <div id="prelloader"></div>
  <header>
    <nav>
      <img id="icon" src="img/S1S.png" alt="" class="logo" /> <!-- رمز الموقع -->
      <ul>
        <li><a href="1Services website.html">الرئيسية</a></li> <!-- روابط القائمة -->
        <li><a href="1Services website.html#section2">نبذة عنا</a></li>
        <li><a href="1Services website.html#text2">الخدمات</a></li>
        <li><a href="1Services website.html#footer">اتصل بنا</a></li>
      </ul>
    </nav>
  </header>
  <section>
    <div class="container">
      
      <form id="signup-form" method="post" action="Create a customer account.php">
        <h2>Create Customer Account</h2> <!-- عنوان نموذج إنشاء الحساب -->
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required /> <!-- حقل إدخال لاسم المستخدم -->

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required /> <!-- حقل إدخال للبريد الإلكتروني -->

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required /> <!-- حقل إدخال لكلمة المرور -->

        <label for="password_confirm">Confirm Password:</label>
        <input type="password" id="password_confirm" name="password_confirm" required />

        <button type="submit" name="create_account">Create Account</button> <!-- زر لإرسال النموذج -->

      </form>
        <ul>
          <li>
            <a href="Customer Login.php">Login account</a>
          </li>
        </ul>
      <?php
include_once 'db_connection.php';

// تحقق من وجود طلب POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // التحقق من صحة البريد الإلكتروني
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // التحقق من أن جميع الحقول المطلوبة مملوءة
        if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
            echo "يرجى ملء جميع الحقول المطلوبة.";
            exit();
        }

        // التحقق من تطابق كلمتي المرور
        if ($password !== $password_confirm) {
            echo "<div class='error-message' id='#InvalidPassword'>كلمة المرور غير متطابقة. يرجى التأكد من تطابق كلمة المرور.</div>";
            exit();
        }

        // التحقق من أن البريد الإلكتروني غير مستخدم مسبقًا
        $email_check_query = "SELECT * FROM accounts WHERE email='$email' LIMIT 1";
        $result = mysqli_query($connection, $email_check_query);
        $email_exists = mysqli_fetch_assoc($result);

        if ($email_exists) {
            echo "<div class='error-message' id='#InvalidPassword'>عذرًا، هذا البريد الإلكتروني مستخدم مسبقًا. يرجى استخدام بريد إلكتروني آخر.</div>";
            exit();
        }

        // استخدام استعلام معلمة للحماية من حقن SQL
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // تنفيذ الاستعلام
        $result = $stmt->execute();

        // التحقق من نجاح الاستعلام وإظهار رسالة مناسبة
        if ($result) {
            echo "تم إنشاء حسابك بنجاح!";
            // التوجيه إلى صفحة تسجيل الدخول بعد إنشاء الحساب
            header("Location: Customer login.php");
            exit();
        } else {
            echo "<div class='error-message' id='InvalidEmployeeID'>حدث خطأ أثناء إنشاء الحساب:</div> " . $stmt->error;
        }

        // إغلاق الاستعلام
        mysqli_stmt_close($stmt);
    } else {
        echo " <div class='error-message' id='InvalidEmployeeID'>يرجى إدخال بريد إلكتروني صالح.</div>";
    }

    // إغلاق اتصال قاعدة البيانات
    mysqli_close($connection);
}
?>

    </div>
  </section>
  <!--    سكربت الودنق -->
  <script>
      var loader = document.getElementById("prelloader");
      window.addEventListener("load", function () {
        loader.style.display = "none";
      });
    </script>
</body>
</html>
