<?php 
 
  $session = session();
  // print_r($_SESSION);
if ($session->has('jobseeker_user_type')) {
    // Session exists
  $db = \Config\Database::connect();
  
  $user_id = session()->get('uid');
  
    $builder = $db->table('tbl_user');

    $user = $builder->select('*')
                    ->where('uid', $user_id)
                    ->get()
                    ->getRow();


    $userType = $session->get('jobseeker_user_type');
    $jobseekerUid = $session->get('uid');

    $jobseeker = $db->table('tbl_jobseeker')
        ->select('*')
        ->where('uid', $jobseekerUid)
        ->get()
        ->getRow();
            $fullName = $jobseeker ? $jobseeker->full_name : '';
            $firstLetter = strtoupper(substr($fullName, 0, 1));
} ?>
<html lang="en">
  <head>
    <?php use Config\Database; ?>
    <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png"><title>Adis India Placement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Doctor Placement & Healthcare Recruitment Consultancy in India" />
    <meta property="og:image" content="<?php echo base_url();?>assets/jobportal/images/color_logo.png">
    <meta name="keywords" content="" />
    <meta name="author" content="Free-Template.co" />
    <link rel="shortcut icon" href="ftco-32x32.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/custom-bs.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/fonts/line-icons/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/animate.min.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/modal.css">
    <style>
      .home-section .search-jobs-form .form-control, .home-section .search-jobs-form .btn-lg {
        border-radius: 30px !important;
      }
      .filter-option-inner-inner
      {
        margin-top:4;
      }
      .custom-clear-checkbox {
    width: 1.3rem;
    height: 1.3rem;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .form-check-input {
    position: absolute;
    margin-top: 0.3rem;
    margin-left: -2.25rem;
}

  .custom-clear-checkbox:checked {
    transform: scale(1.2);
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.6);
  }

  .form-check-label {
    cursor: pointer;
    font-size: 0.9rem;
  }
  .right-cta-menu .dropdown-toggle::after {
        margin-left: 0.3rem;
      }
    </style>
    <script async src="https://www.googletagmanager.com/gtag/js?id=GT-WPLHPVP"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'GT-WPLHPVP');
</script>
  </head>
  <body id="top">
  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <div class="site-wrap">
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->


  <header class="site-navbar mt-3">
  <div class="container-fluid">
    <?php 
    if ($session->has('jobseeker_user_type'))
    { ?>

        <?php if(isset($user->status) && strtolower(trim($user->status)) == 'active') 
        { ?>

          <?php if(isset($user->login_status) && strtolower(trim($user->login_status))=='active')
          { ?>

            <div class="row align-items-center">

              <!-- Logo -->
              <div class="site-logo col-6 col-lg-3">
                <a href="<?= base_url('/'); ?>">
                  <img src="<?= base_url('assets/jobportal/images/white_logo.png'); ?>" 
                       alt="Job Portal Logo" 
                       style="height: 50px;">
                </a>
              </div>
       
              <!-- Navigation -->
                    <nav class="mx-auto site-navigation">
                        <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
                            <li><a href="<?= base_url('jobseeker/jobseeker_profile') ?>" class="nav-link active">Dashboard</a></li>
                            <li><a href="<?= base_url('jobseeker/update_jobseeker_profile') ?>" class="nav-link ">Profile</a></li>
                            <li class="has-children">
                                <a href="#">Jobs</a>
                                <ul class="dropdown">
                                  <li><a href="<?= base_url('jobseeker/jobseeker_save_jobs') ?>">Save Jobs</a></li>
                                    <li><a href="<?= base_url('jobseeker/jobseeker_applied_jobs') ?>">Applied Jobs</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>

              <!-- Right CTA Section -->
                <div class="right-cta-menu d-flex align-items-center justify-content-end col-6 col-lg-3">
                  <!-- Circle with First Alphabet -->
                  <div class="mr-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 40px; height: 40px; background-color: #f5959c; color: #fff; font-weight: bold; font-size: 18px;">
                      <?= esc($firstLetter) ?>
                    </div>
                  </div>
                  <!-- Dropdown -->
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-dark font-weight-bold" id="moreDropdown" 
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <?= $fullName; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                       <a class="dropdown-item" href="<?= base_url('jobseeker/jobseeker_profile') ?>">Dashboard12</a>
                      <a class="dropdown-item" href="<?= base_url('jobseeker/update_jobseeker_profile') ?>">Edit Profile</a>
                      <a class="dropdown-item" href="<?= base_url('logout'); ?>">Logout</a>
                    </div>
                  </div>
                       <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-lg-none ml-3">
                    <span class="icon-menu h3 m-0 p-0"></span>
                  </a>
                </div>
            </div>

            <?php
          }else{?>
            <div class="row align-items-center">
              <!-- Logo -->
              <div class="site-logo col-6 col-lg-3">
                <a href="<?= base_url('/'); ?>">
                  <img src="<?= base_url('assets/jobportal/images/white_logo.png'); ?>" 
                       alt="Job Portal Logo" 
                       style="height: 50px;">
                </a>
              </div>
              <!-- Right CTA Section -->
                <div class="right-cta-menu d-flex align-items-center justify-content-end col-6 col-lg-3">
                  <!-- Circle with First Alphabet -->
                 
                  <!-- Dropdown -->
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-dark font-weight-bold" id="moreDropdown" 
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Candidate Login
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                       
                      
                      <a class="dropdown-item" href="<?= base_url('logout'); ?>">Logout</a>
                    </div>
                  </div>
                       <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-lg-none ml-3">
                    <span class="icon-menu h3 m-0 p-0"></span>
                  </a>
                </div>
            </div>
          <?php
          } ?>
          <?php 
        }else{ ?>
            <div class="row align-items-center">

              <!-- Logo -->
              <div class="site-logo col-6 col-lg-3">
                <a href="<?= base_url('/'); ?>">
                  <img src="<?= base_url('assets/jobportal/images/white_logo.png'); ?>" 
                       alt="Job Portal Logo" 
                       style="height: 50px;">
                </a>
              </div>
       
            

              <!-- Right CTA Section -->
                <div class="right-cta-menu d-flex align-items-center justify-content-end col-6 col-lg-3">
                  <!-- Circle with First Alphabet -->
                 
                  <!-- Dropdown -->
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-dark font-weight-bold" id="moreDropdown" 
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Candidate Login
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                       <a class="dropdown-item" href="<?= base_url('jobseeker/job_login_otp_new') ?>" onclick="return sendOtpAjax(event, this)"> OTP Verify</a>

                      
                      <a class="dropdown-item" href="<?= base_url('logout'); ?>">Logout</a>
                    </div>
                  </div>
                       <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-lg-none ml-3">
                    <span class="icon-menu h3 m-0 p-0"></span>
                  </a>
                </div>
            </div>
        <?php
        } ?>
        

      <!-- Mobile Menu Collapse -->
       <!-- Mobile Menu Toggle -->
     
      <?php
    }else { ?>
      <div class="row align-items-center">
          <div class="site-logo col-6"><a href="<?= base_url('/')?>">
         
           <img src="<?php echo base_url(); ?>assets/jobportal/images/white_logo.png" alt="Free Website Template by Free-Template.co" style="height: 50px;">
          </a></div>
          
          <div class="right-cta-menu text-right d-flex aligin-items-center col-6">
            <div class="ml-auto">
               

                <a href="<?= base_url('jobseeker-login'); ?>" class="btn btn-primary border-width-2 d-none d-lg-inline-block" style="border-radius: 20px;"><span class="mr-2 icon-lock_outline"></span>JobSeeker Login</a>&nbsp;
                
            </div>
            <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-xl-none mt-lg-2 ml-3"><span class="icon-menu h3 m-0 p-0 mt-2"></span></a>
          </div>

        </div>
    <?php
    } ?>

  </div>

