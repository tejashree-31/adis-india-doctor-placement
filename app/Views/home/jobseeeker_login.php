<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
 

    .bg-overlay {
      background-color: rgba(236, 99, 109, 0.6); /* #ec636d with opacity */
      width: 100%;
      height: 100vh;
    }

    .form_wrapper {
      max-width: 400px;
      margin: 80px auto;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      position: relative;
    }

    .home_icon {
      text-align: center;
      margin-bottom: 20px;
    }

    .home_icon i {
      font-size: 2rem;
      color: #e91e63;
    }

    .tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .tab.login_tab {
      padding: 10px 40px;
      background: linear-gradient(to right, #8e0e00, #e52e71);
      color: white;
      border-radius: 8px;
      font-weight: bold;
      cursor: default;
    }

    .form_wrap {
      text-align: center;
    }

    .form_field {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .form_field h3 {
      margin-bottom: 20px;
      font-size: 1.5rem;
      color: #333;
    }

    .input_group {
      width: 100%;
      margin-bottom: 15px;
    }

    .input {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
      outline: none;
    }

    .forgot {
      display: block;
      margin: 10px 0 20px;
      color: #e91e63;
      font-size: 0.9rem;
      text-decoration: none;
    }

    .btn {
      width: 100%;
      padding: 10px;
      background: linear-gradient(to right, #8e0e00, #e52e71);
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    .btn:hover {
      opacity: 0.95;
    }
  </style>
</head>
<body style="background-image: url('<?= base_url(); ?>assets/jobportal/images/6.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center; background-attachment: fixed;">

  <div class="form_wrapper"> 
    <div class="home_icon">
      <a href="<?= base_url('/'); ?>">
        <i class="fas fa-home"></i>
      </a>
    </div>
     <?php 
      $error = session()->getFlashdata('error');
        $message = session()->getFlashdata('message');

     if ($error): ?>
          <div class="alert alert-danger text-center">
            <?= esc($error) ?>
          </div>
        <?php endif; ?>
        <?php if ($message): ?>
          <div class="alert alert-danger text-center">
            <?= esc($message) ?>
          </div>
        <?php endif; ?>
    <div class="tabs">
      <div class="tab login_tab">Login</div>
    </div>

    <div class="form_wrap">
         <?php 
            $otp_str = str_shuffle("0123456789");
            $otp = substr($otp_str, 0, 5);
            $act_str = rand(100000, 10000000);
            $activation_code = str_shuffle("abcdefghijklmno" . $act_str);
          ?>
      <form class="form_field login_form" method="post" action="<?= base_url('jobseeker/Saveloginform') ?>">
       
        
        <input type="hidden" name="user_type" value="jobseekar">
        <input type="hidden" name="otp" value="<?= $otp; ?>">
        <input type="hidden" name="activation_code" value="<?= $activation_code; ?>">
        <!-- <h3>Login Form</h3> -->
        <div class="input_group">
          <input type="email" name="email" class="input" placeholder="Email Address" required>
        </div>
      
        <!-- <a href="#forgot" class="forgot">Forgot password?</a> -->
        <input type="submit" class="btn" value="Login">
      </form>
    </div>
  </div>

</body>
</html>
