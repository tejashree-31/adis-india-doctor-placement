  <?php
  // print_r($data);
  //   exit();
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


    $jobRole = $db->table('tbl_job_role');
    $job_role = $jobRole
    ->where('job_id', $data['job_role'])
    ->get()
    ->getRowArray();

    // ======= city ===============


  
     $city = $db->table('cities');
    $cityName = $city
    ->where('id',$data['city'])
    ->get()
    ->getRowArray();

    $city_name = $cityName['name'];
    // $area_name = $recruiter_form['area_name'];
    
    $min_salary = $data['salary_min'];
    $max_salary = $data['salary_max'];

    $min_experiance = $data['experience_min'];
    $max_experiance = $data['experience_max'];
    $job_description = $data['job_description'];
    $qualification_id = $db->table('tbl_qualification');
                        $qualifaction = $qualification_id
                            ->where('qual_id',$data['qualification'])
                            ->get()
                            ->getRowArray();
  $qualifaction_name = $qualifaction['qualification_name'];

  $department_id = $db->table('tbl_department');
                        $department = $department_id
                            ->where('department_id ',$data['department'])
                            ->get()
                            ->getRowArray();
  $department_name = $department['department_name'];

  $course_id = $db->table('tbl_course');
                        $course = $course_id
                            ->where('course_id ',$data['course'])
                            ->get()
                            ->getRowArray();
  $course_name = $course['course_name'];


  $gender = isset($data['gender']) 
          ? (is_array($data['gender']) ? implode(' / ', $data['gender']) : $data['gender']) 
          : 'Not selected';

  $number_of_vacuncy = $data['vacancies'];

  ?>
  <style type="text/css">
      .site-section
    {
      background:#FBDDDF;
    }
    .bg-primary {
      background: #Ffff !important
    }
   .block__87154.bg-primary {
  box-shadow: 0px 10px 20px rgba(245, 149, 156, 0.4) !important;
  -webkit-box-shadow: 0px 10px 20px rgb(217 98 107 / 40%) !important;
}
.logo-square1 {
    width: 95px;
    height: 87px;
    background-color: FBDDDF;
    color: #F5959C;
    font-weight: bold;
    font-size: 61px;
    display: flex
;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
.my-span {
  font-style: normal;    
  font-size: 16px;
  font-family: Montserrat;

}
.title
{
  font-weight: 600;
  font-size: 25px; 
  font-style: normal;
  font-family: Montserrat;

}
.title-head
{
   font-weight: 600;
   font-style: normal;    
  font-size: 18px;
  font-family: Montserrat;
}

  </style>
<section class="site-section" id="next-section" style="padding-top: 0rem; ;">
      <div class="container">
          <div class="col-lg-12 mb-4">
            <div class="block__87154 bg-primary d-flex align-items-center">
              <div class="logo-square1 mr-3">
              <?= esc($firstLetter) ?>  
              </div> 
              <div class="text-black">
                  <p class="mb-1"><span class="title"><?= esc($job_role['job_role'] ?? 'Not selected') ?></span></p>
                  <p class="mb-0"><span class="my-span"><?= esc($recruiter_name ?? 'Not selected') ?></span></p>
                  <p class="mb-1"><i class="bi bi-geo-alt-fill" style="font-size: 17px;"></i>&nbsp;<span class="my-span"><?= esc($city_name ?? 'Not selected') ?>&nbsp;&nbsp;&nbsp;&nbsp;</span><i class="bi bi-briefcase" style="font-size: 17px;"></i>&nbsp;<span class="my-span"><?= esc($min_experiance) ?> Years - <?= esc($max_experiance) ?> Years </span>&nbsp;&nbsp;&nbsp;<i class="bi bi-wallet2" style="font-size: 17px;"></i> <span class="my-span"> <?= esc($min_salary ?? 'Not selected') ?> INR - <?= esc($max_salary ?? 'Not selected') ?> INR</span></p>
              </div>
              
            </div>
          </div>

  <div class="col-lg-12 mb-4">
  <div class="block__87154 bg-primary p-4 rounded">
    
    <p class="mb-3 text-black"><span class="title">Job Description</span></p>

    <!-- Main Job Description -->
    <p><span class="my-span"><?= esc($job_description ?? 'Not selected') ?></span></p>

    <div class="row">
      <!-- Left Column -->
      <div class="col-lg-1 mb-3">
      </div>
      <div class="col-lg-5 mb-3">
        <p><span class="title-head text-black">Employee Type : </span>&nbsp;   <span class="my-span text-black"><?= esc($job_description ?? 'Not selected') ?></span></p>
      </div>

      <!-- Right Column -->
      <div class="col-lg-5 mb-3">
       <p><span class="title-head text-black">Qualification : </span>&nbsp;   <span class="my-span text-black"><?= esc($qualifaction_name ?? 'Not selected') ?></span></p>
      </div>
      <div class="col-lg-1 mb-3">
      </div>
    </div>

    <div class="row">
      <!-- Left Column -->
      <div class="col-lg-1 mb-3">
      </div>
      <div class="col-lg-5 mb-3">
        <p><span class="title-head text-black">Job Role : </span>&nbsp;   <span class="my-span text-black"><?= esc($job_role['job_role'] ?? 'Not selected') ?></span></p>
      </div>

      <!-- Right Column -->
      <div class="col-lg-5 mb-3">
       <p><span class="title-head text-black">Department : </span>&nbsp;   <span class="my-span text-black"><?= esc($department_name ?? 'Not selected') ?></span></p>
      </div>
      <div class="col-lg-1 mb-3">
      </div>
    </div>

    <div class="row">
      <!-- Left Column -->
      <div class="col-lg-1 mb-3">
      </div>
      <div class="col-lg-5 mb-3">
        <p><span class="title-head text-black">Course : </span>&nbsp;   <span class="my-span text-black"><?= esc($course_name ?? 'Not selected') ?></span></p>
      </div>

      <!-- Right Column -->
      <div class="col-lg-5 mb-3">
       <p><span class="title-head text-black">Gender : </span>&nbsp;   <span class="my-span text-black"><?= esc($gender ?? 'Not selected') ?></span></p>
      </div>
      <div class="col-lg-1 mb-3">
      </div>
    </div>
    <div class="row">
      <!-- Left Column -->
      <div class="col-lg-1 mb-3">
      </div>
      <div class="col-lg-5 mb-3">
        <p><span class="title-head text-black">Number Of Vacancies : </span>&nbsp;   <span class="my-span text-black"><?= esc($number_of_vacuncy ?? 'Not selected') ?></span></p>
      </div>

    
    </div>

    <!-- Update Button Centered -->
    
    <div class="text-center mt-4">
      <button type="submit" name="action" class="btn btn-primary btn-lg border-width-2 d-none d-lg-inline-block" style="border-radius: 20px;" fdprocessedid="2xwcjl">Save Draft</button>&nbsp;
      <!-- <button type="submit" class="btn btn-primary btn-lg border-width-2 d-none d-lg-inline-block" style="border-radius: 20px;" fdprocessedid="2xwcjl">Cancel</button>&nbsp; -->
       <button type="button" onclick="history.back()" class="btn btn-primary btn-lg px-4" style="border-radius: 20px;"> Cancel </button>
      <button type="submit" class="btn btn-primary btn-lg border-width-2 d-none d-lg-inline-block" style="border-radius: 20px;" fdprocessedid="2xwcjl">Publish</button>
    </div>

  </div>
</div>

          </div>
      </div>
  </section>