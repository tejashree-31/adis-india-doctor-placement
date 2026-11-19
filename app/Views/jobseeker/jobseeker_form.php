<?php $session = session(); 
use Config\Database;
$db = Database::connect();

$job_role = $db->query("SELECT * FROM tbl_job_role")->getResultArray(); 
$email = session()->get('jobseeker_email');
$qualifications = $db->query("SELECT * FROM tbl_qualification")->getResultArray();
$user_id = session()->get('uid');
$user_det = $db->table('tbl_user')
             ->select('*')
             ->where('uid', $user_id)
             ->get()
             ->getRow();
// =====================================24-06-2026 =============================//
$languages = $db->query("SELECT * FROM  tbl_languages")->getResultArray();
$licensing_registration = $db->query("SELECT * FROM tbl_licensing_registration")->getResultArray();
$ud_medical_degree = $db->query("SELECT * FROM tbl_ug_medical_degree")->getResultArray();
$post_degree = $db->query("SELECT * FROM tbl_post_degree")->getResultArray();
$international_degree = $db->query("SELECT * FROM tbl_international_degree")->getResultArray();
$superspeciality_degree = $db->query("SELECT * FROM tbl_superspeciality_degree")->getResultArray();

// ========================== jobseeker experiance =============================//

?>
<style>
/*======================18-06-2026==================*/
.cv-chip{
    min-width:220px;
}

.cv-chip span{
    font-weight:600;
    letter-spacing:.3px;
}

.cv-chip input:checked + span{
    color:#fff;
}
.bootstrap-select .dropdown-toggle {
    border: 2px solid #dee2e6 !important;
}
.experience-box{
    border:1px solid #ececec;
    border-radius:8px;
    padding:15px;
    margin-bottom:15px;
    background:#fff;
    position:relative;
}

.experience-box label{
    font-weight:500;
    font-size:14px;
}

.removeExperience{
    position:absolute;
    top:5px;
    right:5px;

    width:30px;
    height:30px;

    border:none;
    border-radius:50%;

    background:#dc3545;
    color:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    cursor:pointer;
    font-size:18px;
    font-weight:bold;
    line-height:1;

    z-index:999;
}

.form-check-label{
    margin-left:5px;
}


.premium-photo-card{
    border:1px solid #ececec;
    border-radius:12px;
    padding:15px;
    background:#fff;
}

.photo-header{
    font-size:16px;
    font-weight:600;
    color:#b8860b;
    margin-bottom:15px;
}

.crop-area{
    width:220px;
    height:220px;
     overflow:hidden;
    border:1px solid #ddd;
    border-radius:10px;
    background:#f8f9fa;
    margin:auto;
}

#candi_profile_imagePreview{
    max-width:100%;
    display:none;
}

.preview-title{
    font-size:14px;
    font-weight:600;
    margin-bottom:10px;
}

#candi_profile_croppedPreview{
    width:140px;
    height:140px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #fff;
    box-shadow:0 4px 15px rgba(0,0,0,0.15);
    display:none;
    margin-top:15px;
}

</style>

