<?php
  
      $session = session();
      $user_id = $session->get('uid');
      $email = session()->get('jobseeker_email');

      use Config\Database;
      $db = Database::connect();

      $builder = $db->table('tbl_jobseeker');
      $jobseeker_form = $builder
    ->where('uid', $user_id)
    ->get()
    ->getRowArray();

    $candidate_name= $jobseeker_form['full_name'];
  

    $firstLetter = strtoupper(substr($candidate_name, 0, 1));
    // $area_name = $recruiter_form['area_name'];

    $c_id = $jobseeker_form['current_city'];
    $mobile_number = $jobseeker_form['mobile_number'];


 $city = $db->table('cities');

$cityName = $city
    ->where('id', $c_id)
    ->get()
    ->getRowArray();

$city_name = $cityName['name'] ?? "";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta name="facebook-domain-verification" content="osfm42dkrnuj6jdb3n5y4elhuxajtw" />
    <style>
      .section-hero.overlay:before,
      .section-hero.overlay-2:before {
                                        background: none !important; /* Removes image or color */
                                      }
      .right-cta-menu .dropdown-toggle::after {
        margin-left: 0.3rem;
      }

      .font
      {
        font-size: medium !important;
        /*    font-weight: 300;*/
        font-style: normal !important;
      }

      .block__871541 {
      position: relative !important;
      background: #f8f9fa !important;
      padding: 8px !important;
      margin-bottom: 2rem !important;
      border-radius: 32px !important;
    }

    .logo-square {
      border-radius: 72px !important;
    }


    </style>
     
    <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png">
       <title>Doctor Placement & Healthcare Recruitment Consultancy in India</title>
          <meta name="description" content="Doctor Placement Agency in India | Healthcare Recruitment Company| Adis India Placement Pvt.Ltd.spetialist doctors,super spetialist doctors,MBBS Doctor,across India">
          <meta property="og:image" content="<?php echo base_url();?>assets/jobportal/images/color_logo.png">
    <meta charset="utf-8">
     <script async src="https://www.googletagmanager.com/gtag/js?id=GT-WPLHPVP"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'GT-WPLHPVP');
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/custom-bs.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/fonts/line-icons/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/quill.snow.css">
    <link rel="canonical" href="https://adisindiaplacement.com/">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/style.css">  
    <link rel="stylesheet" href="<?= base_url('assets/jobportal/css/custom.css') . '?v=' . filemtime(FCPATH . 'assets/jobportal/css/custom.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/modal.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/common.css">
  
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
         
          <div class="site-logo col-6"><a href="<?= base_url('/'); ?>"><img src="<?php echo base_url(); ?>assets/jobportal/images/white_logo.png" alt="Free Website Template by Free-Template.co" style="height: 50px;"></a></div>
         <?php
              $uri = uri_string(); // gets path only, e.g. "jobseeker/jobseeker_recruiter_profile/5"
              if (
              $uri !== 'jobseeker/update_jobseeker_profile' &&
              $uri !== 'jobseeker/jobseeker_profile' &&
              $uri !== 'jobseeker/jobseeker_save_jobs' &&
              $uri !== 'jobseeker/resume_builder' &&
              $uri !== 'jobseeker/jobseeker_applied_jobs' &&
              $uri !== 'jobseeker/jobseeker_form' &&
              strpos($uri,'jobseeker/jobseeker_recruiter_profile') !== 0 &&
              strpos($uri,'client/jobseeker_view_profile') !== 0
            ) 
              {
              ?>
                  <nav class="mx-auto site-navigation">
                      <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
                          <li><a href="<?= base_url('jobseeker/jobseeker_profilex') ?>" class="nav-link active">Dashboard</a></li>
                          <li><a href="<?= base_url('recruiter/recruiter_posting_form') ?>">Post Job</a></li>
                          <li class="has-children">
                              <a href="#">More</a>
                              <ul class="dropdown">
                                  <li><a href="<?= base_url('recruiter/savedraft') ?>">Save Draft</a></li>
                                  <li><a href="<?= base_url('recruiter/publish') ?>">Publish</a></li>
                              </ul>
                          </li>
                      </ul>
                  </nav>
              <?php
              }
              ?>

              <?php
              if($uri == 'jobseeker/jobseeker_profile' || $uri == 'jobseeker/update_jobseeker_profile' || $uri == 'jobseeker/jobseeker_save_jobs' || $uri == 'jobseeker/resume_builder' || $uri == 'jobseeker/jobseeker_applied_jobs')
              { ?>
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
                          <li>
                              <a href="<?= base_url('jobseeker/resume_builder') ?>">Resume Builder</a>
                          </li>
                      </ul>
                  </nav>

              <?php
              }
          ?>
          <?php
          if($uri == 'jobseeker/jobseeker_profile' || $uri == 'jobseeker/update_jobseeker_profile' || $uri == 'jobseeker/jobseeker_save_jobs' || $uri == 'jobseeker/resume_builder' || $uri == 'jobseeker/jobseeker_applied_jobs' || strpos($uri,'client/jobseeker_view_profile')==0)
          { ?>
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
              <?= $candidate_name; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="<?= base_url('jobseeker/jobseeker_profile') ?>">Dashboard</a>
              <a class="dropdown-item" href="<?= base_url('jobseeker/update_jobseeker_profile') ?>">Edit Profile</a>
              <a class="dropdown-item" href="<?= base_url('jobseeker/logout_jobseeker'); ?>">Logout</a>
            </div>
          </div>

          <!-- Mobile Menu Toggle -->
          <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-lg-none ml-3">
            <span class="icon-menu h3 m-0 p-0"></span>
          </a>
        </div>
           <?php
        }
          ?>



        </div>
      </div>
    </header>

    <!-- HOME -->
        <?php  
        // $uri = uri_string();
        // if ($uri != base_url('jobseeker/update_jobseeker_profile') && strpos($uri,'jobseeker/jobseeker_recruiter_profile') !== 0)
        //     { 

        if ($uri != 'jobseeker/update_jobseeker_profile' 
        && strpos($uri, 'jobseeker/jobseeker_recruiter_profile') !== 0
        && strpos($uri, 'client/jobseeker_view_profile') !== 0) { 
              ?>
          <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/Adis_India_BG.jpg') ?>');" id="home-section">
              <div class="container" style="margin-top: 100px;">
                  <div class="col-lg-12 mb-4">
                    <div class="block__871541 bg-primary d-flex align-items-center">
                      <div class="logo-square mr-3">
                          <?= esc($firstLetter) ?>  
                      </div> 
                      <div class="text-white">
                          <p class="mb-1 font-weight-bold font" > <?= esc($candidate_name) ?></p>
                          <p class="mb-0 font"><i class="bi bi-geo-alt-fill fs-3"></i> <span style="font-style: normal;"><?= esc($city_name) ?></span> &nbsp;&nbsp;&nbsp;&nbsp;<i class="bi bi-envelope-fill fs-3"></i> <?= esc($email) ?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="bi bi-telephone-fill fs-3"> <?= esc($mobile_number) ?></i></p>

                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12 mb-4">
                      <div class="block__871541 bg-primary p-4">
                          <div class="row align-items-center">
                            <?php $progress=70; ?>
                              <div class="col-lg-7">
                                <div class="progress" style="height: 22px; border-radius: 12px;">
                                  <div class="progress-bar bg-success text-white fw-bold"
                                       role="progressbar"
                                       style="width: <?= $progress ?>%;"
                                       aria-valuenow="<?= $progress ?>"
                                       aria-valuemin="0" aria-valuemax="100">
                                    <?= $progress ?>% Completed
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-2">
                                  <span class="text-white text-bold">Profile strength</span>
                              </div>
                              <!-- ✅ Update Profile Button -->
                              <div class="col-lg-3 text-end">
                                <blockquote class="m-0">
                                   <a href="<?= base_url('jobseeker/update_jobseeker_profile'); ?>" class="btn btn-light text-dark font-weight-bold btn-sm"
                                          style="font-size: 13px; padding: 4px 10px; border-radius: 10px;"> Update Profile </a>
                                  <!-- <button type="submit" 
                                          class="btn btn-light text-dark font-weight-bold btn-sm"
                                          style="font-size: 13px; padding: 4px 10px; border-radius: 10px;">
                                    Update Profile
                                  </button> -->
                                </blockquote>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
      
    
        </section>
          <?php  
            } ?>
   
      