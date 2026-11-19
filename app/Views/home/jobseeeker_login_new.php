<!-- Username: "apikey" (case-sensitive). 
Password: configure SENDGRID_API_KEY in the local .env file.
Host: smtp.sendgrid.net. 
Port: 587 (TLS) or 465 (SSL). -->
<?php 
use Config\Database;
$db = Database::connect();
  $job_role = $db->query("SELECT * FROM tbl_job_role")->getResultArray(); 
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png">
    <!-- <link rel="stylesheet" href="<?php //echo base_url(); ?>assets/jobportal/css/bootstrap-select.min.css"> -->
    <title>Adis India Placement</title>
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
.large-checkbox {
    transform: scale(1.4);   /* 1.4x मोठा */
    margin-right: 8px;
    cursor: pointer;
}
    </style>
  </head>
  <body style="background-image: url('<?= base_url(); ?>assets/jobportal/images/6.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center; background-attachment: fixed;">

     <section class="main">
      <?php
        // $activeTab = session()->getFlashdata('activeTab') ?? 'login';
      $activeTab = session()->getFlashdata('activeTab')  
             ?? $_GET['tab'] 
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
          <form id="login-form" method="post" action="<?= base_url('jobseeker/jobseeker_new_login') ?>" class="form_field login_form" style="display: <?= $activeTab == 'login' ? 'block' : 'none' ?>;">
            <h3>Candidate Login Form</h3>
            <div class="input_group">
              <input type="email" name="email" id="email_new" class="input" placeholder="Email Address" required>
              <span id="emailError_new" style="color:red; font-size:13px; display:none;"></span>
            </div>
            <div class="input_group">
              <input type="password"  id="password" name="password" class="input" placeholder="Password" required>
              <span id="togglePassword" class="toggle-eye">👁️</span>
            </div>
            <a href="<?= base_url('jobseeker/forgot_password'); ?>" class="forgot">Forgot password?</a>
            <input type="submit" class="btn" value="Login">
            <div class="text-center mt-3">
                    <div id="g_id_onload"
                         data-client_id="220230990399-n11icg5m3228fqe9g4j2vpq4q0d70tbh.apps.googleusercontent.com" data-callback="handleCredentialResponse">
                    </div>

                    <div class="g_id_signin"
                         data-type="standard"
                         data-size="large"
                         data-theme="outline"
                         data-text="signup_with"
                         data-shape="rectangular"
                         data-width="350">
                    </div>
            </div>
          </form>

          <?php 
            $otp_str = str_shuffle("0123456789");
            $otp = substr($otp_str, 0, 5);
            $act_str = rand(100000, 10000000);
            $activation_code = str_shuffle("abcdefghijklmno" . $act_str);
          ?>

          <form id="signup-form" method="post" class="form_field signup_form" action="<?= base_url('jobseeker/new_Saveloginform') ?>" style="display: <?= $activeTab == 'signup' ? 'block' : 'none' ?>;">
            <input type="hidden" name="user_type" value="jobseekar">
            <input type="hidden" name="otp" value="<?= $otp; ?>">
            <input type="hidden" name="activation_code" value="<?= $activation_code; ?>">

            <h3>Candidate Signup Form1

            </h3>
            <div class="input_group">
               <input type="text" name="full_name" id="full_name"  class="input" placeholder="Full Name" required>
             </div>
             <div class="input_group">
              <input type="email" name="email" id="email"  class="input" placeholder="Email Address" required>
              <span id="emailError" style="color:red; font-size:13px; display:none;"></span>
            </div>
            <div class="input_group">
              <input type="password" id="password_sign" name="password" class="input" placeholder="Password" required>
              <span id="togglePassword_sign" class="toggle-eye">👁️</span>
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
                      <option value="<?= esc($role['job_id']) ?>"><?= esc($role['job_role']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input_group">
              <input type="checkbox" id="terms" name="i_agree" value="1" class="large-checkbox">
              <label for="terms" style="font-size:14px;">I agree to the <span style="color:#D10000;font-size:14px;">Terms</span> and <span style="color:#D10000;font-size:14px;">Conditions Policy</span></label>
              <br>
                <span id="termsError" style="color:#D10000;font-size:13px;"></span>
            </div>
            <input type="submit" class="btn" value="Signup"><br><br><br>
            <div class="text-center mt-3">
                    <div id="g_id_onload"
                         data-client_id="220230990399-n11icg5m3228fqe9g4j2vpq4q0d70tbh.apps.googleusercontent.com" data-callback="handleCredentialResponse">
                    </div>

                    <div class="g_id_signin"
                         data-type="standard"
                         data-size="large"
                         data-theme="outline"
                         data-text="signup_with"
                         data-shape="rectangular"
                         data-width="350">
                    </div>
                </div>
          </form>
        </div>
      </div>
    </section>
<script src="<?php echo base_url(); ?>assets/jobportal/js/bootstrap-select.min.js"></script>
<script src="<?= base_url('assets/jobportal/js/mobile-email-validation.js') ?>?v=<?= time() ?>"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>

    <script>
function handleCredentialResponse(response)
{
    $.ajax({
        url: "<?= base_url('google-login') ?>",
        type: "POST",
        dataType: "json",
        data: {
            credential: response.credential
        },
        success: function(res)
        {
            console.log(res);

            if(res.status == 1)
            {
                window.location.href = res.redirect;
            }
        },
        error:function(xhr)
        {
            console.log(xhr.responseText);
        }
    });
}
</script>
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
   
$(document).ready(function () {
    $('.selectpicker').selectpicker();
});



$(document).ready(function () {

    $('#signup-form').on('submit', function (e) {
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

</script>






     
  </body>
</html>