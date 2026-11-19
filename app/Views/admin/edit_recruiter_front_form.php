<?php 
use Config\Database;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Post Vacancy</title>
<style>
</style>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add Recruiter Form</h5>
            
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
               <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success'); ?>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('admin/save-front-employer') ?>" method="post" id="blogForm" enctype="multipart/form-data">
                <input type="hidden" name="uid" value="<?= $uid; ?>">
                   
              
                <input type="hidden" id="user_type" name="user_type" class="form-control form-control-md" value="recruiter">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email_id" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-md" name="institute_email" id="email" value="<?= isset($recuiterfrontFormDataedit['email']) ? esc($recuiterfrontFormDataedit['email']) : ''; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                     <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" id="password" name="password" class="form-control form-control-md" value="<?= isset($recuiterfrontFormDataedit['password']) ? esc($recuiterfrontFormDataedit['password']) : ''; ?>" readonly>
                    </div>
                    </div>
                </div>
                
                <div class="row g-3 mt-2">
                    <!-- Industry -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry</label>
                            <select class="form-control form-control-md selectpicker" name="industry_name" id="industry" required data-live-search="true">
                                <option value="">Select Industry</option>
                                <?php 
                                  $db = Database::connect();
                                  $industry = $db->query("SELECT * FROM tbl_industry")->getResultArray(); 
                                  foreach ($industry as $location): ?>
                                    <option value="<?= esc($location['industry_id']) ?>"><?= esc($location['industry_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" id="hospitalTypeDiv" style="display: none;">
                        <label>Type of Hospital</label>
                        <select id="hospital-type" name="type_hospital" class="form-control form-control-md">
                          <option value="">Select Type</option>
                          <option value="Multi Speciality">Multi Speciality</option>
                          <option value="Super Speciality">Super Speciality</option>
                          <option value="General Hospital">General Hospital</option>
                          <option value="Clinic">Clinic</option>
                        </select>
                    </div>

                    <!-- Institute Name -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="institute" class="form-label">Institute Name</label>
                            <input type="text" class="form-control form-control-md" name="institute_name" id="institute_name" placeholder="Institution Name" required>
                             <small id="institute_error" class="text-danger"></small>
                        </div>
                    </div>

                    <!-- Display Name -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="display_name" class="form-label">Display Name</label>
                            <input type="text" class="form-control form-control-md" name="company_display_name" id="company-name" placeholder="Display Name" required>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <!-- Industry -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="industry" class="form-label">Recruiter Name</label>
                            <input type="text" class="form-control form-control-md" name="recruiter_name" id="company-website" placeholder="Recruiter Name" required>
                        </div>
                    </div>
                  
                     <div class="col-md-3">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                             <input type="text" class="form-control form-control-md" name="mobile_number" id="company-website-fb" value="<?= isset($recuiterfrontFormDataedit['mobile_no']) ? esc($recuiterfrontFormDataedit['mobile_no']) : ''; ?>" readonly>
                        </div>
                    </div>
                     <!-- city Name -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="city" class="form-label">City/Town</label>
                            <select class="form-control form-control-md selectpicker" name="city_id" id="city_id" data-live-search="true" title="City/Town" required>
                            <option value="">Anywhere</option>
                            <?php 
                              $locations = $db->query("SELECT * FROM cities")->getResultArray();
                              foreach ($locations as $location): ?>
                                <option value="<?= esc($location['id']) ?>"><?= esc($location['name']) ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                    </div>
                    <!-- pincode Name -->
                    <div class="col-md-3">
                       <label for="pincode" class="form-label">Pincode</label>
                          <input type="text" class="form-control form-control-md" name="pincode" id="cities_pincode" placeholder="Pincode">
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                       <label for="area_name" class="form-label">Area Name</label>
                          <input type="text" class="form-control form-control-md" name="area_name" id="area_name" placeholder="Area Name">
                    </div>
                    <!-- Industry -->
                    <div class="col-md-3">
                        <div class="mb-3">
                           <label for="institute" class="form-label">Select Image</label>
                        <input type="file" id="imageInput" name="logo" class="form-control form-control-md" accept="image/*">
                        </div>

                    </div>
                    <div class="col-md-3">
                        <img id="preview" src="" style="max-width:200px; display:none; border:1px solid #ccc; padding:5px;">

                    </div>
                    <div class="col-md-3">
                         <button type="submit" class="btn btn-primary mt-3">Publish</button>
                    </div>
                    <div class="col-md-3">
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
        document.getElementById('imageInput').addEventListener('change', function(event)
    {
        const file = event.target.files[0];
        if(file)
        {
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
