<?php
 // print_r($_SESSION['uid']);
 // exit();
use Config\Database;
$db = Database::connect();
 $posting_id = $data['posting_id'];

$session = session();
$user_id = $session->get('uid');



$builder = $db->table('tbl_recruiter');
$recruiter_form = $builder->where('uid', $user_id)->get()->getRowArray();
$recruiter_name = $recruiter_form['recruiter_name'] ?? '';
$firstLetter = strtoupper(substr($recruiter_name, 0, 1));

// Job Role
$jobRole = $db->table('tbl_job_role');
$job_role = $jobRole->where('job_id', $data['job_id'])->get()->getRowArray();

// City
$city = $db->table('cities');
$cityName = $city->where('id', $data['city_id'])->get()->getRowArray();
$city_name = $cityName['name'] ?? 'Not selected';

// Salary & Experience
$min_salary = $data['salary_min'];
$max_salary = $data['salary_max'];
$min_experience = $data['experience_min'];
$max_experience = $data['experience_max'];

// Description
$job_description = $data['job_description'] ?? 'Not provided';

// Qualification
$qualifaction = $db->table('tbl_qualification')->where('qual_id', $data['qual_id'])->get()->getRowArray();
$qualifaction_name = $qualifaction['qualification_name'] ?? 'Not selected';

// Department
$department = $db->table('tbl_department')->where('department_id', $data['department_id'])->get()->getRowArray();
$department_name = $department['department_name'] ?? 'Not selected';

// Course
$course_name = 'Not selected';
if (!empty($data['course_id'])) {
    $course = $db->table('tbl_course')->where('course_id', $data['course_id'])->get()->getRowArray();
    $course_name = $course['course_name'] ?? 'Not selected';
}

// Gender & Vacancy
$gender = isset($data['gender']) ? (is_array($data['gender']) ? implode(' / ', $data['gender']) : $data['gender']) : 'Not selected';
$number_of_vacuncy = $data['vacancies'];
$employment_type = $data['employment_type'] ?? 'Not selected';
?>

<style>
  .site-section { background: #FBDDDF; }
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
  p{
  font-style: normal;
    font-size: 16px;
    font-family: Montserrat;
    color: #000;
}
ol{
  font-style: normal;
    font-size: 16px;
    font-family: Montserrat;
    color: #000;
}
ul{
  font-style: normal;
    font-size: 16px;
    font-family: Montserrat;
    color: #000;
}
</style>

<section class="site-section" id="next-section">
  <div class="container">
    <div class="col-lg-12 mb-4">
      <div class="block__87154 bg-primary1 d-flex align-items-center">
        <div class="logo-square1 mr-3"><?= esc($firstLetter) ?></div>
        <div class="text-black">
          <p class="mb-1">
            <span class="title">
                <?= esc($job_role['job_role'] ?? 'Not selected') ?>

            </span></p>
          <p class="mb-0"><span class="my-span"><?= esc($recruiter_name) ?></span></p>
          <p class="mb-1">
            <i class="bi bi-geo-alt-fill" style="font-size: 17px;"></i>
            <span class="my-span"><?= esc($city_name) ?>&nbsp;&nbsp;&nbsp;</span>
            <i class="bi bi-briefcase" style="font-size: 17px;"></i>
            <span class="my-span"><?= esc($min_experience) ?> Years - <?= esc($max_experience) ?> Years</span>&nbsp;&nbsp;&nbsp;
            <i class="bi bi-wallet2" style="font-size: 17px;"></i>
            <span class="my-span"><?= esc($min_salary) ?> INR - <?= esc($max_salary) ?> INR</span>
          </p>
        </div>
      </div>
    </div>

    <div class="col-lg-12 mb-4">
      <div class="block__87154 bg-primary1 p-4 rounded">
        <p class="mb-3 text-black"><span class="title">Job Description</span></p>
        <p><span class="my-span"><?= $job_description ?></span></p>

        <div class="row">
          <div class="col-lg-1 mb-3"></div>
          <div class="col-lg-5 mb-3">
            <p><span class="title-head text-black">Employee Type :</span> <span class="my-span text-black"><?= esc($employment_type) ?></span></p>
          </div>
          <div class="col-lg-5 mb-3">
            <p><span class="title-head text-black">Qualification :</span> <span class="my-span text-black"><?= esc($qualifaction_name) ?></span></p>
          </div>
          <div class="col-lg-1 mb-3"></div>
        </div>

        <div class="row">
          <div class="col-lg-1 mb-3"></div>
          <div class="col-lg-5 mb-3">
            <p><span class="title-head text-black">Job Role :</span> <span class="my-span text-black"><?= esc($job_role['job_role'] ?? '') ?></span></p>
          </div>
          <div class="col-lg-5 mb-3">
            <p><span class="title-head text-black">Department :</span> <span class="my-span text-black"><?= esc($department_name) ?></span></p>
          </div>
          <div class="col-lg-1 mb-3"></div>
        </div>

        <div class="row">
          <div class="col-lg-1 mb-3"></div>
          <div class="col-lg-5 mb-3">
            <p><span class="title-head text-black">Course :</span> <span class="my-span text-black"><?= esc($course_name) ?></span></p>
          </div>
          <div class="col-lg-5 mb-3">
            <p><span class="title-head text-black">Gender :</span> <span class="my-span text-black"><?= esc($gender) ?></span></p>
          </div>
          <div class="col-lg-1 mb-3"></div>
        </div>

        <div class="row">
          <div class="col-lg-1 mb-3"></div>
          <div class="col-lg-5 mb-3">
            <p><span class="title-head text-black">Number Of Vacancies :</span> <span class="my-span text-black"><?= esc($number_of_vacuncy) ?></span></p>
          </div>
        </div>

        <!-- Submit Buttons -->
        <form method="post" action="<?= base_url('recruiter/saveorupdate') ?>">
          <input type="hidden" name="post_id" value="<?= esc($posting_id) ?>">
          <!-- <input type="hidden" name="action" id="formAction" value=""> -->

          <div class="text-center mt-4">
            <button type="submit" onclick="setAction('draft')" class="btn btn-primary btn-lg" style="border-radius: 20px;">Save Draft</button>&nbsp;
            <button type="submit"  class="btn btn-primary btn-lg" style="border-radius: 20px;">Cancel</button>&nbsp;
            <button type="submit" onclick="setAction('publish')" class="btn btn-primary btn-lg" style="border-radius: 20px;">Publish</button>
          </div>
        </form>

        <script>
          function setAction(val) {
            document.getElementById('formAction').value = val;
          }
        </script>

      </div>
    </div>
  </div>
</section>
