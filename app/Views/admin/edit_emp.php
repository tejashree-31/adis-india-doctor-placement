<?php 
use Config\Database;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<meta name="csrf-header" content="<?= csrf_token() ?>">
<title>Edit Empolyee</title>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<style>
/*    #editor { min-height:400 px; }*/
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
            <h5 class="mb-0">Edit Employer &nbsp;<a href="<?= base_url('admin/client_details') ?>" class="btn btn-light">
                <i class="fa fa-arrow-left"></i>
            </a></h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('update-emp') ?>" method="post" id="blogForm" enctype="multipart/form-data">
                <input type="hidden" id="user_type" name="user_type" class="form-control form-control-md" value="recruiter">
                <input type="hidden" name="uid" value="<?= isset($single_emp_edit['uid']) ? esc($single_emp_edit['uid']) : ''; ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email_id" class="form-label">Email</label>
                           <input type="email" class="form-control form-control-md" name="institute_email" id="institute_email" placeholder="Institution Email" value="<?= isset($single_emp_edit['email']) ? esc($single_emp_edit['email']) : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                     <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" id="password" name="password" class="form-control form-control-md" value="<?= isset($single_emp_edit['password']) ? esc($single_emp_edit['password']) : '' ?>" >
                    </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <!-- Industry -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry</label>
                            <select class="form-control form-control-md selectpicker" name="industry_name" id="industry1" required data-live-search="true">
                                <option value="">Select Industry</option>
                                <?php 
                                $db = \Config\Database::connect();
                                $industry = $db->query("SELECT * FROM tbl_industry")->getResultArray(); 
                                foreach ($industry as $ind): 
                                    $selected = (isset($single_emp_edit['industry_name']) && $single_emp_edit['industry_name'] == $ind['industry_id']) ? 'selected' : '';
                                ?>
                                    <option value="<?= esc($ind['industry_id']) ?>" <?= $selected ?>>
                                        <?= esc($ind['industry_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" id="hospitalTypeDiv1" style="display: none;">
                        <label>Type of Hospital</label>
                        <?php $selectedType = $single_emp_edit['type_hospital'] ?? ''; ?>
                        <select id="hospital-type" name="type_hospital" class="form-control form-control-md">
                            <option value="">Select Type</option>
                            <option value="Multi Speciality" <?= $selectedType == 'Multi Speciality' ? 'selected' : '' ?>>Multi Speciality</option>
                            <option value="Super Speciality" <?= $selectedType == 'Super Speciality' ? 'selected' : '' ?>>Super Speciality</option>
                            <option value="General Hospital" <?= $selectedType == 'General Hospital' ? 'selected' : '' ?>>General Hospital</option>
                            <option value="Clinic" <?= $selectedType == 'Clinic' ? 'selected' : '' ?>>Clinic</option>
                        </select>
                    </div>

                    <!-- Institute Name -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="institute" class="form-label">Institute Name</label>
                             <input type="text" class="form-control form-control-md" name="institute_name" id="institute_name" value="<?= isset($single_emp_edit['institute_name']) ? esc($single_emp_edit['institute_name']) : '' ?>" >
                             <small id="institute_error" class="text-danger"></small>
                        </div>
                    </div>

                    <!-- Display Name -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="display_name" class="form-label">Display Name</label>
                            <input type="text" class="form-control form-control-md" name="company_display_name" id="company-name" value="<?= isset($single_emp_edit['institute_name']) ? esc($single_emp_edit['company_display_name']) : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <!-- Industry -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="industry" class="form-label">Recruiter Name</label>
                            <input type="text" class="form-control form-control-md" name="recruiter_name" id="company-website" value="<?= isset($single_emp_edit['recruiter_name']) ? esc($single_emp_edit['recruiter_name']) : '' ?>">
                        </div>
                    </div>
                  
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control form-control-md" name="mobile_number" id="company-website-fb" value="<?= isset($single_emp_edit['mobile_number']) ? esc($single_emp_edit['mobile_number']) : '' ?>">
                        </div>
                    </div>
               
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <label for="country" class="form-label">Country <span style="color: red;">* </span></label>
                        <?php $selected_country_id = isset($single_emp_edit['country_id']) 
    ? $single_emp_edit['country_id']  : ''; ?>
                        <select class="form-control form-control-md" name="country_id" id="country_id" data-live-search="true" required>
                            
                            <?php 
                            $country = $db->query("SELECT country_id, country_name FROM tbl_country ORDER BY country_name ASC")->getResultArray();
                            foreach ($country as $dis_country): 
                                $selected = ($dis_country['country_id'] == $selected_country_id) ? 'selected' : '';
                            ?>
                                <option value="<?= esc($dis_country['country_id']) ?>" <?= $selected ?>>
                                    <?= esc($dis_country['country_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <?php 
                                $selected_state = isset($single_emp_edit['state_id']) ? $single_emp_edit['state_id'] : ''; ?>
                        <label for="state_id" class="form-label">State <span style="color: red;">* </span></label>
                       <select name="state_id" id="state_id_edit" class="form-control" data-selected="<?= $selected_state ?>" required>
                        <option value="">Select State</option>
                        </select>

                    </div>
                    <div class="col-md-3">
                       <?php $selected_district = isset($single_emp_edit['district_id']) ? $single_emp_edit['district_id']  : ''; ?>
                        <label for="district_id" class="form-label">District <span style="color: red;">* </span></label>
                       <select name="district_id" id="district_id_edit" class="form-control" data-selected="<?= $selected_district ?>" required>
                        <option value="">Select District</option>
                        </select>

                    </div>
                    <div class="col-md-3">
                        <?php $selected_city = isset($single_emp_edit['id']) ? $single_emp_edit['id'] : ''; ?>
                        <label for="city_id" class="form-label">City <span style="color: red;">* </span></label>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addcityBtn_admin_edit">
                            <i class="fas fa-plus"></i> Add</button>
                       <select name="city_id" id="city_id_edit" class="form-control" data-selected="<?= $selected_city ?>" required>
                        <option value="">Select city</option>
                        </select>
                         <div id="cityInputWrapper_admin_edit" class="mt-2" style="display: none;">
                                <input type="text" id="newcity_admin_edit" class="form-control form-control-sm" placeholder="Enter new job role">
                                <button type="button" class="btn btn-sm btn-success mt-1" id="savecity_admin_edit">Save</button>
                                 <button type="button" class="btn btn-sm btn-danger mt-1" id="cancelcity_admin_edit">
                                  <i class="fas fa-times"></i> Cancel
                                </button>
                              </div>
                    </div>
               
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-12 ">
                       <label for="area_name" class="form-label">Hospital Full Address</label>
                           <textarea class="form-control form-control-md" name="area_name" id="area_name" placeholder="Hospital Full Address"><?= isset($single_emp_edit['area_name']) ? esc($single_emp_edit['area_name']) : '' ?></textarea>
                    </div>
                </div>
                <div class="row g-3 mt-4">
                    <!-- Industry -->
                    <div class="col-md-4">
                        <div class="mb-3">
                           <label for="institute" class="form-label">Select Image</label>
                            <input type="file" id="imageInput" name="logo" class="form-control form-control-md" accept="image/*" >
                        </div>

                    </div>
                    <div class="col-md-4">
                   <?php 
                    $logoPath = !empty($single_emp_edit['logo']) 
                        ? base_url('public/uploads/' . $single_emp_edit['logo']) 
                        : base_url('public/images/default-logo.png'); 
                    ?>
                    <img id="preview" src="<?= esc($logoPath) ?>" style="max-width:200px; border:1px solid #ccc; padding:5px;" alt="Logo Preview">

                    </div>
                     <div class="col-md-4">
                         <div class="mb-3">
                            <label for="addleadBtn_admin" class="form-label">Lead From</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="addleadBtn_admin">
                                        <i class="fas fa-plus"></i> Add
                                    </button>

                                    <select class="form-control form-control-md"
                                            name="lead_name"
                                            id="lead_admin"
                                            title="Lead From"
                                            required>

                                        <option value="">Select Lead From</option>

                                        <?php foreach ($display_lead as $lead): ?>
                                            <option value="<?= esc($lead['lead_id']) ?>"
                                                <?= (!empty($single_emp_edit['lead_id']) && $single_emp_edit['lead_id'] == $lead['lead_id']) ? 'selected' : '' ?>>
                                                <?= esc($lead['lead_name']) ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>

                                    <div class="invalid-feedback" id="leadError_admin" style="display: none;">
                                        Please select a Lead From
                                    </div>

                                    <!-- Hidden Input Field -->
                                    <div id="leadInputWrapper_admin" class="mt-2" style="display: none;">
                                        <input type="text" id="newlead_admin"
                                               class="form-control form-control-md"
                                               placeholder="Enter new Lead">

                                        <button type="button" class="btn btn-sm btn-success mt-1" id="savelead_admin">
                                            Save
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger mt-1" id="cancellead_admin">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                    </div>
                        </div>
                      
                       
                    </div>
                 
                </div>
                <div class="row g-3 mt-4">
                    <div class="col-md-3">
                        <label for="final_agreement" class="form-label">Final Agreement %</label>
                            <input type="text" 
                                   class="form-control form-control-md" 
                                   name="final_agreement" 
                                   id="final_agreement" 
                                   placeholder="Final Agreement"
                                   value="<?= isset($single_emp_edit['final_agreement']) ? esc($single_emp_edit['final_agreement']) : '' ?>">
                            <span id="agreementError" class="text-danger"></span>
                        
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                        <label for="advanced_payment" class="form-label label_color">Advanced Payment</label>
                            <input type="text" 
                                   class="form-control form-control-md" 
                                   name="advanced_payment" 
                                   id="advanced_payment" 
                                   placeholder="Advanced Payment"
                                   value="<?= isset($single_emp_edit['advanced_payment']) ? esc($single_emp_edit['advanced_payment']) : '' ?>">
                            <span id="advance_payment_Error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                            <div class="mb-4">
                                    <label>Recruiter GSTIN No:.</label>
                                    <input type="text" 
                                       class="form-control form-control-md" 
                                       name="recruiter_gstin_no" 
                                       id="recruiter_gstin_no" 
                                       placeholder="Enter GSTIN"
                                       value="<?= isset($single_emp_edit['recruiter_gstin_no']) ? esc($single_emp_edit['recruiter_gstin_no']) : '' ?>">
                                    <!-- <span id="advance_payment_Error" class="text-danger"></span> -->
                            </div>
                    </div>
                    <div class="col-md-3">
                       <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </div>
                </div>
                

                
             
                <!-- <button type="submit" class="btn btn-primary">Update</button> -->
            </form>
        </div>
    </div>
</div>

</body>
</html>
