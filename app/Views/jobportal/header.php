<?php
$session = session();
// print_r($_SESSION);
use Config\Database;
$db = Database::connect();
$recruiter_type = $session->get('recruiter_user_type');
$jobseeker_type = session()->get('jobseeker_user_type');
$recruiter_full_name = session()->get('recruiter_full_name');
// $jobseekar_full_name = session()->get('jobseekar_full_name');
 $firstLetter = strtoupper(substr($recruiter_full_name, 0, 1));
$session_uid = session()->get('uid');
$builder = $db->table('tbl_jobseeker');
$jobseekar_full_name = 'Jobseeker'; // default
// ================ 08-12-2025 =====================
$tbl_user = $db->table('tbl_user');
$tbl_user_form = $tbl_user->select('*')->where('uid',$session_uid)->get()->getRow();
// echo $db->getLastQuery();

if ($tbl_user_form) {
  
    $tbl_user_login_status = $tbl_user_form->login_status;
} else {
  
    $tbl_user_login_status = null; // or set a default value
   
}

// ==========================================================
$jobseekar_form_uid   = '';
$jobseekar_full_name  = '';


if (!empty($session_uid)) {

    $builder = $db->table('tbl_jobseeker');

    $jobseekar_form = $builder
        ->select('uid, full_name')
        ->where('uid', $session_uid)
        ->get()
        ->getRow();

    
    if ($jobseekar_form) {
        $jobseekar_form_uid  = $jobseekar_form->uid;        // ✅ UID set
        $jobseekar_full_name = $jobseekar_form->full_name; // ✅ Name set
    }
}



 ?>
 <!DOCTYPE html>
<html lang="en">
  <head>
      <meta name="facebook-domain-verification" content="osfm42dkrnuj6jdb3n5y4elhuxajtw" />
 <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-E2PX97KN6Y"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-E2PX97KN6Y');
