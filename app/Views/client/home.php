
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<style type="text/css">
  
.award-slider-sec{
     padding:70px 0 30px;
    background:#fff;
    overflow:hidden;
}

.award-heading{
    text-align:center;
    margin-bottom:50px;
}

.award-heading h2{
    font-size:48px;
    font-weight:800;
    color:#1d1d1d;
}

.award-heading span{
    color:#ff4d6d;
}

.award-heading p{
    color:#777;
    font-size:17px;
    margin-top:12px;
}

.awardSwiper{
    width:100%;
    max-width:1140px;
    margin:auto;
    padding:30px 15px 35px;
    overflow:hidden;
}

/* Space between cards */
.awardSwiper .swiper-slide{
    display:flex;
    justify-content:center;
}

.award-card-box{
    
    width:100%;
    max-width:230px;   /* आधी 340px होते */
    margin:auto;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
/*    box-shadow:0 10px 30px rgba(0,0,0,.08);*/
    transition:.35s;
}


.award-card-box:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 35px rgba(255,77,109,.15);
}

.award-card-box img{
    width:100%;
    aspect-ratio:1/1;   /* Square Image */
    object-fit:cover;
       height:130px; 
    display:block;
}

.award-content{
    padding:12px;
    text-align:center;
    background:#fff;

    border:1px solid #f3d3dc;
    border-top:none;

    border-radius:0 0 18px 18px;
    box-shadow:0 -2px 8px rgba(255,77,109,.05);
}

.award-content h4{
    font-size:16px;
    font-weight:700;
    line-height:1.4;
    min-height:42px;
    margin-bottom:14px;
}

.award-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:9px 22px;
    border-radius:30px;
    background:linear-gradient(90deg,#ff4d6d,#ff7b54);
    color:#fff;
    font-weight:600;
    text-decoration:none;
    transition:.3s;
}

.award-btn:hover{
    color:#fff;
    transform:translateY(-2px);
}

/* Arrows */
.awardSwiper .swiper-button-prev,
.awardSwiper .swiper-button-next{
    width:52px;
    height:52px;
    background:#fff;
    border-radius:50%;
    box-shadow:0 10px 30px rgba(0,0,0,.12);
    color:#ff4d6d;
}

.awardSwiper .swiper-button-prev{
    left:0;
}

.awardSwiper .swiper-button-next{
    right:0;
}

.awardSwiper .swiper-button-prev:after,
.awardSwiper .swiper-button-next:after{
    font-size:18px;
    font-weight:bold;
}

/* Pagination */
.awardSwiper .swiper-pagination{
     display:none !important;
}

.awardSwiper .swiper-pagination-bullet{
    width:10px;
    height:10px;
    opacity:.4;
    background:#ff4d6d;
}

.awardSwiper .swiper-pagination-bullet-active{
    width:28px;
    border-radius:30px;
    opacity:1;
}

/* Tablet */
@media(max-width:991px){

.award-heading h2{
    font-size:38px;
}

.award-card-box{
    max-width:320px;
}

}

/* Mobile */
@media(max-width:767px){

.award-slider-sec{
    padding:50px 0;
}

.award-heading h2{
    font-size:30px;
}

.award-heading p{
    font-size:15px;
}

.award-card-box{
    max-width:100%;
}

.award-card-box img{
    height:180px;
}

.award-content{
    padding:18px;
}

.award-content h4{
    font-size:18px;
}

.award-btn{
    width:100%;
}

.awardSwiper .swiper-button-next,
.awardSwiper .swiper-button-prev{
    display:none;
}

}
/*=============================  awards-section =========================*/
.ivVNuE {
    width: 100%;
    display: none;
    align-items: center;
    gap: 0.5rem;
    margin: -6px 0px 0px;
    justify-content: flex-end;
}

.image-counter-section{
    position:relative;
    text-align:center;
}

.main-img{
    width:100%;
    height:246px;
    object-fit:cover;
}

/* counters wrapper */
.counter-wrapper{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    display:flex;
    gap:40px;
}

/* counter box */
.counter-circle{
    width:200px;
    height:158px;
    border-radius:10%;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    /*backdrop-filter:blur(8px);*/
    box-shadow: 0 10px 5px rgba(0, 0, 0, 0.25);

    animation:float 3s ease-in-out infinite;
}

.counter-circle h3{
    font-size:28px;
    margin:0;
    color:#333;
}

