<style>
  .site-section { background: #FBDDDF; }
  .bg-primary1 { background: #fff !important; }
  .block__87154.bg-primary {
    box-shadow: 0px 10px 20px rgba(245, 149, 156, 0.4) !important;
  }
  .logo-square1 {
    width: 95px; height: 87px;
    background-color: #FBDDDF; color: #F5959C;
    font-weight: bold; font-size: 61px;
    display: flex; justify-content: center; align-items: center;
    border-radius: 4px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
    margin-right: 15px;
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

  /* ✅ Align logo & name properly */
  .block__87154.bg-primary1.d-flex.align-items-center {
    align-items: center !important;
  }

  .text-black {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .text-black .title {
    display: inline-block;
    white-space: normal;
    word-wrap: break-word;
    line-height: 1.3;
  }

  .logo-box {
    position: relative;
    width: 100%;
    height: 100%;
  }

  .camera-icon {
    position: absolute;
    bottom: -6px;
    right: -6px;
    font-size: 20px;
    cursor: pointer;
    color: #f5959c;
  }


  /* 🔹 Responsive adjustments */
  @media (max-width: 767px) {
    .logo-square1 {
      width: 100px; height: 100px;
      font-size: 35px;
      margin-right: 0 !important;
      margin-bottom: 10px !important;
    }
    .title { font-size: 18px; }
    .title-head { font-size: 16px; }
    .my-span { font-size: 14px; }

    .block__87154.bg-primary1.d-flex.align-items-center {
      flex-direction: column !important;
      text-align: center !important;
      align-items: center !important;
      padding: 15px;
      margin-top: 60px;
    }

    .text-black {
      align-items: center;
    }

    .text-center.mt-4 button {
      width: 100%;
      margin-bottom: 10px;
    }
    .row .col-lg-1 { display: none; }
  }
</style>

<?php 
use Config\Database;
$db = Database::connect();
$full_name= $jobseeker_display['full_name'];
$firstLetter = strtoupper(substr($full_name, 0, 1));

// =====================================01-07-2026 =============================//
$languages = $db->query("SELECT * FROM  tbl_languages")->getResultArray();
$licensing_registration = $db->query("SELECT * FROM tbl_licensing_registration")->getResultArray();
$ud_medical_degree = $db->query("SELECT * FROM tbl_ug_medical_degree")->getResultArray();
$post_degree = $db->query("SELECT * FROM tbl_post_degree")->getResultArray();
$international_degree = $db->query("SELECT * FROM tbl_international_degree")->getResultArray();
$superspeciality_degree = $db->query("SELECT * FROM tbl_superspeciality_degree")->getResultArray();


$experience = $db->table('tbl_jobseeker_experience')
    ->where('jobseeker_id', $jobseeker_display['jobseeker_id'])
    ->get()
    ->getResultArray();

$data['experience'] = $experience;
?>

<section class="site-section" id="next-section">
  <div class="container">

    <!-- Profile Header -->
    <div class="col-lg-12 mb-4">
      <div class="block__87154 bg-primary1 d-flex align-items-center rounded p-3">
        <div class="logo-square1">
          <div class="logo-box" id="logoDisplay_jobseeker">
            <?php if (!empty($jobseeker_display) && !empty($jobseeker_display['profile_image'])): ?>
              <img src="<?= base_url('jobseeker/profile_image/' . $jobseeker_display['profile_image']) ?>" 
                   id="logoImage_jobseeker" alt="Profile Image" 
                   style="width:100%; height:100%; object-fit:cover;">
            <?php else: ?>
              <span id="initialLetter"><?= esc($firstLetter) ?></span>
            <?php endif; ?>
            <!-- Upload trigger -->
            <label for="imageUpload_jobseeker" class="camera-icon">&#x1F4F7;</label>
          </div>
          <input type="file" id="imageUpload_jobseeker" name="compny_profile" hidden>
        </div>

        <div class="text-black">
          <p class="mb-1"><span class="title"><?= esc($full_name) ?></span></p>
          <p class="mb-1">
            <i class="bi bi-geo-alt-fill" style="font-size: 17px;"></i>
            <span class="my-span"><?= $jobseeker_display['city_name'] ?></span>&nbsp;&nbsp;
            <i class="bi bi-telephone-fill" style="font-size: 17px;"></i>
            <span class="my-span"><?= $jobseeker_display['mobile_number'] ?></span>&nbsp;&nbsp;
            <i class="bi bi-envelope-fill" style="font-size: 17px;"></i>
            <span class="my-span"><?= $jobseeker_display['email'] ?></span>
          </p>
        </div>
      </div>
    </div>

    <!-- Job Description -->
    <div class="col-lg-12 mb-4">
      <div class="block__87154 bg-primary1 p-4 rounded">
        <div class="tab-pane fade show active" id="publish_update">
          <div class="container-fluid py-4">
            <form action="<?= base_url('jobseeker/update_jobseeker') ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="jobseeker_id" value="<?= isset($jobseeker_display['jobseeker_id']) ? esc($jobseeker_display['jobseeker_id']) : '' ?>">
              <input type="hidden" name="user_id" value="<?= isset($jobseeker_display['uid']) ? esc($jobseeker_display['uid']) : '' ?>">
              <h5 class="text-primary head-title">Edit Jobseeker Profile</h5>
              <!-- ===========================01-07-2026  =========================================== -->
              <div class="form-row align-items-end">
                <div class="form-group">

                    <label class="insurance-label1">
                        How would you like to proceed with your CV?
                    </label>

                    <div class="insurance-choice">

                        <label class="insurance-chip cv-chip">
                            <input type="radio"
                                   name="cv_option"
                                   value="yes"
                                   <?= (isset($jobseeker_display['cv_option']) && $jobseeker_display['cv_option'] == 'yes') ? 'checked' : ''; ?>>
                            <span>
                                📁 I Already Have a CV
                            </span>
                        </label>

                        <label class="insurance-chip cv-chip">
                            <input type="radio"
                                   name="cv_option"
                                   value="no"
                                   <?= (isset($jobseeker_display['cv_option']) && $jobseeker_display['cv_option'] == 'no') ? 'checked' : ''; ?>>
                            <span>
                                👑 Build My Premium CV
                            </span>
                        </label>

                    </div>

                </div>
              </div>
              <div class="row" id="resume_upload_section" style="display:none;">
                <div class="col-md-6 mt-2">
                  <label for="industry">CV (Resume)</label>
                  <input type="file" class="" name="resume" id="resume" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                  <div id="resumeDisplay" style="margin-top:10px; font-weight:bold;">
                    <?php if(isset($jobseeker_display['resume']) && $jobseeker_display['resume'] != ''): ?>
                      Selected file: 
                      <a href="<?= base_url('jobseeker/resume/' . $jobseeker_display['resume']) ?>" download> 
                        <i class="bi bi-download"></i> <?= esc($jobseeker_display['resume']) ?>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- ===========================01-07-2026  =========================================== -->

              <div class="row">
                <div class="col-md-6 mt-2">
                  <p class="mb-2 text-secondary">Full Name</p>
                  <input type="text" class="form-control form-control-md" name="full_name" id="full_name" value="<?= $jobseeker_display['full_name'] ?>">
                </div>
                <div class="col-md-6 mt-2">
                    <p class="mb-2 text-secondary">Job Role</p>
                    <?php
                    $selectedJobId = !empty($jobseeker_display['job_id']) ? $jobseeker_display['job_id'] : '';
                    ?>
                    <select class="job-role-select selectpicker form-control"
                            name="job_role"
                            data-live-search="true"
                            data-size="5">
                      <?php foreach ($job_role as $role): ?>
                        <option value="<?= esc($role['job_id']) ?>"
                                <?= ($role['job_id'] == $selectedJobId) ? 'selected' : '' ?>>
                          <?= esc($role['job_role']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                 </div>
              </div>

              <div class="row">
                 <div class="col-md-6 mt-2">
                  <label for="qualification_job" class="form-label d-flex justify-content-between">
                    <span>Category <span style="color:red;">*</span></span>
                  </label>
                  <select class="form-control form-control-md" name="education" id="qualification_job_edit" data-live-search="true" data-size="5" required>
                    <option value="">Select Category</option>
                    <?php foreach ($qualifications as $q): ?>
                      <option value="<?= esc($q['qual_id']) ?>" <?= (isset($jobseeker_display['education']) && $jobseeker_display['education'] == $q['qual_id']) ? 'selected' : '' ?>>
                        <?= esc($q['qualification_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-6 mt-2" id="coursesDiv_job">
                  <label for="course">Higher Qualification 
                  </label>
                  <select class="form-control form-control-md" name="course" id="course_job_edit" data-live-search="true" required>
                    <option value="">Select Courses</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mt-2">
                  <label for="email">Email</label>
                  <input type="email" class="form-control form-control-md" name="email" id="email" value="<?= $jobseeker_display['email']?>" readonly>
                </div>
                <div class="col-md-6 mt-2">
                  <label for="company-website-fb">Mobile Number</label>
                  <input type="text" class="form-control form-control-md" name="mobile_number" id="company-website-fb" value="<?= $jobseeker_display['mobile_number']?>" >
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mt-2">
                 
                      <label for="company-website-fb" style="color:#7f848c;">Marital Status</label><br>

                      <?php $marital = $jobseeker_display['marital_status'] ?? ''; ?>

                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="marital_status" id="married" value="Married"
                              <?= ($marital == 'Married') ? 'checked' : '' ?>>
                          <label class="form-check-label" for="married">Married</label>
                      </div>

                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="marital_status" id="unmarried" value="Never Married"
                              <?= ($marital == 'Never Married') ? 'checked' : '' ?>>
                          <label class="form-check-label" for="unmarried">Unmarried</label>
                      </div>

                
                </div>

                <?php $spouse = $jobseeker_display['spouse_type'] ?? ''; ?>

                <div class="col-md-6 mt-2" id="spouseField" style="display:none;">
                    <label for="company-website-fb" style="color:#7f848c;">Spouse Profession Type</label><br>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="spouse_type" value="Medical"
                            <?= ($spouse == 'Medical') ? 'checked' : '' ?>>
                        <label class="form-check-label">Medical</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="spouse_type" value="Non-Medical"
                            <?= ($spouse == 'Non-Medical') ? 'checked' : '' ?>>
                        <label class="form-check-label">Non-Medical</label>
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mt-2">
                  <label for="job-region">Current City</label>
                  <select class="form-control form-control-md selectpicker" name="current_city" id="current_city" data-live-search="true" data-size="5" title="City/Town">
                    <option value="">Anywhere</option>
                    <?php 
                      $locations = $db->query("SELECT * FROM cities")->getResultArray();
                      $selectedCity = isset($jobseeker_display['current_city']) ? $jobseeker_display['current_city'] : '';
                      foreach ($locations as $location): 
                        $isSelected = ($location['id'] == $selectedCity) ? 'selected' : '';
                    ?>
                      <option value="<?= esc($location['id']) ?>" <?= $isSelected ?>><?= esc($location['name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6 mt-2">
                  <label for="expected_cities">Interested Location</label>
                  <select class="form-control selectpicker" id="expected_cities" name="expected_cities[]" multiple data-live-search="true" data-size="5" data-actions-box="true" required>
                    <?php 
                      $selectedCities = [];
                      if (isset($jobseeker_display['expected_cities']) && $jobseeker_display['expected_cities'] != '') {
                        $selectedCities = explode(',', $jobseeker_display['expected_cities']);
                      }
                      foreach ($locations as $location):
                        $isSelected = in_array((string)$location['id'], $selectedCities) ? 'selected' : '';
                    ?>
                      <option value="<?= esc($location['id']) ?>" <?= $isSelected ?>><?= esc($location['name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row mt-2">
              
                <div class="col-md-12">
                  <label for="email">Permanent Address </label>
                  <textarea class="form-control" name="candidate_full_address"><?= isset($jobseeker_display['candidate_full_address']) ? esc($jobseeker_display['candidate_full_address']) : '' ?></textarea>
                  <!-- <div class="invalid-feedback">Please enter Details
                  .</div> -->
                </div>
            </div>
              <div class="row">
                <div class="col-md-12 mt-2">
                  <label for="email">Additional Qualification</label>
                  <textarea class="form-control" name="fellowship"><?= isset($jobseeker_display['fellowship']) ? esc($jobseeker_display['fellowship']) : '' ?></textarea>
                </div>
              </div>

              <div class="row mt-2 insuranceDiv" style="display:none;">
                <div class="col-md-6">
                    <label for="expected_cities">Do you have an professional insurance policy?</label>

                    <div class="insurance-choice">

                        <label class="insurance-chip">
                         <input type="radio" name="insurance_policy" value="Yes" <?= (set_value('insurance_policy', $jobseeker_display['insurance_policy'] ?? '') == 'Yes') ? 'checked' : ''; ?>>
                            <span>Yes</span>
                        </label>

                        <label class="insurance-chip">
                           <input type="radio" name="insurance_policy" value="No" <?= (set_value('insurance_policy', $jobseeker_display['insurance_policy'] ?? '') == 'No') ? 'checked' : ''; ?>>
                            <span>No</span>
                        </label>

                    </div>
                </div>
              </div>
              <div id="cv_plan_section" style="display:none; margin-top:0px;">
                <div style=" display:flex; align-items:center; font-size:16px; font-weight:600; color:#b8860b;">
                    <span style="flex:1; height:1px; background:#e6c75a;"></span>

                    <span style="padding:0 15px;">
                        👑 Advanced Career Details
                    </span> <span style="flex:1; height:1px; background:#e6c75a;"></span>
                </div>



                  <div class="edit-premium-photo-card">

                            <div class="edit-photo-header">
                                📸 Profile Photo
                            </div>

                            <input type="file"
                                   id="edit_candi_profile_imageInput"
                                   name="candidate_job_profile"
                                   accept="image/*">

                            <div class="row">

                                <div class="col-md-5 text-center">

                                    <div class="edit-preview-title">
                                        Profile Preview
                                    </div>

                                    <img id="edit_candi_profile_preview"
                                         src="<?= !empty($jobseeker_display['candi_profile_cropped_image']) ? base_url('jobseeker/candidate_job_profile/'.$jobseeker_display['candi_profile_cropped_image']) : '' ?>"
                                         style="<?= !empty($jobseeker_display['candi_profile_cropped_image']) ? 'display:block;max-width:200px;' : 'display:none;max-width:200px;' ?>">

                                </div>

                                <div class="col-md-7">

                                    <div class="edit-crop-area" style="display:none;">
                                        <img id="edit_candi_profile_imagePreview" style="max-width:100%;">
                                    </div>

                                </div>

                            </div>

                              <button type="button"
                                      id="edit_candi_profile_cropBtn"
                                      class="btn btn-warning btn-sm mt-3"
                                      style="display:none;">
                                  ✂ Crop & Apply
                              </button>

                              <input type="hidden"
                             id="edit_candi_profile_cropped_image"
                             name="candi_profile_cropped_image">

                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Birth Date</label>
                        <input type="date" name="birth_date" class="form-control" value="<?= set_value('birth_date', $jobseeker_display['birth_date'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label>Gender</label>
                        <select name="gender" class="form-control" style="padding: 7px 12px;">
                            <option value="">Select Gender</option>
                            <option value="Male" <?= ($jobseeker_display['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= ($jobseeker_display['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= ($jobseeker_display['gender'] ?? '') == 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                  </div>

                  <div class="row mt-2">
                  </div>

                  <div class="row mt-2">
                     <?php
                        $selectedLanguages = !empty($jobseeker_display['language_name'])
                            ? explode(',', $jobseeker_display['language_name'])
                            : [];
                        ?>

                      <div class="col-md-12">
                          <label for="language_name">Languages Known</label>

                          <select class="form-control selectpicker"
                                  id="language_name"
                                  name="language_name[]"
                                  multiple
                                  data-live-search="true"
                                  data-actions-box="false"
                                  title="Languages Known"
                                  data-selected-text-format="count > 15"
                                  data-size="5">

                              <?php foreach ($languages as $lang): ?>
                                  <option value="<?= esc($lang['lang_id']) ?>"
                                      <?= in_array($lang['lang_id'], $selectedLanguages) ? 'selected' : '' ?>>
                                      <?= esc($lang['language_name']) ?>
                                  </option>
                              <?php endforeach; ?>

                          </select>

                          <div id="expectedCitiesError" class="text-danger mt-1" style="display:none;">
                              Please select Languages
                          </div>
                      </div>
                  </div>
               
                  <div class="row mt-2">
                    <div class="col-md-8">
                       <label for="job-region">licensing Registration</label>
                      <select class="form-control form-control-md selectpicker" name="lire_id" id="lice_reg_name"
                          data-size="5" data-live-search="true" title="Licensing Registration">

                          <?php foreach ($licensing_registration as $lice_reg): ?>
                              <option value="<?= esc($lice_reg['lire_id']) ?>"
                                  <?= (set_value('lire_id', $jobseeker_display['lire_id'] ?? '') == $lice_reg['lire_id']) ? 'selected' : ''; ?>>
                                  <?= esc($lice_reg['lice_reg_name']) ?>
                              </option>
                          <?php endforeach; ?>

                      </select>
                    </div>
                    <div class="col-md-4">
                          <label>Registration No.:</label>
                         <input type="text" name="licen_registration_number" class="form-control" placeholder="Registration No" value="<?= set_value('licen_registration_number', $jobseeker_display['licen_registration_number'] ?? '') ?>">
                    </div>
                  </div>


                  <div class="row mt-2">
                    <div class="col-md-6">
                       <label for="job_role" class="form-label">Specialization</label>
                          
                        <select class="form-control form-control-md selectpicker" name="speci_id" id="specialization_name" data-live-search="true" data-size="5" title="Specialization">
                         <option value="">Select Specialization</option>
                            <?php foreach ($job_role as $role): ?>
                                <option value="<?= esc($role['job_id']) ?>"
                                    <?= (set_value('speci_id', $jobseeker_display['speci_id'] ?? '') == $role['job_id']) ? 'selected' : ''; ?>>
                                    <?= esc($role['job_role']) ?>
                                </option>
                            <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                          <label>Total Experience</label>

                          <div class="row">
                              <div class="col-6">
                                  <select name="experience_years" id="experience_years" class="form-control form-control-md selectpicker" data-live-search="true" data-size="5">
                                    <option value="">Years</option>
                                    <?php for($i = 0; $i <= 50; $i++): ?>
                                        <option value="<?= $i ?>"
                                            <?= (set_value('experience_years', $jobseeker_display['experience_years'] ?? '') == $i) ? 'selected' : ''; ?>>
                                            <?= $i ?> Year<?= $i != 1 ? 's' : '' ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                              </div>

                              <div class="col-6">
                                  <select name="experience_months" id="experience_months" class="form-control form-control-md selectpicker" data-live-search="true" data-size="5">
                                      <option value="">Months</option>
                                      <?php for($i = 0; $i <= 11; $i++): ?>
                                          <option value="<?= $i ?>"
                                              <?= (set_value('experience_months', $jobseeker_display['experience_months'] ?? '') == $i) ? 'selected' : ''; ?>>
                                              <?= $i ?> Month<?= $i != 1 ? 's' : '' ?>
                                          </option>
                                      <?php endfor; ?>
                                  </select>
                              </div>
                          </div>
                    </div>

                  </div>

                 <div class="row mt-2">
                    <div class="col-md-6">
                       <label for="job_role" class="form-label">Under Graduation</label>
                          
                          <select class="form-control form-control-md selectpicker" name="ug_id" id="ug_name" data-live-search="true" data-size="5" title="Under Graduation">

                              <option value="">Select Under Graduation</option>
                              <?php foreach ($ud_medical_degree as $ug_degree): ?>
                                  <option value="<?= esc($ug_degree['ug_id']) ?>"
                                      <?= (set_value('ug_id', $jobseeker_display['ug_id'] ?? '') == $ug_degree['ug_id']) ? 'selected' : ''; ?>>
                                      <?= esc($ug_degree['ug_name']) ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="industry">Under Graduation Passing Year</label>
                       <input type="month" id="ug_passing_month" name="ug_year_month" value="<?= esc($jobseeker_display['ug_year_month'] ?? '') ?>" class="form-control form-control-md">
                    </div>
                 </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                      <label for="industry">Under Graduation College Name</label>
                      <input type="text"
                       class="form-control form-control-md"
                       name="ug_clg_name"
                       id="full_name"
                       placeholder="Under Graduation College Name"
                       value="<?= esc($jobseeker_display['ug_clg_name'] ?? '') ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                      <label for="job_role" class="form-label">Post Graduation</label>
                          <select class="form-control form-control-md selectpicker" name="pg_id" id="pg_id" data-live-search="true" data-size="5" title="Post Graduation">
                            <?php foreach ($post_degree as $pg_degree): ?>
                                <option value="<?= esc($pg_degree['pg_id']) ?>"
                                    <?= (set_value('pg_id', $jobseeker_display['pg_id'] ?? '') == $pg_degree['pg_id']) ? 'selected' : ''; ?>>
                                    <?= esc($pg_degree['pg_name']) ?>
                                </option>
                            <?php endforeach; ?>
                          </select>
                    </div>
                    <div class="col-md-6">
                        <label for="industry">Post Graduation Passing Year</label>
                        <input type="month" id="pg_passing_month" name="pg_year_month" class="form-control form-control-md" value="<?= esc($jobseeker_display['pg_year_month'] ?? '') ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                      <label for="industry">Post Graduation College Name</label>
                        <input type="text" class="form-control form-control-md" name="pg_clg_name"
                          id="pg_name" placeholder="Post Graduation College Name" value="<?= esc($jobseeker_display['pg_clg_name'] ?? '') ?>">
                    </div>
                  </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                       <label for="job_role" class="form-label">International Qualification</label>
                          
                          <select class="form-control form-control-md selectpicker" name="int_degree_id" id="int_degree_id" data-live-search="true" data-size="5" title="International Qualification">

                              <option value="">Select International Qualification</option>
                               <?php foreach ($international_degree as $int_deg): ?>
                                  <option value="<?= esc($int_deg['int_degree_id']) ?>"
                                      <?= (set_value('int_degree_id', $jobseeker_display['int_degree_id'] ?? '') == $int_deg['int_degree_id']) ? 'selected' : ''; ?>>
                                      <?= esc($int_deg['inq_name']) ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
                    </div>
                    <div class="col-md-6">
                      <label for="industry" class="form-label">International Passing Year </label>
                        <input type="month" id="iq_passing_month" name="iq_year_month"
                          class="form-control form-control-md" value="<?= esc($jobseeker_display['iq_year_month'] ?? '') ?>">
                    </div>
                    
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                      <label for="industry">International College Name</label>
                      <input type="text" class="form-control form-control-md"
                        name="iq_clg_name" id="iq_name" placeholder="Int Qul College Name" value="<?= esc($jobseeker_display['iq_clg_name'] ?? '') ?>">
                    </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-6">
                    <label for="job_role" class="form-label">Superspeciality Degrees</label>
                          
                          <select class="form-control form-control-md selectpicker" name="sup_id" id="sup_id" data-live-search="true" data-size="5" title="Superspeciality Degrees">

                              <option value="">Select Superspeciality Degrees</option>
                               <?php foreach ($superspeciality_degree as $sup_degree): ?>
                                    <option value="<?= esc($sup_degree['sup_id']) ?>"
                                        <?= (set_value('sup_id', $jobseeker_display['sup_id'] ?? '') == $sup_degree['sup_id']) ? 'selected' : ''; ?>>
                                        <?= esc($sup_degree['superspeciality_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                          </select>
                  </div>
                  <div class="col-md-6">
                    <label for="job_role" class="form-label">Superspeciality Deg Passing Year</label>
                     <input type="month" id="iq_passing_month" name="sup_year_month"
                          class="form-control form-control-md" value="<?= esc($jobseeker_display['sup_year_month'] ?? '') ?>">
                  </div>
                </div>
                <div class="row mt-2">

                    <div class="col-md-12">
                        <label>Key Skills</label>
                       <textarea class="ckeditor" name="key_skills"><?= set_value('key_skills', $jobseeker_display['key_skills'] ?? '') ?></textarea>
                    </div>

                    <div class="col-md-12">
                        <label>Publications</label>
                       <textarea class="ckeditor" name="publications"><?= set_value('publications', $jobseeker_display['publications'] ?? '') ?></textarea>
                    </div>

                    <div class="col-md-12">
                        <label>Conference Attended</label>
                        <textarea class="ckeditor" name="conference_attended"><?= set_value('conference_attended', $jobseeker_display['conference_attended'] ?? '') ?></textarea>
                    </div>

                </div>

                 <div class="row mt-2">
                      <div class="form-group col-md-12">

                          <label class="insurance-label1">
                              Do you have a LinkedIn profile?
                          </label>

                          <div class="insurance-choice">

                              <label class="insurance-chip">
                                  <input type="radio"
                                         name="linkdin_profile"
                                         value="Yes"
                                         <?= (set_value('linkdin_profile', $jobseeker_display['linkdin_profile'] ?? '') == 'Yes') ? 'checked' : ''; ?>>
                                  <span>Yes</span>
                              </label>

                              <label class="insurance-chip">
                                  <input type="radio"
                                         name="linkdin_profile"
                                         value="No"
                                         <?= (set_value('linkdin_profile', $jobseeker_display['linkdin_profile'] ?? '') == 'No') ? 'checked' : ''; ?>>
                                  <span>No</span>
                              </label>

                          </div>

                          <!-- Hidden Textbox -->
                          <div id="linkedin_url_div" style="display:none; margin-top:15px;">
                                <input type="url" name="linkedin_url" class="form-control" placeholder="https://www.linkedin.com/in/your-profile" value="<?= set_value('linkedin_url', $jobseeker_display['linkedin_url'] ?? '') ?>">
                          </div>

                      </div>
                 </div>

                 <div class="row mt-2">
                    <div style="display:flex; align-items:center; margin-bottom:15px;">
                      <span style="flex:1;height:1px;background:#e6c75a;"></span>
                      <span style="padding:0 15px;font-size:16px;font-weight:600;color:#b8860b;">
                          💼 Work Experience
                      </span>
                      <span style="flex:1;height:1px;background:#e6c75a;"></span>
                    </div>
                 </div>
                 <div class="row mt-2">
                  <div id="edit_experience_container">

                     <?php if(!empty($experience)): ?>

                            <?php foreach($experience as $index => $exp): ?>

                            <div class="edit-experience-box">
                               
                                <h6 class="edit-experience-title">
                                    Experience <?= $index + 1 ?>
                                </h6>

                                <?php if($index > 0): ?>
                                    <button type="button" class="editRemoveExperience">&times;</button>
                                <?php endif; ?>

                                <!-- Experience ID -->
                                <input type="hidden"
                                       name="experience_id[]"
                                       value="<?= $exp['experience_id'] ?>">

                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>Organization Name</label>
                                        <input type="text"
                                               name="company_name[]"
                                               class="form-control"
                                               value="<?= esc($exp['company_name']) ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Designation</label>
                                        <input type="text"
                                               name="designation[]"
                                               class="form-control"
                                               value="<?= esc($exp['designation']) ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Start Date</label>
                                        <input type="month"
                                               name="start_date[]"
                                               class="form-control"
                                               value="<?= !empty($exp['start_date']) ? date('Y-m', strtotime($exp['start_date'])) : '' ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>End Date</label>
                                        <input type="month"
                                               name="end_date[]"
                                               class="form-control edit-end-date"
                                               value="<?= !empty($exp['end_date']) ? date('Y-m', strtotime($exp['end_date'])) : '' ?>"
                                               <?= $exp['currently_working'] ? 'disabled' : '' ?>>
                                    </div>

                                    <div class="form-group col-md-12">

                                        <input type="hidden"
                                               name="currently_working[<?= $index ?>]"
                                               value="0">

                                        <div class="form-check">
                                            <input type="checkbox"
                                                   class="form-check-input edit-current-job"
                                                   id="edit_current_job_<?= $index ?>"
                                                   name="currently_working[<?= $index ?>]"
                                                   value="1"
                                                   <?= $exp['currently_working'] ? 'checked' : '' ?>>

                                            <label class="form-check-label"
                                                   for="edit_current_job_<?= $index ?>">
                                                Currently Working Here
                                            </label>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Job Description</label>

                                        <textarea name="job_description[]"
                                                  class="form-control"
                                                  rows="3"><?= esc($exp['job_description']) ?></textarea>

                                    </div>

                                </div>

                            </div>

                          <?php endforeach; ?>

                         <?php else: ?>
                          
                            <div class="edit-experience-box">

                                <h6 class="edit-experience-title">
                                    Experience 1
                                </h6>

                                <input type="hidden" name="experience_id[]" value="">

                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>Organization Name</label>
                                        <input type="text" name="company_name[]" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Designation</label>
                                        <input type="text" name="designation[]" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Start Date</label>
                                        <input type="month" name="start_date[]" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>End Date</label>
                                        <input type="month" name="end_date[]" class="form-control edit-end-date">
                                    </div>

                                    <div class="form-group col-md-12">

                                        <input type="hidden" name="currently_working[0]" value="0">

                                        <div class="form-check">
                                            <input type="checkbox"
                                                   class="form-check-input edit-current-job"
                                                   id="edit_current_job_0"
                                                   name="currently_working[0]"
                                                   value="1">

                                            <label class="form-check-label"
                                                   for="edit_current_job_0">
                                                Currently Working Here
                                            </label>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Job Description</label>
                                        <textarea name="job_description[]" class="form-control" rows="3"></textarea>
                                    </div>

                                </div>

                            </div>

                        <?php endif; ?>
                        <button type="button"
                                id="editAddExperience"
                                class="btn btn-sm btn-outline-primary mt-2">
                            + Add Experience
                        </button>

                  </div>
                 </div>
              </div>

              <div class="row">
                <div class="col-md-6 mt-2">
                  <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
$(document).ready(function() {
    $('#resume').on('change', function() {
        const file = this.files[0];
        const displayDiv = $('#resumeDisplay');
        displayDiv.empty();
        if(file) {
            displayDiv.html('Selected file: ' + file.name);
        }
    });
});
</script>
