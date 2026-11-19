<!DOCTYPE html>
<html lang="en">
  <head>
      <title> Doctor Placement & Healthcare Consultancy in India </title>
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
      .section-hero, .section-hero > .container > .row {
       height: 500px !important;
       min-height: 0px !important;
      }
      /* Mobile adjustments without changing hero fixed height */
@media (max-width: 900.98px) {

    /* Flex wrap for company block */
    .section-hero .d-flex.flex-wrap {
        flex-direction: row !important;
        flex-wrap: wrap !important;
    }

    .section-hero .logo-square {
        width: 50px !important;
        height: 50px !important;
        font-size: 20px !important;
        margin-bottom: 0.5rem !important;
    }

    /* Profile strength stacking */
    .section-hero .row.align-items-center.flex-wrap > div {
        margin-bottom: 0.5rem !important;
        text-align: left !important;
    }

    /* Button full width on mobile */
    .section-hero .btn.w-100 {
        width: 100% !important;
    }

    /* Adjust scroll button */
    .scroll-button {
        left: 90% !important;
    }
}
    </style>
    <?php
          $session = session();
          $user_id = $session->get('uid');

          use Config\Database;
          $db = Database::connect();

          $builder = $db->table('tbl_recruiter');
          $recruiter_form = $builder
        ->where('uid', $user_id)
        ->get()
        ->getRowArray();

        $recruiter_name= $recruiter_form['recruiter_name'];
        $company_name= $recruiter_form['company_display_name'];

        $firstLetter = strtoupper(substr($recruiter_name, 0, 1));
        $area_name = $recruiter_form['area_name'];

        $c_id = $recruiter_form['city_id'];
      $city = $db->table('cities');
        $cityName = $city
        ->where('id',$c_id)
        ->get()
        ->getRowArray();

        $city_name = $cityName['name'];
    ?>
    <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png"><title>Adis India Placement</title>
  
    <meta charset="utf-8">
      <script async src="https://www.googletagmanager.com/gtag/js?id=GT-WPLHPVP"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'GT-WPLHPVP');
        </script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="description" content="Doctor Placement Agency in India | Healthcare Recruitment Company| Adis India Placement Pvt. Ltd.spetialist doctors,super spetialist doctors,MBBS Doctor,across India">
    
    
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/custom.css">
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
            <!-- Logo -->
            <div class="site-logo col-6">
              <a href="<?= base_url('/'); ?>">
                <img src="<?= base_url(); ?>assets/jobportal/images/home/newlogo.jpeg" 
                 alt="JobPortal Logo" style="height: 63px;border-radius: 4px;">
              </a>
            </div>

            <!-- Navigation -->
             <nav class="mx-auto site-navigation">
                        <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
                            <li><a href="<?= base_url('recruiter/publishsavedraft'); ?>" class="nav-link active">Dashboard</a></li>
                            <li><a href="<?= base_url('recruiter/recruiter_posting_form'); ?>">Post Job</a></li>
                            <li class="has-children">
                                <a href="#">More</a>
                                <ul class="dropdown">
                                    <li><a href="<?= base_url('recruiter/savedraft_page'); ?>">Save Draft</a></li>
                                    <li><a href="<?= base_url('recruiter/publish_page'); ?>">Publish</a></li>
                                    <li><a href="<?= base_url('recruiter/preview'); ?>">Preview</a></li>
                                </ul>
                            </li>
                        </ul>
            </nav>
          

            <!-- Right side (Desktop buttons + Hamburger) -->

            <div class="right-cta-menu text-right d-flex align-items-center col-6">
                <div class="ml-auto">
                    <?php 
                    $session = session();

                    // Check if user logged in
                    if ($session->has('uid')) {

                   
                        // Recruiter case
                        if ($session->get('recruiter_user_type') === 'recruiter') { 
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
                    } ?>

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
    <!-- Only show Hero section on specific pages -->
<?php if (
    current_url() != base_url('recruiter/save_recruiter_posting') &&
    current_url() != base_url('recruiter/update_recruiter_profile')
): ?>

<section class="section-hero overlay bg-image" 
         style="background-image: url('<?= base_url('assets/jobportal/images/Adis_India_BG.jpg') ?>');"
         id="home-section">

    <div class="container">
        <div class="row align-items-center justify-content-center py-4">
            <div class="col-12 col-lg-10">

                <!-- Company Block -->
                <div class="mb-4">
                    <div class="d-flex align-items-center p-3 bg-primary rounded shadow-sm">
                        <div class="logo-square d-flex align-items-center justify-content-center mr-3" 
                             style="width: 60px; height: 60px; border-radius: 50%; background: #fff; color: #F5959C; font-weight: bold; font-size: 24px;">
                            <?= esc($firstLetter) ?>
                        </div>
                        <div class="text-white">
                            <p class="mb-1 font-weight-bold" style="font-size: 1.1rem;"><?= ucwords(esc($company_name ?? '')) ?></p>
                            <p class="mb-0" style="font-size: 0.9rem;">
                                <i class="bi bi-geo-alt-fill"></i> <?= ucwords(esc($area_name ?? '')) ?>, <?= ucwords(esc($city_name ?? '')) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Profile Strength Block -->
                <div class="mb-4">
                    <div class="p-3 bg-primary rounded shadow-sm">
                        <div class="row align-items-center">
                            <?php $progress = 70; ?>
                            <div class="col-md-7 mb-2 mb-md-0">
                                <div class="progress" style="height: 22px; border-radius: 12px;">
                                    <div class="progress-bar bg-success text-white fw-bold" role="progressbar"
                                         style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?= $progress ?>% Completed
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-white mb-2 mb-md-0">
                                Profile strength
                            </div>
                            <div class="col-md-3 text-md-end">
                                <a href="<?= base_url('recruiter/update_recruiter_profile'); ?>" 
                                   class="btn btn-light text-dark btn-sm font-weight-bold"
                                   style="font-size: 13px; padding: 4px 10px; border-radius: 10px;">
                                   Update Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

   

</section>
<?php endif; ?>

  
