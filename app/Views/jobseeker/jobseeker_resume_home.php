<style>
	/* ===========================
   Common Bootstrap Select
=========================== */
/* Select2 Main Box */
.select2-container--default .select2-selection--single{
    height:52px !important;
    border:1px solid #ddd !important;
    border-radius:12px !important;
}

/* Selected Text */
.select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height:56px !important;
    padding-left:15px !important;
    color:#555 !important;
    font-size:15px !important;
}

/* Dropdown Arrow */
.select2-container--default .select2-selection--single .select2-selection__arrow{
    height:56px !important;
    right:10px !important;
}
.resume-builder-section{
    background:#f6f7fb;
    padding:50px 0;
    min-height:100vh;
}

.resume-card{
    max-width:850px;
    margin:auto;
    background:#fff;
    border-radius:22px;
    padding:35px;
    border:1px solid #ececec;
    box-shadow:0 10px 35px rgba(0,0,0,.06);
}

.form-title{
    font-size:28px;
    font-weight:700;
    color:#222;
    margin-bottom:25px;
}

.upload-section{
    display:flex;
    align-items:center;
    margin-bottom:30px;
}

.photo-circle{
    width:70px;
    height:70px;
    border-radius:50%;
    background:#f2f4f8;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-right:20px;
}

.photo-circle i{
    font-size:28px;
    color:#9ca3af;
}

.upload-text label{
    color:#e53935;
    font-weight:600;
    cursor:pointer;
    margin:0;
    font-size:16px;
}

.form-control{
    height:52px;
    border-radius:12px;
    border:1px solid #e5e7eb;
    box-shadow:none;
    font-size:15px;
    padding:12px 16px;
    transition:.3s;
}

.form-control::placeholder{
    color:#9ca3af;
}

textarea.form-control{
    height:auto;
    min-height:90px;
    resize:none;
    padding-top:14px;
}

.form-control:focus{
    border-color:#ef4444;
    box-shadow:0 0 0 3px rgba(239,68,68,.10);
}

.mb-3{
    margin-bottom:18px !important;
}

.generate-btn{
    width:100%;
    height:55px;
    border:none;
    border-radius:12px;
    background:#e3262e;
    color:#fff;
    font-size:17px;
    font-weight:600;
    transition:.3s;
}

.generate-btn:hover{
    background:#c91d24;
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(227,38,46,.25);
}

.generate-btn i{
    margin-right:8px;
}
.upload-section{
    display:flex;
    align-items:center;
    gap:25px;
}

.photo-circle{
    width:90px;
    height:90px;
    border-radius:50%;
    background:#f4f5fb;
    overflow:hidden;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
    border:2px solid #eee;
}

.photo-circle i{
    font-size:42px;
    color:#9aa3b2;
}

.photo-circle img{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:50%;
}

.upload-text label{
    color:#ff3b30;
    font-size:20px;
    font-weight:600;
    cursor:pointer;
}
@media(max-width:768px){

    .resume-card{
        padding:22px;
        border-radius:16px;
    }

    .upload-section{
        flex-direction:column;
        align-items:flex-start;
    }

    .photo-circle{
        margin-bottom:15px;
    }

    .form-title{
        font-size:24px;
    }

}
</style>
<section class="resume-builder-section">

    <div class="resume-card">

        <h3 class="form-title">Candidate Details</h3>

        <form method="post" action="<?= base_url('jobseeker/save_resume_home_form') ?>" enctype="multipart/form-data">

            <!-- Upload Photo -->
            <div class="upload-section">
                <div class="photo-circle">
                    <img id="photoPreview" src="" alt="" style="display:none;">
                    <i class="bi bi-person" id="defaultIcon"></i>
                </div>

                <div class="upload-text">
                    <label for="profile_photo"> Upload Photo </label>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" hidden>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" name="full_name" placeholder="Full Name">
                </div>
               	<div class="col-md-6 mb-3">
				    <select class="form-control" name="job_role" id="job_role" required>
    				    <option value="">Select Job Role</option>
    				    <?php foreach ($job_role as $role): ?>
    				        <option value="<?= esc($role['job_id']) ?>">
    				            <?= esc($role['job_role']) ?>
    				        </option>
    				    <?php endforeach; ?>
					</select>
				</div>

                <div class="col-md-6 mb-3">
                    <input type="email"
                           class="form-control"
                           name="email"
                           id="email"
                           placeholder="Email" required>
                            <span id="emailError" style="color:red; font-size:13px; display:none;"></span>
                </div>

                <div class="col-md-6 mb-3">
                    <input type="text"
                           class="form-control"
                           name="mobile" id="mobile_no"
                           placeholder="Phone" maxlength="10"  required>
                    <small id="mobileError" style="color:red; display:none;">
                        Enter valid 10 digit mobile number
                    </small>
                </div>
                <div class="col-md-6 mb-3">
                     <select class="form-control form-control-md" name="education" id="qualification_job" data-live-search="true" data-size="5" required>
                     
                      <option value="">Select Category</option>
                      <?php foreach ($qualifications as $q): ?>
                        <option value="<?= esc($q['qual_id']) ?>">
                          <?= esc($q['qualification_name']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                        <select class="form-control form-control-md" name="course" id="course_job" data-live-search="true" data-size="5" style="padding:0px;" required>
                    <option value="">Select Higher Qualification</option>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                    <select class="form-control" name="current_city" id="current_city" data-live-search="true" data-size="5"  required>

				    <option value="">Select Current City</option>

				    <?php foreach ($locations as $ct): ?>

				        <option value="<?= esc($ct['name']) ?>">
				            <?= esc($ct['name']) ?>
				        </option>

				    <?php endforeach; ?>

					</select>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="row">
                              <div class="col-6">
                                  <select name="experience_years" id="experience_years" class="form-control form-control-md" data-live-search="true" data-size="5">
                                      <option value="">Exp Years</option>
                                      <?php for($i=0; $i<=50; $i++): ?>
                                          <option value="<?= $i ?>"><?= $i ?> Year<?= $i != 1 ? 's' : '' ?></option>
                                      <?php endfor; ?>
                                  </select>
                              </div>

                              <div class="col-6">
                                  <select name="experience_months" id="experience_months" class="form-control form-control-md" data-live-search="true" data-size="5">
                                      <option value="">Exp Months</option>
                                      <?php for($i=0; $i<=11; $i++): ?>
                                          <option value="<?= $i ?>"><?= $i ?> Month<?= $i != 1 ? 's' : '' ?></option>
                                      <?php endfor; ?>
                                  </select>
                              </div>
                          </div>
                </div>

                <div class="col-md-12 mb-3">
                    <input type="url"
                           class="form-control"
                           name="linkedin_url"
                           placeholder="linkedin Url">
                </div>

                <div class="col-md-12 mb-3">

                    <textarea class="ckeditor" name="key_skills"></textarea>

                </div>
                

                <div class="col-md-12 mb-3">
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
                <div class="col-md-12">

                    <button type="submit" class="generate-btn">

                        <i class="bi bi-stars"></i>

                        Generate Resume

                    </button>

                </div>

            </div>

        </form>

    </div>

</section>

<script src="<?= base_url('assets/jobportal/js/mobile-email-validation.js') ?>?v=<?= time() ?>"></script>

