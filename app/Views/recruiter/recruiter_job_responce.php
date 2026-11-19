
<div class="container py-4">
  <div class="row">
    <div class="col-md-12">
  

<div class="text-center mb-4">
  <button type="button" class="btn btn-outline-success active btn-tab-spacing" id="goToPublish">Publish </button>
  <button type="button" class="btn btn-outline-success btn-tab-spacing" id="goToDraft">Save Draft</button>
</div>

      <!-- Tab Content -->
      <div class="tab-content border p-4 bg-white shadow-sm rounded" id="jobTabContent">

        <!-- Publish Tab -->
        <div class="tab-pane fade show active" id="publish"> 
          <div class="container-fluid py-4">
              <div class="row">
                  <?php if (!empty($published_jobs)): ?>
                  <?php foreach ($published_jobs as $job): ?>
                  <div class="col-12 mb-4">
                    <div class="card1 border-success w-100">
                      <div class="card-body text-start px-4">
                        <h6 class="mb-2"><b><?= esc($job['job_role']) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-sm btn-success"><?= esc($job['admin_status']) ?></span>&nbsp;<a href="<?= base_url('recruiter/edit_job_recruiter?id=' . $job['posting_id']); ?>" class="btn btn-sm btn-primary">Edit Job</a>&nbsp; </h6><br>
                        <p class="mb-2">
                          Posted By: You &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <span>Posted On: <?= date('d M Y', strtotime($job['created_date'])) ?></span>
                        </p>
                       
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
                  <?php else: ?>
                    <div class="col-12">
                      <div class="alert alert-warning">No published jobs found.</div>
                    </div>
                  <?php endif; ?>
              </div>
          </div>
        </div>

        <!-- Draft Tab -->
        <div class="tab-pane fade" id="draft">
         <div class="container-fluid py-4">
              <div class="row">
                  <?php if (!empty($draft_jobs)): ?>
                  <?php foreach ($draft_jobs as $job): ?>
                        <div class="col-12 mb-4">
                          <div class="card1 border-success w-100">
                            <div class="card-body text-start px-4">
                              <h6 class="mb-2"><b><?= esc($job['job_role']) ?></b>&nbsp;<a href="<?= base_url('recruiter/view_job_recruiter?id=' . $job['posting_id']); ?>" class="btn btn-sm btn-primary">view Job</a>&nbsp;<a href="<?= base_url('recruiter/edit_job_recruiter?id=' . $job['posting_id']); ?>" class="btn btn-sm btn-primary">Edit Job</a></h6><br>
                              <p class="mb-2">
                                Posted By: You &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>Posted On: <?= date('d M Y', strtotime($job['created_date'])) ?></span>
                              </p>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                          <div class="alert alert-warning">No Draft jobs found.</div>
                        </div>
                    <?php endif; ?>
                </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>










