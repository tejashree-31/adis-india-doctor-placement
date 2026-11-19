<style>
  .site-section { background: #FBDDDF;padding-top: 6rem !important; }
  .bg-primary1 { background: #fff !important; }
  .block__87154.bg-primary {
    box-shadow: 0px 10px 20px rgba(245, 149, 156, 0.4) !important;
  }
  .logo-square1 {
    width: 74px; height: 70px;
    background-color: FBDDDF; color: #F5959C;
    font-weight: bold; font-size: 41px;
    display: flex; justify-content: center; align-items: center;
    border-radius: 4px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  }
  .my-span {
    font-style: normal; font-size: 16px; font-family: Montserrat;
  }
  .title {
    font-weight: 600; font-size: 25px; font-family: Montserrat;
  }
  .title-head {
    font-weight: 600; font-size: 18px; font-family: Montserrat;
  }

  .share-icon i {
    font-size: 2rem; 
    transition: transform 0.2s ease-in-out;
    color: red;
}

.share-icon1 i {
    font-size: 2rem;
    transition: transform 0.2s ease-in-out;
    color: blue;
}
.share-icon i:hover {
    transform: scale(1.2); 
}
 p{
  font-style: normal !important;
    font-size: 16px !important;
    font-family: Montserrat !important;
    color: #000 !important;
}
ol{
  font-style: normal !important;
    font-size: 16px !important;
    font-family: Montserrat !important;
    color: #000 !important;
}


</style>
<?php 
 //echo "<pre>";
// print_r($posting);
// print_r($recruiter);
//echo $recruiter['recruiter_name'];

$firstLetter = !empty($recruiter['recruiter_name'])
    ? strtoupper($recruiter['recruiter_name'][0])
    : '';
    
    
    $db = \Config\Database::connect();


if (empty($user_id)) {

    $builder = $db->table('tbl_recruiter_posting');
    $builder->where('posting_id', $posting_id);
    $builder->where('job_id', $recruiter_id); // ✅ second condition
    $query = $builder->get();

    $posting_uid = $query->getRow();
    $user_id = $posting_uid->user_id;
}

?>

<section class="site-section" id="next-section">
  <nav aria-label="breadcrumb" class="py-2">
    <div class="container">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="javascript:history.back()">Job List</a></li>
        <li class="breadcrumb-item active text-black" aria-current="page"><?= esc($jobrole['job_role'] ?? '') ?></li>
      </ol>
    </div>
  </nav>

  <div class="container">

    <!-- Job Header Block -->
    <div class="block__87154 bg-primary1 p-3 mb-3">
      <div class="row align-items-center">
        <!-- Logo -->
        <div class="col-4 col-sm-2 text-center text-sm-left mb-2 mb-sm-0">
          <div class="logo-square1"><?= esc($firstLetter) ?></div>
        </div>

        <!-- Action Buttons -->
        <div class="col-8 col-sm-10 d-flex flex-wrap justify-content-end align-items-center">
          <!-- <a href="#" class="btn btn-primary mb-2 mb-sm-0 mr-2">Apply</a> -->
            <form method="post" action="<?= base_url('jobseeker/apply_job') ?>" class="m-0">
                  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                  <input type="hidden" name="jobseeker_id" value="<?php echo $jobseeker_id; ?>">
                  <input type="hidden" name="posting_id" value="<?php echo $posting_id; ?>">
                  <input type="hidden" name="recruiter_id" value="<?php echo $recruiter_id; ?>">
                  <button type="submit" class="btn btn-primary">Apply</button>
            </form>&nbsp;
             <form method="post" action="<?= base_url('jobseeker/save_job') ?>" class="m-0">
                  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                  <input type="hidden" name="jobseeker_id" value="<?= $jobseeker_id ?>">
                  <input type="hidden" name="posting_id" value="<?= $posting_id ?>">
                  <input type="hidden" name="recruiter_id" value="<?= $recruiter_id ?>">
                  <button type="submit" class="btn btn-primary">Save</button>
              </form>&nbsp;&nbsp;
          <a href="https://www.facebook.com/adisindiaplacement" target="_blank" class="text-primary share-icon1 mr-2 mb-2 mb-sm-0">
            <i class="bi bi-facebook"></i>
          </a>
         <a href="https://mail.google.com/mail/?view=cm&fs=1&to=adishr@adisindiaplacement.com&su=<?= urlencode('Job Application - '.$jobrole['job_role']) ?>"  
   class="text-danger share-icon mr-2 mb-2 mb-sm-0" target="_blank">
    <i class="bi bi-envelope-fill"></i>
</a>
          <a href="https://www.linkedin.com/company/adisindiaplacement/" class="text-primary share-icon mb-2 mb-sm-0">
            <i class="bi bi-linkedin"></i>
          </a>
        </div>
      </div>

      <!-- Job Info -->
      <div class="row mt-3">
        <div class="col-12">
          <h4 class="title mb-1 text-black"><?= esc($jobrole['job_role'] ?? '') ?></h4>
          <!--<p class="my-span mb-1 text-black"><?//= esc($recruiter['company_display_name'] ?? '') ?></p>-->
          <p class="my-span mb-0 text-black">
            <i class="bi bi-geo-alt-fill"></i> <?= esc($cities['name'] ?? '') ?> &nbsp;|&nbsp;
            <i class="bi bi-briefcase-fill"></i> <?= esc($posting['experience_min'] ?? '') ?> - <?= esc($posting['experience_max'] ?? '') ?> Years &nbsp;|&nbsp;
            <i class="bi bi-wallet2"></i>
                <?php if (($posting['salary_negotiation'] ?? '') === 'yes'): ?>
                    <span>(Negotiable)</span>
                <?php else: ?>
                    <?= esc($posting['salary_min'] ?? '') ?> - <?= esc($posting['salary_max'] ?? '') ?> INR
                <?php endif; ?>
          </p>
        </div>
      </div>
    </div>

    <!-- Job Details Block -->
    <div class="block__87154 bg-primary1 p-3 mb-3">
      <h5 class="title text-black mb-2">Job Description</h5>
      <p class="my-span text-black mb-3"><?= ($posting['job_description'] ?? 'N/A') ?></p>

      <div class="row">
        <div class="col-6 col-md-3 mb-2 text-black"><b>Employment Type :</b> <?= esc($posting['employment_type'] ?? '') ?></div>
        <div class="col-6 col-md-3 mb-2 text-black"><b>Category :</b> <?= esc($qualification['qualification_name'] ?? '') ?></div>
        <div class="col-6 col-md-3 mb-2 text-black"><b>Job Role :</b> <?= esc($jobrole['job_role'] ?? '') ?></div>
        <div class="col-6 col-md-3 mb-2 text-black"><b>Higher Qualification :</b> <?= esc($course['course_name'] ?? '') ?></div>

        <div class="col-6 col-md-3 mb-2 text-black"><b>Gender :</b> <?= esc($posting['gender'] ?? '') ?></div>
        <div class="col-6 col-md-3 mb-2 text-black"><b>Shift/Timings:</b> <?= ($posting['shift_time'] ?? '') === 'Evening' ? 'General' 
   : (($posting['shift_time'] ?? '') === 'Morning' ? 'Rotational' 
   : (($posting['shift_time'] ?? '') === 'Night' ? 'Night' 
   : esc($posting['shift_time'] ?? ''))) ?>
</div>
        <div class="col-6 col-md-3 mb-2 text-black"><b>Vacancies :</b> <?= esc($posting['vacancies'] ?? '') ?></div>
      </div>
    </div>

  </div>
</section>

