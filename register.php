<?php
require "./koneksi.php";

if (isset($_POST['registerbtn'])) {

    $username = htmlspecialchars(trim($_POST['username']));
    $email    = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm  = trim($_POST['confirm_password']);

    if (!preg_match('/^[a-zA-Z0-9._%+-]+@upitra\.ac\.id$/', $email)) {
        $error = "Gunakan email kampus @upitra.ac.id";
    } elseif (strlen($password) < 8) {
        $error = "Password minimal 8 karakter!";
    } elseif (!preg_match('/[^\w]/', $password)) {
        $error = "Password harus mengandung simbol!";
    } elseif ($password !== $confirm) {
        $error = "Konfirmasi password tidak sama!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $cek  = mysqli_query($mysqli, "SELECT * FROM user WHERE username='$username' OR email='$email'");

        if (mysqli_num_rows($cek) > 0) {
            $error = "Username atau email sudah digunakan!";
        } else {
            $query = mysqli_query($mysqli, "INSERT INTO user(username,email,password) VALUES('$username','$email','$hash')");
            if ($query) {
                header("Location: login.php?success=1");
                exit;
            } else {
                $error = "Register gagal!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Register</title>
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
  input[type="email"],
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

  .strength-row { display: flex; gap: 4px; margin-top: 6px; }
  .seg {
    flex: 1; height: 3px; border-radius: 2px;
    background: #eee;
    transition: background 0.25s;
  }
  .strength-text { font-size: 11px; color: #aaa; margin-top: 4px; min-height: 14px; }

  /* Alert error */
  .alert {
    margin-top: 0;
    margin-bottom: 16px;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    background: #fff3f3;
    border: 1px solid #fcc;
    color: #c0392b;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .alert i { font-size: 14px; }

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

  .login-link {
    text-align: center;
    font-size: 13px;
    color: #999;
    margin-top: 14px;
  }
  .login-link a { color: #ff8c42; text-decoration: none; font-weight: 500; }
  .login-link a:hover { text-decoration: underline; }
</style>
</head>
<body>

<div class="container">
  <div class="top-bar">
    <div class="dot dot-1"></div>
    <div class="dot dot-2"></div>
    <div class="dot dot-3"></div>
  </div>

  <h1>Daftar Akun</h1>
  <p class="subtitle">Isi data di bawah untuk membuat akun baru</p>

  <div class="card">

    <?php if (isset($error)): ?>
    <div class="alert">
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
                 value="<?= isset($username) ? htmlspecialchars($username) : '' ?>"/>
        </div>
      </div>

      <div class="field">
        <label for="email">Email Kampus</label>
        <div class="input-wrap">
          <i class="fa fa-envelope input-icon"></i>
          <input type="email" id="email" name="email" placeholder="nama@upitra.ac.id"
                 
                 value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"/>
        </div>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <i class="fa fa-lock input-icon"></i>
          <input type="password" id="password" name="password" placeholder="Minimal 8 karakter + simbol"
                 oninput="checkStrength(this.value)" required/>
          <button class="toggle-btn" type="button" id="togglePassword" onclick="toggleVis('password','togglePassword')">
            <i id="togglePassword-icon" class="fa fa-eye"></i>
          </button>
        </div>
      </div>

      <div class="field">
        <label for="confirmPassword">Konfirmasi Password</label>
        <div class="input-wrap">
          <i class="fa fa-lock input-icon"></i>
          <input type="password" id="confirmPassword" name="confirm_password" placeholder="Ulangi password" required/>
          <button class="toggle-btn" type="button" id="toggleConfirm" onclick="toggleVis('confirmPassword','toggleConfirm')">
            <i id="toggleConfirm-icon" class="fa fa-eye"></i>
          </button>
        </div>
      </div>

      <hr/>

      <button class="btn" id="registerBtn" name="registerbtn" type="submit" onclick="showLoading()">
        Daftar Sekarang
      </button>

    </form>

    <p class="login-link">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
  </div>
</div>

<script>
  function toggleVis(inputId, btnId) {
    const inp  = document.getElementById(inputId);
    const icon = document.getElementById(btnId + '-icon');
    const show = inp.type === 'password';
    inp.type = show ? 'text' : 'password';
    icon.className = show ? 'fa fa-eye-slash' : 'fa fa-eye';
  }
</script>
</body>
</html>