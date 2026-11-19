<?php 
  $session = session();
  $db = \Config\Database::connect();
  $uid = $session->get('uid');  
  $jobseeker = $db->table('tbl_jobseeker')
    ->select('full_name')
    ->where('uid', $uid)
    ->get()
    ->getRow();
        $fullName = $jobseeker ? $jobseeker->full_name : ''; 
 $firstLetter = strtoupper(substr($fullName, 0, 1));
            ?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <title> Doctor Placement & Healthcare Recruitment Consultancy  </title>
   <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-E2PX97KN6Y"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-E2PX97KN6Y');
</script>
    <?php use Config\Database; ?>
    <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png"><title>Adis India Placement</title>
    <meta name="description" content="Doctor Placement Agency in India | Healthcare Recruitment Company| Adis India Placement Pvt. Ltd.spetialist doctors,super spetialist doctors,MBBS Doctor,across India">
    <meta property="og:image" content="<?php echo base_url();?>assets/jobportal/images/color_logo.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="keywords" content="Doctor Placement & Healthcare Recruitment Consultancy in India" />
    <meta name="author" content="Free-Template.co" />
    <link rel="shortcut icon" href="ftco-32x32.png">
    <link rel="canonical" href="https://adisdoctorplacement.com/">
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
    </style>
    
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

    <!-- NAVBAR -->
    <header class="site-navbar mt-3">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="site-logo col-6"><a href="<?= base_url('/'); ?>"><img src="<?php echo base_url(); ?>assets/jobportal/images/white_logo.png" alt="Free Website Template by Free-Template.co" style="height: 50px;"></a>
          </div>
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
          <div class="right-cta-menu d-flex align-items-center justify-content-end col-6 col-lg-3">
                <!-- Circle with Initial -->
                <div class="mr-2">
                  <div class="rounded-circle d-flex align-items-center justify-content-center"
                       style="width: 40px; height: 40px; background-color: #f5959c; color: #fff; font-weight: bold; font-size: 18px;">
                    <?= esc($firstLetter) ?>
                  </div>
                </div>
                <!-- Candidate Dropdown -->
                <div class="dropdown">
                  <a href="#" class="dropdown-toggle text-dark font-weight-bold" id="moreDropdown" 
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $fullName; ?>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="<?= base_url('jobseeker/update_jobseeker_profile') ?>">Edit Profile</a>
                    <a class="dropdown-item" href="<?= base_url('logout'); ?>">Logout</a>
                  </div>
                </div>
                <!-- Mobile Menu Toggle -->
                <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-lg-none ml-3">
                  <span class="icon-menu h3 m-0 p-0"></span>
                </a>
          </div>
        </div>
      </div>
    </header>



    <!-- HOME -->
    <section class="home-section section-hero overlay bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/office_logo.jpg') ?>'); min-height: 515px!important;height: 15vh;" id="home-section">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-12" style="margin-bottom: 160px;">
            <div class="mb-5 text-center">

            </div>
            <?php
              
             if (current_url() != base_url('recruiter/register_form') && current_url() != base_url('recruiter/recruiter_posting_form') && current_url() != base_url('jobseeker/jobseeker_form')): ?>
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
        <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
          <select class="selectpicker" 
                  data-style="btn-white btn-lg zoom-select" 
                  data-width="100%" 
                  data-live-search="true" 
                  title="💼 Experience" 
                  name="employment_type">
            <option value="Part Time" <?= (isset($employmentType) && $employmentType == 'Part Time') ? 'selected' : '' ?>>Part Time</option>
            <option value="Full Time" <?= (isset($employmentType) && $employmentType == 'Full Time') ? 'selected' : '' ?>>Full Time</option>
          </select>
        </div>

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
    
   