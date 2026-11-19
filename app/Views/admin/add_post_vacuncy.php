<?php 
use Config\Database;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Post Vacancy</title>
<style>
   .big-checkbox {
    transform: scale(1.9);   /* size increase */
    cursor: pointer;
}
</style>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add Post</h5>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('save-post-vacuncy') ?>" method="post" id="blogForm" enctype="multipart/form-data">
            <input type="hidden" name="uid" value="<?= $uid; ?>">
            <input type="hidden" id="user_type" name="user_type" class="form-control form-control-md" value="recruiter">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="job_role" class="form-label">Job Role
                            <button type="button" class="btn btn-sm btn-outline-primary" id="addJobRoleBtn_admin">
                            <i class="fas fa-plus"></i> Add</button></label>
                            <select class="form-control form-control-md" name="job_role" id="job_role_admin" data-live-search="true" title="Job Role" required>
                                <option value="">Select Job Role</option>
                                <?php foreach ($job_role as $role): ?>
                                  <option value="<?= esc($role['job_id']) ?>"><?= esc($role['job_role']) ?></option>
                                <?php endforeach; ?>
                            </select>
                           <div class="invalid-feedback" id="jobRoleError_admin" style="display: none;"> Please select a job role.
                            </div>
                              <!-- Hidden Input Field -->
                            <div id="jobRoleInputWrapper_admin" class="mt-2" style="display: none;">
                                <input type="text" id="newJobRole_admin" class="form-control form-control-sm" placeholder="Enter new job role">
                                <button type="button" class="btn btn-sm btn-success mt-1" id="saveJobRole_admin">Save</button>
                                 <button type="button" class="btn btn-sm btn-danger mt-1" id="cancelJobRole_admin">
                                  <i class="fas fa-times"></i> Cancel
                                </button>
                              </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="location_id" class="form-label" style="margin-top: 7px;">Location </label>

                            <select class="form-control form-control-md" name="city" id="location_id" data-live-search="true"  title="City/Town" required>
                            <option value="">Anywhere</option>
                            <?php 
                             
                              foreach ($cities as $location): ?>
                                <option value="<?= esc($location['id']) ?>"><?= esc($location['name']) ?></option>
                            <?php endforeach; ?>
                          </select>
                          <div class="invalid-feedback">Please select an Location.</div>


                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="qualification_admin" class="form-label">Category
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addQualificationBtn_admin">Add</button>
                            </label>
                            <select class="form-control form-control-md" name="qualification" id="qualification_admin" data-live-search="true" required>
                                <option value="">Select Category</option>
                                <?php foreach ($qualifications as $q): ?>
                                  <option 
                                    value="<?= esc($q['qual_id']) ?>" 
                                    data-name="<?= esc($q['qualification_name']) ?>">
                                    <?= esc($q['qualification_name']) ?>
                                  </option>
                            <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select an Qualification.</div>
                            <!-- Hidden input and buttons -->
                            <div id="qualificationInputWrapper_admin" style="display: none;" class="mt-2">
                                <input type="text" id="newQualification_admin" class="form-control form-control-sm mb-2" placeholder="Enter new qualification">
                                <div>
                                  <button type="button" class="btn btn-sm btn-success" id="saveQualification_admin">Save</button>
                                  <button type="button" class="btn btn-sm btn-secondary" id="cancelQualification_admin">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="course_admin" class="form-label">Higher Qualification <button type="button" class="btn btn-outline-success btn-sm" id="showAddCourse_admin">Add</button></label>
                            <select class="form-control form-control-md" name="course" id="course_admin" data-live-search="true" >
                                <option value="">Select Courses</option>
                            </select>
                            <div id="newCourseWrapper_admin" class="mt-2" style="display: none;">
                                <input type="text" class="form-control mb-2" id="newCourseInput_admin" placeholder="Enter new course">
                                <button type="button" class="btn btn-primary btn-sm" id="saveNewCourse_admin">Save</button>
                                <button type="button" class="btn btn-secondary btn-sm" id="cancelNewCourse_admin">Cancel</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="department_admin" class="form-label">Department</label>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="addDepartmentBtn_admin">
                                <i class="fas fa-plus"></i> Add
                            </button>
                            <select class="form-control form-control-md" name="department_admin" id="department_admin" required>
                                <option value="">Select Department</option>
                                    <?php foreach ($depart as $d): ?>
                                      <option value="<?= esc($d['department_id']) ?>"><?= esc($d['department_name']) ?></option>
                                    <?php endforeach; ?>
                            </select>
                           <div class="invalid-feedback">Please select an Department.</div>
                            <div id="departmentInputWrapper_admin" class="mt-2" style="display: none;">
                              <input type="text" id="newDepartmentInput_admin" class="form-control form-control-sm" placeholder="Enter new department">
                              <button type="button" class="btn btn-sm btn-success mt-1" id="saveDepartmentBtn_admin">Save</button>
                              <button type="button" class="btn btn-sm btn-danger mt-1" id="cancelDepartmentBtn_admin">
                                <i class="fas fa-times"></i> Cancel
                              </button>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="password" class="form-label">Number of Vacancies</label>
                             <input type="text" class="form-control form-control-md" id="number_of_vacancies" name="vacancies" required>
                              <span id="vacanciesError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label>Employment Type <span class="text-danger">*</span></label><br>

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="employment_type" id="fullTime" value="Full Time">
                                <label class="form-check-label" for="fullTime">Full Time</label>
                              </div>

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="employment_type" id="partTime" value="Part Time">
                                <label class="form-check-label" for="partTime">Part Time</label>
                              </div>

                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="employment_type" id="freelance" value="Freelance">
                                <label class="form-check-label" for="freelance">Locum</label>
                              </div>
                          </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label>Gender</label><br>

                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="gender[]" id="genderMale" value="Male">
                              <label class="form-check-label" for="genderMale">Male</label>
                            </div>


                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="checkbox" name="gender[]" id="genderFemale" value="Female">
                              <label class="form-check-label" for="genderFemale">Female</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                   
                        <div class="col-md-12">
                             <div class="mb-3">
                            <label for="job_description">Job Description</label>
                                <textarea name="job_description" id="editor" class="form-control" style="height: 400px!important;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                          <label>Shift Time </label><br>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="shift_time" id="shiftMorning" value="Morning" required>
                            <label class="form-check-label" for="shiftMorning">Rotational</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="shift_time" id="shiftEvening" value="Evening">
                            <label class="form-check-label" for="shiftEvening">General</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="shift_time" id="shiftNight" value="Night">
                            <label class="form-check-label" for="shiftNight">Night</label>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="number_of_vacancies">Experiance(min)</label>
                            <input type="text" class="form-control form-control-md" id="experience_min" name="experience_min" required>
                            <span id="experience_minError" style="color:red; display:none;">Please enter only numbers</span>
                       
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="number_of_vacancies">Experiance(max)</label>
                            <input type="text" class="form-control form-control-md" id="experience_max" name="experience_max" required>
                             <span id="experience_maxError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>
                    

                </div>
                 <div class="row g-3">
                    <div class="col-md-2" style="margin-top: 5px;">
                        <div class="mb-3">
                            <label for="salary_negotiation">Salary Negotiation</label>
                                <input type="checkbox"
                                       id="salary_negotiation"
                                       name="salary_negotiation"
                                       value="yes"
                                       class="big-checkbox"
                                       style="margin-left:10px;">
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="number_of_vacancies">Salary(min)</label>
                            <input type="text" class="form-control form-control-md" id="salary_min" name="salary_min" required>
                             <span id="salary_minError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="number_of_vacancies">Salary(max)</label>
                            <input type="text" class="form-control form-control-md" id="salary_max" name="salary_max" required>
                             <span id="salary_maxError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>

                 </div>
            
                <div class="row g-3 mt-2">
                    <!-- Industry -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            
                        </div>
                    </div>
                  
                     <div class="col-md-3">
                        <div class="mb-3">
                           
                        </div>
                    </div>
                     <!-- city Name -->
                    <div class="col-md-3">
                        <div class="mb-3">
                           
                        </div>
                    </div>
                    <!-- pincode Name -->
                    <div class="col-md-3">
                      
                    </div>
                </div>
                <div class="row g-3 mt-2" >
                    <div class="col-md-3">
                         <button type="submit" class="btn btn-primary mt-3">Publish</button>
                    </div>
                </div>
                
            </form>
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



</body>
</html>
