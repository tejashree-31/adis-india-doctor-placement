<pre><?php 
use Config\Database;
$session = session();
$user_id = $session->get('uid');
$db = Database::connect();

$builder = $db->table('tbl_recruiter');
$recruiter_form = $builder->where('uid', $user_id)->get()->getRowArray();
$user = $db->table('tbl_user');
$usercp = $user->where('uid', $user_id)->get()->getRowArray();
$about = $db->table('tbl_about');
$adescription = $about->where('uid', $user_id)->get()->getRowArray();
$locations = $db->query("SELECT * FROM cities")->getResultArray();
$industry = $db->query("SELECT * FROM tbl_industry")->getResultArray();
$gallery = $db->table('tbl_gallery'); // or 'tbl_gallery' if that's your actual table name
$displaygallery = $gallery->where('uid', $user_id)->orderBy('id', 'DESC')->get()->getResultArray();

    $recruiter_name= $recruiter_form['recruiter_name'];
    $companyProfile = $recruiter_form['logo'] ?? '';
    $about_description =  $adescription['about_description'] ?? '';
    $firstLetter = strtoupper(substr($recruiter_name, 0, 1));
$selectedIndustry = $data['industry_name'] ?? ''; 
 ?></pre>
 <style type="text/css">
   .font-span
   {
      color : #a18a8a;
   }
   .head-title
   {
    color : #860C15 !important;
    font-weight: bold;
   }
   .btn4
   {
    margin-top: 38px;
   }
 </style>
