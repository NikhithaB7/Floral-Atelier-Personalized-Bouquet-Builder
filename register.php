<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['username'] = $_POST['username'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Registration Success</title>

<!-- 💗 Same UI styling palette -->
<style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Poppins", sans-serif;
      background: linear-gradient(180deg, #F9F4EF, #FCD9E8, #E7F8E8); /* beige → pink → pastel green */
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .success-card {
      background: #ffffff;
      width: 400px;
      padding: 45px 35px;
      border-radius: 25px;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
      animation: fadeIn 0.7s ease-in-out;
    }

    .success-icon {
      width: 90px;
      height: 90px;
      background: #7BC47F; /* pastel green for success */
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto 15px auto;
      font-size: 45px;
      color: white;
    }

    h2 {
      color: #3D2A24;
      font-weight: 700;
      margin-bottom: 10px;
    }

    p {
      color: #6a5953;
      margin-bottom: 20px;
      font-size: 15px;
    }

    .home-btn {
      display: inline-block;
      padding: 12px 28px;
      background: #D67CA9;
      color: #fff;
      text-decoration: none;
      border-radius: 25px;
      font-weight: 600;
      transition: 0.3s;
      margin-top: 10px;
    }
    .home-btn:hover {
      background: #bf6a95;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>

<body>

<div class="success-card">
    <div class="success-icon">✔</div>
    <h2>Registration Successful!</h2>
    <p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong> </p>
    <a href="index.html" class="home-btn">Go to Home</a>
</div>

</body>
</html>