<section class="site-section">
  <div class="container">
    <div class="row">
      
      <!-- 🧭 Left Column: Registration Form -->
      <div class="col-md-7">
        <form class="p-4 p-md-5 border rounded" id="myForm" method="post" enctype="multipart/form-data" action="<?= base_url('jobseeker/save_jobseeker_form') ?>">
          
          <h3 class="text-black mb-5 border-bottom pb-2">Candidate Registration</h3>

            <div class="form-row align-items-end">
                <div class="form-group">

                  <label class="insurance-label1">
                      How would you like to proceed with your CV? <span style="color:red;">*</span>
                  </label>

                    <div class="insurance-choice">

                        <label class="insurance-chip cv-chip">
                            <input type="radio" name="cv_option" value="yes">
                            <span>
                                📁 I Already Have a CV
                            </span>
                        </label>

                        <label class="insurance-chip cv-chip">
                            <input type="radio" name="cv_option" value="no">
                            <span>
                                👑 Build My Premium CV
                            </span>
                        </label><br>

                        <div id="cvOptionError" style="display:none;color: red;">
                            Please select a CV option.
                        </div>

                    </div>

                </div>

            </div>
            <div id="resume_upload_section" style="display:none;">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-7">
                        <label for="resume">
                            CV (Resume) <span style="color:red;">*</span>
                        </label>

                        <input type="file"
                               name="resume"
                               id="resume"
                               class="form-control-file"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">

                        <div class="invalid-feedback" style="display:none;">
                            Please upload your CV.
                        </div>
                    </div>
                </div>
            </div>
         

          <!-- Industry and City -->
          <div class="form-row">
            <div class="form-group col-md-6">
                <label for="industry">Full Name <span style="color:red;">*</span> </label>
                <input type="text" class="form-control form-control-md" name="full_name" id="full_name" placeholder="Full Name"  value="<?= !empty($user_det->full_name) ? esc($user_det->full_name) : '' ?>" required>
                <div class="invalid-feedback">Please Enter Full Name.</div>

            </div>
            <div class="form-group col-md-6">
                <label for="job_role" class="form-label">Job Role(Department) <span style="color:red;">*</span></label>
                            
                <select class="form-control form-control-md selectpicker" name="job_role" id="job_role_jobseeker" data-live-search="true" data-size="5" title="Job Role" required>

                    <?php foreach ($job_role as $role): ?>
                        <option value="<?= esc($role['job_id']) ?>"
                            <?= (isset($user_det->job_id) && $user_det->job_id == $role['job_id']) ? 'selected' : '' ?>>
                            <?= esc($role['job_role']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div> 
          </div>
            <div class="form-row">
              
                <div class="form-group col-md-6">
                    <label for="qualification_job" class="form-label d-flex justify-content-between">
                      <span>Category <span style="color:red;">*</span></span>
                    </label>

                    <select class="form-control form-control-md selectpicker" name="education" id="qualification_job" data-live-search="true" data-size="5" required>
                     
                      <option value="">Select Category</option>
                      <?php foreach ($qualifications as $q): ?>
                        <option value="<?= esc($q['qual_id']) ?>">
                          <?= esc($q['qualification_name']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-6" id="coursesDiv_job">
                  <label for="course">Higher Qualification <span style="color:red;">*</span>
                 
                  </label>
                  <select class="form-control form-control-md" name="course" id="course_job" data-live-search="true" data-size="5" style="padding:0px;" required>
                    <option value="">Select Higher Qualification</option>
                  </select>
               
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="industry">Higher Qualification College Name</label>
                    <input type="text" class="form-control form-control-md" name="hq_clg_name" id="full_name" placeholder="Higher Qual College Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="industry">Higher Qualification Passing Year</label>
                    <input type="month" id="higher_passing_month" name="hq_year_month"
                       class="form-control form-control-md">
                </div>
            </div>
              <!-- Area and Recruiter Name -->
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="job-location">Email Id</label>
                <label for="email">Email</label>
                <input type="email" class="form-control form-control-md" name="email" id="email" value="<?= $email ?>" readonly>
              </div>
              <div class="form-group col-md-6">
                <label for="company-website-fb">Mobile Number</label>
                <input type="text" class="form-control form-control-md" name="mobile_number" id="company-website-fb" value="<?= $user_det->mobile_no ?>" readonly>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                  <label>Marital Status</label><br>

                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="marital_status" id="married" value="Married"
                          <?= (isset($marital_status) && $marital_status == 'Married') ? 'checked' : '' ?>>
                      <label class="form-check-label" for="married">Married</label>
                  </div>

                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="marital_status" id="unmarried" value="Never Married"
                          <?= (isset($marital_status) && $marital_status == 'Never Married') ? 'checked' : '' ?>>
                      <label class="form-check-label" for="unmarried">Unmarried</label>
                  </div>

              </div>
              <div class="form-group col-md-6">
                      <label for="job-region">Current City <span style="color:red;">*</span></label>
                      <select class="form-control form-control-md selectpicker" name="current_city" id="current_city" data-size="5" data-live-search="true" title="City/Town" required>
                        <option value="">Anywhere</option>
                        <?php 
                          $locations = $db->query("SELECT * FROM cities")->getResultArray();
                          foreach ($locations as $location): ?>
                            <option value="<?= esc($location['id']) ?>"><?= esc($location['name']) ?></option>
                        <?php endforeach; ?>
                      </select>
              </div>
            </div>

              <!-- Pincode & Mobile -->
            <div class="form-row">
              <div class="form-group col-md-6" id="spouseField" style="display:none;">
                    <label>Spouse Profession Type</label><br>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="spouse_type" value="Medical">
                        <label class="form-check-label">Medical</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="spouse_type" value="Non-Medical">
                        <label class="form-check-label">Non-Medical</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                  <label for="expected_cities">Intrested Location</label>
                    <select class="form-control selectpicker" id="expected_cities" name="expected_cities[]" multiple data-live-search="true" data-actions-box="false"     data-selected-text-format="count > 15" data-size="5"><?php foreach ($locations as $location): ?>
                        <option value="<?= esc($location['id']) ?>"><?= esc($location['name']) ?></option>
                    <?php endforeach; ?>
                    </select>
                    <div id="expectedCitiesError" class="text-danger mt-1" style="display: none;">Please select at least one city.
                    </div>
             
              </div>
            </div>
            <div class="form-row align-items-end">
              
                <div class="form-group col-md-12">
                  <label for="email">Permanent Address </label>
                  <textarea class="form-control" name="permanent address"></textarea>
                  <!-- <div class="invalid-feedback">Please enter Details
                  .</div> -->
                </div>
            </div>
            <div class="form-row align-items-end">
              
                <div class="form-group col-md-12">
                  <label for="email">Additional Qualification</label>
                  <textarea class="form-control" name="fellowship"></textarea>
                  <!-- <div class="invalid-feedback">Please enter Details
                  .</div> -->
                </div>
            </div>
            <div class="form-row align-items-end insuranceDiv" style="margin-bottom:0; display:none;">
                <div class="form-row align-items-end" style="margin-bottom:0">
                  <div class="form-group col-md-12">
                    <div class="form-group">
          
                        <label class="insurance-label1">
                            Do you have an professional insurance policy?
                        </label>

                        <div class="insurance-choice">

                            <label class="insurance-chip">
                                <input type="radio" name="insurance_policy" value="Yes">
                                <span>Yes</span>
                            </label>

                            <label class="insurance-chip">
                                <input type="radio" name="insurance_policy" value="No">
                                <span>No</span>
                            </label>

                        </div>

                    </div>
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

                <div class="premium-photo-card">

                    <div class="photo-header" >
                        📸 Profile Photo
                    </div>

                    <div class="form-group">
                        <input type="file"
                               id="candi_profile_imageInput"
                               class="form-control"
                               accept="image/*" name="candidate_job_profile">
                    </div>
                    <div class="row">

                        <!-- Preview Left Side -->
                        <div class="col-md-5 text-center">

                            <div class="preview-title">
                                Profile Preview
                            </div>

                            <img id="candi_profile_croppedPreview"  style="display:none;">

                        </div>

                        <!-- Crop Area Right Side -->
                        <div class="col-md-7">

                            <div class="crop-area" style="display:none;">
                                <img id="candi_profile_imagePreview">
                            </div>

                        </div>

                    </div>

                    <button type="button"
                            id="candi_profile_cropBtn"
                            class="btn btn-warning btn-sm mt-3" style="display:none;">
                        ✂ Crop & Apply
                    </button>

                    <input type="hidden"
                           name="candi_profile_cropped_image"
                           id="candi_profile_cropped_image">

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Birth Date</label>
                        <input type="date" name="birth_date" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Gender</label>
                        <select name="gender" class="form-control" style="padding: 7px 12px;">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="expected_cities">Languages Known</label>
                        <select class="form-control selectpicker" id="language_name" name="language_name[]" multiple data-live-search="true" data-actions-box="false" title="Languages Known"    data-selected-text-format="count > 15" data-size="5"><?php foreach ($languages as $lang): ?>
                            <option value="<?= esc($lang['lang_id']) ?>"><?= esc($lang['language_name']) ?></option>
                        <?php endforeach; ?>
                        </select>
                        <div id="expectedCitiesError" class="text-danger mt-1" style="display: none;">Please Languages
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                       <label for="job-region">licensing Registration</label>
                       <select class="form-control form-control-md selectpicker" name="lire_id" id="lice_reg_name" data-size="5" data-live-search="true" title="licensing Registration">
                       
                        <?php 
                          
                          foreach ($licensing_registration as $lice_reg): ?>
                            <option value="<?= esc($lice_reg['lire_id']) ?>"><?= esc($lice_reg['lice_reg_name']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                          <label>Registration No.:</label>
                          <input type="text" name="licen_registration_number" class="form-control" placeholder="Registration No">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                       <label for="job_role" class="form-label">Specialization</label>
                          
                          <select class="form-control form-control-md selectpicker" name="speci_id" id="specialization_name" data-live-search="true" data-size="5" title="Specialization">

                              <option value="">Select Specialization</option>
                              <?php foreach ($job_role as $role): ?>
                                <option value="<?= esc($role['job_id']) ?>"><?= esc($role['job_role']) ?></option>
                              <?php endforeach; ?>
                          </select>
                    </div>
                    <div class="form-group col-md-6">
                          <label>Total Experience</label>

                          <div class="row">
                              <div class="col-6">
                                  <select name="experience_years" id="experience_years" class="form-control form-control-md selectpicker" data-live-search="true" data-size="5">
                                      <option value="">Years</option>
                                      <?php for($i=0; $i<=50; $i++): ?>
                                          <option value="<?= $i ?>"><?= $i ?> Year<?= $i != 1 ? 's' : '' ?></option>
                                      <?php endfor; ?>
                                  </select>
                              </div>

                              <div class="col-6">
                                  <select name="experience_months" id="experience_months" class="form-control form-control-md selectpicker" data-live-search="true" data-size="5">
                                      <option value="">Months</option>
                                      <?php for($i=0; $i<=11; $i++): ?>
                                          <option value="<?= $i ?>"><?= $i ?> Month<?= $i != 1 ? 's' : '' ?></option>
                                      <?php endfor; ?>
                                  </select>
                              </div>
                          </div>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                       <label for="job_role" class="form-label">Under Graduation</label>
                          
                          <select class="form-control form-control-md selectpicker" name="ug_id" id="ug_name" data-live-search="true" data-size="5" title="Under Graduation">

                              <option value="">Select Under Graduation</option>
                              <?php foreach ($ud_medical_degree as $ug_degree): ?>
                                <option value="<?= esc($ug_degree['ug_id']) ?>"><?= esc($ug_degree['ug_name']) ?></option>
                              <?php endforeach; ?>
                          </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="industry">Under Graduation Passing Year</label>
                        <input type="month" id="ug_passing_month" name="ug_year_month"
                           class="form-control form-control-md">
                       
                       
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="industry">Under Graduation College Name</label>
                        <input type="text" class="form-control form-control-md" name="ug_clg_name" id="full_name" placeholder="Under Graduation College Name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="job_role" class="form-label">Post Graduation</label>
                          
                        <select class="form-control form-control-md selectpicker" name="pg_id" id="pg_id" data-live-search="true" data-size="5" title="Post Graduation">

                          <option value="">Select Job Role</option>
                          <?php foreach ($post_degree as $pg_degree): ?>
                            <option value="<?= esc($pg_degree['pg_id']) ?>"><?= esc($pg_degree['pg_name']) ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="industry">Post Graduation Passing Year</label>
                        <input type="month" id="pg_passing_month" name="pg_year_month"
                           class="form-control form-control-md">
                    </div>
                </div>
                <div class="form-row">
                     <div class="form-group col-md-12">
                        <label for="industry">Post Graduation College Name</label>
                        <input type="text" class="form-control form-control-md" name="pg_clg_name" id="pg_name" placeholder="Post Graduation College Name">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                       <label for="job_role" class="form-label">International Qualification</label>
                          
                          <select class="form-control form-control-md selectpicker" name="int_degree_id" id="int_degree_id" data-live-search="true" data-size="5" title="International Qualification">

                              <option value="">Select International Qualification</option>
                              <?php foreach ($international_degree as $int_deg): ?>
                                <option value="<?= esc($int_deg['int_degree_id']) ?>"><?= esc($int_deg['inq_name']) ?></option>
                              <?php endforeach; ?>
                          </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="industry">International Passing Year </label>
                        <input type="month" id="iq_passing_month" name="iq_year_month"
                           class="form-control form-control-md">
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="industry">International College Name</label>
                        <input type="text" class="form-control form-control-md" name="iq_clg_name" id="iq_name" placeholder="Int Qul College Name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="job_role" class="form-label">Superspeciality Degrees</label>
                        <select class="form-control form-control-md selectpicker" name="sup_id" id="sup_id" data-live-search="true" data-size="5" title="Superspeciality Degrees">

                          <option value="">Select Superspeciality Degrees</option>
                          <?php foreach ($superspeciality_degree as $sup_degree): ?>
                            <option value="<?= esc($sup_degree['sup_id']) ?>"><?= esc($sup_degree['superspeciality_name']) ?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label>Key Skills</label>
                        <textarea class="ckeditor" name="key_skills"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Publications</label>
                        <textarea class="ckeditor" name="publications"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Conference Attended</label>
                        <textarea class="ckeditor" name="conference_attended"></textarea>
                    </div>

                </div>
                <div class="form-row align-items-end" style="margin-bottom:0">
                      <div class="form-group col-md-12">

                          <label class="insurance-label1">
                              Do you have a LinkedIn profile?
                          </label>

                          <div class="insurance-choice">

                              <label class="insurance-chip">
                                  <input type="radio" name="linkdin_profile" value="Yes">
                                  <span>Yes</span>
                              </label>

                              <label class="insurance-chip">
                                  <input type="radio" name="linkdin_profile" value="No">
                                  <span>No</span>
                              </label>

                          </div>

                          <!-- Hidden Textbox -->
                          <div id="linkedin_url_div" style="display:none; margin-top:15px;">
                              <input type="url"
                                     name="linkedin_url"
                                     class="form-control"
                                     placeholder="https://www.linkedin.com/in/your-profile">
                          </div>

                      </div>
                </div>

                  <div style="display:flex; align-items:center; margin-bottom:15px;">
                    <span style="flex:1;height:1px;background:#e6c75a;"></span>
                    <span style="padding:0 15px;font-size:16px;font-weight:600;color:#b8860b;">
                        💼 Work Experience
                    </span>
                    <span style="flex:1;height:1px;background:#e6c75a;"></span>
                  </div>

                <div class="form-row">

                    <div class="col-md-12">

                        <div id="experience_container">

                            <!-- First Experience Block -->
                            <div class="experience-box">

                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>Organization Name</label>
                                        <input type="text" name="company_name[]" class="form-control" placeholder="Enter Company Name">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Designation</label>
                                        <input type="text" name="designation[]" class="form-control" placeholder="Enter Designation">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Start Date</label>
                                        <input type="month" name="start_date[]" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>End Date</label>
                                        <input type="month" name="end_date[]" class="form-control end-date">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="form-check">

                                            <input type="hidden"
                                                   name="currently_working[0]"
                                                   value="0">

                                            <input type="checkbox"
                                                   name="currently_working[0]"
                                                   value="1"
                                                   class="form-check-input current-job">

                                            <label class="form-check-label">
                                                Currently Working Here
                                            </label>

                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Job Description</label>
                                        <textarea name="job_description[]" class="form-control" rows="3"
                                            placeholder="Describe your responsibilities and achievements"></textarea>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <button type="button" id="addExperience" class="btn btn-sm btn-outline-primary mt-2">
                            + Add Experience
                        </button>

                    </div>

                </div>
                

            </div>
            <div class="form-row align-items-end">
                 <div class="form-group col-auto">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-md d-block" id="saveBtn">
                  <i class="fa fa-save mr-1"></i> Save
                </button>
              </div>
            </div>
        </form>
      </div>

      <!-- 🖼️ Right Column: Image -->
      <div class="col-md-5 d-flex align-items-center justify-content-center">
        <img src="<?= base_url('assets/jobportal/images/gif/new1.gif') ?>" alt="Recruiter Visual" class="img-fluid rounded" style="max-width: 100%; height: auto;">
        
          <div id="adBox" style=" position:absolute; top:10px; left:0;width:100%;z-index:999;text-align:center;">

              <button type="button" id="closeAd"
                      style="
                          position:absolute;
                          top:8px;
                          right:8px;
                          border:none;
                          background:rgba(0,0,0,0.6);
                          color:#fff;
                          width:24px;
                          height:24px;
                          border-radius:50%;
                          cursor:pointer;
                          z-index:1000;
                          font-size:14px;
                          font-weight:normal;
                          display:flex;
                          align-items:center;
                          justify-content:center;
                          transition:0.3s;
                          box-shadow:0 2px 6px rgba(0,0,0,0.2);
                      "
                      onmouseover="this.style.background='red'"
                      onmouseout="this.style.background='rgba(0,0,0,0.6)'">
                      ×
                  </button>

                      <img src="<?= base_url('assets/jobportal/images/wonderful.jpeg') ?>"
                     class="img-fluid rounded shadow"
                     style="
                        border-radius:15px;
                        width:100%;
                        max-width:600px;
                        height:auto;
                     ">
          </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function() {
    
      $('.job-role-select').selectpicker();
  });


</script>
