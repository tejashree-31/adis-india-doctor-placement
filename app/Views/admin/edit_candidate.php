<?php 
use Config\Database;
$db = Database::connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Empolyee</title>
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
            <h5 class="mb-0">Edit Candidate &nbsp;<a href="<?= base_url('admin/registration_admin_candidate') ?>" class="btn btn-light">
    <i class="fa fa-arrow-left"></i>
</a></h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('update-candidate') ?>" method="post" id="blogForm" enctype="multipart/form-data">
                <!-- <input type="hidden" id="user_type" name="user_type" class="form-control form-control-md" value="recruiter"> -->
                <input type="hidden" name="uid" value="<?= isset($single_candidate_edit['uid']) ? esc($single_candidate_edit['uid']) : ''; ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                           <input type="text" class="form-control form-control-md" name="full_name" id="full_name" placeholder="Full Name" value="<?= isset($single_candidate_edit['full_name']) ? esc($single_candidate_edit['full_name']) : '' ?>">
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email_id" class="form-label">Email</label>
                           <input type="email" class="form-control form-control-md" name="email" id="institute_email" placeholder="Institution Email" value="<?= isset($single_candidate_edit['email']) ? esc($single_candidate_edit['email']) : '' ?>" readonly>
                        </div>
                    </div>
                  
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                           
                             <label for="mobile_number" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control form-control-md" name="mobile_number" id="company-website-fb" value="<?= isset($single_candidate_edit['mobile_number']) ? esc($single_candidate_edit['mobile_number']) : '' ?>">
                           

                        </div>
                    </div>
                     <div class="col-md-4">
                             <div class="mb-3">
                            <label for="city" class="form-label">City/Town</label>
                     
                             <select class="form-control form-control-md" name="city_id" id="city_id" data-live-search="true" title="City/Town" required>
                                <option value="">Anywhere</option>
                                <?php 
                                  $locations = $db->query("SELECT * FROM cities")->getResultArray();
                                  $selectedCity = isset($single_candidate_edit['current_city']) ? $single_candidate_edit['current_city'] : '';
                                  foreach ($locations as $location): 
                                    $isSelected = ($location['id'] == $selectedCity) ? 'selected' : '';
                                ?>
                                  <option value="<?= esc($location['id']) ?>" <?= $isSelected ?>><?= esc($location['name']) ?></option>
                             <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="mb-3">
                            <label for="job_role" class="form-label">Job Role</label>
                            <select class="form-control form-control-md" name="job_role" id="job_role" data-live-search="true" title="job_role" required>
                                <?php 
                                $job_role = $db->query("SELECT * FROM tbl_job_role")->getResultArray();
                                foreach ($job_role as $job_roles): 
                                  $selected = (isset($single_candidate_edit['job_id']) && $single_candidate_edit['job_id'] == $job_roles['job_id']) ? 'selected' : '';
                              ?>
                                <option value="<?= esc($job_roles['job_id']) ?>" <?= $selected ?>>
                                  <?= esc($job_roles['job_role']) ?>
                                </option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                    </div>

                </div>
                <div class="row g-3 mb-3">
                    <!-- <div class="mb-3"> -->

                        <div class="col-md-12">
                                <label for="expected_cities">Interested Location</label>
                              <select class="form-control selectpicker" id="expected_cities" name="expected_cities[]" multiple data-live-search="true" data-size="5" data-actions-box="false" required>
                                <?php 
                                  $selectedCities = [];
                                  if (isset($single_candidate_edit['expected_cities']) && $single_candidate_edit['expected_cities'] != '') {
                                    $selectedCities = explode(',', $single_candidate_edit['expected_cities']);
                                  }
                                  foreach ($locations as $location):
                                    $isSelected = in_array((string)$location['id'], $selectedCities) ? 'selected' : '';
                                ?>
                                  <option value="<?= esc($location['id']) ?>" <?= $isSelected ?>><?= esc($location['name']) ?></option>
                                <?php endforeach; ?>
                              </select>
                        </div>
                    <!-- </div> -->
                 </div>
                <div class="row g-3">
                    <div class="col-md-12">
                         <label for="additional_qualification" class="form-label">Additional Qualification</label>
                         <textarea class="form-control form-control-md" name="fellowship" id="fellowship"><?= isset($single_candidate_edit['fellowship']) ? esc($single_candidate_edit['fellowship']) : '' ?></textarea>
                           
                        </div>
                    </div>
               
                <div class="row g-3">
                      <div class="col-md-4">
                        <div class="mb-3">
                              <button type="submit" class="btn btn-primary mt-3">Update</button>

                        </div>
                    </div>
                </div>
             

                
             
                <!-- <button type="submit" class="btn btn-primary">Update</button> -->
            </form>
        </div>
    </div>
</div>

</body>
</html>
