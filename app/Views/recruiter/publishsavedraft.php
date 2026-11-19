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
    $firstLetter = strtoupper(substr($recruiter_name, 0, 1));
    $company_name = $recruiter_form['company_display_name'];
    $c_id = $recruiter_form['city_id'];

    $creating_date = $recruiter_form['created_date'];
    // echo $creating_date;

// =================== Recruiter Posting ===================//
     $recruter_post = $db->table('tbl_recruiter_posting');

    $rp_count = $recruter_post->where('user_id', $user_id)
                     ->countAllResults();
  
    $formattedDate = date('d M Y', strtotime($creating_date));
    // ========= latest count =========================//

    $builder = $db->table('tbl_recruiter_posting');

$lp_count = $builder->where('user_id', $user_id)
                    ->where('DATE(created_date)', date('Y-m-d')) // filter by today
                    ->countAllResults();
// echo $db->getLastQuery();


    // example: 07 Jul 2025, 04:00 PM

    $city = $db->table('cities');
    $cityName = $city
    ->where('id',$c_id)
    ->get()
    ->getRowArray();

    $city_name = $cityName['name'];
    $area_name = $recruiter_form['area_name'];
  ?>
  <section class="site-section1" id="next-section">
    
      <div class="container-fluid" style="">
        <div class="row">
          <!-- Left Side: Three Vertical Divs -->
          <div class="col-lg-3 py-2">
            <div class="d-flex flex-column"><a href="<?= base_url('recruiter/recruiter_posting_form'); ?>" style="text-decoration: none;">
              <div class="p-4 bg-light border mb-0">
                <h5 class="mb-2 text-black">Post a Job</h5>
              </div></a>
            </div>
             <div class="d-flex flex-column"><a href="<?= base_url('recruiter/recruiter_job_responce'); ?>" style="text-decoration: none;">
              <div class="p-4 bg-light border border-top-0 mb-0">
                <h5 class="mb-2 text-black">Job Responses</h5>
              </div></a>
            </div>
             <div class="d-flex flex-column">
              <div class="p-4 bg-light border border-top-0">
                 <h5 class="mb-2 text-black">Manage Sub-Users</h5>
              </div>
            </div>
          </div>

          <!-- Right Side: Main Content Divided in Two Parts -->
         <div class="col-lg-9 py-2">
            <div class="row">
              <!-- Left Half (Top Content) -->
              <div class="col-md-6 mb-3">
                <div class="p-4 bg-white border rounded shadow-sm h-100">
                  <h3 class="mb-2">Job Post</h3>
                  <p>Creating Recruiter Date   : <span class="font-weight-bold-medium"><?= esc($formattedDate) ?></span></p>
                  <p> Posting Count   : <span class="font-weight-bold-medium"><?= esc($rp_count) ?></span></p>
                  <p> current Opening Count   : <span class="font-weight-bold-medium"><?= esc($lp_count) ?></span></p>
                </div>
              </div>

              <!-- Right Half (Bottom Content) -->
              <div class="col-md-6 mb-3">
                <div class="p-4 bg-white border rounded shadow-sm h-100">
                  <h3 class="mb-2">Bottom Content</h3>
                  <p>This is the right half of the main content area.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
  </section>
  

  
     
