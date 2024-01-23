<?php
session_start();
include_once 'db_connection.php';

$error_message = '';

if (!isset($_SESSION['employee_id'])) {
    header("Location: Log in as an employee.php ");
    exit();
}

$employee_id = $_SESSION['employee_id'];

$employee_query = $conn->prepare("SELECT * FROM Employees WHERE employee_id = ?");

if ($employee_query) {
    $employee_query->bind_param("s", $employee_id);
    $executed = $employee_query->execute();

    if ($executed) {
        $employee_result = $employee_query->get_result();

        if ($employee_result->num_rows > 0) {
            $employee_data = $employee_result->fetch_assoc();
            $employee_email = $employee_data['employee_email'];
            $employee_name = $employee_data['employee_name'];
            $profession_service = $employee_data['profession_service'];
            $employee_result->close();
        } else {
            echo "No results found for the employee.";
            header("Location: Log in as an employee.php ");
            exit();
        }
    } else {
        echo "Error executing the query: " . $employee_query->error;
        header("Location: Log in as an employee.php ");
        exit();
    }
} else {
    echo "Error in query preparation: " . $conn->error;
    header("Location: Log in as an employee.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="Employee page.css" />

    <link rel="shortcut icon" href="img/S1S.png" type="image/png" />

    <title>Employee Page</title>
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
        <div class="employee-info">
          <h2>معلومات الشخصية</h2>
          <p> اسم: <?php echo $employee_name; ?></p>
          <p>رقم الموظف: <?php echo $employee_id; ?></p>
          <p>بريد الاكتروني: <?php echo $employee_email; ?></p>
          <p>عمل الموظف: <?php echo $profession_service; ?></p>
        </div>

        <div class="tasks">
          <h2>الطلبات جاري قيام بية</h2>
          <!-- عرض المهام، الواجبات، أو أية معلومات ذات صلة هنا -->
        </div>
      </div><div> <h2 class="containerh2">معلومات الطلبات</h2>
      <div class="container2">
       
        <!-- جدول لعرض طلبات الموظف -->
        <table class="con">
        <tr>
            <th>رقم الطلب</th>
            <th>اسم الموظف</th>
            <th>تفاصيل العمل</th>
            <th>رقم الجوال</th>
        </tr>
</table>
<table>
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



        ?>
    </table>
      </div>
      </div>
      <div class="container3">
    <div>
    <form action="Employee page.php" method="post">
        <h4 for="employee_name">اسم الموظف:   <?php echo $employee_name; ?></h4>
 
        <label for="job_details">تفاصيل العمل:</label>
        <textarea id="job_details" name="job_details" required  rows="5" cols="30"><?php echo $profession_service; ?></textarea>
<br>
        <label for="mobile_number">رقم الجوال:</label>
        <input type="text" id="mobile_number" name="mobile_number" required>
        <br>
        <button type="submit" name="compressBtn">إرسال الطلب</button>
    </form><?php
// ...
if (isset($_POST['compressBtn'])) {
// التحقق من أن الطلب قد تم بواسطة الطريقة POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // قم بتحقق وتنظيف إدخال المستخدم
    $job_details = mysqli_real_escape_string($conn, $_POST['job_details']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);

    // التحقق من أن الرقم لا يزيد ولا يقل عن 10 أرقام
    if (strlen($mobile_number) != 10) {
        echo "خطأ: رقم الهاتف يجب أن يكون 10 أرقام.";
    } else {
        // التحقق من عدم وجود رقم هاتف مكرر في قاعدة البيانات
        $check_query = $conn->prepare("SELECT COUNT(*) FROM JobRequests WHERE mobile_number = ?");
        
        // التحقق من نجاح استعلام التحقق
        if ($check_query) {
            $check_query->bind_param("s", $mobile_number);
            $check_query->execute();
            $check_query->bind_result($count);
            $check_query->fetch();

            // إغلاق نتائج استعلام التحقق
            $check_query->close();

            if ($count > 0) {
                // إذا كان هناك رقم هاتف مكرر، عرض رسالة خطأ
                echo "خطأ: رقم الهاتف مكرر ولا يمكن إدراجه.";
            } else {
                // إذا كان رقم الهاتف غير مكرر، قم بإدراج البيانات في جدول الطلبات
                $insert_query = $conn->prepare("INSERT INTO JobRequests (employee_name, job_details, mobile_number) VALUES (?, ?, ?)");
                
                // التحقق من نجاح استعلام الإدراج
                if ($insert_query) {
                    $insert_query->bind_param("sss", $employee_name, $job_details, $mobile_number);
                    $insert_result = $insert_query->execute();
                    
                    // عرض رسالة النجاح أو الفشل
                    echo $insert_result ? "تم إرسال الطلب بنجاح." : "حدث خطأ أثناء إرسال الطلب: " . $conn->error;
                    
                    // إغلاق استعلام الإدراج
                    $insert_query->close();
                } else {
                    echo "حدث خطأ أثناء تحضير استعلام الإدراج: " . $conn->error;
                }
            }
        } else {
            echo "حدث خطأ أثناء تحضير استعلام التحقق: " . $conn->error;
        }
    }
} else {
    echo "حدث خطأ: الطلب";
}
}
// ...
?>


</div>
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