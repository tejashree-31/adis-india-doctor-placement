
<!doctype html>
<html lang="en">
  <head>
    <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png"><title>Adis India Placement</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/recr_login_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style type="text/css">
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
    </style>
  </head>
  <body>

     <section class="main">
      <?php
        // $activeTab = session()->getFlashdata('activeTab') ?? 'login';
      $activeTab = session()->getFlashdata('activeTab') 
             ?? $_GET['activeTab'] 
             ?? 'login';
        $error = session()->getFlashdata('error');
        $message = session()->getFlashdata('message');
      ?>
      <div class="form_wrapper">
        <div class="home_icon">
          <a href="<?= base_url('/'); ?>" class="home_icon">
            <i class="fas fa-home"></i>
          </a>
        </div>

        <input type="radio" class="radio" name="radio" id="login" <?= $activeTab === 'login' ? 'checked' : '' ?>>
        <input type="radio" class="radio" name="radio" id="signup" <?= $activeTab === 'signup' ? 'checked' : '' ?>>

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

        <div class="tabs">
          <label for="login" class="tab login_tab <?= $activeTab == 'login' ? 'active' : '' ?>" onclick="showTab('login')">Login</label>
          <label for="signup" class="tab signup_tab <?= $activeTab == 'signup' ? 'active' : '' ?>" onclick="showTab('signup')">Signup</label>
          <div class="shape"></div>
        </div>

        <div class="form_wrap">
          <form id="login-form" method="post" action="<?= base_url('recruiterlogin') ?>" class="form_field login_form" style="display: <?= $activeTab == 'login' ? 'block' : 'none' ?>;">
            <h3>Login Form</h3>
            <div class="input_group">
              <input type="email" name="email" class="input" placeholder="Email Address" required>
            </div>
            <div class="input_group">
              <input type="password"  id="password" name="password" class="input" placeholder="Password" required>
              <span id="togglePassword" class="toggle-eye">👁️</span>
            </div>
            <a href="<?= base_url('recruiter/forgot_password'); ?>" class="forgot">Forgot password?</a>
            <input type="submit" class="btn" value="Submit">
          </form>

          <?php 
            $otp_str = str_shuffle("0123456789");
            $otp = substr($otp_str, 0, 5);
            $act_str = rand(100000, 10000000);
            $activation_code = str_shuffle("abcdefghijklmno" . $act_str);
          ?>

          <form id="signup-form" method="post" class="form_field signup_form" action="<?= base_url('recruiter-sign-up') ?>" style="display: <?= $activeTab == 'signup' ? 'block' : 'none' ?>;">
            <input type="hidden" name="user_type" value="recruiter">
            <input type="hidden" name="otp" value="<?= $otp; ?>">
            <input type="hidden" name="activation_code" value="<?= $activation_code; ?>">

            <h3>Signup Form </h3>
            <div class="input_group">
               <input type="text" name="full_name" id="full_name"  class="input" placeholder="Full Name" required>
             </div>
            <div class="input_group">
              <input type="email" name="email" id="email" class="input" placeholder="Email Address" required>
                <span id="emailError" style="color:red; font-size:13px; display:none;"></span>
            </div>
         <div class="input_group">
              <input type="password" id="password_sign" name="password" class="input" placeholder="Password" required>
              <span id="togglePassword_sign" class="toggle-eye">👁️</span>
            </div>
            <div class="input_group">
              <input type="text" name="mobile_no" class="input" id="mobile_no" placeholder="Mobile Number" required>
                <small id="mobileError" style="color:red; display:none;">
                Enter valid 10 digit mobile number
              </small>
            </div>
            <div class="input_group">
              <input type="checkbox" id="terms" name="i_agree" value="1" class="large-checkbox">
              <label for="terms" style="font-size:14px;">I agree to the <span style="color:#D10000;font-size:14px;">Terms</span> and <span style="color:#D10000;font-size:14px;">Conditions Policy</span></label>
              <br>
                <span id="termsError" style="color:#D10000;font-size:13px;"></span>
            </div>
            <div class="input_group">
            <input type="submit" class="btn btn-primary" value="Signup">
            </div>
          </form>
        </div>
      </div>
    </section>

    <script>
      window.onload = function () {
          const activeTab = '<?= $activeTab ?>';
          showTab(activeTab);
      };

      function showTab(tab) {
          document.querySelector('.login_tab').classList.remove('active');
          document.querySelector('.signup_tab').classList.remove('active');

          document.querySelector('.login_form').style.display = 'none';
          document.querySelector('.signup_form').style.display = 'none';

          if (tab === 'login') {
              document.querySelector('.login_tab').classList.add('active');
              document.querySelector('.login_form').style.display = 'block';
          } else {
              document.querySelector('.signup_tab').classList.add('active');
              document.querySelector('.signup_form').style.display = 'block';
          }
      }
    </script>
    <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.textContent = type === 'password' ? '👁️' : '🙈';
    });
  </script>
    <script>
  const togglePassword_sign = document.getElementById('togglePassword_sign');
  const passwordInput_sign = document.getElementById('password_sign');

  togglePassword_sign.addEventListener('click', function () {
    const type = passwordInput_sign.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput_sign.setAttribute('type', type);
    this.textContent = type === 'password' ? '👁️' : '🙈';
  });
</script>

<script>
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

<script>
const mobileInput = document.getElementById('mobile_no');
const mobileError = document.getElementById('mobileError');

// Typing validation
mobileInput.addEventListener('input', function () {
    const value = this.value;

    // If alphabet or special character typed
    if (/[^0-9]/.test(value)) {
        mobileError.innerText = 'Only numbers are allowed';
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


// $(document).ready(function () {

//     $('#signup-form').on('submit', function (e) {
//         $('#termsError').text('');
//         if (!$('#terms').is(':checked')) {
//             e.preventDefault();
//             $('#termsError').text('Please accept the Terms & Conditions Policy.');
//             return false;
//         }
//     });
//     $('#terms').on('change', function () {
//         $('#termsError').text('');
//     });

    

// });
</script>


     
  </body>
</html>