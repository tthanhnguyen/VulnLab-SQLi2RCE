<?php
$host = "localhost";    // getenv("MYSQL_HOSTNAME");
$db = "lab";           // getenv("MYSQL_DATABASE");
$user = "newuser";      // getenv("MYSQL_USER");
$password = "password"; // getenv("MYSQL_PASSWORD");

$conn = new mysqli($host, $user, $password, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Khởi tạo biến để lưu thông báo kết quả
$resultMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username']) && isset($_GET['password'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];

    // Truy vấn dễ bị SQL Injection
    $sql = "SELECT username FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result === false) {
        // In ra thông báo lỗi nếu truy vấn thất bại
        die("Error in query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $values = array_values($row);
        $firstValue = $values[0]; // Lấy giá trị đầu tiên
        $resultMessage = "Login as: " . htmlspecialchars($firstValue); // Trả về tên người dùng
    } else {
        $resultMessage = "Invalid username or password";
    }
}

$conn->close();
?>

<!-- Form truy vấn người dùng -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Lab</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
        }
        label {
            margin-bottom: 10px;
            display: block;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #e9ecef;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>SQL Injection Lab</h2>
        <form method="get" action="">
            <label for="username">Enter username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Enter password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Submit">
        </form>
        <div class="result">
            <?php
            // Hiển thị thông báo kết quả
            if (!empty($resultMessage)) {
                echo htmlspecialchars($resultMessage);
            }
            ?>
        </div>
    </div>
</body>
</html>
