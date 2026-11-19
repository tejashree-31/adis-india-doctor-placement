<style>
.pagination_links {
    text-align: center;
    margin-top: 20px;
}

/* ul container */
.pagination_links ul {
    display: inline-flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

/* li items including Next / Last / Prev */
.pagination_links li {
    margin: 0 5px;
}

/* All links and spans */
.pagination_links li a,
.pagination_links li span {
    display: block;
    padding: 0px 7px;
    background: #fff;
    border: 1px solid #ddd;
    color: #007bff;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    min-width: 40px;
    text-align: center;
}

/* Active page */
.pagination_links li.active span {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

/* Hover effect for clickable links */
.pagination_links li a:hover {
    background-color: #007bff;
    color: #fff;
}

/* Disabled buttons like Prev / Next on first/last page */
.pagination_links li.disabled span {
    color: #ccc;
    border-color: #ccc;
    
}
 .department_text {
    font-size: 14px;
    color: #fff;
    opacity: 0.9;
    margin-top: 3px;
    display: flex;
    align-items: center;
    gap: 2px;
}
</style>
<div class="container all_jobs_container">
  <div class="posting_div">
    <form action="<?= base_url('all_jobs') ?>" method="GET" class="search_poting_form">
      <input type="text" name="job_role" placeholder="Enter Job Role"  class="search_input_post" value="<?= isset($_GET['job_role']) ? esc($_GET['job_role']) : '' ?>" 
        onfocus="this.style.borderColor='#F5959C'; this.style.boxShadow='#F5959C';"
        onblur="this.style.borderColor='#FBDDDF'; this.style.boxShadow='none';">
      <button 
        type="submit" class="search_post_button" onmouseover="this.style.background='#F5959C';" onmouseout="this.style.background='#F5959C';" >
        Search Jobs
      </button>
    </form>
  </div>
</div>
<?php

    $session = session();
    $user_id = session()->get('uid');
    $db = \Config\Database::connect();
    $builder = $db->table('tbl_user');

    $user = $builder->select('login_status')
                    ->where('uid', $user_id)
                    ->get()
                    ->getRow();

?>

<div class="container search_post_container" style="max-width:942px;">
    <?php if(!empty($jobs)): ?>
    <?php foreach($jobs as $job): ?>
    
    <?php if($session->has('jobseeker_user_type')) 
    { 
        if ($user->login_status === 'active') 
        { ?>
            <div class="apply_button_search_div">
                <a href="<?= base_url('client/jobseeker_view_profile/'.$job['recruiter_id'].'/'.$job['posting_id']); ?>"><button class="apply_button_search">Apply</button></a>
                <div class="circle_search_post">
                        <i class="fa fa-hospital-o" aria-hidden="true" style="font-size:25px;"></i>
                </div>
                <div class="job_role_search_post">
                 <div class="job_text_search">
                          <?= esc($job['job_role']) ?>

                          <?php if (isset($job['industry_name']) && $job['industry_name'] == 'Medical College' && !empty($job['department_name'])): ?>
                              
                              <div class="department_text">
                                  🏢 <?= esc($job['department_name']); ?>
                              </div>

                          <?php endif; ?>
                      </div>
      <div class="location_search">
         <!-- Location -->
          <div style=" align-items:center;">
             <i class="fa fa-map-marker" style="margin-right:5px;"></i>
            <span><?= esc($job['city_name']) ?></span>
          </div>

                  <!-- Experience -->
          <div style=" align-items:center;">
            <i class="fa fa-briefcase" style="margin-right:5px;"></i>
            <?= esc($job['experience_min']) ?> - <?= esc($job['experience_max']) ?> yrs
          </div>

          <!-- Salary -->
        <div style=" align-items:center;">
        
         <?php if (isset($job['salary_negotiation']) && trim(strtolower($job['salary_negotiation'])) === 'yes') : ?>

                          <p class="mb-3" style="font-size: 14px;margin-top: 15px;">
                                <i class="fa fa-money" style="margin-right:5px;"></i> Negotiable
                          </p>

                      <?php else : ?>

                          <p class="mb-3" style="font-size: 14px;margin-top: 15px;">
                                <i class="fa fa-money" style="margin-right:5px;"></i> ₹ <?= esc($job['salary_min']); ?> - <?= esc($job['salary_max']); ?>
                          </p>

                      <?php endif; ?>
        </div>
      </div>
    </div>
            </div>
                <?php 
            
        }else
        {  ?>
            <div class="apply_button_search_div">
               <a href="<?= base_url('client/jobseeker_form_client/'.$job['job_id'].'/'.$job['posting_id']); ?>" class="text-decoration-none text-dark">
                  <button class="apply_button_search">Apply</button></a>
                <div class="circle_search_post">
                        <i class="fa fa-hospital-o" aria-hidden="true" style="font-size:25px;"></i>
                </div>
                <div class="job_role_search_post">
      <div class="job_text_search">
       <?= esc($job['job_role']) ?>
      </div>
      <div class="location_search">
         <!-- Location -->
          <div style=" align-items:center;">
             <i class="fa fa-map-marker" style="margin-right:5px;"></i>
            <span><?= esc($job['city_name']) ?></span>
          </div>

                  <!-- Experience -->
          <div style=" align-items:center;">
            <i class="fa fa-briefcase" style="margin-right:5px;"></i>
            <?= esc($job['experience_min']) ?> - <?= esc($job['experience_max']) ?> yrs
          </div>

          <!-- Salary -->
        <div style=" align-items:center;">
          <i class="fa fa-money" style="margin-right:5px;"></i>
          ₹<?= number_format($job['salary_min']) ?> - ₹<?= number_format($job['salary_max']) ?>
        </div>
      </div>
    </div>
            </div>

        <?php
        } 
    }else
    { ?> 
        <div class="apply_button_search_div">
            <a href="<?= base_url('apply-job/' . $job['posting_id'] . '/' . $job['job_id']); ?>" class="no-underline"><button class="apply_button_search">Apply</button></a>
            <div class="circle_search_post">
         <i class="fa fa-hospital-o" aria-hidden="true" style="font-size:25px;"></i>
      </div>
            <div class="job_role_search_post">
          <div class="job_text_search">
           <?= esc($job['job_role']) ?>
          </div>
          <div class="location_search">
             <!-- Location -->
              <div style=" align-items:center;">
                 <i class="fa fa-map-marker" style="margin-right:5px;"></i>
                <span><?= esc($job['city_name']) ?></span>
              </div>

                      <!-- Experience -->
              <div style=" align-items:center;">
                <i class="fa fa-briefcase" style="margin-right:5px;"></i>
                <?= esc($job['experience_min']) ?> - <?= esc($job['experience_max']) ?> yrs
              </div>

              <!-- Salary -->
            <div style=" align-items:center;">
              <i class="fa fa-money" style="margin-right:5px;"></i>
              ₹<?= number_format($job['salary_min']) ?> - ₹<?= number_format($job['salary_max']) ?>
            </div>
          </div>
      </div>
        </div>
        <?php
      } ?>
   <?php endforeach; ?>
     <!-- ✅ Pagination links below all job cards -->
          <div class="pagination_links" style="text-align:center; margin-top:20px;">
        <?= $pager->links() ?>
    </div>
    
  <?php else: ?>
    <p>No jobs found.</p>
  <?php endif; ?>
</div>

