.counter-circle p{
    margin:0;
    font-size:14px;
}

/* animation */
@keyframes float{
0%{transform:translateY(0)}
50%{transform:translateY(-10px)}
100%{transform:translateY(0)}
}

.counter-icon{
    color:#444;
    margin-bottom:8px;
}

/* ---------- MOBILE VIEW ---------- */

@media (max-width:768px){

.counter-wrapper{
    flex-direction:column;
    gap:20px;
    top:55%;
}

.counter-circle{
    width:140px;
    height:120px;
}

.counter-circle h3{
    font-size:22px;
}

.counter-circle p{
    font-size:12px;
}

.main-img{
    height:500px;
}

}

/*==============================

Premium Google Popup

===============================*/

.popup-overlay{

    position:fixed;

    inset:0;

    background:rgba(20,20,20,.45);

    backdrop-filter:blur(14px);

    display:none;

    justify-content:center;

    align-items:center;

    z-index:99999;

    animation:fade .3s;
}

.popup-overlay.active{

    display:flex;
}

@keyframes fade{

from{

opacity:0;

}

to{

opacity:1;

}

}

/* Popup */

.premium-popup{

    width:650px;
    max-width:90%;
    background:#fff;
    border-radius:28px;
    padding:50px 45px;
    position:relative;
    text-align:center;
    overflow:hidden;
    box-shadow:0 20px 60px rgba(0,0,0,.12);

}

/* Glow */

.premium-popup::before{

content:"";

position:absolute;

width:280px;

height:280px;

background:#ff4f92;

filter:blur(130px);

border-radius:50%;

top:-130px;

left:-120px;

opacity:.18;

}

.premium-popup::after{

content:"";

position:absolute;

width:260px;

height:260px;

background:#ff8a5c;

filter:blur(120px);

border-radius:50%;

bottom:-120px;

right:-120px;

opacity:.12;

}

/* Close */

.popup-close{

position:absolute;

right:18px;

top:18px;

width:42px;

height:42px;

border:none;

background:#fff;

border-radius:50%;

font-size:24px;

cursor:pointer;

box-shadow:0 8px 20px rgba(0,0,0,.08);

transition:.3s;

}

.popup-close:hover{

transform:rotate(90deg);

color:#ff4d88;

}

/* Icon */

.popup-icon{

    width:80px;
    height:80px;

    margin:0 auto 25px;

    border-radius:50%;

    background:#fff2f7;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:36px;

}

/* Heading */

.premium-popup h2{

    font-size:30px;

    font-weight:700;

    color:#222;

    margin-bottom:15px;

}

.premium-popup p{

    font-size:20px;

    color:#666;

    line-height:1.7;

    margin-bottom:35px;

}

.premium-popup p span{

color:#ff4d88;

font-weight:700;

}

/* Google Button */

.google-login-btn{

    width:100%;

    max-width:500px;

    margin:auto;

    height:70px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    background:#fff;

    border:2px solid #ececec;

    border-radius:60px;

    padding:0 10px 0 25px;

    cursor:pointer;

    transition:.3s;

    box-shadow:0 10px 25px rgba(255,90,140,.12);

}

.google-login-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 18px 40px rgba(255,90,140,.22);

}

.google-login-btn img{

    width:34px;

    height:34px;

}

.google-login-btn span{

    flex:1;

    margin-left:18px;

    text-align:left;

    font-size:21px;

    font-weight:600;

    color:#333;

}

