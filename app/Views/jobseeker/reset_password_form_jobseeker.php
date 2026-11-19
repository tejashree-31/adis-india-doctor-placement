<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
   <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png">
    <meta name="description" content="Adis India Placement Pvt. Ltd. – Leading Healthcare Recruitment consultancy providing spetialist doctors,super spetialist doctors,MBBS Doctor,BAMS,BHMS, HR, & ADMINISTARION  staffing solutions across India.">
  <title>Forgot Password</title>
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

    .form-box input[type="email"],
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
  
  <div class="form-box">
     <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red; text-align: center; font-weight: bold; margin-bottom: 10px;">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>
    
    <div class="single-tab">New Password</div>
    

    <form method="post" action="<?= base_url('jobseeker/update_password') ?>">
      <input type="hidden" name="token" value="<?= esc($token) ?>">
      <input type="password" class="form-control" name="password" placeholder="Eneter New Password">
    <input type="submit" class="submit-btn" style="border-radius: 90px;" value="Update Password">
    </form>
    
    <!-- <button id="resendBtn" onclick="resendOtp()" >Resend OTP</button> -->

  </div>

</body>
</html>
