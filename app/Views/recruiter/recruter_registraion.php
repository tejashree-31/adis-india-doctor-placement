<?php $session = session(); 
$email = session()->get('email');
use Config\Database;

?>

<style>
  .preview-container {
      margin-top: 20px;
      position: relative;
      display: inline-block;
    }

    .circular-image {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #4CAF50;
    }

    .icon-btn {
      background: none;
      border: none;
      cursor: pointer;
      font-size: 20px;
      margin: 10px 6px;
      display: none;
    }

    .icon-btn.upload-label {
      font-size: 24px;
      display: inline-block;
    }
#imageInput_job {
      display: none;
    }
</style>

<section class="site-section">
  <div class="container">
    <div class="row">
      
      <!-- 🧭 Left Column: Registration Form -->
      <div class="col-md-7">
        <form class="p-4 p-md-5 border rounded" id="myForm" method="post" enctype="multipart/form-data" action="<?= base_url('recruiter/save_recruiter_form') ?>">
          
          <h3 class="text-black mb-5 border-bottom pb-2">Recruiter Registration</h3>

          <!-- Logo Upload -->
          <div class="form-group mb-4">
            <label for="imageInput" class="icon-btn upload-label" title="Upload Image">⬆️</label>
            <input type="file" id="imageInput" name="logo" accept="image/*" class="form-control form-control-md">
            <div class="preview-container">
              <img id="previewImage" class="circular-image" src="" style="display: none;">
            </div>
            <div>
              <button type="button" class="icon-btn" id="editBtn" title="Change Image">🖉</button>
              <button type="button" class="icon-btn" id="deleteBtn" title="Delete Image">🗑️</button>
            </div>
          </div>

          <!-- Industry and City -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="industry">Industry</label>
              <select class="form-control form-control-md selectpicker" name="industry_name" id="industry" required data-live-search="true">
                <option value="">Select Industry</option>
                <?php 
                  $db = Database::connect();
                  $industry = $db->query("SELECT * FROM tbl_industry")->getResultArray(); 
                  foreach ($industry as $location): ?>
                    <option value="<?= esc($location['industry_id']) ?>"><?= esc($location['industry_name']) ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Please select an industry.</div>
            </div>
            <div class="form-group col-md-6">
              <label>City/Town</label>
              <select class="form-control form-control-md selectpicker" data-size="5" name="city" id="job-region" data-live-search="true" title="City/Town" required>
                <option value="">Anywhere</option>
                <?php 
                  $locations = $db->query("SELECT * FROM cities")->getResultArray();
                  foreach ($locations as $location): ?>
                    <option value="<?= esc($location['id']) ?>"><?= esc($location['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Hospital Type (Optional) -->
          <div class="form-group mb-4" id="hospitalTypeDiv" style="display: none;">
            <label>Type of Hospital</label>
            <select id="hospital-type" name="type_hospital" class="form-control form-control-md">
              <option value="">Select Type</option>
              <option value="Multi Speciality">Multi Speciality</option>
              <option value="Super Speciality">Super Speciality</option>
              <option value="General Hospital">General Hospital</option>
              <option value="Clinic">Clinic</option>
            </select>
          </div>

          <!-- Institution Name & Display Name -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Name</label>
              <input type="text" class="form-control form-control-md" name="institute_name" id="institute_name" placeholder="Institution Name" required>
              <div class="invalid-feedback">Institution name is required.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="company-name">Display Name</label>
              <input type="text" class="form-control form-control-md" name="company_display_name" id="company-name" placeholder="Display Name" required>
              <div class="invalid-feedback">Display Name is required</div>
            </div>
          </div>

          <!-- Area and Recruiter Name -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Area Name</label>
              <input type="text" class="form-control form-control-md" name="area_name" id="job-location" placeholder="Area Name">
              <div class="invalid-feedback">Area Name is required</div>
            </div>
            <div class="form-group col-md-6">
              <label for="company-website">Recruiter Name</label>
              <input type="text" class="form-control form-control-md" name="recruiter_name" id="company-website" placeholder="Recruiter Name" required>
              <div class="invalid-feedback">Recruiter Name is required</div>
            </div>
          </div>

          <!-- Pincode & Mobile -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Pincode</label>
              <input type="text" class="form-control form-control-md" name="pincode" id="company-tagline" placeholder="Pincode">
              <div class="invalid-feedback" id="pincodeError">Please enter a valid 6-digit pincode.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Mobile Number</label>
              <input type="text" class="form-control form-control-md" name="mobile_number" id="company-website-fb" placeholder="Mobile Number" required>
              <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
            </div>
          </div>

      
          <div class="form-row align-items-end">
            <!-- Email input -->
            <div class="form-group col-md-7">
              <label>Email</label>
              <input type="email" class="form-control form-control-md" name="email" id="email" value="<?= $email ?>" readonly>
            </div>

       

            <!-- Save button -->
            <div class="form-group col-auto">
              <label>&nbsp;</label>
              <button type="submit" class="btn btn-primary btn-md d-block" id="saveBtn" disabled>
                <i class="fa fa-save mr-1"></i> Save
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- 🖼️ Right Column: Image -->
      <div class="col-md-5 d-flex align-items-center justify-content-center">
        <img src="<?= base_url('assets/jobportal/images/gif/new1.gif') ?>" alt="Recruiter Visual" class="img-fluid rounded" style="max-width: 100%; height: auto;">
      </div>
    </div>
  </div>
</section>
