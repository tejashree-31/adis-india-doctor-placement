<?php
$session = session(); 
$applied_posting_id = $session->get('applied_posting_id');
$applied_job_id     = $session->get('applied_job_id');

// ================ 01-11-2025 ====================================
 $user_id = session()->get('uid');
  $db = \Config\Database::connect();
    $builder = $db->table('tbl_user');

    $user = $builder->select('login_status')
                    ->where('uid', $user_id)
                    ->get()
                    ->getRow();
?>
<style>
/* General Styles */
.site-section {
    background: #FBDDDF;
    position: relative;
}

/* Breadcrumb */
.breadcrumb-nav {
    position: relative;
    z-index: 9999;
    background: none;
    padding: 0.5rem 0;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
    margin-bottom: 0;
    font-size: 0.95rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #6c757d;
    padding: 0 5px;
}

.breadcrumb-item a {
    text-decoration: none;
    color: #007bff;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #6c757d;
    font-weight: 500;
}

/* Job Card */
.job-card {
    position: relative; /* ensures buttons are on top */
    z-index: 1;
    display: flex;
    flex-direction: column;
    padding: 1rem;
    background: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    transition: all 0.2s;
}

.job-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.job-card img {
    max-height: 50px;
    object-fit: contain;
    margin-bottom: 0.5rem;
}

.job-card h4 {
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.job-card p {
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.job-card a.btn {
    margin-top: auto; /* push button to bottom */
    z-index: 2;
    pointer-events: auto;
}

/* Responsive */
@media (max-width: 767px) {
    .breadcrumb { font-size: 0.85rem; }
    .job-card h4 { font-size: 0.95rem; }
    .job-card p { font-size: 0.7rem; }
    .job-card a.btn { font-size: 0.75rem; padding: 0.35rem 0; }
}

/**/
</style>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="breadcrumb-nav">
  <div class="container">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="<?= site_url(); ?>">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Latest Opening</li>
    </ol>
  </div>
</nav>

<!-- Latest Opening Section -->
<section class="site-section services-section" style="padding: 2rem 0;">
  <div class="container">
    <!-- Section Title -->
    <div class="row mb-4 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-2">Latest Opening</h2>
      </div>
    </div>

    <!-- Job Cards -->
    <div class="row g-3">
      <?php if(!empty($search_jobs)) : ?>
        <?php foreach ($search_jobs as $job) : ?>
          <div class="col-12 col-sm-6 col-lg-3 mb-4">
            <div class="job-card text-center d-flex flex-column">
              <img src="<?= base_url('assets/jobportal/images/color_logo.png'); ?>" alt="Company Logo" class="img-fluid mx-auto">
              <h4 class="fw-bold text-black"><?= esc($job['job_role']); ?></h4>
               <?php if(isset($job['industry_name']) && $job['industry_name'] == 'Medical College'){ ?>
                    <p class="text-black" style="font-size: 14px;">
                      🏢<?= esc($job['department_name']); ?>
                    </p>
                <?php } ?>
              <p class="text-black">&#x1F4CD; <?= esc($job['city_name']); ?></p>
              <p class="text-black">&#x1F4BC; <?= esc($job['experience_min']); ?> - <?= esc($job['experience_max']); ?> Years</p>
              <p class="text-black">
                    <?php if (($job['salary_negotiation'] ?? '') === 'yes'): ?>
                       Negotiable
                    <?php else: ?>
                        ₹ <?= esc($job['salary_min']); ?> - <?= esc($job['salary_max']); ?>
                    <?php endif; ?>
                </p>

              <?php if ($session->has('jobseeker_user_type')): ?> 
                <?php if ($user->login_status === 'active') { ?>
                        <a href="<?= base_url('client/jobseeker_view_profile/'.$job['recruiter_id'].'/'.$job['posting_id']); ?>" 
                        class="btn btn-primary btn-sm rounded-pill w-100"> Apply Now
                        </a>
                    <?php }else{ ?>
                    <!--     <a href="<?//= base_url('client/jobseeker_form_client/'.$job['job_id'].'/'.$job['posting_id']); ?>" class="text-decoration-none text-dark"> <button class="btn btn-warning btn-sm rounded-pill w-100">-->
                    <!--        Continue to Apply-->
                    <!--</button></a>-->
                           <?php if(isset($user->status) && strtolower(trim($user->status)) == 'active') { ?>
                            <p class="text-danger fw-bold">Login Required ✅</p>
                                <a href="<?= base_url('client/jobseeker_form_client/'.$job['job_id'].'/'.$job['posting_id']); ?>" class="text-decoration-none text-dark"> <button class="btn btn-warning btn-sm rounded-pill w-100">
                                Continue to Apply
                                </button></a>
                        <?php } else { ?>
                                   <p class="text-danger fw-bold">Please complete OTP verification to proceed 🔐</p>
                                   <a href="<?= base_url('client/jobseeker_form_client/'.$job['job_id'].'/'.$job['posting_id']); ?>" class="text-decoration-none text-dark"> <button class="btn btn-warning btn-sm rounded-pill w-100" disabled style="cursor: not-allowed;">
                                Continue to Apply
                                </button></a>
                          <?php } ?>
                    <?php
                    } ?>
              <?php else: ?>
                <a href="<?= base_url('apply-job/'.$job['posting_id'].'/'.$job['job_id']); ?>" 
                   class="btn btn-primary btn-sm rounded-pill w-100">
                  Apply Now
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="col-12">
          <div class="alert alert-info text-center">
            No jobs found matching your criteria.
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
