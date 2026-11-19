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

<style type="text/css">
   .font-span {
      color : #a18a8a;
   }
   .form-label {
       font-weight: bold;
   }
</style>

<div class="container py-4">
  <div class="row">
    <div class="col-md-12">
        <div class="text-center mb-4"></div>
        <div class="tab-content border p-4 bg-white shadow-sm rounded" id="jobTabContent">
            <div class="tab-pane fade show active" id="publish"> 
                <div class="container-fluid py-4">
                    <div class="row">
                      <div class="col-12 mb-4">
                        <?php if (session()->getFlashdata('success')): ?>
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <?= session()->getFlashdata('success'); ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    <?php endif; ?>
                        <div class="card1 border-success w-100">
                          <div class="card-body text-start px-4">

                            <!-- Job Preview FIRST -->
                            <h3 class="mb-2 text-center"><b>Job Details Preview </b></h3>
                            <div class="row mt-4">
                              <div class="col-md-3">
                                <?php if (!empty($result['recruiter_logo'])) : ?>
                                    <img src="<?= base_url('public/uploads/' . $result['recruiter_logo']); ?>" 
                                         alt="Recruiter Logo" width="100" height="100">
                                <?php else : ?>
                                    <img src="<?= base_url('assets/jobportal/images/default1.jpg'); ?>" 
                                         alt="Default Logo" width="100" height="100">
                                <?php endif; ?>
                              </div>
                              <div class="col-md-3">
                                <p class="mb-2"><?= esc($result['job_role']); ?></p>
                                <p class="mb-2 font-span"><?= esc($result['city_name']); ?></p>
                              </div>
                            </div>

                            <hr style="border: 1px solid #ccc; margin: 20px 0;">

                            <!-- Edit Job Profile FORM -->
                            <h3 class="mb-2 text-center"><b>Edit Job Profile</b></h3><br>

                            <form method="post" action="<?= base_url('recruiter/upade_recruiter_posting_new'); ?>">
                               <input type="hidden" name="job_id" value="<?= esc($data['posting_id']) ?>">
                               <input type="hidden" name="status" value="<?= esc($data['status']) ?>">
                              <div class="row mb-3">
                                <div class="col-md-4">
                                  <!-- <label class="form-label">Job Role</label>
                                  <input type="text" class="form-control" name="job_role" 
                                         value="<?//= esc($result['job_role']); ?>"> -->
                                     <div class="d-flex justify-content-between align-items-center">
                                        <label for="job_role">Job Role</label>
                                          <button type="button" class="btn btn-sm btn-outline-primary" id="addJobRoleBtn">
                                          <i class="fas fa-plus"></i> Add
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
                                        <i class="fas fa-times"></i> Cancel
                                      </button>
                                    </div>


                                </div>
                                <div class="col-md-4">
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


                                <div class="col-md-4">
                                  <label for="qualification"> Qualification
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="addQualificationBtn">Add</button>
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
                                                <button type="button" class="btn btn-sm btn-danger" id="cancelQualification">Cancel</button>
                                            </div>
                                      </div>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-md-4">
                                     <label for="course">
                                        Courses 
                                        <button type="button" class="btn btn-outline-success btn-sm" id="showAddCourse">Add</button>
                                      </label>
                                      
                                      <select class="form-control form-control-md" name="course" id="course" data-live-search="true">
                                        <option value="">Select Courses</option>
                                      </select>

                                      <div id="newCourseWrapper" class="mt-2" style="display: none;">
                                        <input type="text" class="form-control mb-2" id="newCourseInput" placeholder="Enter new course">
                                        <button type="button" class="btn btn-success btn-sm" id="saveNewCourse">Save</button>
                                        <button type="button" class="btn btn-danger btn-sm" id="cancelNewCourse">Cancel</button>
                                      </div>
                                </div>
                                <div class="col-md-4">
                                     <label for="employment_type">Department</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="addDepartmentBtn">
                                        <i class="fas fa-plus"></i> Add
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
                                        <i class="fas fa-times"></i> Cancel
                                      </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                  <label for="number_of_vacancies">Number of Vacancies</label>
                                    <input type="text"  class="form-control form-control-md" id="number_of_vacancies" name="vacancies" value="<?= isset($data['vacancies']) ? esc($data['vacancies']) : '' ?>">
                                      <div class="invalid-feedback">Please enter vacancies.</div>
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                              
                              </div>

                              <div class="row mb-3">
                                <div class="col-md-12">
                                  <label for="job_description">Job Description</label>
                                   <textarea name="job_description" id="editor" class="form-control" style="height: 400px!important;"><?php echo isset($data['job_description']) ? $data['job_description'] : ''; ?></textarea>
                                </div>
                              
                              </div>
                              <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="number_of_vacancies">Experience (min)</label>
                                    <input type="text" class="form-control form-control-md" id="experience_min" name="experience_min" value="<?= isset($data['experience_min']) ? esc($data['experience_min']) : '' ?>" required >
                                    <div class="invalid-feedback">Please enter Experience (min).</div>

                                </div>
                                <div class="col-md-3">
                                  <label for="number_of_vacancies">Experience (max)</label>
                                  <input type="text" class="form-control form-control-md" id="experience_max" name="experience_max" value="<?= isset($data['experience_max']) ? esc($data['experience_max']) : '' ?>" required >
                                  <div class="invalid-feedback">Enter Experience (max).</div>
                                </div>
                                <div class="col-md-3">
                                  <label for="number_of_vacancies">Salary (min)</label>
                                  <input type="text" class="form-control form-control-md" id="salary_min" name="salary_min" value="<?= isset($data['salary_min']) ? esc($data['salary_min']) : '' ?>" required >
                                    <div class="invalid-feedback">Enter Salary (min).</div>
                                </div>
                                <div class="col-md-3">
                                   <label for="salary_max">Salary (max)</label>
                                    <input type="text" class="form-control form-control-md" id="salary_max" name="salary_max" value="<?= isset($data['salary_max']) ? esc($data['salary_max']) : '' ?>" required >
                                    <div class="invalid-feedback">Enter Salary (max).</div>
                                </div>

                              </div>

                         <div class="row mt-4"> <div class="col-md-1"> <button type="submit" class="btn btn-success" style="border-radius: 20px; padding: 4px 12px;"> Update </button> </div> <div class="col-md-3"> <a href="<?= base_url('recruiter/recruiter_job_responce'); ?>" class="btn btn-info" style="border-radius: 20px; padding: 4px 12px;"> Cancel </a> </div> </div>
                            </form>
                            <!-- End of form -->

                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
.create(document.querySelector('#editor'), {
    toolbar: ['heading','bold','italic','link','bulletedList','numberedList','blockQuote','undo','redo','imageUpload'],
    placeholder: 'Write your blog here...',
    removePlugins: ['CKBox','CKFinder','EasyImage','RealTimeCollaborativeComments','MathType']
})
.then(editor => console.log('Editor ready'))
.catch(error => console.error(error));

// Image preview
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>