<div class="container py-4 mt-5">
  <nav aria-label="breadcrumb" class="py-2">
      <div class="container">
        <ol class="breadcrumb mb-0">
          <!-- <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li> -->
          <li class="breadcrumb-item"><a href="<?= base_url('recruiter/publishsavedraft') ?>">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Company Profile</li>
        </ol>
      </div>
  </nav>
  <div class="row">
    <div class="col-md-12">
        <div class="text-center mb-4">
          
        </div>
        <div class="tab-content border p-4 bg-white shadow-sm rounded" id="jobTabContent">
            <div class="tab-pane fade show active" id="publish"> 
                <div class="container-fluid py-4">
                    <div class="row">
                      <div class="col-12 mb-4">
                        <div class="card1 border-success w-100">
                          <div class="card-body text-start px-4">
                            <!-- <h3 class="mb-2 text-center"><b>Job Details </b></h3><br> -->

                            <div class="row">
                              <div class="col-md-6">
                                <div class="logo-container">
                                  <div class="logo-box" id="logoDisplay">
                                      <?php if (!empty($companyProfile)): ?>
                                        <img src="<?= base_url('public/uploads/' . $companyProfile) ?>" id="logoImage" alt="Company Logo">
                                      <?php else: ?>
                                        <span id="initialLetter"><?= esc($firstLetter) ?></span>
                                      <?php endif; ?>

                                      <!-- Upload trigger -->
                                      <label for="imageUpload" class="camera-icon">&#x1F4F7;</label>
                                    </div>

                                    <!-- Hidden input -->
                                    <input type="file" id="imageUpload" name="compny_profile" hidden>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <p class="mb-2">About</p>
                               <div class="editable-container">
                                    <!-- Show about text from DB -->
                                    <div class="static-text" id="companyText"><?= esc($about_description) ?></div>

                                    <!-- Hidden textarea -->
                                    <textarea id="editTextarea" name="about_description" class="form-control" style="display: none;"></textarea>

                                    <!-- Edit ✏️ icon -->
                                    <label class="edit-icon" id="editTrigger">&#x270F;&#xFE0F;</label>
                              </div>

                              </div>
                            </div>
                     
                            <hr style="border: 1px solid #ccc; margin: 20px 0;">
                          

                          </div>
                        </div>
                      </div>

                      <div class="col-12 mb-4">
                        <div class="card1 border-success w-100">
                          <div class="card-body text-start px-4">
                            <!-- <h3 class="mb-2 text-center"><b>Job Details </b></h3><br> -->

                            <div class="row">
                              <div class="col-md-12">
                                  <div class="text-center mb-4">
                                    <button type="button" class="btn btn-outline-success active btn-tab-spacing" id="goToPublish_update">Comapany Details</button>
                                    <button type="button" class="btn btn-outline-success btn-tab-spacing" id="goToDraft_update">Gallery</button>
                                    <!-- <button type="button" class="btn btn-outline-success btn-tab-spacing" id="goToPreview_update">Preview</button> -->
                                  </div>

                                  <!-- Tab Contents -->
                                  <div class="tab-content border p-4 bg-white shadow-sm rounded" id="jobTabContent">

                                    <!-- Publish Tab -->
                                    <div class="tab-pane fade show active" id="publish_update">
                                      <div class="container-fluid py-4">
                                        <form action="<?= base_url('recruiter/edit_recruiter') ?>" method="post">
                                          <input type="hidden" name="recruiter_id" value="<?= isset($data['recruiter_id']) ? esc($data['recruiter_id']) : '' ?>">
                                        <h5 class="text-success head-title">Edit Company Details</h5>
                                        <!-- <p>This is the Publish tab content.</p> -->
                                        <div class="row">
                                          <div class="col-md-6 mt-2">
                                              <p class="mb-2 text-secondary">Address</p>
                                              <input type="text" class="form-control form-control-md" name="req_address" id="req_address" value="<?= isset($data['req_address']) ? esc($data['req_address']) : '' ?>">
                                          </div>
                                          <div class="col-md-6 mt-2">
                                              <p class="mb-2 text-secondary">City</p>
                                                <select class="form-control" name="city" id="job-region" data-live-search="true" title="City/Town">
                                                  <?php 
                                                    foreach ($locations as $location): 
                                                      $selected = (isset($data['city_id']) && $data['city_id'] == $location['id']) ? 'selected' : '';
                                                  ?>
                                                    <option value="<?= esc($location['id']) ?>" <?= $selected ?>>
                                                      <?= esc($location['name']) ?>
                                                    </option>
                                                  <?php endforeach; ?>
                                                </select>
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 mt-2">
                                             <p class="mb-2 text-secondary"> Area Name</p>
                                             <input type="text" class="form-control form-control-md" name="area_name" id="job-location" value="<?= isset($data['area_name']) ? esc($data['area_name']) : '' ?>">
                                          </div>
                                          <div class="col-md-6 mt-2">
                                             <p class="mb-2 text-secondary"> Pincode</p>
                                             <input type="text" class="form-control form-control-md" name="pincode" id="company-tagline" value="<?= isset($data['pincode']) ? esc($data['pincode']) : '' ?>" required>
                                          </div>
                                        </div>

                                        <div class="row">
                                          <div class="col-md-6 mt-2">
                                              <p class="mb-2 text-secondary"> Industry</p>
                                              <select class="form-control form-control-md select" name="industry_name" id="industry1" required data-live-search="true">
                                             <?php foreach ($industry as $location): ?>
                                              <option value="<?= esc($location['industry_id']) ?>" 
                                                <?= $data['industry_name'] == $location['industry_id'] ? 'selected' : '' ?>>
                                                <?= esc($location['industry_name']) ?>
                                              </option>
                                            <?php endforeach; ?>
                                            </select>
                                          </div>
                                          <div class="col-md-6 mt-2">
                                              <p class="mb-2 text-secondary"> Company Name</p>
                                              <input type="text" class="form-control form-control-md" name="institute_name" id="institute_name" value="<?= isset($data['institute_name']) ? esc($data['institute_name']) : '' ?>" >
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-12 mt-2" id="hospitalTypeDiv1" style="display: none;">
                                            <?php $selectedType = $data['type_hospital'] ?? ''; ?>
                                              <p class="mb-2 text-secondary"> Type of Hospital</p>
                                               <select id="hospital-type" name="type_hospital" class="form-control form-control-md">
                                                    <option value="">Select Type</option>
                                               <option value="Multi Speciality" <?= $selectedType == 'Multi Speciality' ? 'selected' : '' ?>>Multi Speciality</option>
                                                <option value="Super Speciality" <?= $selectedType == 'Super Speciality' ? 'selected' : '' ?>>Super Speciality</option>
                                                <option value="General Hospital" <?= $selectedType == 'General Hospital' ? 'selected' : '' ?>>General Hospital</option>
                                                <option value="Clinic" <?= $selectedType == 'Clinic' ? 'selected' : '' ?>>Clinic</option>
                                                </select>
                                          </div>
                                         
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 mt-2">
                                            <p class="mb-2 text-secondary">Display Name</p>
                                            <input type="text" class="form-control form-control-md" name="company_display_name" id="company-name" value="<?= isset($data['institute_name']) ? esc($data['company_display_name']) : '' ?>">
                                          </div>
                                          <div class="col-md-6 mt-2">
                                              <p class="mb-2 text-secondary">Recruiter Namee</p>
                                              <input type="text" class="form-control form-control-md" name="recruiter_name" id="company-website" value="<?= isset($data['recruiter_name']) ? esc($data['recruiter_name']) : '' ?>">
                                          </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-6 mt-2">
                                              <p class="mb-2 text-secondary">Contact Number </p>
                                            <input type="text" class="form-control form-control-md" name="mobile_number" id="company-website-fb" value="<?= isset($data['mobile_number']) ? esc($data['mobile_number']) : '' ?>">

                                          </div>
                                          <div class="col-md-6">
                                              <button type="submit" class="btn btn-primary btn-md d-block btn4" >
                                                <i class="fas fa-save mr-1"></i> Save
                                              </button>
                                          </div>
                                        </div>
                                      </form>

                                      </div>
                                    </div>

                                    <!-- Draft Tab -->
                                    <div class="tab-pane fade" id="draft_update">
                                      <div class="container-fluid py-4">
                                        <form id="galleryForm" enctype="multipart/form-data">
                                            <div class="row">
                                              <div class="col-md-6">
                                                <h5 class="text-success head-title">Gallery</h5>
                                              </div>
                                              <div class="col-md-6">
                                                <input type="file" name="gallery_images[]" id="images" multiple accept="image/*" required>

                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-6">
                                                 <p class="mt-4 text-secondary">Update Company youtube Video</p>
                                                  <input type="url" class="form-control" name="youtube_video" id="youtube_link" placeholder="Update Company youTube Video">
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-6">
                                                <button class="mt-4 btn btn-primary" type="submit">Submit</button>
                                              </div>
                                            </div>
                                        </form>

                                         <!-- <div id="galleryStatus" class="mt-3"></div>
                                         <div id="galleryPreview" class="mt-4"> -->

                                          <?php if (!empty($displaygallery)): ?>
  <div class="row">
    <?php foreach ($displaygallery as $media): ?>
      <?php if (isset($media['type'])): ?>
        <div class="col-md-4 mb-4 position-relative" id="media_<?= esc($media['id']) ?>">
          <?php if ($media['type'] == 'image'): ?>
            <img src="<?= base_url('writable/uploads/' . esc($media['media_value'])) ?>" class="img-fluid rounded shadow" style="max-height: 200px; width: 100%; object-fit: cover;">
          <?php elseif ($media['type'] == 'youtube'): ?>
            <?php
              // extract video ID from YouTube URL
              $video_link = $media['media_value'];
              $video_id = null;
              if (strpos($video_link, 'youtu.be') !== false) {
                $video_id = basename(parse_url($video_link, PHP_URL_PATH));
              } else {
                parse_str(parse_url($video_link, PHP_URL_QUERY), $params);
                $video_id = $params['v'] ?? null;
              }
            ?>
            <?php if ($video_id): ?>
              <iframe width="100%" height="200" src="https://www.youtube.com/embed/<?= esc($video_id) ?>" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>
          <?php endif; ?>

          <!-- ❌ Delete Button -->
          <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-gallery" data-id="<?= esc($media['id']) ?>">×</button>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="text-muted">No gallery items found.</p>
<?php endif; ?>




                                        <!-- <p>This is the Draft tab content.</p> -->
                                      </div>
                                    </div>

                                    <!-- Preview Tab -->
                                    <div class="tab-pane fade" id="preview_update">
                                      <div class="container-fluid py-4">
                                        <h5 class="text-info">Preview Content</h5>
                                        <p>This is the Preview tab content.</p>
                                      </div>
                                    </div>

                                  </div> <!-- End tab-content -->
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
  </div>
</div>










