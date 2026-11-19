<?php 
use Config\Database;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Blog</title>
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
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add Empolyer</h5>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('save-employer') ?>" method="post" id="blogForm" enctype="multipart/form-data">
                <?php 
            $otp_str = str_shuffle("0123456789");
            $otp = substr($otp_str, 0, 5);
            $act_str = rand(100000, 10000000);
            $activation_code = str_shuffle("abcdefghijklmno" . $act_str);
          ?>
          <input type="hidden" name="otp" value="<?= $otp; ?>">
            <input type="hidden" name="activation_code" value="<?= $activation_code; ?>">
            <input type="hidden" id="user_type" name="user_type" class="form-control form-control-md" value="recruiter">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email_id" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-md" 
               name="institute_email" id="institute_email" placeholder="Institution Email" readonly required>
                        </div>
                    </div>
                    <div class="col-md-6">
                     <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" id="password" name="password" class="form-control form-control-md" value="adisjobsplacement" readonly>
                    </div>
                    </div>
                </div>
                
                <div class="row g-3 mt-2">
                    <!-- Industry -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry <span style="color: red;">*</span></label>
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
                        <label>Type of Hospital <span style="color: red;">*</span></label>
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
                            <label for="institute" class="form-label">Institute Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control form-control-md" name="institute_name" id="institute_name" placeholder="Institution Name" required>
                             <small id="institute_error" class="text-danger"></small>
                        </div>
                    </div>

                    <!-- Display Name -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="display_name" class="form-label">Display Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control form-control-md" name="company_display_name" id="company-name" placeholder="Display Name" required>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <!-- Industry -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="industry" class="form-label">Recruiter Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control form-control-md" name="recruiter_name" id="company-website" placeholder="Recruiter Name" required>
                        </div>
                    </div>
                  
                     <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number <span style="color: red;">*</span></label>
                             <input type="text" class="form-control form-control-md" name="mobile_number" id="company-website-fb" placeholder="Mobile Number" required>
                        </div>
                    </div>
                     <!-- city Name -->
                    <!--<div class="col-md-3">
                        <div class="mb-3">
                            <label for="city" class="form-label">City/Town <span style="color: red;">* </span></label>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="addcityBtn_admin">
                            <i class="fas fa-plus"></i> Add</button>
                            <select class="form-control form-control-md" name="city_id" id="city_id" data-live-search="true" title="City/Town" required>
                            <option value="">Anywhere</option>
                            <?php 
                              $locations = $db->query("SELECT * FROM cities")->getResultArray();
                              foreach ($locations as $location): ?>
                                <option value="<?= esc($location['id']) ?>"><?= esc($location['name']) ?></option>
                            <?php endforeach; ?>
                          </select>
                          <div id="cityInputWrapper_admin" class="mt-2" style="display: none;">
                                <input type="text" id="newcity_admin" class="form-control form-control-sm" placeholder="Enter new job role">
                                <button type="button" class="btn btn-sm btn-success mt-1" id="savecity_admin">Save</button>
                                 <button type="button" class="btn btn-sm btn-danger mt-1" id="cancelcity_admin">
                                  <i class="fas fa-times"></i> Cancel
                                </button>
                              </div>
                        </div>
                    </div>-->
                    <!-- pincode Name -->
                    <!-- <div class="col-md-3">
                       <label for="pincode" class="form-label">Pincode</label>
                          <input type="text" class="form-control form-control-md" name="pincode" id="cities_pincode" placeholder="Pincode">
                    </div> -->
                </div>
                
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label for="country" class="form-label">Country <span style="color: red;">* </span></label>
                        <select class="form-control form-control-md" name="country_id" id="country_id" data-live-search="true" title="country_id" required>
                            <option value="">Anywhere</option>
                            <?php 
                              $country = $db->query("SELECT * FROM tbl_country")->getResultArray();
                              foreach ($country as $dis_country): ?>
                                <option value="<?= esc($dis_country['country_id']) ?>"><?= esc($dis_country['country_name']) ?></option>
                            <?php endforeach; ?>
                          </select>
                        
                    </div>
                    <div class="col-md-3">
                        <label for="state_id" class="form-label">State <span style="color: red;">* </span></label>
                        <select class="form-control form-control-md" name="state_id" id="state_id" required>
                            <option value="">Select State</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="district_id" class="form-label">District <span style="color:red;">* </span></label>
                        <select class="form-control form-control-md" name="district_id" id="district_id" required>
                            <option value="">Select District</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                     
                            <label for="city" class="form-label">City/Town <span style="color: red;">* </span></label>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="addcityBtn_admin">
                            <i class="fas fa-plus"></i> Add</button>
                            <select class="form-control form-control-md" name="city_id" id="city_id" data-live-search="true" title="City/Town" required>
                             <option value="">Select City</option>
                          </select>

                          <div id="cityInputWrapper_admin" class="mt-2" style="display: none;">
                                <input type="text" id="newcity_admin" class="form-control form-control-sm" placeholder="Enter new job role">
                                <button type="button" class="btn btn-sm btn-success mt-1" id="savecity_admin">Save</button>
                                 <button type="button" class="btn btn-sm btn-danger mt-1" id="cancelcity_admin">
                                  <i class="fas fa-times"></i> Cancel
                                </button>
                              </div>
                      
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12">
                       <label for="area_name" class="form-label">Hospital Full Address <span style="color: red;">*</span></label>
                       <textarea class="form-control form-control-md" name="area_name" id="area_name" placeholder="Hospital Full Address"></textarea>
                          <!-- <input type="text" class="form-control form-control-md" name="area_name" id="area_name" placeholder="Area Name"> -->
                    </div>
                    <!-- Industry -->
                </div>
                <div class="row g-3 mt-2">
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
                        <div class="mb-4">
                                <label>Registration Type</label>
                                <div>
                                    <label class="me-3">
                                        <input type="radio" name="company_regis_type" value="free" id="radio_free"> Free
                                    </label>&nbsp;

                                    <label>
                                        <input type="radio" name="company_regis_type" value="paid" id="radio_paid"> Paid
                                    </label>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-3" id="paid_input_box" style="display:none;">
                        <div class="mb-3">
                            <label>Enter Amount</label>
                            <input type="text" class="form-control" id="paid_amount" name="company_registraion"
                                  value="10,000.00" readonly>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3" style="padding-top: 19px;">
                         <button type="submit" class="btn btn-primary mt-3">Save</button>
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
