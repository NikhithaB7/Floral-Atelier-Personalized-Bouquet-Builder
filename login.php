<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['username'] = $_POST['username'];
    header('Location: index.html');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Poppins", sans-serif;
      background: linear-gradient(180deg, #F9F4EF, #FCD9E8, #E7F8E8);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-card {
      background: #ffffff;
      width: 400px;
      padding: 45px 35px;
      border-radius: 25px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
      text-align: left;
      animation: fadeIn 0.6s ease;
    }

    h2 {
      color: #3D2A24;
      font-weight: 700;
      margin: 0 0 10px 0;
      font-size: 32px;
    }

    .welcome {
      color: #6a5953;
      margin: 0 0 25px 0;
      font-size: 17px;
    }

    form input[type="text"] {
      width: 100%;
      padding: 12px;
      margin: 12px 0;
      border-radius: 25px;
      border: 2px solid #E6C5D2;
      outline: none;
      font-size: 15px;
      transition: 0.3s;
    }

    form input[type="text"]:focus {
      border-color: #7BC47F;
      box-shadow: 0 0 5px #7BC47F;
    }

    .remember-forgot {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      color: #6a5953;
      margin: 5px 0 20px 0;
    }

    .remember-forgot input {
      margin-right: 3px;
    }

    form input[type="submit"] {
      width: 100%;
      padding: 12px;
      background: #D67CA9;
      border: none;
      border-radius: 25px;
      color: #fff;
      font-weight: 600;
      font-size: 16px;
      transition: 0.3s;
      cursor: pointer;
    }

    form input[type="submit"]:hover {
      background: #bf6a95;
    }

    .signup-text {
      text-align: center;
      color: #3D2A24;
      margin-top: 15px;
      font-size: 14px;
    }

    .signup-text a {
      color: #D67CA9;
      text-decoration: none;
      font-weight: 600;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(18px);}
      to { opacity: 1; transform: translateY(0);}
    }
</style>
</head>

<body>

<div class="login-card">
    <h2>Hi,</h2>
    <p class="welcome">Welcome back</p>

    <form method="post">
        <input type="text" name="username" placeholder="Email or Username" required>

        <div class="remember-forgot">
            <label><input type="checkbox"> Remember me</label>
            
        </div>

        <input type="submit" value="Login">
    </form>

    <p class="signup-text">Don’t have an account? <a href="register.html">Sign up</a></p>
</div>

</body>
</html>
