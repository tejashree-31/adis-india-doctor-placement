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

.popup_profile{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(10,20,40,.45);
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);
    z-index:99999;
}
.resume-popup{
        position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    width:420px;
    max-width:92%;
    padding:35px;
    border-radius:25px;

    background:rgba(245,149,156,.18);
    backdrop-filter:blur(25px);
    -webkit-backdrop-filter:blur(25px);
    border:1px solid rgba(255,255,255,.35);
    box-shadow:
        0 20px 45px rgba(0,0,0,.25),
        inset 0 1px 1px rgba(255,255,255,.4);

    text-align:center;
    overflow:hidden;
    
}
/*.glass-popup{*/

/*}*/

/* Glass shine */
.glass-popup::before{
    content:'';
    position:absolute;
    top:-120px;
    left:-80px;
    width:250px;
    height:250px;
    background:rgba(255,255,255,.25);
    border-radius:50%;
    filter:blur(40px);
}

.glass-popup::after{
    content:'';
    position:absolute;
    bottom:-100px;
    right:-60px;
    width:220px;
    height:220px;
    background:rgba(13,110,253,.25);
    border-radius:50%;
    filter:blur(45px);
}

.close-btn{
    position:absolute;
    top:15px;
    right:20px;
    color:#fff;
    font-size:28px;
    cursor:pointer;
    z-index:2;
}

.premium-tag{
    display:inline-block;
    padding:7px 18px;
    border-radius:50px;
    background:rgba(255,255,255,.2);
    border:1px solid rgba(255,255,255,.4);
    color:#fff;
    font-size:13px;
    font-weight:700;
    letter-spacing:1px;
    margin-bottom:25px;
}

.resume-card-icon{
    width:76px;
    height:78px;
    margin:0 auto 25px;
    background:#fff;
    border-radius:18px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    color:#5B4BFF;
    box-shadow:0 15px 40px rgba(0,0,0,.18);
    animation:float 3s ease-in-out infinite;
}

.resume-card-icon i{
    font-size:42px;
}

.resume-card-icon span{
    margin-top:8px;
    font-weight:700;
    letter-spacing:1px;
}
.glass-popup h5{
    color:#fff;
    font-weight:700;
    margin-bottom:34px;
}

.glass-popup p{
    color:#f2f2f2;
    font-size:15px;
    line-height:1.7;
    margin-bottom:30px;
}

.glass-btn{
    background:linear-gradient(135deg,#F5959C,#F26F7A);
    color:#fff;
    border:none;
    border-radius:50px;
    padding:14px 38px;
    font-size:18px;
    font-weight:700;
    transition:.35s;
    box-shadow:0 12px 30px rgba(245,149,156,.45);
}

.glass-btn:hover{
    background:linear-gradient(135deg,#F26F7A,#E85C68);
    color:#fff;
    transform:translateY(-4px);
    box-shadow:0 18px 40px rgba(245,149,156,.55);
}
@media (max-width:768px){

    .glass-popup{
        width:90%;
        padding:30px 20px;
        border-radius:20px;
    }

    .glass-popup h5{
        font-size:28px;
        margin-bottom:25px;
    }

    .glass-popup p{
        font-size:14px;
        margin-bottom:25px;
    }

    .resume-card-icon{
        width:70px;
        height:72px;
    }

    .resume-card-icon i{
        font-size:34px;
    }

    .glass-btn{
        width:100%;
        padding:13px;
        font-size:17px;
    }

    .close-btn{
        top:12px;
        right:15px;
        font-size:26px;
    }

}


@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-10px);}
}
/* subtle continuous pulse */
@keyframes pulse {
  0% { box-shadow: 0 4px 12px rgba(255,110,120,0.18); }
  50% { box-shadow: 0 16px 24px rgba(255,110,120,0.12); }
  
  
  

</style>



<section class="site-section" id="next-section"> 
  <div class="container">
    <div class="col-lg-12 mb-4">
      <span class="title">Recommended Jobs</span>

      <?php 
      $hasJobs = false; 
      if (!empty($qualCoursSerchingData)) { 
          foreach ($qualCoursSerchingData as $row) { 
              if (!empty($row['posting_id'])) {  // Only show if posting_id exists
                  $hasJobs = true;
      ?>
                  <!-- <a href="<?//= base_url('jobseeker/jobseeker_recruiter_profile/' . $row['posting_id']); ?>" style="text-decoration: none!important;"> -->
                  <a href="<?= base_url('jobseeker/jobseeker_recruiter_profile/' 
                    . $row['posting_id'] . '/' 
                    . $row['uid'] . '/' 
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
                                 <!--     <form method="post" action="<?//= base_url('jobseeker/apply_job') ?>">
                                        <input type="text" name="user_id" value="<?//= esc($row['uid']) ?>">
                                      <input type="text" name="jobseeker_id" value="<?//= esc($jobseeker['jobseeker_id']) ?>">
                                        <input type="text" name="posting_id" value="<?//= esc($row['posting_id']) ?>">
                                        <input type="text" name="recruiter_id" value="<?//= esc($row['recruiter_id']) ?>">
                                        <button type="submit" class="apply-btn">Apply Now</button>
                                    </form> -->
                                      <!-- <button class="apply-btn">Apply Now</button> -->
                                  </div>
                              </div>
                              <!--<p class="mb-0"><span class="my-span"><?//= esc($row['company_display_name']) ?></span></p>-->
                              <p class="mb-1">
                                  <i class="bi bi-geo-alt-fill" style="font-size: 17px;"></i>
                                  <span class="my-span"><?= esc($row['city_name']) ?>&nbsp;&nbsp;&nbsp;</span>
                                  <i class="bi bi-briefcase-fill" style="font-size: 17px;"></i>
                                  <span class="my-span"><?= esc($row['experience_min']) ?> - <?= esc($row['experience_max']) ?> Years</span>&nbsp;&nbsp;&nbsp;
                                  <i class="bi bi-wallet2" style="font-size: 17px;"></i>
                                  <span class="my-span">
                                  <?= (!empty($row['salary_negotiation']) && trim(strtolower($row['salary_negotiation'])) === 'yes')
                                      ? 'Negotiable'
                                      : esc($row['salary_min']) . ' - ' . esc($row['salary_max']) . ' Monthly'; ?>
                                  </span>
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
  <div id="popup" class="popup_profile">
      <div class="resume-popup glass-popup">

          <span class="close-btn">&times;</span>

          <div class="premium-tag">
              <i class="bi bi-stars"></i> PREMIUM
          </div>

          <div class="resume-card-icon">
              <i class="bi bi-file-earmark-richtext-fill"></i>
          </div>

          <h5>Create Your Resume</h5>

        

          <a href="<?= base_url('jobseeker/resume_builder'); ?>" class="glass-btn">
              <i class="bi bi-lightning-charge-fill"></i>
              Build Resume
          </a>

      </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {

    // Popup open after page load
    $("#popup").fadeIn();

    // Close button
    $(".close-btn").click(function () {
        $("#popup").fadeOut();
    });

    // Outside click
    $(window).click(function (e) {
        if ($(e.target).is("#popup")) {
            $("#popup").fadeOut();
        }
    });

});
</script>





