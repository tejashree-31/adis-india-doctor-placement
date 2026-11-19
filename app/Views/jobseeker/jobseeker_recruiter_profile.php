<?php 
$db = \Config\Database::connect();
 ?>
<style>
  .site-section { background: #FBDDDF; }
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


// print_r($recruiter);

$firstLetter = !empty($recruiter['recruiter_name'])
    ? strtoupper($recruiter['recruiter_name'][0])
    : '';
// echo $firstLetter;
?>

<section class="site-section" id="next-section">
  <nav aria-label="breadcrumb" class="py-2">
      <div class="container">
        <ol class="breadcrumb mb-0">
          <!-- <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li> -->
          <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('jobseeker/jobseeker_profile') ?>">Job List</a></li>
          
          <li class="breadcrumb-item active" aria-current="page"><?= esc($jobrole['job_role']) ?></li>
        </ol>
      </div>
  </nav>
  <div class="container">

    <div class="block__87154 bg-primary1 justify-content-between p-3">
      <div class="row align-items-center">
          <div class="col-md-2">
              <div class="logo-square1"><?= esc($firstLetter) ?></div>
          </div>
          <div class="col-md-2"></div>
          <div class="col-md-2"></div>
          <div class="col-md-2"></div>
          <div class="col-md-4 d-flex align-items-center gap-2">
            <?php 
                  $builder = $db->table('tbl_candidate_job_status');
                    $apply_existing = $builder->where([
                        'user_id'          => $uid,
                        'jobseeker_id'     => $jobseeker_id,
                        'posting_id'       => $posting_id,
                        'recruiter_id'     => $recruiter_id
                    ])->get()->getRow();
                        // echo $db->getLastQuery();
                if ($apply_existing) 
                {
                  if($apply_existing->candidate_status =='Apply Job' && $apply_existing->candidate_status !='Save Job')
                  { ?>
                      <button class="btn btn-success" disabled>Already Applied</button>&nbsp;&nbsp;
                  <?php  
                  }?>
                  <?php
                   if($apply_existing->candidate_status !='Apply Job' && $apply_existing->candidate_status =='Save Job')
                   { ?>
                        <form method="post" action="<?= base_url('jobseeker/apply_job') ?>" class="m-0">
                            <input type="hidden" name="user_id" value="<?= $uid ?>">
                            <input type="hidden" name="jobseeker_id" value="<?= $jobseeker_id ?>">
                            <input type="hidden" name="posting_id" value="<?= $posting_id ?>">
                            <input type="hidden" name="recruiter_id" value="<?= $recruiter_id ?>">
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>&nbsp;&nbsp;

                  <?php 
                   }

                }else{ ?>
                  <form method="post" action="<?= base_url('jobseeker/apply_job') ?>" class="m-0">
                  <input type="hidden" name="user_id" value="<?= $uid ?>">
                  <input type="hidden" name="jobseeker_id" value="<?= $jobseeker_id ?>">
                  <input type="hidden" name="posting_id" value="<?= $posting_id ?>">
                  <input type="hidden" name="recruiter_id" value="<?= $recruiter_id ?>">
                  <button type="submit" class="btn btn-primary">Apply</button>
              </form>&nbsp;&nbsp;
               <form method="post" action="<?= base_url('jobseeker/save_job') ?>" class="m-0">
                  <input type="hidden" name="user_id" value="<?= $uid ?>">
                  <input type="hidden" name="jobseeker_id" value="<?= $jobseeker_id ?>">
                  <input type="hidden" name="posting_id" value="<?= $posting_id ?>">
                  <input type="hidden" name="recruiter_id" value="<?= $recruiter_id ?>">
                  <button type="submit" class="btn btn-primary">Save</button>
              </form>&nbsp;&nbsp;

              <?php
                } ?>
            
          
              <a href="mailto:?subject=Check this out&body=I thought you might like this: https://yourwebsite.com" class="text-danger share-icon">
                  <i class="bi bi-envelope-fill"></i>
              </a>&nbsp;&nbsp;

              <a href="https://www.facebook.com/sharer/sharer.php?u=https://yourwebsite.com" target="_blank" class="text-primary share-icon1">
                  <i class="bi bi-facebook"></i>
              </a>&nbsp;
          </div>
      </div>
      <div class="row">
        <div class="col-md-12">
           <p class="mt-3 mb-0 text-black"><span class="title"><?= esc($jobrole['job_role']) ?></span></p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
           <!--<p class="mt-1 mb-0 text-black"><span class="my-span"><?//= esc($recruiter['company_display_name']) ?></span></p>-->
            <p class="mb-0 text-black"><i class="bi bi-geo-alt-fill" style="font-size: 17px;"></i>
            <span class="my-span"><?= esc($cities['name']) ?>&nbsp;&nbsp;&nbsp;</span><i class="bi bi-briefcase-fill" style="font-size: 17px;"></i>
            <span class="my-span"><?= esc($posting['experience_min']) ?> - <?= esc($posting['experience_max']) ?> Years</span>&nbsp;&nbsp;&nbsp;
            <i class="bi bi-wallet2" style="font-size: 17px;"></i>
            <span class="my-span"><?= esc($posting['salary_min']) ?> INR - <?= esc($posting['salary_max']) ?> INR</span></p>
        </div>
      </div>

    </div>
     <div class="block__87154 bg-primary1 justify-content-between p-3">
     
      <div class="row">
        <div class="col-md-12">
           <p class="mt-3 mb-0 text-black"><span class="title">Job Description</span></p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><?= ($posting['job_description'] ?? 'N/A') ?></span></p>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><b>Employment Type</b></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><?= esc($posting['employment_type'] ?? 'N/A') ?></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><b>Qualification</b></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"> <?= esc($qualification['qualification_name'] ?? 'Not specified') ?></span></p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><b>Job Role</b></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><?= esc($jobrole['job_role'] ?? 'N/A') ?></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><b>Course</b></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><?= esc($course['course_name'] ?? 'N/A') ?></span></p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><b>Gender</b></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><?= esc($posting['gender'] ?? 'N/A') ?></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><b>Shit/Timings</b></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><?= esc($posting['shift_time'] ?? 'N/A') ?></span></p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><b> Number Of Vacancies</b></span></p>
        </div>
        <div class="col-md-3">
           <p class="mt-1 mb-0 text-black"><span class="my-span"><?= esc($posting['vacancies'] ?? 'N/A') ?></span></p>
        </div>
      </div>
    </div>

  </div>
</section>
