<?php
require "./koneksi.php";
session_start();

if (isset($_POST['loginbtn'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $mysqli,
        "SELECT * FROM user WHERE username='$username'"
    );

    $user = mysqli_fetch_assoc($query);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['login']    = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['id']       = $user['id'];
            header("Location: home.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Login</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #fff4ec 0%, #ffe8d6 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    color: #1a1a1a;
  }

  .container { width: 100%; max-width: 400px; }

  .top-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 20px;
  }
  .dot { width: 10px; height: 10px; border-radius: 50%; }
  .dot-1 { background: #ff8c42; }
  .dot-2 { background: #ffb347; }
  .dot-3 { background: #ffd580; }

  h1 {
    font-size: 22px;
    font-weight: 600;
    text-align: center;
    margin-bottom: 4px;
    color: #1a1a1a;
  }
  .subtitle {
    font-size: 13px;
    color: #999;
    text-align: center;
    margin-bottom: 24px;
  }

  .card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #fde0c8;
    padding: 24px;
    box-shadow: 0 2px 16px rgba(255,140,66,0.1);
  }

  .field { margin-bottom: 16px; }

  label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #555;
    margin-bottom: 6px;
  }

  .input-wrap { position: relative; display: flex; align-items: center; }

  .input-icon {
    position: absolute;
    left: 12px;
    color: #ffb347;
    font-size: 13px;
    pointer-events: none;
  }

  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 9px 38px 9px 34px;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    color: #1a1a1a;
    background: #fafafa;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
  }
  input::placeholder { color: #ccc; }
  input:focus {
    border-color: #ff8c42;
    box-shadow: 0 0 0 3px rgba(255,140,66,0.12);
    background: #fff;
  }

  .toggle-btn {
    position: absolute;
    right: 10px;
    background: none;
    border: none;
    cursor: pointer;
    color: #ccc;
    font-size: 13px;
    padding: 2px;
    transition: color 0.15s;
  }
  .toggle-btn:hover { color: #ff8c42; }

  /* Alert */
  .alert {
    margin-bottom: 16px;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .alert-error {
    background: #fff3f3;
    border: 1px solid #fcc;
    color: #c0392b;
  }
  .alert-success {
    background: #f0fff4;
    border: 1px solid #b2f0c5;
    color: #1e7e34;
  }

  hr { border: none; border-top: 1px solid #f0f0f0; margin: 20px 0; }

  .btn {
    width: 100%;
    padding: 10px;
    background: linear-gradient(90deg, #ff8c42, #ffb347);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    box-shadow: 0 3px 10px rgba(255,140,66,0.3);
  }
  .btn:hover { opacity: 0.9; }
  .btn:active { transform: scale(0.98); }
  .btn:disabled {
    background: #e0e0e0;
    color: #aaa;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
  }

  .spinner {
    display: inline-block;
    width: 13px; height: 13px;
    border: 2px solid rgba(255,255,255,0.4);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
    vertical-align: middle;
    margin-right: 6px;
  }
  @keyframes spin { to { transform: rotate(360deg); } }

  .register-link {
    text-align: center;
    font-size: 13px;
    color: #999;
    margin-top: 14px;
  }
  .register-link a { color: #ff8c42; text-decoration: none; font-weight: 500; }
  .register-link a:hover { text-decoration: underline; }
</style>
</head>
<body>

<div class="container">
  <div class="top-bar">
    <div class="dot dot-1"></div>
    <div class="dot dot-2"></div>
    <div class="dot dot-3"></div>
  </div>

  <h1>Selamat Datang</h1>
  <p class="subtitle">Masuk ke akun kamu untuk melanjutkan</p>

  <div class="card">

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" id="successAlert">
      <i class="fa fa-circle-check"></i>
      Registrasi berhasil! Silakan login.
    </div>
    <script>
      setTimeout(() => {
        document.getElementById('successAlert').style.display = 'none';
      }, 3000);
    </script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
    <div class="alert alert-error">
      <i class="fa fa-circle-exclamation"></i>
      <?= $error ?>
    </div>
    <?php endif; ?>

    <form method="post">

      <div class="field">
        <label for="username">Username</label>
        <div class="input-wrap">
          <i class="fa fa-user input-icon"></i>
          <input type="text" id="username" name="username" placeholder="Username kamu" required
                 value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"/>
        </div>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <i class="fa fa-lock input-icon"></i>
          <input type="password" id="password" name="password" placeholder="Password kamu" required/>
          <button class="toggle-btn" type="button" id="togglePassword" onclick="toggleVis()">
            <i id="toggleIcon" class="fa fa-eye"></i>
          </button>
        </div>
      </div>

      <hr/>

      <button class="btn" id="loginBtn" name="loginbtn" type="submit" onclick="showLoading()">
        Masuk
      </button>

    </form>

    <p class="register-link">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
  </div>
</div>

<script>
  function toggleVis() {
    const inp  = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    const show = inp.type === 'password';
    inp.type       = show ? 'text' : 'password';
    icon.className = show ? 'fa fa-eye-slash' : 'fa fa-eye';
  }
</script>
</body>
</html>