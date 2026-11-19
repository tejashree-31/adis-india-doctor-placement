<body>
<div class="container mt-5">
    <!-- <h1 class="mb-4">Edit Empolyee</h1> -->
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
    <?php endif; ?>
        <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    
            <h5 class="mb-0">
               Candidate Agreement Salary
                <a href="<?= base_url('admin/candidateClosedDetailsData') ?>" class="btn btn-light btn-sm ms-2">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </h5>

            <!-- <span><b>Invoice No : </b><?php //echo $ref_no ?></span> -->

        </div>
        <div class="card-body">
            <form action="<?= base_url('update-candidate-agreement') ?>" method="post" id="update-conformed-salary-form" enctype="multipart/form-data">
                <!-- <input type="text" name="invoice_number" value="<?//= isset($single_posting_edit['invoice_number']) ? esc($single_posting_edit['invoice_number']) : ''; ?>"> -->
               <input type="hidden" name="job_status_id" value="<?= isset($single_candidate_edit_agreement['job_status_id']) ? esc($single_candidate_edit_agreement['job_status_id']) : ''; ?>">
               <input type="hidden" name="jobseeker_id" value="<?= isset($single_candidate_edit_agreement['jobseeker_id']) ? esc($single_candidate_edit_agreement['jobseeker_id']) : ''; ?>">

                
               <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                      <label for="email_id" class="form-label">Candidate Name</label>
                      <input type="text" class="form-control form-control-md" id="candidate_name" name="candidate_name" value="<?= isset($single_candidate_edit_agreement['full_name']) ? esc($single_candidate_edit_agreement['full_name']) : ''; ?>" readonly>
                           
                        </div>
                  </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                     <label for="email_id" class="form-label">Candidate Fees</label>
                      <input type="text" class="form-control form-control-md" id="salary_max" name="candidate_placement_salary" value="<?= isset($single_candidate_edit_agreement['candidate_placement_salary']) ? esc($single_candidate_edit_agreement['candidate_placement_salary']) : ''; ?>">
                            <span id="salary_maxError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                     <div class="col-md-9">
                        <div class="mb-3">
                      <label for="email_id" class="form-label">Full Address</label>
                     <textarea class="form-control form-control-md" id="candidate_full_address" name="candidate_full_address" ><?= isset($single_candidate_edit_agreement['candidate_full_address']) ? esc($single_candidate_edit_agreement['candidate_full_address']) : ''; ?></textarea>
                        </div>
                    </div>
                </div>
           
              
           
               
                <div class="row g-3 mt-2">
               
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