</script>
    <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png">
    <meta name="description" content="Doctor Placement Agency in India | Healthcare Recruitment Company| Adis India Placement Pvt. Ltd.spetialist doctors,super spetialist doctors,MBBS Doctor,across India">
    <meta property="og:image" content="<?php echo base_url();?>assets/jobportal/images/color_logo.png">
    <title> Doctor Placement & Healthcare Recruitment Consultancy in India </title>
    <meta charset="utf-8">
       <script async src="https://www.googletagmanager.com/gtag/js?id=GT-WPLHPVP"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'GT-WPLHPVP');
        </script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="keywords" content="" />
    <meta name="author" content="Free-Template.co" />
    <link rel="canonical" href="https://adisindiaplacement.com/">
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
   <link rel="stylesheet"
      href="<?= base_url('assets/jobportal/css/home.css') . '?v=' . time(); ?>">
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/about.css">
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/terms_service.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/all_jobs.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/contact.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/home_new5march.css">
     
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/blog.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/modal.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">-->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/traning.css">
       <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/new_custom.css">
       <!-- /*============================================25-06-2026 =========================*/ -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
        <style>
           
        .premium-home-wrap{
            background:#f8fbff;
            padding:90px 0 140px;
            position:relative;
        }

        .premium-home-container{
            width:90%;
            max-width:1300px;
            margin:auto;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:60px;
        }

        .premium-home-left{
            width:50%;
        }

        .premium-home-right{
            width:50%;
            text-align:center;
        }

        .premium-home-right img{
            width:90%;
            max-width:520px;
        }

        .premium-badge{
            display:inline-block;
            background:#e9f7ef;
            color:#0d8a4b;
            padding:8px 18px;
            border-radius:30px;
            font-weight:600;
            margin-bottom:25px;
        }

        .premium-home-title{

            font-size:52px;
            line-height:1.2;
            font-weight:800;
            color:#111;
        }

        .premium-home-title span{
            color:#d81b60;
        }

        .premium-home-desc{
            font-size:18px;
            color:#666;
            margin:25px 0;
        }
        .premium-search-section{
            margin-top:-60px;
            position:relative;
            z-index:99;
        }

        .premium-search-card{
            width:85%;
            max-width:980px;
            margin:auto;
                background: linear-gradient(135deg, #4a001f 0%, #7a1b47 55%, #ff7473 100%);
            border-radius:22px;
            padding:26px;
            box-shadow:0 20px 45px rgba(0,0,0,.18);
        }

        .premium-search-card h3{
            text-align:center;
            margin-bottom:18px;
            font-size:24px;
            font-weight:700;
        }

        .premium-search-grid{
            display:grid;
            grid-template-columns:1fr 1fr 180px;
            gap:15px;
            align-items:center;
        }

        .premium-input,
        .premium-select{
            width:100%;
            height:58px;
            border:none;
            outline:none;
            background:#fff;
            border-radius:40px;
            padding:0 22px;
            font-size:17px;
            color:#555;
            box-shadow:0 4px 12px rgba(0,0,0,.08);
        }
        .premium-input::placeholder{
            color:#777;
        }

        .premium-search-btn{
            width:100%;
            height:58px;
            border:none;
            border-radius:40px;
            background:#ffe3e3;
            color:#111;
            font-size:18px;
            font-weight:600;
            cursor:pointer;
            transition:.3s;
        }

        .premium-input,
        .premium-select{
            width:100%;
            height:58px;
            border:none;
            outline:none;
            background:#fff;
            border-radius:40px;
            padding:0 22px;
            font-size:17px;
            color:#555;
            box-shadow:0 4px 12px rgba(0,0,0,.08);
        }

        .premium-search-btn:hover{
            background:#fff;
            transform:translateY(-2px);
        }
        .bootstrap-select:not(.input-group-btn), .bootstrap-select[class*="col-"] {
            float: none;
            display: inline-block;
            margin-left: 0;
            background: #fff;
            border-radius: 30px;
        }

  
        @media (max-width:767px){

        .premium-home-wrap{
            padding:55px 0 90px;
        }

        .premium-home-container{
            flex-direction:column-reverse;
            gap:25px;
            width:92%;
        }

        .premium-home-left,
        .premium-home-right{
            width:100%;
            text-align:center;
        }

        .premium-badge{
            font-size:13px;
            padding:7px 16px;
        }

        .premium-home-title{
            font-size:30px;
            line-height:1.35;
        }

        .premium-home-desc{
            font-size:15px;
            margin:18px 0;
        }

        .premium-typing{
            font-size:20px;
        }

        .premium-home-right img{
            width:90%;
            max-width:300px;
        }

        .premium-search-section{
                margin-top:-30px;
            padding:0 15px;
        }

        .premium-search-card{
            width:94%;
             padding:10px;
            border-radius:16px;
        }

        .premium-search-card h3{
            font-size:22px;
            margin-bottom:18px;
        }

        .premium-search-grid{
            grid-template-columns:1fr;
            gap:3px;
        }

        .premium-input,
        .premium-select,
        .premium-search-btn{
            width:100%;
            height:40px;
              font-size:14px;
        border-radius:5px;
            padding:0 12px;
            margin:0;

        }

        }


      /* Extra spacing for mobile */
      @media (max-width: 576px) {
        .search-jobs-form .form-control,
        .search-jobs-form .selectpicker,
        .search-jobs-form button {
          font-size: 14px;
          padding: 10px 14px;
        }
      }
      .site-mobile-menu {
        z-index: 9999;
      }

      .site-mobile-menu a {
        position: relative;
        z-index: 10000;
      }
      .no-underline {
        text-decoration: none!important;
      }
      
       .new-badge {
             background: #0056d2;   /* Blue background */
              color: #fff;
              font-size: 10px;
              padding: 3px 7px;
              border-radius: 12px;
              margin-left: 6px;
              position: relative;
              top: -2px;
              animation: pulseBlink 1s infinite;
            }

            @keyframes pulseBlink {
              0% {
                transform: scale(1);
               box-shadow: 0 0 8px 4px rgba(0,86,210,0.4);
                opacity: 1;
              }
              50% {
                transform: scale(1.15);
                box-shadow: 0 0 8px 4px rgba(0,123,255,0.4);
                opacity: 0.8;
              }
              100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(0,123,255,0.7);
                opacity: 1;
              }
            }
            /*================= latest News===============*/
            .latest-news-blink {
                padding: 4px 12px;              /* height & width increase */
                border-radius: 20px;
                font-size: 13px;                /* font motha */
                font-weight: 700;
                color: #fff !important;
                background: linear-gradient(45deg, #ff5f6d, #ff9966);
                animation: softBlink 1.5s infinite ease-in-out;
                display: inline-block;
                line-height: 1.2;               /* proper spacing */
                box-shadow: 0 0 8px rgba(255,95,109,0.6);  /* glow effect */
            }
            
            @keyframes softBlink {
                0% { opacity: 1; }
                50% { opacity: 0.5; }
                100% { opacity: 1; }
            }
            
            .home-section {
            position: relative;
              }

              /* Section relative */
              .home-section {
                  position: relative;
              }

              /* Tagline absolute center */
              .hero-tagline {
                  position: absolute;
                  top: 45%;
                  left: 50%;
                  transform: translate(-50%, -50%);
                  width: 100%;
                  z-index: 5;
                  text-align: center;
              }

              /* ===== HERO BADGE FIXED ===== */
              .hero-badge {
                  display: inline-flex;
                  align-items: center;
                  gap: 8px;
                  padding: 8px 22px;
                  border: 2px solid #ff4f6f;
                  border-radius: 50px;
                  color: #ff4f6f;
                  font-weight: 600;
                  font-size: 15px;
                  background: rgba(255, 255, 255, 0.08);
                  backdrop-filter: blur(6px);
                  margin-bottom: 20px;   /* heading pasun gap */
              }

            .hero-badge .badge-icon {
                font-size: 14px;
            }

            /* Heading styles */
            .hero-tagline h2 {
                color: #ffffff;
                font-weight: 700;
                letter-spacing: 1px;
            }

            .fixed-main {
                color: #000;
                font-weight: 800;
                font-size: 37px !important;
                margin-bottom: 10px;
            }

            .fixed-sub {
                color: #fff;
                font-weight: 500;
                font-size: 24px;
                margin-bottom: 15px;
            }

            /* Search form shift */
            .search-jobs-form {
                margin-top: 120px;
            }

            /* Mobile View */
            @media (max-width: 768px) {

                #typing-text{
                    font-size: 14px !important;
                }

                .hero-tagline {
                    top: 38%;
                    padding: 0 15px;
                }

                .hero-badge {
                    font-size: 12px;
                    padding: 6px 15px;
                    margin-bottom: 15px;
                }

                .fixed-main {
                    font-size: 18px !important;
                    line-height: 1.2;
                }

                .fixed-sub {
                    font-size: 16px;
                    margin-bottom: 10px;
                }

                .search-jobs-form {
                    margin-top: 40px;
                }
            }
            .doctor-home-row{
            /*    min-height:580px;*/
                display:flex;
                align-items:center;
}

            .doctor-home-content{
    padding-right:40px;
}

            .doctor_home_image{
    text-align:right;
}

            .doctor-img{
    width:100%;
    max-width:620px;
    height:auto;
}

            @media(max-width:991px){

                .doctor-home-row{
                    flex-direction:column-reverse;
                    text-align:center;
                }

                .doctor_home_image{
                    text-align:center;
                    margin-bottom:30px;
                }

                .doctor-img{
                    max-width:350px;
                }
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
            <!-- Logo -->
            <div class="site-logo col-6">
              <a href="<?= base_url('/'); ?>">
                <img src="<?= base_url(); ?>assets/jobportal/images/home/logo only adis india PNG.PNG" 
                 alt="JobPortal Logo" style="height: 63px;border-radius: 4px;">
              </a>
            </div>

            <!-- Navigation -->
            <?php if (
              current_url() != base_url('recruiter/register_form') && 
              current_url() != base_url('recruiter/recruiter_posting_form') &&
              current_url() != base_url('recruiter/saveorupdate')
            ) { ?>
            <nav class="mx-auto site-navigation">
              <ul class="site-menu js-clone-nav ml-0 pl-0 d-none d-xl-block">
                <li><a href="<?= base_url('/'); ?>" class="nav-link active">Home</a></li>
                <li><a href="<?= base_url('about'); ?>">About</a></li>
                 <?php  if ($tbl_user_login_status == 'active' && $jobseekar_form_uid != '') { ?> 
                    <li><a href="<?= base_url('all_jobs'); ?>">All Jobs</a></li>
                <?php } ?>
              
                <li class="has-children" style="position:relative;">
                  <a href="#" 
                     onclick="if(window.innerWidth < 992){ 
                        event.preventDefault(); 
                        var d = this.nextElementSibling; 
                        if(d.style.display === 'block'){
                          d.style.display = 'none';
                        } else {
                          d.style.display = 'block';
                        }
                     }">
                     Our Services
                  </a>

                  <ul class="dropdown" style="padding-left:15px;">
                    <li><a href="https://adisindiaplacement.com">Web Design</a></li>
                    <li><a href="https://adisindiaplacement.com">Web Developers</a></li>
                    <li><a href="https://www.facebook.com/adisindia2021">AdisIndia Digital</a></li>
                    <li><a href="https://www.facebook.com/inspirecreativegarment/">Inspire creative garments</a></li>
                    <li><a href="https://wonderfuljodi.com/">WonderfulJodi</a></li>
                  </ul>
                </li>
                <li>
                  <a href="<?= base_url('traning-page'); ?>" style="position:relative;">
                    Training 
                    <span class="new-badge">NEW</span>
                  </a>
                </li>
                  <!-- <li><a href="<?//= base_url('gallery'); ?>">Gallery</a></li> -->
                <!--<li><a href="<?//= base_url('display-blogs'); ?>">Blog</a></li>-->
                <?php  if ($tbl_user_login_status == 'active' && $jobseekar_form_uid != '') { ?> 
                <li><a href="<?= base_url('jobseeker/resume_builder'); ?>"><span class="latest-news-blink">Build Your Resume</span></a></li>
               <?php }else{ ?>
                  <li><a href="<?= base_url('jobseeker-login?tab=signup'); ?>"><span class="latest-news-blink">Build Your Resume</span></a></li>
              <?php } ?>
                <li><a href="<?= base_url('contact_us'); ?>">Contact</a></li>

                <!-- MOBILE ONLY LOGIN/LOGOUT BUTTONS -->
                <li class="d-lg-none mt-3">
                  <?php 
                  if (
                    current_url() != base_url('recruiter/register_form') && 
                    current_url() != base_url('recruiter/recruiter_posting_form') && 
                    current_url() != base_url('jobseeker/jobseeker_form')
                  ) { ?>
                    
                    <a href="<?= base_url('jobseeker-login'); ?>" class="btn btn-primary btn-sm w-100 mb-2" style="border-radius: 20px;">Candidate Login</a>
                    <a href="<?= base_url('recruiter-login'); ?>" class="btn btn-primary btn-sm w-100" style="border-radius: 20px;">Client Login</a>
                  <?php } else {
                    $jobseeker_type = session()->get('jobseeker_user_type');
                    if ($jobseeker_type == 'jobseekar') { ?>
                      <a href="<?= base_url('jobseeker/logout_jobseeker'); ?>" class="btn btn-primary btn-sm w-100" style="border-radius: 20px;">Logout</a>
                    <?php } else { ?>
                      <a href="<?= base_url('logout'); ?>" class="btn btn-primary btn-sm w-100" style="border-radius: 20px;">Logout</a>
                    <?php } ?>
                  <?php } ?>
                </li>
              </ul>
            </nav>
            <?php } ?>

            <!-- Right side (Desktop buttons + Hamburger) -->

            <div class="right-cta-menu text-right d-flex align-items-center col-6">
                <div class="ml-auto">
                    <?php 
                    $session = session();

                    // Check if user logged in
                    if ($session->has('uid')) {
                         // echo $session->get('jobseeker_user_type');
                        // Jobseeker case
                        if ($session->get('jobseeker_user_type') === 'jobseekar') {  ?>

                    
                        <div class="dropdown mr-3">
                              <button class="btn btn-primary rounded-pill px-3 py-1 d-flex align-items-center"
                                      type="button" id="recruiterDropdown"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                      style="font-weight: 500;">
                                  <span>
                                      <?php
                                     
                                      echo !empty($jobseekar_full_name) ? $jobseekar_full_name : 'Candidate';
                                      ?>
                                  </span>
                                  <span class="ml-2 dropdown-toggle"></span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="recruiterDropdown">
                                  <?php if ($jobseekar_form && !empty($jobseekar_full_name)) : ?>
                                    <a class="dropdown-item" href="<?= base_url('jobseeker/jobseeker_profile') ?>">Dashboard</a>
                                    <a class="dropdown-item" href="<?= base_url('jobseeker/update_jobseeker_profile') ?>">Edit Profile</a>
                                  <?php else : ?>
                                  
                                        <?php if (isset($tbl_user_form->status) && $tbl_user_form->status == 'active') : ?>
                                          
                                          <a class="dropdown-item" href="<?= base_url('jobseeker/jobseeker_form') ?>">Candidate Registration1</a>

                                      <?php else : ?>

                                          <!--<a class="dropdown-item" href="<?//= base_url('jobseeker/job_login_otp_new') ?>">OTP Verify</a>-->
                                           <a class="dropdown-item" href="<?= base_url('jobseeker/job_login_otp_new') ?>" onclick="return sendOtpAjax(event, this)"> OTP Verify</a>

                                      <?php endif; ?>
                                  
                                      <!--<a class="dropdown-item" href="<?//= base_url('jobseeker/jobseeker_form') ?>">Candidate Registration</a>-->
                                  <?php endif; ?>
                                  <a class="dropdown-item" href="<?= base_url('jobseeker/logout_jobseeker'); ?>">Logout11</a>
                              </div>
                          </div>

                        <?php 
                        } 
                        // Recruiter case
                        else if ($session->get('recruiter_user_type') === 'recruiter') { 
                            $recruiter_name = $session->get('recruiter_full_name') ?? 'Client'; ?>

                          <div class="dropdown mr-3">
                              <button class="btn btn-primary rounded-pill px-3 py-1 d-flex align-items-center"
                                      type="button" id="recruiterDropdown"
                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                      style="font-weight: 500;">
                                  <span><?= $recruiter_name; ?></span>
                                  <span class="ml-2 dropdown-toggle"></span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="recruiterDropdown">
                                  <a class="dropdown-item" href="<?= base_url('recruiter/publishsavedraft') ?>">
                                      Dashboard
                                  </a>
                                  <a class="dropdown-item" href="<?= base_url('recruiter/update_recruiter_profile') ?>">
                                      Edit Profile
                                  </a>
                                  <a class="dropdown-item" href="<?= base_url('logout'); ?>">
                                      Logout
                                  </a>
                              </div>
                          </div>
                        <?php 
                        } 
                    } else { 
                        // Guest user
                        ?>
                        <?php if(current_url() != base_url('traning-page')) 
                         { ?>
                        <div class="d-none d-md-flex">
                            <a href="<?= base_url('jobseeker-login'); ?>" class="btn btn-primary btn-sm mr-2 rounded-pill">Candidate Login</a>
                            <a href="<?= base_url('recruiter-login'); ?>" class="btn btn-primary btn-sm rounded-pill">Client Login</a>
                        </div>
                        <?php }?>
                    <?php } ?>

                    <!-- Mobile Menu Toggle -->
                   
                </div>
                 <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-xl-none ml-3">
                        <span class="icon-menu h3 m-0 p-0"></span>
                    </a>
            </div>

        </div>
      </div>
    </header>
    <!-- HOME -->
            <?php
            $current = current_url();

            if (
                $current != base_url('about') &&
                $current != base_url('terms_of_service') &&
                $current != base_url('privacy') &&
                $current != base_url('all_jobs') &&
                $current != base_url('gallery') &&
                $current != base_url('display-blogs') &&
                $current != base_url('contact_us') &&
                $current != base_url('traning-page') &&
                $current != base_url('jobseeker/jobseeker_form') &&
                !str_contains($current, base_url('client/jobseeker_form_client'))
            ):
            ?>

        <section class="premium-home-wrap">

            <div class="premium-home-container">

                <div class="premium-home-left">

                   <!--  <span class="premium-badge">
                        India's #1 Healthcare Recruitment
                    </span> -->

                    <h1 class="premium-home-title">
                        Healthcare Recruitment &
                        <span>Doctor Placement Consultancy</span>
                    </h1>

                    <p class="premium-home-desc">
                        Connecting Hospitals with Qualified Doctors Across India.
                    </p>

                    <h3 class="premium-typing">
                        <span id="typing-text"></span>
                        <span class="cursor">|</span>
                    </h3>

                </div>

                <div class="premium-home-right">

                    <img src="<?= base_url('assets/jobportal/images/home/doctor _home_image.png') ?>">

                </div>

            </div>

        </section>


        <section class="premium-search-section">

            <div class="premium-search-card">

              <!--   <h3>
                    🔍 Search Healthcare Jobs
                </h3> -->

                <?php
                        if (
                            $current != base_url('recruiter/register_form') &&
                            $current != base_url('recruiter/recruiter_posting_form') &&
                            $current != base_url('recruiter/saveorupdate') &&
                            !str_contains($current, base_url('single_blog_display')) &&
                            !str_contains($current, base_url('award-details'))
                        ):
                        ?>

                        <form action="<?= base_url('search-job') ?>" method="get">

                            <div class="row">

                                <div class="col-lg-4">
                                    <input type="text"
                                           class="form-control form-control-lg"
                                           name="job_role"
                                           placeholder="🏢 Search By Job Role"
                                           style="border-radius:30px;">
                                </div>

                                <div class="col-lg-4">

                                    <select class="selectpicker"
                                            data-style="btn-white btn-lg"
                                            data-width="100%"
                                            data-live-search="true"
                                            title="📍 Select Location"
                                            name="location_id">

                                        <?php
                                        $db = Database::connect();
                                        $locations = $db->query("SELECT * FROM cities")->getResultArray();

                                        foreach($locations as $location):
                                        ?>
                                            <option value="<?= $location['id']; ?>">
                                                <?= esc($location['name']); ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="col-lg-4">

                                    <?php if($tbl_user_login_status=='active' && !empty($jobseekar_form_uid)){ ?>

                                        <button type="submit"
                                                class="btn btn-primary btn-lg w-100"
                                                style="border-radius:30px;">
                                            <span class="icon-search mr-2"></span>
                                            Search Job
                                        </button>

                                    <?php } elseif($tbl_user_login_status=='active'){ ?>

                                        <button type="button"
                                                class="btn btn-primary btn-lg w-100"
                                                style="border-radius:30px;"
                                                onclick="location.href='<?= base_url('jobseeker/jobseeker_form'); ?>'">
                                            Search Job
                                        </button>

                                    <?php } else { ?>

                                        <button type="button"
                                                class="btn btn-primary btn-lg w-100"
                                                style="border-radius:30px;"
                                                onclick="location.href='<?= base_url('jobseeker-login'); ?>'">
                                            Search Job
                                        </button>

                                    <?php } ?>

                                </div>

                            </div>

                        </form>

                        <?php endif; ?>

            </div>

        </section>
        <?php endif; ?>

        <?php if (current_url() == base_url('about')){?>
            <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/home/adis_india_new3.jpg') ?>');    min-height: 530px !important; " id="home-section">
              <div class="container">
                <div class="row">
                  <div class="col-md-7" style="margin-bottom: 51px;">
                    <h1 class="text-white font-weight-bold">About Us</h1>
                    <div class="custom-breadcrumbs">
                      <a href="<?= base_url('/') ?>">Home</a> <span class="mx-2 slash">/</span>
                      <span class="text-white"><strong>About Us</strong></span>
                    </div>
                  </div>
                </div>
              </div>
            </section>
        <?php } ?>
        <?php if (current_url() == base_url('all_jobs')){ ?>
            <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/home/adis_india_new3.jpg') ?>');
              min-height: 530px !important;" id="home-section">
                <div class="container">
                    <div class="row">
                      <div class="col-md-7" style="">
                        <h1 class="text-white font-weight-bold">All Jobs</h1>
                        <div class="custom-breadcrumbs">
                          <a href="<?= base_url('/') ?>">Home</a> <span class="mx-2 slash">/</span>
                          <span class="text-white"><strong>All Jobs</strong></span>

                        </div>
                      </div>
                    </div>
                </div>
            </section>
        <?php } ?>
      
        <?php if (current_url() == base_url('gallery')){ ?>
            <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/home/adis_india_new3.jpg') ?>');min-height: 530px !important;" id="home-section">
                <div class="container">
                  <div class="row">
                    <div class="col-md-7" style="margin-bottom: 51px;">
                      <h1 class="text-white font-weight-bold">Gallery</h1>
                      <div class="custom-breadcrumbs">
                        <a href="<?= base_url('/') ?>">Home</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong>Gallery</strong></span>

                      </div>
                    </div>
                  </div>
                </div>
            </section>
        <?php } ?>
       <?php if (current_url() == base_url('display-blogs')){ ?>
            <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/home/adis_india_new3.jpg') ?>');min-height: 530px !important;" id="home-section">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-7" style="margin-bottom: 51px;">
                        <h1 class="text-white font-weight-bold">Latest News</h1>
                        <div class="custom-breadcrumbs">
                          <a href="<?= base_url('/') ?>">Home</a> <span class="mx-2 slash">/</span>
                          <span class="text-white"><strong>Latest News</strong></span>

                        </div>
                      </div>
                    </div>
                  </div>
            </section>
        <?php } ?>
        <?php if (current_url() == base_url('contact_us')){ ?>
            <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/home/adis_india_new3.jpg') ?>');min-height: 530px !important;" id="home-section">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-7" style="margin-bottom: 51px;">
                        <h1 class="text-white font-weight-bold">Contact Us</h1>
                        <div class="custom-breadcrumbs">
                          <a href="<?= base_url('/') ?>">Home</a> <span class="mx-2 slash">/</span>
                          <span class="text-white"><strong>Contact Us</strong></span>
            
                        </div>
                      </div>
                    </div>
                  </div>
            </section>
        <?php } ?>
        <?php if (current_url() == base_url('traning-page')){ ?>
            <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/traning/adis2.jpeg') ?>');min-height: 575px !important;" id="home-section">
                <div class="container">
                  <div class="row">
                    <div class="col-md-7" style="margin-bottom: 10px;">
                      <h1 class="text-white font-weight-bold">Traning</h1>
                      <div class="custom-breadcrumbs">
                        <a href="<?= base_url('/') ?>">Home</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong>Traning</strong></span>

                      </div>
                    </div>
                  </div>
                </div>
            </section>
        <?php } ?>
      
        <?php if (current_url() == base_url('jobseeker/jobseeker_form')){ ?>
            <section class="section-hero overlay inner-page bg-image" style="background-image: url('<?= base_url('assets/jobportal/images/home/adis_india_new3.jpg') ?>');
                 min-height: 475px !important;" id="home-section">
                <div class="container">
                    <div class="row">
                      <div class="col-md-7" style="">
                        <h1 class="text-white font-weight-bold">Candidate Registration&nbsp;<i class="fa fa-hand-o-down" style="color:white; font-size:30px;"></i></h1>
                        <div class="custom-breadcrumbs">
                          <a href="<?= base_url('/') ?>">Home</a> <span class="mx-2 slash">/</span>
                          <span class="text-white"><strong>Candidate Registration</strong></span>

                        </div>
                      </div>
                    </div>
                  </div>
            </section>
        <?php } ?>
        <?php
            $current = current_url();

            if (str_contains($current, base_url('client/jobseeker_form_client/'))):
            ?>
    
            <section class="section-hero overlay inner-page bg-image"
                style="background-image: url('<?= base_url('assets/jobportal/images/home/adis_india_new3.jpg') ?>');
                       min-height: 475px !important;"
                id="home-section">
        
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <h1 class="text-white font-weight-bold">Candidate Registration&nbsp;<i class="fa fa-hand-o-down" style="color:white; font-size:30px;"></i></h1>
        
                            <div class="custom-breadcrumbs">
                                <a href="<?= base_url('/') ?>">Home</a>
                                <span class="mx-2 slash">/</span>
                                <span class="text-white"><strong>Candidate Registration</strong></span>
                            </div>
        
                        </div>
                    </div>
                </div>
        
            </section>

        <?php endif; ?>
      
    

<style>

</style>


     
    
   