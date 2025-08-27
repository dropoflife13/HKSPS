<?php
session_start();
include("../config/conn.php"); // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Compare raw password (no hashing)
        if ($password === $user['password']) {
            // Save session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role']      = $user['role'];

            // Redirect by role
            switch ($user['role']) {
                case "admin":
                    header("Location: ../Admin/index.php");
                    break;
                case "teacher":
                    header("Location: ../Teachers/index.php");
                    break;
                default: // student
                    header("Location: ../Students/index.php");
                    break;
            }
            exit;
        } else {
            $error = "❌ Invalid password!";
        }
    } else {
        $error = "❌ No account found with that email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <link rel="stylesheet" href="../assets/css/global.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form action="login.php" method="POST">
      <label>Email</label>
      <input type="text" name="email" required>

      <label>Password</label>
      <input type="password" name="password" required>

      <button type="submit">Login</button>
    </form>

    <p>Don't have an account?</p>
    <a href="register.php"><button type="button">Register</button></a>
  </div>
</body>
</html>
