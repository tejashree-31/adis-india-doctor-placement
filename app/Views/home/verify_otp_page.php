<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>OTP Verify</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f26b72;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-box {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      width: 350px;
      box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
    }

    .single-tab {
      background: linear-gradient(to right, #8B0000, #E34234);
/*      padding: 15px;*/
        padding:9px ;
      text-align: center;
/*      border-radius: 10px 10px 0 0;*/
      color: #fff;
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .form-box input[type="text"],
    .form-box input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    .form-box .forgot {
      text-align: right;
      font-size: 14px;
      color: deeppink;
      margin-bottom: 20px;
    }

    .form-box .submit-btn {
      background: linear-gradient(to right, #8B0000, #E34234);
      color: #fff;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
    }

    .form-box .submit-btn:hover {
      opacity: 0.9;
    }

  </style>
</head>
<body>
  
  <?php  $message = session()->getFlashdata('message');
        $error = session()->getFlashdata('error');
  ?>
  <div class="form-box">
     <?php if ($message): ?>
          <div class="alert alert-success text-center">
            <?= esc($message) ?>
          </div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="alert alert-danger text-center">
            <?= esc($error) ?>
          </div>
        <?php endif; ?>
    <!-- <div class="home-icon">🏠</div> -->
    <div class="single-tab">OTP Verify</div>
   
    <a href="<?= base_url('recruiter-login') ?>?activeTab=signup" class="btn btn-secondary">← Back</a>
     <form method="post" class="form_field signup_form" action="<?= base_url('verify_otp') ?>">
      <input type="text" name="otp" placeholder="Eneter OTP">
       <input type="hidden" name="activation_code" value="<?= esc($activation_code) ?>">
    <!-- <input type="password" placeholder="Password">
    <div class="forgot">Forgot password?</div> -->
    <!-- <button class="submit-btn" style="border-radius: 90px;">Login</button> -->
    <input type="submit" class="submit-btn" style="border-radius: 90px;" value="Login">
    </form>
  

  </div>

</body>
</html>
