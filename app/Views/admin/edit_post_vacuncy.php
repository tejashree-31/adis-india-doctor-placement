<?php 
use Config\Database;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Post Vacuncy</title>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<style>
    .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 35px !important;
    user-select: none;
    -webkit-user-select: none;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 35px !important;
}  
    .big-checkbox {
    transform: scale(1.9);   /* size increase */
    cursor: pointer;
} 
</style>
</head>
<body>
<div class="container mt-5">
    <!-- <h1 class="mb-4">Edit Empolyee</h1> -->
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
    <?php endif; ?>
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Post Vacuncy &nbsp;<a href="<?= base_url('admin/all-post-vacancies') ?>" class="btn btn-light">
    <i class="fa fa-arrow-left"></i>
</a></h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('update-posting-form') ?>" method="post" id="blogForm" enctype="multipart/form-data">
                <input type="hidden" name="posting_id" value="<?= isset($single_posting_edit['posting_id']) ? esc($single_posting_edit['posting_id']) : ''; ?>">
                <!-- <?php //echo $single_posting_edit['job_id']; ?> -->
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="job_role" class="form-label">Job Role </label>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="addJobRoleBtn_admin">
                                        <i class="fas fa-plus"></i> Add
                                    </button>

                                    <select class="form-control form-control-md"
                                            name="job_role"
                                            id="job_role_admin"
                                            title="Job Role"
                                            required>

                                        <option value="">Select Job Role </option>

                                        <?php foreach ($job_role as $role): ?>
                                            <option value="<?= esc($role['job_id']) ?>"
                                                <?= (!empty($single_posting_edit['job_id']) && $single_posting_edit['job_id'] == $role['job_id']) ? 'selected' : '' ?>>
                                                <?= esc($role['job_role']) ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>

                                    <div class="invalid-feedback" id="jobRoleError_admin" style="display: none;">
                                        Please select a job role.
                                    </div>

                                    <!-- Hidden Input Field -->
                                    <div id="jobRoleInputWrapper_admin" class="mt-2" style="display: none;">
                                        <input type="text" id="newJobRole_admin"
                                               class="form-control form-control-md"
                                               placeholder="Enter new job role">

                                        <button type="button" class="btn btn-sm btn-success mt-1" id="saveJobRole_admin">
                                            Save
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger mt-1" id="cancelJobRole_admin">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="location_id" class="form-label">Location</label>

                            <select class="form-control form-control-md"
                                    name="city"
                                    id="location_id"
                                    data-live-search="true"
                                    title="City/Town"
                                    required>

                                <option value="">Anywhere</option>

                                <?php foreach ($cities as $location): ?>
                                    <option value="<?= esc($location['id']) ?>"
                                        <?= (!empty($single_posting_edit['city_id']) && $single_posting_edit['city_id'] == $location['id']) ? 'selected' : '' ?>>
                                        <?= esc($location['name']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>

                            <div class="invalid-feedback">Please select a Location.</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="qualification_admin" class="form-label">Category</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addQualificationBtn_admin">Add</button>
                       
                           <select class="form-control form-control-md"
                                    name="qualification"
                                    id="qualification_admin"
                                    data-live-search="true"
                                    required>

                                <option value="">Select Category</option>

                                <?php foreach ($qualifications as $q): ?>
                                    <option value="<?= esc($q['qual_id']) ?>"
                                        <?= (isset($single_posting_edit['qual_id']) 
                                            && (int)$single_posting_edit['qual_id'] === (int)$q['qual_id']) 
                                            ? 'selected' 
                                            : '' ?>
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
                            <label for="course_admin" class="form-label">Higher Qualification </label><button type="button" class="btn btn-outline-success btn-sm" id="showAddCourse_admin">Add</button>
                            <select class="form-control form-control-md" name="course" id="course_admin" data-live-search="true">
                                <option value="">Select Higher Qualification</option>
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
                            <label for="job_role" class="form-label">Department</label>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="addDepartmentBtn_admin">
                                <i class="fas fa-plus"></i> Add
                            </button>
                            <select class="form-control form-control-md" name="department_admin" id="department_admin" required>
                                <option value="">Select Department</option>
                                <?php foreach ($depart as $d): ?>
                                    <option value="<?= esc($d['department_id']) ?>"
                                        <?= (isset($single_posting_edit['department_id']) 
                                            && (int)$single_posting_edit['department_id'] === (int)$d['department_id']) 
                                            ? 'selected' 
                                            : '' ?>>
                                        <?= esc($d['department_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                           <div class="invalid-feedback">Please select an Department.</div>
                            <div id="departmentInputWrapper_admin" class="mt-2" style="display: none;">
                              <input type="text" id="newDepartmentInput_admin" class="form-control form-control-sm" placeholder="Enter new department" name="department">
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
                            <input type="text" class="form-control form-control-md" id="number_of_vacancies"
                                name="vacancies" value="<?= isset($single_posting_edit['vacancies']) ? esc($single_posting_edit['vacancies']) : '' ?>"  required >
                              <span id="vacanciesError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label>Employment Type <span class="text-danger">*</span></label><br>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="employment_type"
                                       id="fullTime"
                                       value="Full Time"
                                       <?= (isset($single_posting_edit['employment_type']) 
                                           && $single_posting_edit['employment_type'] === 'Full Time') 
                                           ? 'checked' : '' ?>>
                                <label class="form-check-label" for="fullTime">Full Time</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="employment_type"
                                       id="partTime"
                                       value="Part Time"
                                       <?= (isset($single_posting_edit['employment_type']) 
                                           && $single_posting_edit['employment_type'] === 'Part Time') 
                                           ? 'checked' : '' ?>>
                                <label class="form-check-label" for="partTime">Part Time</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="employment_type"
                                       id="freelance"
                                       value="Freelance"
                                       <?= (isset($single_posting_edit['employment_type']) 
                                           && $single_posting_edit['employment_type'] === 'Freelance') 
                                           ? 'checked' : '' ?>>
                                <label class="form-check-label" for="freelance">Locum</label>
                            </div>
                        </div>
                    </div>

                    <?php
                    $selectedGender = [];
                    if (!empty($single_posting_edit['gender'])) {
                        $selectedGender = explode(',', $single_posting_edit['gender']); // Male,Female
                    }
                    ?>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label>Gender</label><br>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="gender[]"
                                       id="genderMale"
                                       value="Male"
                                       <?= in_array('Male', $selectedGender) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="genderMale">Male</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="gender[]"
                                       id="genderFemale"
                                       value="Female"
                                       <?= in_array('Female', $selectedGender) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="genderFemale">Female</label>
                            </div>
                        </div>
                    </div>

                </div>

                

                <div class="row g-3">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="email_id" class="form-label">Job Description</label>
                      <!-- <textarea name="job_description" class="form-control" id="job_description"><?= isset($single_posting_edit['job_description']) ? esc(trim($single_posting_edit['job_description'])) : 'Job description...'; ?></textarea> -->

                       <textarea name="job_description" id="editor" style="height: 400px!important;">
                        <?= isset($single_posting_edit['job_description']) ? esc($single_posting_edit['job_description']) : 'Start writing your blog...'; ?>
                        </textarea>
                    </div>
                  </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label>Shift Time</label><br>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="shift_time"
                                       id="shiftMorning"
                                       value="Morning"
                                       <?= (isset($single_posting_edit['shift_time']) 
                                           && $single_posting_edit['shift_time'] === 'Morning') 
                                           ? 'checked' : '' ?>
                                       required>
                                <label class="form-check-label" for="shiftMorning">Rotational</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="shift_time"
                                       id="shiftEvening"
                                       value="Evening"
                                       <?= (isset($single_posting_edit['shift_time']) 
                                           && $single_posting_edit['shift_time'] === 'Evening') 
                                           ? 'checked' : '' ?>>
                                <label class="form-check-label" for="shiftEvening">General</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="shift_time"
                                       id="shiftNight"
                                       value="Night"
                                       <?= (isset($single_posting_edit['shift_time']) 
                                           && $single_posting_edit['shift_time'] === 'Night') 
                                           ? 'checked' : '' ?>>
                                <label class="form-check-label" for="shiftNight">Night</label>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="experience_min">Experience (Min)</label>

                            <input
                                type="text"
                                class="form-control form-control-md"
                                id="experience_min"
                                name="experience_min"
                                value="<?= isset($single_posting_edit['experience_min']) ? esc($single_posting_edit['experience_min']) : '' ?>"
                                required
                            >

                            <span id="experience_minError" style="color:red; display:none;">
                                Please enter only numbers
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="experience_max">Experience (Max)</label>

                            <input
                                type="text"
                                class="form-control form-control-md"
                                id="experience_max"
                                name="experience_max"
                                value="<?= isset($single_posting_edit['experience_max']) ? esc($single_posting_edit['experience_max']) : '' ?>"
                                required
                            >

                            <span id="experience_maxError" style="color:red; display:none;">
                                Please enter only numbers
                            </span>
                        </div>
                    </div>


                </div>

                <div class="row g-3">
                    <div class="col-md-2" style="margin-top: 5px;">
                        <div class="mb-3">
                            <label for="salary_negotiation">Salary Negotiation</label>

                            <input
                                type="checkbox"
                                id="salary_negotiation"
                                name="salary_negotiation"
                                value="yes"
                                class="big-checkbox"
                                style="margin-left:10px;"
                                <?= (isset($single_posting_edit['salary_negotiation']) 
                                    && ($single_posting_edit['salary_negotiation'] === 'yes' 
                                        || $single_posting_edit['salary_negotiation'] == 1))
                                    ? 'checked' 
                                    : '' ?>
                            >
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="salary_min">Salary (Min)</label>

                            <input
                                type="text"
                                class="form-control form-control-md"
                                id="salary_min"
                                name="salary_min"
                                value="<?= isset($single_posting_edit['salary_min']) ? esc($single_posting_edit['salary_min']) : '' ?>"
                                required
                            >

                            <span id="salary_minError" style="color:red; display:none;">
                                Please enter only numbers
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="salary_max">Salary (Max)</label>

                            <input
                                type="text"
                                class="form-control form-control-md"
                                id="salary_max"
                                name="salary_max"
                                value="<?= isset($single_posting_edit['salary_max']) ? esc($single_posting_edit['salary_max']) : '' ?>"
                                required
                            >

                            <span id="salary_maxError" style="color:red; display:none;">
                                Please enter only numbers
                            </span>
                        </div>
                    </div>


                </div>
             
               
                <div class="row g-3 mt-2">
               
                    <div class="col-md-3">
                         <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </div>
                    <div class="col-md-3">
                       
                    </div>
                </div>

                
             
                <!-- <button type="submit" class="btn btn-primary">Update</button> -->
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
.create(document.querySelector('#editor'), {
    toolbar: [
        'heading','bold','italic','link','bulletedList','numberedList',
        'blockQuote','undo','redo','imageUpload'
    ],
    placeholder: 'Write your blog here...',
    // Enable Base64 image upload
    removePlugins: [ 'CKBox', 'CKFinder', 'EasyImage', 'RealTimeCollaborativeComments', 'MathType' ]
})
.then(editor => console.log('Editor ready'))
.catch(error => console.error(error));
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = 'block'; // show image
        }
        reader.readAsDataURL(file); // convert image to base64
    }
});
</script>
</body>
</html>
