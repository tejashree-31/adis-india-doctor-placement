<?php 
$applied_posting_id = session()->get('applied_posting_id');
$applied_job_id     = session()->get('applied_job_id');
?>
<section class="py-5 bg-image overlay-primary fixed overlay" id="next" style="background:#FFF;">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-2">Top Hospitals Hiring Now</h2>
      </div>
    </div>

    <!-- LTR Carousel -->
    <div class="row pb-4">
      <div class="owl-carousel custom-carousel owl-theme carousel-ltr">
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 1.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 2.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 3.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 4.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 5.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 6.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 7.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 8.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 9.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 10.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 11.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 12.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 13.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 14.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 16.png" alt="Logo"></div>
        <div class="item"><img src="<?= base_url(); ?>assets/jobportal/images/client/logo 17.png" alt="Logo"></div>
      </div>
    </div>
  </div>
</section>

<!-- Latest Openings -->
<section class="site-section services-section bg-light block__62849" id="next-section" style="padding: 2rem 0;">
  <div class="container">
    <div class="row mb-4 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-2">Latest Opening</h2>
      </div>
    </div>
    <div class="row">
      <?php if (!empty($latestJobquery)): ?>
    <?php foreach ($latestJobquery as $job): ?>
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="job-card text-center p-3 bg-white shadow-sm rounded h-100">
              
              <!-- Company Logo -->
              <img src="<?= base_url('assets/jobportal/images/color_logo.png'); ?>" 
                   alt="Company Logo" style="height:50px;" class="mb-2">
              
              <!-- Job Title -->
              <h4 class="fw-bold text-black mb-2" style="font-size: 20px; line-height: 1.3;">
                <b><?= esc($job['job_role']); ?></b>
              </h4>
              
              <!-- Company Name -->
              <!--<h6 class="fw-semibold text-dark mb-2" style="font-size: 15px; line-height: 1.2;">
                <?//= esc($job['company_display_name']); ?>
              </h6>-->
              
              <!-- Location -->
              <p class="mb-1 text-secondary" style="font-size: 14px;">&#x1F4CD; 
                <?= esc($job['city_name']); ?>
              </p>
              
              <!-- Experience -->
              <p class="mb-3 text-secondary" style="font-size: 14px;">
                &#x1F4BC; <?= esc($job['experience_min']); ?> - <?= esc($job['experience_max']); ?> Years
              </p>
            
              <a href="<?= base_url('client/jobseeker_view_profile/'. $job['recruiter_id'] . '/' . $job['posting_id']); ?>" class="btn btn-sm rounded-pill w-100
                   <?= ($applied_posting_id == $job['posting_id'] && $applied_job_id == $job['job_id']) 
                       ? 'btn-success' 
                       : 'btn-primary' ?>">
                 <?= ($applied_posting_id == $job['posting_id'] && $applied_job_id == $job['job_id']) 
                       ? 'Applied' 
                       : 'Apply Now' ?>
              </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center">No latest jobs available.</p>
<?php endif; ?>
    </div>


  </div>
</section>

 <section class="site-section py-5 bg-image" style="background:#FBDDDF;">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-5 text-black">Steps to Get Job</h2>
        <img src="<?= base_url('assets/jobportal/images/job_aply_step.png'); ?>" 
       alt="Header Image" 
       style="width: 100%; height: auto; display: block;">
      </div>
    </div>
  </div>
</section>
