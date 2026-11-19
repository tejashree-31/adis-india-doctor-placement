<?php $session = session(); 
$email = session()->get('email');

use Config\Database;
 $db = Database::connect();
 $job_role = $db->query("SELECT * FROM tbl_job_role")->getResultArray(); 
$locations = $db->query("SELECT * FROM cities")->getResultArray();
$qualifications = $db->query("SELECT * FROM tbl_qualification")->getResultArray();
  $depart = $db->query("SELECT * FROM tbl_department")->getResultArray();


  $selectedGenders = [];

if (!empty($data['gender'])) {
    // Split comma separated values like "Male,Female"
    $selectedGenders = array_map('trim', explode(',', $data['gender']));
}
  ?>

<section class="site-section">
<!-- <section class="site-section testing_section"> -->
<nav aria-label="breadcrumb" class="py-2">
  <div class="container">
    <ol class="breadcrumb mb-0">
      <!-- <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li> -->
      <li class="breadcrumb-item"><a href="<?= base_url('recruiter/publishsavedraft') ?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Post Job </li>
    </ol>
  </div>
</nav>
  <div class="container">
    <div class="row">
      
      <!-- 🧭 Left Column: Registration Form -->
      <div class="col-md-7">

        <form class="p-4 p-md-5 border rounded" id="recruiterpost_update" method="post" enctype="multipart/form-data" action="<?= base_url('recruiter/upade_recruiter_posting') ?>">
          <h3 class="text-black mb-5 border-bottom pb-2">Edit Post Job</h3>
          <input type="hidden" name="job_id" value="<?= esc($data['posting_id']) ?>">
          <!-- Industry and City -->
          <div class="form-row">
            <div class="form-group col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                      <label for="job_role">Job Role</label>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addJobRoleBtn">
                        <i class="fa fa-plus"></i> Add
                        </button>
                </div>

                  <!-- Dropdown -->
                <select class="form-control form-control-md" name="job_role" id="job_role">
                    <!-- <option value="">Select Job Role</option> -->
                        <?php foreach ($job_role as $role): ?>
                          <option value="<?= esc($role['job_id']) ?>" 
                          <?= (isset($data['job_id']) && $data['job_id'] == $role['job_id']) ? 'selected' : '' ?>>
                           <?= esc($role['job_role']) ?>
                          </option>
                        <?php endforeach; ?>
                </select>
                <div class="invalid-feedback" id="jobRoleError" style="display: none;">
                        Please select a job role.
                </div>
                  <!-- Hidden Input Field -->
                  <div id="jobRoleInputWrapper" class="mt-2" style="display: none;">
                    <input type="text" id="newJobRole" class="form-control form-control-sm" placeholder="Enter new job role">
                    <button type="button" class="btn btn-sm btn-success mt-1" id="saveJobRole">Save</button>
                     <button type="button" class="btn btn-sm btn-danger mt-1" id="cancelJobRole">
                      <i class="fa fa-times"></i> Cancel
                    </button>
                  </div>
            </div>

            <div class="form-group col-md-6">
              <label for="job-region">Location</label>
              <select class="form-control form-control-md" name="city" id="location"  title="City/Town">
                <!-- <option value="">Anywhere</option> -->
                <?php 
                  foreach ($locations as $location): 
                    $selected = (isset($data['city_id']) && $data['city_id'] == $location['id']) ? 'selected' : '';
                ?>
                  <option value="<?= esc($location['id']) ?>" <?= $selected ?>>
                    <?= esc($location['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Please select an Location.</div>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-6">
                  <label for="qualification"> Qualification
                     <button type="button" class="btn btn-sm btn-outline-primary" id="addQualificationBtn"><i class="fa fa-plus"></i> Add</button>
                  </label>

                <select class="form-control form-control-md" name="qualification" id="qualification" data-live-search="true">
                    <option value="">Select Qualification</option>
                        <?php foreach ($qualifications as $q): 
                              $selected = (isset($data['qual_id']) && $data['qual_id'] == $q['qual_id']) ? 'selected' : '';
                        ?>
                      <option value="<?= esc($q['qual_id']) ?>" data-name="<?= esc($q['qualification_name']) ?>" <?= $selected ?>>
                            <?= esc($q['qualification_name']) ?>
                       </option>
                    <?php endforeach; ?>
                </select>
  
                  <div class="invalid-feedback">Please select a Qualification.</div>

                  <!-- Hidden input and buttons -->
                  <div id="qualificationInputWrapper" style="display: none;" class="mt-2">
                        <input type="text" id="newQualification" class="form-control form-control-sm mb-2" placeholder="Enter new qualification">
                        <div>
                            <button type="button" class="btn btn-sm btn-success" id="saveQualification">Save</button>
                            <button type="button" class="btn btn-sm btn-danger" id="cancelQualification"><i class="fa fa-times"></i> Cancel</button>
                        </div>
                  </div>
            </div>
            <div class="form-group col-md-6" id="coursesDiv">
                  <label for="course">
                    Courses 
                    <button type="button" class="btn btn-outline-success btn-sm" id="showAddCourse"><i class="fa fa-plus"></i> Add</button>
                  </label>
                  
                  <select class="form-control form-control-md" name="course" id="course" data-live-search="true">
                    <option value="">Select Courses</option>
                  </select>

                  <div id="newCourseWrapper" class="mt-2" style="display: none;">
                    <input type="text" class="form-control mb-2" id="newCourseInput" placeholder="Enter new course">
                    <button type="button" class="btn btn-success btn-sm" id="saveNewCourse">Save</button>
                    <button type="button" class="btn btn-danger btn-sm" id="cancelNewCourse"><i class="fa fa-times"></i> Cancel</button>
                  </div>
            </div>
          </div>

          <div class="form-row">

            <div class="form-group col-md-6">
                <label for="employment_type">Department</label>
                <button type="button" class="btn btn-sm btn-outline-primary" id="addDepartmentBtn">
                    <i class="fa fa-plus"></i> Add
                </button>
                <select class="form-control form-control-md" name="department" id="department">
                    <!-- <option value="">Select Department</option> -->
                    <?php foreach ($depart as $d): ?>
                        <option value="<?= esc($d['department_id']) ?>" 
                            <?= (isset($data['department_id']) && $data['department_id'] == $d['department_id']) ? 'selected' : '' ?>>
                            <?= esc($d['department_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Please select an Department.</div>
                <div id="departmentInputWrapper" class="mt-2" style="display: none;">
                  <input type="text" id="newDepartmentInput" class="form-control form-control-sm" placeholder="Enter new department">
                  <button type="button" class="btn btn-sm btn-success mt-1" id="saveDepartmentBtn">Save</button>
                  <button type="button" class="btn btn-sm btn-danger mt-1" id="cancelDepartmentBtn">
                    <i class="fa fa-times"></i> Cancel
                  </button>
                </div>
            </div>

            <div class="form-group col-md-6">
              <label for="number_of_vacancies">Number of Vacancies</label>
              <input type="text"  class="form-control form-control-md" id="number_of_vacancies" name="vacancies" value="<?= isset($data['vacancies']) ? esc($data['vacancies']) : '' ?>">
                <div class="invalid-feedback">Please enter vacancies.</div>
             
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-7">
                <label>Employment Type <span class="text-danger">*</span></label><br>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="employment_type" id="fullTime" value="Full Time"
                      <?= (isset($data['employment_type']) && $data['employment_type'] == 'Full Time') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="fullTime">Full Time</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="employment_type" id="partTime" value="Part Time"
                      <?= (isset($data['employment_type']) && $data['employment_type'] == 'Part Time') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="partTime">Part Time</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="employment_type" id="freelance" value="Freelance"
                      <?= (isset($data['employment_type']) && $data['employment_type'] == 'Freelance') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="freelance">Locum</label>
                  </div>

                  <div class="invalid-feedback" id="employmentTypeError" style="display: none;">
                    Please select an employment type.
                  </div>
            </div>
            <div class="form-group col-md-5">
              <div class="form-group">
                <label>Gender</label><br>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="gender[]" id="genderMale" value="Male"
                        <?= in_array('Male', $selectedGenders) ? 'checked' : '' ?>>
                      <label class="form-check-label" for="genderMale">Male</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="gender[]" id="genderFemale" value="Female"
                        <?= in_array('Female', $selectedGenders) ? 'checked' : '' ?>>
                      <label class="form-check-label" for="genderFemale">Female</label>
                    </div>

                    <div class="invalid-feedback" id="genderError" style="display: none;">
                      Please select at least one gender.
                    </div>
             
              </div>
            </div>
          </div>
          <div class="form-row">
             <div class="form-group col-md-12">
                  <label for="job_description">Job Description</label>
                  <textarea class="form-control form-control-md" name="job_description" id="job_description" rows="4" placeholder="Enter job details..." required><?= isset($data['job_description']) ? esc($data['job_description']) : '' ?></textarea>
                  <div class="invalid-feedback">Please Enter Job Description.</div>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-7">
                    <label>Shift Time <span class="text-danger">*</span></label><br>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="shift_time" id="shiftMorning" value="Morning"
                        <?= isset($data['shift_time']) && $data['shift_time'] === 'Morning' ? 'checked' : '' ?> required>
                      <label class="form-check-label" for="shiftMorning">Rotational</label>
                    </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="shift_time" id="shiftEvening" value="Evening"
                      <?= isset($data['shift_time']) && $data['shift_time'] === 'Evening' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="shiftEvening">General</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="shift_time" id="shiftNight" value="Night"
                      <?= isset($data['shift_time']) && $data['shift_time'] === 'Night' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="shiftNight">Night</label>
                  </div>

                  <div class="invalid-feedback" id="shiftTimeError" style="display: none;">
                    Please select a shift time.
                  </div>
              </div>
              <div class="form-group col-md-5">
                  <label for="number_of_vacancies">Experience (min)</label>
                  <input type="text" class="form-control form-control-md" id="experience_min" name="experience_min" value="<?= isset($data['experience_min']) ? esc($data['experience_min']) : '' ?>" required >
                  <div class="invalid-feedback">Please enter Experience (min).</div>
              </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
                <label for="number_of_vacancies">Experience (max)</label>
                <input type="text" class="form-control form-control-md" id="experience_max" name="experience_max" value="<?= isset($data['experience_max']) ? esc($data['experience_max']) : '' ?>" required >
                <div class="invalid-feedback">Enter Experience (max).</div>
            </div>
            <div class="form-group col-md-4">
                  <label for="number_of_vacancies">Salary (min)</label>
                  <input type="text" class="form-control form-control-md" id="salary_min" name="salary_min" value="<?= isset($data['salary_min']) ? esc($data['salary_min']) : '' ?>" required >
                <div class="invalid-feedback">Enter Salary (min).</div>
            </div>
            <div class="form-group col-md-4">
                <label for="salary_max">Salary (max)</label>
                <input type="text" class="form-control form-control-md" id="salary_max" name="salary_max" value="<?= isset($data['salary_max']) ? esc($data['salary_max']) : '' ?>" required >
                <div class="invalid-feedback">Enter Salary (max).</div>
            </div>
          </div>
          <div class="row mt-4">
                <div class="col-12 d-flex justify-content-end align-items-center">
                  <!-- Custom checkbox -->
                  <label class="custom-checkbox mr-3 mb-0 d-flex align-items-center">
                    <input type="checkbox" id="termsCheckbox" name="status">
                    <span class="checkmark"></span>
                  </label>

                  <!-- Publish -->
                  <button type="submit" name="action" value="publish" class="btn btn-outline-secondary btn-md mr-2" id="publishBtn" disabled>
                    <i class="fa fa-paper-plane mr-1"></i> Publish
                  </button>

                   <button type="submit" name="action" value="draft" class="btn btn-primary btn-md" id="postingsave" disabled>
                    <i class="fa fa-save mr-1"></i> Save Draft
                  </button>
                </div>
          </div>


          <!-- </div> -->
        </form>
      </div>

      <!-- 🖼️ Right Column: Image -->
      <div class="col-md-5 d-flex align-items-center justify-content-center">
        <img src="<?= base_url('assets/jobportal/images/gif/new.jpg') ?>" alt="Recruiter Visual" class="img-fluid rounded" style="max-width: 100%; height: auto;">
      </div>
    </div>
  </div>
</section>
