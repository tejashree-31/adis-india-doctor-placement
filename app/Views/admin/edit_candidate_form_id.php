<?php 
use Config\Database;

  
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="<?= csrf_hash() ?>">
<meta name="csrf-header" content="<?= csrf_token() ?>">
<title>Edit Candidate</title>
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
            <h5 class="mb-0">Edit Candidate &nbsp;<a href="<?= base_url('admin/signup_admin_candidate') ?>" class="btn btn-light">
            <i class="fa fa-arrow-left"></i>
            </a></h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('update_signup_candidate_new') ?>" method="post" id="blogForm" enctype="multipart/form-data">
                <input type="hidden" id="login_status" name="login_status" class="form-control form-control-md" value="active">
                <input type="hidden" id="uid" name="uid" class="form-control form-control-md" value="<?= esc($uid) ?>">
                <input type="hidden" id="email" name="email" class="form-control form-control-md" value="<?= esc($user['email']) ?>">
                <input type="hidden" id="mobile_number" name="mobile_number" class="form-control form-control-md" value="<?= esc($user['mobile_no']) ?>">

                 <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-control form-control-md" value="<?= esc($user['email']) ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" id="mobile_number" name="mobile_number" class="form-control form-control-md" value="<?= esc($user['mobile_no']) ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                           <input type="text" class="form-control form-control-md" name="full_name" id="full_name" placeholder="Full Name" value="<?= !empty($user['full_name']) ? esc($user['full_name']) : '-'; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                     <div class="mb-3">
                        <label for="password" class="form-label">Job Role</label>
                        <select class="form-control form-control-md" name="job_role" id="job_role_admin" data-live-search="true" title="Job Role" required>
                                <option value="">Select Job Role</option>
                                  <?php foreach ($job_role as $role): ?>
                                <option value="<?= esc($role['job_id']) ?>"
                                    <?= (!empty($user['job_id']) && (int)$user['job_id'] == (int)$role['job_id']) ? 'selected' : '' ?>>
                                    <?= esc($role['job_role']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email_id" class="form-label">Category</label>
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
                        </div>
                    </div>
                    <div class="col-md-6">
                     <div class="mb-3">
                        <label for="password" class="form-label">Higher Qualification</label>
                        <select class="form-control form-control-md" name="course" id="course_admin" data-live-search="true" >
                                <option value="">Select Courses</option>
                        </select>
                    </div>
                    </div>
                </div>
                 <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary mt-3">Publish</button>
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
