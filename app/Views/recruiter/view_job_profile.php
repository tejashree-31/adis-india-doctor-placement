<pre><?php //print_r($result);

 ?></pre>
 <style type="text/css">
   .font-span
   {
        font-size: 16px;
    font-family: Montserrat;
      color : #000;
   }
   .text-heading
   {
       font-size: 16px;
    font-family: Montserrat;
      color : #000;
    font-weight: bold;
   }
     p{
  font-style: normal;
    font-size: 16px;
    font-family: Montserrat;
    color: #000;
}
ol{
  font-style: normal;
    font-size: 16px;
    font-family: Montserrat;
    color: #000;
}
ul{
  font-style: normal;
    font-size: 16px;
    font-family: Montserrat;
    color: #000;
}

 </style>
<div class="container py-4">
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
                            <h3 class="mb-2 text-center"><b>Job Details </b></h3><br>

                            <div class="row">
                              <div class="col-md-3">
                                <p class="mb-2"> 
                                <?php if (!empty($result['recruiter_logo'])) : ?>
                                    <img src="<?= base_url('public/uploads/' . $result['recruiter_logo']); ?>" alt="Recruiter Logo" width="100" height="100">
                                <?php else : ?>
                                    <img src="<?= base_url('assets/jobportal/images/default1.jpg'); ?>" alt="Default Logo" width="100" height="100">
                                <?php endif; ?>
                                </p>
                              </div>
                              <div class="col-md-3">
                                <p class="mb-2"> <?= $result['job_role']; ?></p>
                                <p class="mb-2 font-span"> <?= $result['city_name']; ?></p>
                              </div>
                            </div>
                            <div class="row mt-4">
                              <div class="col-md-4">
                                <p class="mb-2">Employment Type</p>
                                <span class="font-span"><?= $result['employment_type']; ?></span>
                              </div>
                              <div class="col-md-4">
                                <p class="mb-2">Qualifications</p>
                                <span class="font-span"><?= $result['qualification_name']; ?></span>
                              </div>
                              <div class="col-md-4">
                              </div>
                            </div>
                            <hr style="border: 1px solid #ccc; margin: 20px 0;">
                            <div class="row mt-4">
                              <div class="col-md-12">
                                  <p class="mb-2"> Job Description</p>
                                  <span class="font-span"><?= $result['job_description']; ?></span>
                              </div>
                            </div>
                            <div class="row mt-4">
                              <div class="col-md-6">
                                  <p class="mb-2"> Experience</p>
                                  <div class="row mt-4">
                                    <div class="col-md-3">
                                      <p class="mb-2"> Minimum</p>
                                      <span class="font-span"><?= $result['experience_min']; ?> Years</span>
                                    </div>
                                    <div class="col-md-3">
                                      <p class="mb-2"> Maximum</p>
                                      <span class="font-span"><?= $result['experience_max']; ?> Years</span>
                                    </div>
                                  </div>
                              </div>

                              <div class="col-md-6">
                                  <p class="mb-2"> Salary</p>
                                 <div class="row mt-4">
                                    <div class="col-md-3">
                                      <p class="mb-2 text-heading"> Minimum</p>
                                      <span class="font-span"><?= $result['salary_min']; ?> INR</span>
                                    </div>
                                    <div class="col-md-3">
                                      <p class="mb-2 text-heading"> Maximum</p>
                                      <span class="font-span"><?= $result['salary_max']; ?> INR</span>
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <div class="row mt-4">
                              <div class="col-md-6">
                                  <p class="mb-2 text-heading"> Job Role</p>
                                  <span class="font-span"><?= $result['job_role']; ?></span>

                                  
                              </div>

                              <div class="col-md-6">
                                  <p class="mb-2 text-heading"> Department</p>
                                  <span class="font-span"><?= $result['department_name']; ?></span>
                              </div>
                            </div>
                            <div class="row mt-4">
                              <div class="col-md-6">
                                  <p class="mb-2 text-heading"> Course</p>
                                  <span class="font-span"><?= $result['course_name']; ?></span>

                                  
                              </div>

                              <div class="col-md-6">
                                  <p class="mb-2 text-heading"> Number Of Vacancies</p>
                                  <span class="font-span"><?= $result['vacancies']; ?></span>
                              </div>
                            </div>
                             <div class="row mt-4">
                                <div class="col-md-4">
                                <?php
                                  if($result['status'] == 'Preview')
                                { ?>

                              <form method="post" action="<?= base_url('recruiter/previewstatusupdate') ?>" >
                              <input type="hidden" name="posting_id" value="<?= $result['posting_id']; ?>">
                              <button type="submit" class="btn btn-success" name="action" value="Publish">Publish</button>
                              <button type="submit" class="btn btn-success" name="action" value="Draft">Save Draft</button>
                                </form>

                                <?php
                                } ?>
                              </div>
                              <div class="col-md-2">
                                <?php 
                                if($result['status'] == 'Draft')
                                { ?>
                                  <form method="post" action="<?= base_url('recruiter/publishstatusupdate') ?>">
                                    <input type="hidden" value="<?= $result['posting_id']; ?>" name="posting_id">
                                  <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 20px;background:#F5959C;color:#fff;">Publish</button>
                                </form>
                                <!-- <a href="<?//= base_url('recruiter/recruiter_job_responce'); ?>" class="btn btn-primary btn-lg" style="border-radius: 20px;">Cancel</a> -->
                                <?php
                                }

                                ?>
                              </div>
                              <div class="col-md-2">
                                <a href="<?= base_url('recruiter/recruiter_job_responce'); ?>" class="btn btn-info btn-lg" style="border-radius: 20px;">Cancel</a>


                              </div>
                             
                              <div class="col-md-4">
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










