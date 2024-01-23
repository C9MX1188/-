<?php
// بداية الجلسة
session_start();

// التحقق من وجود اسم المستخدم في الجلسة
if (!isset($_SESSION['customer_username'])) {
    // إذا لم يكن هناك اسم مستخدم في الجلسة، يجب توجيه المستخدم إلى صفحة تسجيل الدخول
    header("Location: Customer Login.php");
    exit();
}

// تضمين ملف الاتصال بقاعدة البيانات
include_once 'db_connection.php';

// الحصول على اسم المستخدم من الجلسة
$customer_username = $_SESSION['customer_username'];

// استعلام لجلب بيانات العميل باستخدام اسم المستخدم من الجلسة
$customer_query = $conn->prepare("SELECT * FROM accounts WHERE username = ?");

// التحقق من نجاح إعداد الاستعلام
if ($customer_query) {
    // ربط قيمة اسم المستخدم
    $customer_query->bind_param("s", $customer_username);

    // تنفيذ الاستعلام
    $executed = $customer_query->execute();

    // التحقق من نجاح تشغيل الاستعلام
    if ($executed) {
        // الحصول على نتيجة الاستعلام
        $customer_result = $customer_query->get_result();

        // التحقق من وجود نتائج
        if ($customer_result->num_rows > 0) {
            // استخراج بيانات العميل من النتائج
            $customer_data = $customer_result->fetch_assoc();

            // قم بعرض معلومات العميل في الصفحة
            $customer_name = $customer_data['username'];
            $customer_email = $customer_data['email'];

            // إغلاق نتيجة الاستعلام بمجرد استخدامها
            $customer_result->close();
        } else {
            echo "No results found for the customer.";
            // يمكنك إضافة توجيه إلى صفحة تسجيل الدخول هنا
            exit();
        }
    } else {
        echo "Error executing the query: " . $customer_query->error;
        // يمكنك إضافة توجيه إلى صفحة تسجيل الدخول هنا
        exit();
    }
} else {
    // إذا كان هناك خطأ في الاستعلام
    echo "Error in query preparation: " . $conn->error;
    // يمكنك إضافة توجيه إلى صفحة تسجيل الدخول هنا
    header("Location: CustomerLogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Customer page.css" />
    <link rel="shortcut icon" href="img/S1S.png" type="image/png" />

    <title>Customer Page</title>
  </head>
  <body>
    
    <!--       <div id="prelloader"></div>   شغلته بس عشان شاشت لودنق  -->
    <div id="prelloader"></div>
    <header>
      <div class="header">
        <nav>
          <img id="icon" src="img/S1S.png" alt="" class="logo" />
          <ul>
            <li><a href="1Services website.html ">الرئيسية</a></li>
            <li><a href="1Services website.html  #section2">نبذة عنا</a></li>
            <li><a href="1Services website.html #text2">الخدمات</a></li>
            <li><a href="1Services website.html #footer">اتصل بنا</a></li>
            <li><a href="#">المعرض</a></li>
            <li><a href="1Services website.html">Logout</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <section>
      <div class="container">
        <div class="account-info">
        <h2>معلومات الشخصية</h2>
          <p>اسم: <?php echo $customer_name; ?></p>
          <p>بريد الاكتروني: <?php echo $customer_email; ?></p>
          <!-- يمكنك إضافة معلومات إضافية حسب حاجتك -->
        </div>

        <div class="recent-activity">
          <h2>النشاط الأخير</h2>
          <!-- Display recent transactions, orders, or other activities here -->
          
        </div>
      </div>
      <div>
        
      </div>
 
  
    <div class="container2 ">
    <table>
        <tr>
            <th>رقم الطلب</th>
            <th>اسم الموظف</th>
            <th>تفاصيل العمل</th>
            <th>رقم الجوال</th>
        </tr>

        <?php
        // تضمين ملف الاتصال بقاعدة البيانات
        include_once 'db_connection.php';

        // استعلام لاسترجاع جميع بيانات طلبات العمل
        $query = "SELECT * FROM JobRequests";
        $result = $conn->query($query);

        // التحقق من وجود نتائج
        if ($result->num_rows > 0) {
            // عرض البيانات
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['request_id'] . "</td>
                        <td>" . $row['employee_name'] . "</td>
                        <td>" . $row['job_details'] . "</td>
                        <td>" . $row['mobile_number'] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>لا توجد بيانات حتى الآن.</td></tr>";
        }

        // إغلاق اتصال قاعدة البيانات
        $conn->close();
        ?>
    </table>
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
