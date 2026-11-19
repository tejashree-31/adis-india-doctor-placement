<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png">
  <meta name="description" content="Adis India Placement Pvt. Ltd. – Leading Healthcare Recruitment consultancy providing spetialist doctors,super spetialist doctors,MBBS Doctor,BAMS,BHMS, HR, & ADMINISTARION  staffing solutions across India.">
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

/*    .home-icon {
      text-align: center;
      font-size: 40px;
      color: deeppink;
      margin-bottom: 10px;
    }*/
  </style>
</head>
<body>
  <?php //$code = $this->request->getGet('activation_code'); ?>
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
    <!-- <p id="timer"></p> -->
    <!-- <a href="<?//= base_url('recruiter-login') ?>?activeTab=signup" class="btn btn-secondary">← Back</a> -->
    <form method="post" action="<?= base_url('client/verify_client_jobseeker_otp') ?>">
      <input type="text" name="otp" placeholder="Enter OTP">
       <input type="hidden" name="job_id" value="<?= $job_id; ?>">
        <input type="hidden" name="posting_id" value="<?= $posting_id; ?>">
    
    <!-- <input type="password" placeholder="Password">
    <div class="forgot">Forgot password?</div> -->
    <!-- <button class="submit-btn" style="border-radius: 90px;">Login</button> -->
    <input type="submit" class="submit-btn" style="border-radius: 90px;" value="Login">
    </form>
    <button id="resendBtn" onclick="resendOtp()" style="display:none;">Resend OTP</button>
    <!-- <button id="resendBtn" onclick="resendOtp()" >Resend OTP</button> -->

  </div>

</body>
</html>