</header>


    <!-- HOME -->
    <section class="home-section section-hero overlay bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/office_logo.jpg') ?>'); min-height: 515px!important;height: 15vh;" id="home-section">
      <div class="container">
       <div class="row align-items-center justify-content-center">
  <div class="col-md-12" style="margin-bottom: 160px;">
    <div class="mb-5 text-center"></div>
    <?php if (
      current_url() != base_url('recruiter/register_form') &&
      current_url() != base_url('recruiter/recruiter_posting_form') &&
      current_url() != base_url('jobseeker/jobseeker_form')
    ): ?>
    <form action="<?= base_url('search-job') ?>" method="get" class="search-jobs-form">
      <div class="row mb-5">

        <!-- Job Role -->
        <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
          <input type="text" 
                 class="form-control form-control-lg zoom-input" 
                 name="job_role" 
                 placeholder="🏠 Search By Job Role"
                 style="border-radius: 30px;"
                 value="<?= esc($jobRole ?? '') ?>">
        </div>

        <!-- Location -->
        <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0 location-dropdown">
          <select class="selectpicker"
                  data-style="btn-white btn-lg zoom-select"
                  data-width="100%"
                  data-live-search="true"
                  data-container="body"
                  title="📍 Select Location"
                  name="location_id">
            <?php 
            $db = Database::connect();
            $query = $db->query("SELECT * FROM cities");
            $locations = $query->getResultArray();
            foreach ($locations as $location): ?>
              <option value="<?= esc($location['id']) ?>"
                <?= (isset($locationId) && $locationId == $location['id']) ? 'selected' : '' ?>>
                <?= esc($location['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Employment Type -->
     <!--    <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
          <select class="selectpicker" 
                  data-style="btn-white btn-lg zoom-select" 
                  data-width="100%" 
                  data-live-search="true" 
                  title="💼 Experience" 
                  name="employment_type">
            <option value="Part Time" <?//= (isset($employmentType) && $employmentType == 'Part Time') ? 'selected' : '' ?>>Part Time</option>
            <option value="Full Time" <?//= (isset($employmentType) && $employmentType == 'Full Time') ? 'selected' : '' ?>>Full Time</option>
          </select>
        </div> -->

        <!-- Search + Clear -->
        <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0 d-flex align-items-center">
          <div class="form-check d-flex align-items-center">
            <input class="form-check-input custom-clear-checkbox" type="checkbox" id="clearForm">
            <!-- <label class="form-check-label ms-1 small" for="clearForm">Clear</label> -->
          </div>
          <!-- Search Button -->
          <button type="submit" 
                  class="btn btn-primary btn-lg border-width-2 me-3 flex-fill" 
                  style="border-radius: 30px;">
            <span class="icon-search icon mr-2"></span>Search Job
          </button>

          <!-- Clear Checkbox -->
          
        </div>

      </div>
    </form>
    <?php endif; ?>
  </div>
</div>
      </div>

      <a href="#next" class="scroll-button smoothscroll" style="left: 95%;">
        <span class=" icon-keyboard_arrow_down"></span>
      </a>

    </section>
  </div>
    
   