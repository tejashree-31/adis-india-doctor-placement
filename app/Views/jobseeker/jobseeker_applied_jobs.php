<?php 
$session = session();
$db = \Config\Database::connect();
if ($session->has('uid')) {
          $uid = $session->get('uid');
    $builder = $db->table('tbl_jobseeker');
   $jobseeker = $builder->where('uid', $uid)->get()->getRowArray();
}


 ?>
<style>

  .site-section { background: #FBDDDF;
      padding-top: 4rem !important; }
  .bg-primary1 { background: #fff !important; }
  .block__87154.bg-primary {
    box-shadow: 0px 10px 20px rgba(245, 149, 156, 0.4) !important;
  }
  .logo-square1 {
    width: 95px; height: 87px;
    background-color: FBDDDF; color: #F5959C;
    font-weight: bold; font-size: 61px;
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

.apply-btn {
  --bg1: #ff6b6b;
  --bg2: #ff8e53;
  --txt: #fff;

  appearance: none;
  border: 0;
  cursor: pointer;
  display: inline-block;
  padding: 0.4rem 0.9rem; /* smaller padding */
  font-weight: 600;
  font-size: 0.85rem; /* smaller text */
  color: var(--txt);
  border-radius: 8px; /* slightly smaller radius */
  background: linear-gradient(135deg, var(--bg1), var(--bg2));
  box-shadow: 0 4px 12px rgba(255,110,120,0.18), 
              inset 0 -3px 8px rgba(0,0,0,0.05);
  transition: transform .18s ease, box-shadow .18s ease, filter .18s;
  transform: translateZ(0);
}

/* hover/active */
.apply-btn:hover {
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 12px 20px rgba(255,110,120,0.18);
  filter: brightness(1.03);
}

/* subtle continuous pulse */
@keyframes pulse {
  0% { box-shadow: 0 4px 12px rgba(255,110,120,0.18); }
  50% { box-shadow: 0 16px 24px rgba(255,110,120,0.12); }

</style>



<section class="site-section" id="next-section"> 
  <div class="container">
    <div class="col-lg-12 mb-4">
      <span class="title">Applied Jobs</span>

      <?php 
      $hasJobs = false; 
      if (!empty($applied_job_jobseeker)) { 
          foreach ($applied_job_jobseeker as $row) { 
              if (!empty($row['posting_id'])) {  // Only show if posting_id exists
                  $hasJobs = true;
            $recruiter_user_id = $db->table('tbl_recruiter')
                ->select('uid')
                ->where('recruiter_id', $row['recruiter_id'])
                ->get()
                ->getRow(); // getting recruiter id
            $user_recruiter_id = $recruiter_user_id->uid;

      ?>
                  <!-- <a href="<?//= base_url('jobseeker/jobseeker_recruiter_profile/' . $row['posting_id']); ?>" style="text-decoration: none!important;"> -->
                  <a href="<?= base_url('jobseeker/jobseeker_recruiter_profile/' 
                    . $row['posting_id'] . '/' 
                    . $user_recruiter_id. '/' 
                    . $jobseeker['jobseeker_id'] . '/' 
                    . $row['recruiter_id']); ?>">
                      <div class="block__87154 bg-primary1 d-flex align-items-center">
                          <div class="logo-square1 mr-3"><i class="bi bi-briefcase-fill" style="font-size: 40px;"></i></div>
                          <div class="text-black">
                              <div class="row">
                                  <div class="col-md-8">
                                      <p class="mb-1">
                                          <span class="title"><?= esc($row['job_role']) ?> </span>
                                      </p>
                                  </div>

                                  <div class="col-md-4" style="text-align: right;">
                              
                                  </div>
                              </div>
                              <!--<p class="mb-0"><span class="my-span"><?//= esc($row['company_display_name']) ?></span></p>-->
                              <p class="mb-1">
                                  <i class="bi bi-geo-alt-fill" style="font-size: 17px;"></i>
                                  <span class="my-span"><?= esc($row['city_name']) ?>,<?= esc($row['area_name']) ?>-<?= esc($row['pincode']) ?>&nbsp;&nbsp;&nbsp;</span>
                                  <i class="bi bi-briefcase-fill" style="font-size: 17px;"></i>
                                  <span class="my-span"><?= esc($row['experience_min']) ?> - <?= esc($row['experience_max']) ?> Years</span>&nbsp;&nbsp;&nbsp;
                                  <i class="bi bi-wallet2" style="font-size: 17px;"></i>
                                    <?php if (isset($row['salary_negotiation']) && $row['salary_negotiation'] === 'yes') : ?>

                                      <span class="my-span">Negotiable</span>

                                  <?php else : ?>

                                      <span class="my-span">
                                          ₹ <?= esc($row['salary_min']) ?> - <?= esc($row['salary_max']) ?> Monthly
                                      </span>

                                  <?php endif; ?>
                              </p>
                          </div>
                      </div>
                  </a>
      <?php 
              } 
          } 
      }

      if (!$hasJobs) { ?>
          <p class="mb-1 text-danger">No jobs found for your search criteria.</p>
      <?php } ?>
    </div>
  </div>
</section>