.arrow-circle{

    width:52px;

    height:52px;

    border-radius:50%;

    background:linear-gradient(135deg,#ff4d88,#ff6b63);

    color:#fff;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:26px;

    flex-shrink:0;

}
/*====================flip card latest news ===========================*/

.flip-card{
    width:90%;              /* कार्ड थोडं छोटं */
    max-width:280px;
    height:250px;           /* आधी 320px होतं */
    margin:0 auto;
    perspective:1000px;
}

.flip-card-inner{
    position:relative;
    width:100%;
    height:100%;
    transition:transform .8s;
    transform-style:preserve-3d;
}

.flip-card:hover .flip-card-inner{
    transform:rotateY(180deg);
}

.flip-card-front,
.flip-card-back{
    position:absolute;
    width:100%;
    height:100%;
    border-radius:15px;
    overflow:hidden;
    -webkit-backface-visibility:hidden;
    backface-visibility:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
}

.flip-card-front{
    background:#fff;
}

.flip-card-front img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.flip-card-back{
    background:linear-gradient(135deg, #4a001f 0%, #7a1b47 55%, #ff7473 100%);
    color:#fff;
    transform:rotateY(180deg);

    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:20px;
}

.flip-card-back h4{
    font-size:20px;
    margin-bottom:18px;
    color:#fff;
}

.flip-card-back a{
    display:inline-block;
    padding:10px 25px;
    background:#fff;
    color:#7a1b47;
    text-decoration:none;
    border-radius:30px;
    font-weight:600;
    transition:.3s;
}

.flip-card-back a:hover{
    background:#ffd700;
    color:#4a001f;
}

.news-date{
    position:absolute;
    top:15px;
    right:-8px;

    background:linear-gradient(135deg,#4a001f,#ff7473);
    color:#fff;

    padding:8px 18px;

    font-size:12px;
    font-weight:600;

    box-shadow:0 8px 18px rgba(0,0,0,.25);
}

.news-date::before{
    content:"";
    position:absolute;
    bottom:-8px;
    right:0;
    border-left:8px solid #3b0018;
    border-top:8px solid transparent;
}

/* =========================
   Mobile Responsive
========================= */
@media (max-width: 768px){

    .flip-card{
        width:100%;
        max-width:320px;
        height:220px;
        margin:0 auto 20px;
    }

    .flip-card-back{
        padding:15px;
    }

    .flip-card-back h4{
        font-size:18px;
        margin-bottom:14px;
    }

    .flip-card-back a{
        padding:8px 20px;
        font-size:14px;
    }

    .news-date{
        top:10px;
        right:-6px;
        padding:6px 14px;
        font-size:11px;
    }

    .news-date::before{
        bottom:-6px;
        border-left:6px solid #3b0018;
        border-top:6px solid transparent;
    }
}

/* Extra small mobile */
@media (max-width: 480px){

    .flip-card{
        max-width:100%;
        height:200px;
    }

    .flip-card-back{
        padding:12px;
    }

    .flip-card-back h4{
        font-size:16px;
        margin-bottom:12px;
    }

    .flip-card-back a{
        padding:7px 18px;
        font-size:13px;
    }

    .news-date{
        font-size:10px;
        padding:5px 12px;
    }
}

</style>
<!-- <pre><?php print_r($latestJobquery); ?></pre> -->
<!-- <section class="py-5" id="next" style="background:#FFF;padding-bottom: 1rem !important;padding-top: 1rem !important;">
  <div class="container-fluid">

    <div class="row align-items-center">
      
      
      <div class="col-md-3">
        <h2 class="title-scrolls-hed">Top Hospitals Hiring Now</h2>
      </div>

      
      <div class="col-md-9">
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

  </div>
</section> -->
 <?php
    $session = session();
        // print_r($_SESSION);
    $user_id = session()->get('uid');
    $db = \Config\Database::connect();
    $builder = $db->table('tbl_user');

    $user = $builder->select('login_status')
                    ->where('uid', $user_id)
                    ->get()
                    ->getRow();
 
   
 
    if ($session->has('uid')) 
    {  ?>
            
        <?php 
    }else
    { ?>
           <div id="popup" class="popup"> 
          <div class="popup-content">
            <span class="close-btn">&times;</span>
            <h5 style="color: black">
             New Candidate Signup !
            </h5>
            <div class="popup-buttons text-center mt-3">
              <a href="<?= base_url('jobseeker-login?tab=signup'); ?>" class="btn btn-primary border-width-2 d-inline-block mb-2 mb-md-0" style="width: 150;padding: 5px;">
                <span class="mr-2 icon-lock_outline"></span><b>Sign Up</b>
              </a>
              <!--<a href="<?= base_url('recruiter-login'); ?>" class="btn btn-primary border-width-2 d-inline-block">-->
              <!--  <span class="mr-2 icon-lock_outline"></span>Client Login-->
              <!--</a>-->
            </div>
          </div>
        </div>
    <?php
    
    } ?>
    


<section class="site-section services-section block__62849" id="next-section" style="padding: 2rem 0;" style="background-color: #fff6f6;">
  <div class="container">
    <div class="row mb-4 justify-content-center">
      <div class="col-md-7 text-center">
        <h1 class="section-title mb-2">Latest Opening</h1>
      </div>
    </div>
    <div class="row">
       <?php if (!empty($latestJobquery)): ?>
          <?php foreach ($latestJobquery as $job): ?>
          <?php if ($session->has('jobseeker_user_type'))
            { 
                if ($user && $user->login_status === 'active') 
                { ?>
                    <a href="<?= base_url('client/jobseeker_view_profile/'.$job['recruiter_id'].'/'.$job['posting_id']); ?>">
                  <div class="col-12 col-sm-6 col-lg-3 mb-3">
                    <div class="job-card text-center p-3 bg-white shadow-sm rounded h-100">
                      
                      <!-- Company Logo -->
                      <img src="<?= base_url('assets/jobportal/images/color_logo.png'); ?>" 
                           alt="Company Logo" style="height:50px;" class="mb-2">
                      <!-- Job Title -->
                      <h4 class="fw-bold text-black mb-2" style="font-size: 16px; line-height: 1.3;">
                        <b><?= esc($job['job_role']); ?></b>
                      </h4>
                      
                      <?php if(isset($job['industry_name']) && $job['industry_name'] == 'Medical College'){ ?>
    
                          <p class="mb-1 text-secondary" style="font-size: 14px;">
                             🏢 <?= esc($job['department_name']); ?>
                          </p>

                      <?php } ?>
                      
                      <!-- Company Name -->
                      <h6 class="fw-semibold text-dark mb-2" style="font-size: 15px; line-height: 1.2;">
                        <?//= esc($job['company_display_name']); ?>
                      </h6>
                      
                      <!-- Location -->
                      <p class="mb-1 text-secondary" style="font-size: 14px;">&#x1F4CD; 
                        <?= esc($job['city_name']); ?>
                      </p>
                      
                      <!-- Experience -->
                      <p class="mb-3 text-secondary" style="font-size: 14px;">
                        &#x1F4BC; <?= esc($job['experience_min']); ?> - <?= esc($job['experience_max']); ?> Years
                      </p>

                      <!-- Salary -->
                      <?php if (isset($job['salary_negotiation']) && trim(strtolower($job['salary_negotiation'])) === 'yes') : ?>

                          <p class="mb-3 text-secondary" style="font-size: 14px;">
                              Negotiable
                          </p>

                      <?php else : ?>

                          <p class="mb-3 text-secondary" style="font-size: 14px;">
                              ₹ <?= esc($job['salary_min']); ?> - <?= esc($job['salary_max']); ?>
                          </p>

                      <?php endif; ?>
                      
                      <!-- Apply Button -->
                     <!--  <a href="<?//= base_url('apply-job/' . $job['job_id']); ?>" 
                         class="btn btn-primary btn-sm rounded-pill w-100">
                        Apply Now
                      </a> -->
                      <a href="<?= base_url('client/jobseeker_view_profile/'.$job['recruiter_id'].'/'.$job['posting_id']); ?>" 
                        class="btn btn-primary btn-sm rounded-pill w-100">
                        Apply Now
                      </a>
                    </div>
                  </div>
                </a>
                    <?php 
                }else{ ?>
                    <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <!--<a href="<?//= base_url('client/jobseeker_form_client/'.$job['job_id'].'/'.$job['posting_id']); ?>" class="text-decoration-none text-dark">-->
                <div class="job-card text-center p-3 bg-white shadow-sm rounded h-100">

                    <!-- Company Logo -->
                    <img src="<?= base_url('assets/jobportal/images/color_logo.png'); ?>" 
                         alt="Company Logo" style="height:50px;" class="mb-2">

                    <!-- Job Title -->
                    <h4 class="fw-bold text-black mb-2" style="font-size: 16px; line-height: 1.3;">
                        <?= esc($job['job_role']); ?>
                    </h4>
                    <?php if(isset($job['industry_name']) && $job['industry_name'] == 'Medical College'){ ?>
    
                          <p class="mb-1 text-secondary" style="font-size: 14px;">
                             🏢 <?= esc($job['department_name']); ?>
                          </p>

                      <?php } ?>

                    <!-- City -->
                    <p class="mb-1 text-secondary" style="font-size: 14px;">
                        📍 <?= esc($job['city_name']); ?>
                    </p>

                    <!-- Experience -->
                    <p class="mb-3 text-secondary" style="font-size: 14px;">
                        💼 <?= esc($job['experience_min']); ?> - <?= esc($job['experience_max']); ?> Years
                    </p>

                    <!-- Salary -->
                    <?php if (isset($job['salary_negotiation']) && trim(strtolower($job['salary_negotiation'])) === 'yes') : ?>

                          <p class="mb-3 text-secondary" style="font-size: 14px;">
                              Negotiable
                          </p>

                      <?php else : ?>

                          <p class="mb-3 text-secondary" style="font-size: 14px;">
                              ₹ <?= esc($job['salary_min']); ?> - <?= esc($job['salary_max']); ?>
                          </p>

                      <?php endif; ?>

                    <!-- Login Required Message -->
                    <!--<p class="text-danger fw-bold">Login Required ✅</p>-->

                    <!-- Button -->
                    <!--<button class="btn btn-warning btn-sm rounded-pill w-100">-->
                    <!--    Continue to Apply-->
                    <!--</button>-->
                    
                         <!-- ===============11-04-2026 =============== -->
                            <?php if(isset($user->status) && strtolower(trim($user->status)) == 'active') { ?>
                                  <p class="text-danger fw-bold">Login Required ✅</p>
                                    <a href="<?= base_url('client/jobseeker_form_client/'.$job['job_id'].'/'.$job['posting_id']); ?>" class="text-decoration-none text-dark">
                                        <button class="btn btn-warning btn-sm rounded-pill w-100">
                                            Continue to Apply
                                        </button>
                                    </a>

                                <?php } else { ?>
                                   <p class="text-danger fw-bold">Please complete OTP verification to proceed 🔐</p>
                                    <a href="<?= base_url('jobseeker/job_login_otp_new'); ?>" class="text-decoration-none text-dark">
                                        <button class="btn btn-warning btn-sm rounded-pill w-100" disabled style="cursor: not-allowed;">
                                            Apply
                                        </button>
                                    </a>

                                <?php } ?>

                </div>
              <!--</a>-->
            </div>
                    <?php
                } ?>
                
                <?php 
            }else
            { ?>
                <a href="<?= base_url('apply-job/' . $job['posting_id'] . '/' . $job['job_id']); ?>" class="no-underline">
                  <div class="col-12 col-sm-6 col-lg-3 mb-3">
                    <div class="job-card text-center p-3 bg-white shadow-sm rounded h-100">
                      
                      <!-- Company Logo -->
                      <img src="<?= base_url('assets/jobportal/images/color_logo.png'); ?>" 
                           alt="Company Logo" style="height:50px;" class="mb-2">
                      <!-- Job Title -->
                      <h4 class="fw-bold text-black mb-2" style="font-size: 16px; line-height: 1.3;">
                        <b><?= esc($job['job_role']); ?></b>
                      </h4>
                      
                      <!-- Company Name -->
                       <?php if(isset($job['industry_name']) && $job['industry_name'] == 'Medical College'){ ?>
    
                          <p class="mb-1 text-secondary" style="font-size: 14px;">
                             🏢 <?= esc($job['department_name']); ?>
                          </p>

                      <?php } ?>
                      
                      <!-- Location -->
                      <p class="mb-1 text-secondary" style="font-size: 14px;">&#x1F4CD; 
                        <?= esc($job['city_name']); ?>
                      </p>
                      
                      <!-- Experience -->
                      <p class="mb-3 text-secondary" style="font-size: 14px;">
                        &#x1F4BC; <?= esc($job['experience_min']); ?> - <?= esc($job['experience_max']); ?> Years
                      </p>

                      <!-- Salary -->
                      <?php if (isset($job['salary_negotiation']) && trim(strtolower($job['salary_negotiation'])) === 'yes') : ?>

                          <p class="mb-3 text-secondary" style="font-size: 14px;">
                              Negotiable
                          </p>

                      <?php else : ?>

                          <p class="mb-3 text-secondary" style="font-size: 14px;">
                              ₹ <?= esc($job['salary_min']); ?> - <?= esc($job['salary_max']); ?>
                          </p>

                      <?php endif; ?>
                      
                      <!-- Apply Button -->
                     <!--  <a href="<?//= base_url('apply-job/' . $job['job_id']); ?>" 
                         class="btn btn-primary btn-sm rounded-pill w-100">
                        Apply Now
                      </a> -->
                      <a href="<?= base_url('apply-job/' . $job['posting_id'] . '/' . $job['job_id']); ?>" 
                        class="btn btn-primary btn-sm rounded-pill w-100">
                        Apply Now
                      </a>
                    </div>
                </div>
              </a>
                <?php
            }?>
          <?php endforeach; ?>
        <?php else: ?>
        <p class="text-center">No latest jobs available.</p>
        <?php endif; ?>
    </div>
  </div>
</section>
<section class="ai-resume-section">
    <div class="container">

        <div class="ai-banner">

            <div class="ai-left">
                <h2>
                    Build Your <span>CV with AI</span>
                </h2>

                <p>
                    Create a professional resume in minutes with the power of AI
                </p>
            </div>

            <!-- <a href="<?//= base_url('resume-builder') ?>"
               class="ai-btn">
                ✨ Build Resume →
            </a> -->
            <button class="ai-btn" id="openPopup">✨ Build Ai Cv Resume →</button>
        
            

        </div>

    </div>
</section>
<!-- Premium Google Login Popup -->

<div class="popup-overlay" id="loginPopup">

    <div class="premium-popup">

        <button class="popup-close">&times;</button>

        <div class="popup-icon">
            ✨
        </div>

        <h2>Welcome Back! </h2>

        <p>
            Login to continue building your professional resume with
            <span>AI</span>.
        </p>

        <button class="google-login-btn" onclick="window.location.href='<?= base_url('resume-builder-home') ?>'">

    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg">

    <span>Continue with Google</span>

    <div class="arrow-circle">
        →
    </div>

</button>

  

    </div>

</div>

<!-- Trending Job Titles -->
<section class="py-5 bg-image overlay-primary fixed overlay" style="background:#FBDDDF;">
  <div class="container">
    <div class="row mb-4 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-2">Trending job titles</h2>
      </div>
    </div>
    <div class="scroll-wrapper d-flex align-items-center">
      <button class="arrow" id="btnLeft">&#8249;</button>
      <div class="scroll-area flex-grow-1" id="scrollArea">
        <?php if (!empty($AllJobRoleDisplay)): ?>
          <?php foreach ($AllJobRoleDisplay as $job): ?>
            <a href="<?= base_url('trending-job/'.$job['job_id']) ?>" class="job-link-trending" style="text-decoration: none;">
                <div class="job-card-trending">
                    <?= esc($job['job_role']) ?>
                </div>
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="card" >No jobs found</div>
        <?php endif; ?>
      </div>
      <button class="arrow" id="btnRight">&#8250;</button>
    </div>

  </div>
</section>


<section class="site-section services-section block__62849 latest-opening-section" id="next-section" style="background-color: #fff6f6;">
    <div class="container">
        <div class="row mb-4 justify-content-center">
          <div class="col-md-7 text-center">
            <h2 class="section-title mb-2">Latest News</h2>
          </div>
        </div>
        <div class="row">
            <?php if(!empty($latest_blogs)) : ?>
            <?php foreach($latest_blogs as $blog) : ?>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="flip-card">
                            <div class="flip-card-inner">

                                <!-- Front -->
                                <div class="flip-card-front">
                                    <span class="news-date">
                                        <?= date('d', strtotime($blog['created_at'])) ?>
                                        <small><?= date('M Y', strtotime($blog['created_at'])) ?></small>
                                    </span>
                                    <img src="<?= base_url('admin_blog/images/'.$blog['blog_image']) ?>" alt="">
                                </div>

                                <!-- Back -->
                                <div class="flip-card-back">
                                    <h4><?= esc($blog['blog_title']) ?></h4>
                                    <a href="<?= base_url('single_blog_display/'.$blog['blog_id']) ?>">Read More</a>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="site-section block__62849 latest_section_review" id="next-section" style="padding-bottom: 0px !important;">
  <div class="container">
  <div id="JFWebsiteWidget-019fa2db1698700084b0972bfdb273f45fc1"></div>
  </div>
</section>

<!-- Stats -->
    <div class="container">
        <section class="steps-section" style="background:#FBDDDF;">
         
            <div class="row mb-4">
              <div class="col-12 text-center">
                <h2 class="section-title mb-2" style="font-weight:700; color:#333;">Steps to Get Job</h2>
              </div>
            </div>
            <div class="row justify-content-center align-items-center">
              
              <div class="col-md-4 col-12 mb-4 mb-md-0">
               
                <div class="step">
                  <div class="circle">
                    <i class="fa fa-users"></i>
                  </div>
                  <h5>Create your profile.</h5>
                </div>
              </div>

              <div class="col-md-4 col-12 mb-4 mb-md-0">
                <div class="step">
                  <div class="circle">
                    <i class="fa fa-briefcase"></i>
                  </div>
                  <h5>Find / Apply to job.</h5>
                </div>
              </div>

              <div class="col-md-4 col-12">
                <div class="step">
                  <div class="circle">
                   <i class="fa fa-check-circle"></i>
                  </div>
                  <h5>Get recruited!</h5>
                </div>
              </div>

            </div>

        </section>
    </div>
<!-- <section class="awards-section">
    <h2 class="section-title">Awards & Recognition</h2>

    <div class="awards-slider">
        <div class="awards-track">

            <?php //if(!empty($award_display)): ?>
                <?php //foreach($award_display as $award): ?>

                    <div class="award-card">
                        <img src="<?//= base_url('award_image/images/'.$award['award_image']); ?>" alt="">
                        <h5><?//= esc($award['award_title']); ?></h5>
                        <a href="<?//= base_url('award-details/'.$award['award_id']); ?>" class="read-btn">Read More</a>
                    </div>

                <?php //endforeach; ?>
            <?php //endif; ?>

        </div>
    </div>
</section> -->
<section class="award-slider-sec">
    <div class="container">

           <div class="text-center">
        <h2 class="section-title mt-2 mb-2">Awards & Recognition</h2>
      </div>
        <div class="swiper awardSwiper">
            <div class="swiper-wrapper">

                <?php foreach($award_display as $award){ ?>
                <div class="swiper-slide">

                    <div class="award-card-box">

                        <img src="<?= base_url('award_image/images/'.$award['award_image']) ?>">

                        <div class="award-content">
                            <h4><?= $award['award_title'] ?></h4>

                            <a href="<?= base_url('award/'.$award['award_id']) ?>" class="award-btn">
                                Read More
                            </a>
                        </div>

                    </div>

                </div>
                <?php } ?>

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <div class="swiper-pagination"></div>

        </div>

    </div>
</section>
<section class="image-counter-section">
  <img src="<?= base_url('assets/jobportal/images/traning/home_counter.jpeg') ?>" class="main-img">
    <div class="counter-wrapper">
      <div class="counter-circle">
            <i class="fa fa-users counter-icon" style="font-size: 33px;"></i>
          <h3 class="count" data-count="3000">0</h3>
          <p style="margin-top: 7px;">Clients Number</p>
      </div>

      <div class="counter-circle">
       <i class="fa fa-graduation-cap counter-icon" style="font-size: 33px;"></i>
          <h3 class="count" data-count="1000000">0</h3>
          <p style="margin-top: 7px;">Candidates Number</p>
      </div>

      <div class="counter-circle counter-icon" style="font-size: 33px;">
          <i class="fa fa-line-chart"></i>

          <h3 class="count percent" data-count="95">0</h3>
          <p style="margin-top:7px;">Successfull Placement Rate</p>
      </div>

    </div>

</section>
<script>document.addEventListener('DOMContentLoaded', function () {

  const popup = document.getElementById('popup');
  const closeBtn = document.querySelector('.close-btn');

  if (!popup || !closeBtn) return;

  popup.style.display = 'block';

  // Close button
  closeBtn.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  // Outside click (ONLY overlay)
  popup.addEventListener('click', function (e) {
    if (e.target === popup) {
      popup.style.display = 'none';
    }
  });

  // ESC close
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      popup.style.display = 'none';
    }
  });

});

</script>
<script type="text/javascript">
    const popup = document.getElementById("loginPopup");

document.getElementById("openPopup").addEventListener("click", function () {
    popup.classList.add("active");
});

document.querySelector(".popup-close").addEventListener("click", function () {
    popup.classList.remove("active");
});

popup.addEventListener("click", function (e) {
    if (e.target === popup) {
        popup.classList.remove("active");
    }
});
</script>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<script>

new Swiper(".awardSwiper",{

    slidesPerView:4,
    spaceBetween:20,

    loop:false,

    autoplay:{
        delay:3000,
        disableOnInteraction:false,
    },

    navigation:{
        nextEl:".swiper-button-next",
        prevEl:".swiper-button-prev",
    },

    breakpoints:{
        320:{
            slidesPerView:1
        },
        576:{
            slidesPerView:2
        },
        768:{
            slidesPerView:3
        },
        1200:{
            slidesPerView:4
        }
    }

});
</script>