<?php

use Config\Database;
$db = Database::connect();
  $job_role = $db->query("SELECT * FROM tbl_job_role")->getResultArray(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
   <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png">
    <meta name="description" content="Adis India Placement Pvt. Ltd. – Leading Healthcare Recruitment consultancy providing spetialist doctors,super spetialist doctors,MBBS Doctor,BAMS,BHMS, HR, & ADMINISTARION  staffing solutions across India.">
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /*body {
      margin: 0;
      padding: 0;
      background: #ec636d;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }*/

  /*      body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: url('<?//= base_url(); ?>assets/jobportal/images/6.jpg') no-repeat center center fixed;
      background-size: cover;
    }*/

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
        .home-icon {
      text-align: center;
      font-size: 40px;
      color: deeppink;
      margin-bottom: 10px;
    }
    .input_group {
  position: relative;
}

.toggle-eye {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  cursor: pointer;
  user-select: none;
}
.large-checkbox {
    transform: scale(1.4);   
    margin-right: 8px;
    cursor: pointer;
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
      $warning = session()->getFlashdata('warning');
      ?>

        <?php if ($error): ?>
        <div class="alert alert-danger text-center">
            <?= esc($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="alert alert-danger text-center">
            <?= esc($message) ?>
        </div>
    <?php endif; ?>

    <?php /*if ($warning): ?>
        <div class="alert text-center" style="color:#ff9800; font-weight:bold;">
            <?= esc($warning) ?>
        </div>
    <?php endif;*/ ?>



    <div class="tabs">
      <div class="tab login_tab">Sign Up</div>
    </div>

    <div class="form_wrap">
         <?php 
            $otp_str = str_shuffle("0123456789");
            $otp = substr($otp_str, 0, 5);
            $act_str = rand(100000, 10000000);
            $activation_code = str_shuffle("abcdefghijklmno" . $act_str);
          ?>
      <form class="form_field login_form" id="signup-form-client" method="post" action="<?= base_url('client/client-jobseeker-signup') ?>">
        <!-- <input type="hidden" name="job_id" value="<?= $job_id; ?>"> -->
        <input type="hidden" name="posting_id" value="<?= $posting_id; ?>">

        <input type="hidden" name="user_type" value="jobseekar">
        <input type="hidden" name="otp" value="<?= $otp; ?>">
        <input type="hidden" name="activation_code" value="<?= $activation_code; ?>">
        <!-- <h3>Login Form</h3> -->
        <div class="input_group">
            <input type="text" name="full_name" class="input" placeholder="Full Name" required>
        </div>
        <div class="input_group">
          <input type="email" name="email" id="email" class="input" placeholder="Email Address" required>
          <span id="emailError" style="color:red; font-size:13px; display:none;"></span>
        </div>
        <div class="input_group">
              <input type="password" id="password_client_sign" name="password" class="input" placeholder="Password" required>
              <span id="togglePassword_client_sign" class="toggle-eye">👁️</span>
        </div>
        <div class="input_group">
             <input type="text" name="mobile_no" class="input" id="mobile_no" placeholder="Mobile Number" maxlength="10"  required>
              <small id="mobileError" style="color:red; display:none;">
                Enter valid 10 digit mobile number
              </small>
        </div>
        <div class="input_group">
            <select class="input form-control form-control-md selectpicker" name="job_role" id="job_role_jobseeker" data-live-search="true" data-size="5" title="Job Role" required>

                    <option value="">Select Job Role</option>
                    <?php foreach ($job_role as $role): ?>
                     <option value="<?= esc($role['job_id']) ?>"
                        <?= ($job_id == $role['job_id']) ? 'selected' : ''; ?>>
                        <?= esc($role['job_role']) ?>
                    </option>
                    <?php endforeach; ?>
            </select>
        </div>
        <div class="input_group">
            <input type="checkbox" id="terms" name="i_agree" value="1" class="large-checkbox">
              <label for="terms" style="font-size:14px;">I agree to the <span style="color:#D10000;font-size:14px;">Terms</span> and <span style="color:#D10000;font-size:14px;">Conditions Policy</span></label>
              <br>
                <span id="termsError" style="color:#D10000;font-size:13px;"></span>
        </div>
        <!-- <a href="#forgot" class="forgot">Forgot password?</a> -->
         <div class="input_group">
        <input type="submit" class="btn" value="Signup">
      </div>

      </form>
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
      
    </script>
    <script>
    const togglePassword_client_sign = document.getElementById('togglePassword_client_sign');
    const passwordInput_client_sign = document.getElementById('password_client_sign');

    togglePassword_client_sign.addEventListener('click', function () {
      const type = passwordInput_client_sign.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput_client_sign.setAttribute('type', type);
      this.textContent = type === 'password' ? '👁️' : '🙈';
    });

    $(document).ready(function () 
    {

            $('#signup-form-client').on('submit', function (e) {

                $('#termsError').text('');

                if (!$('#terms').is(':checked')) {
                    e.preventDefault();
                    $('#termsError').text('Please accept the Terms & Conditions Policy.');
                    return false;
                }

            });

            $('#terms').on('change', function () {
                $('#termsError').text('');
            });
    });

    // ================== mobile vaildation ============================ 
    const mobileInput = document.getElementById('mobile_no');
    const mobileError = document.getElementById('mobileError');

    // Typing validation
      mobileInput.addEventListener('input', function () 
      {
        let value = this.value;

        // If alphabet or special character typed
        if (/[^0-9]/.test(value)) {
            mobileError.innerText = 'Only numbers are allowed';
            mobileError.style.display = 'block';
        } else if (value.length > 0 && value.length < 10) {
            mobileError.innerText = 'Enter valid 10 digit mobile number';
            mobileError.style.display = 'block';
        } else {
            mobileError.style.display = 'none';
        }

        // Remove non-numbers
        this.value = value.replace(/[^0-9]/g, '');

        // Limit to 10 digits
        if (this.value.length > 10) {
            this.value = this.value.slice(0, 10);
        }

        // Hide error when exactly 10 digits
        if (this.value.length === 10) {
            mobileError.style.display = 'none';
        }
      });

    // Submit validation
    function validateMobile() {
        if (mobileInput.value.length !== 10) {
            mobileError.innerText = 'Enter valid 10 digit mobile number';
            mobileError.style.display = 'block';
            mobileInput.focus();
            return false;
        }
        return true;
    }

    // ==================== email validation ======================== 

    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    // Typing validation
    emailInput.addEventListener('input', function () {
      const value = this.value;

      // Invalid characters / invalid format
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (value !== '' && !emailRegex.test(value)) {
          emailError.innerText = 'Please enter a valid email address';
          emailError.style.display = 'block';
      } else {
          emailError.style.display = 'none';
      }
    });

    // Submit validation
    function validateEmail() {
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email === '') {
            emailError.innerText = 'Email address is required';
            emailError.style.display = 'block';
            emailInput.focus();
            return false;
        }

        if (!emailRegex.test(email)) {
            emailError.innerText = 'Enter valid email address';
            emailError.style.display = 'block';
            emailInput.focus();
            return false;
        }

        return true;
    }
  </script>
</body>
</html>
