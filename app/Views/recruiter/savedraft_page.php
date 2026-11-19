<div class="container py-4">
  <div class="row">
    <div class="col-md-12">
  <nav aria-label="breadcrumb" class="py-2">
  <div class="container">
    <ol class="breadcrumb mb-0">
      <!-- <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li> -->
      <li class="breadcrumb-item"><a href="<?= base_url('recruiter/publishsavedraft') ?>">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">SaveDraft Jobs</li>
    </ol>
  </div>
</nav>



      <!-- Tab Content -->
      <div class="tab-content border p-4 bg-white shadow-sm rounded" id="jobTabContent">

        <!-- Publish Tab -->
        <div class="tab-pane fade show active" id="publish"> 
          <div class="container-fluid py-4">
              <div class="row">
                  <?php if (!empty($savedraft_jobs)): ?>
                  <?php foreach ($savedraft_jobs as $job): ?>
                  <div class="col-12 mb-4">
                    <div class="card1 border-success w-100">
                      <div class="card-body text-start px-4">
                        <h6 class="mb-2"><b><?= esc($job['job_role']) ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn btn-sm btn-success"><?= esc($job['admin_status']) ?></span>&nbsp;<a href="<?= base_url('recruiter/view_job_recruiter?id=' . $job['posting_id']); ?>" class="btn btn-sm btn-primary">view Job</a>&nbsp;
                        	<a href="<?= base_url('recruiter/edit_job_recruiter?id=' . $job['posting_id']); ?>" class="btn btn-sm btn-primary">Edit Job</a>&nbsp; </h6><br>
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
                      <div class="alert alert-warning">No SaveDraft jobs found.</div>
                    </div>
                  <?php endif; ?>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>