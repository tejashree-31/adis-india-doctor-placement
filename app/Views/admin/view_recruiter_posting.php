<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);

 ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Posting Details <a href="<?= base_url('admin/apply_candidate_admin'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;<a href="<?= base_url('admin/add_post_vacuncy/'.$uid); ?>" class="btn btn-sm btn-primary" title="Add Post Vacuncy">
  <i class="fas fa-user-plus"></i></a></h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3"> 
                <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
                <?php endif; ?>
                <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Department</th>
                                <th>Apply Candidate</th>
                                <th>Posting Date</th>
                                <th>Type</th>
                                <th>Experiance</th>
                                <th>Salary</th>
                                <th>Post Vacuncy</th>
                                <th>Shift Time</th>
                                <!-- <th>Status</th> -->
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Department</th>
                                <th>Apply Candidate</th>
                                <th>Posting Date</th>
                                <th>Type</th>
                                <th>Experiance</th>
                                <th>Salary</th>
                                <th>Post Vacuncy</th>
                                <th>Shift Time</th>
                                <!-- <th>Status</th> -->
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($recuiterPostingData)) : ?>
                                 <?php $i = 1; ?>
                                <?php foreach ($recuiterPostingData as $row) : ?>

                               
                            <tr>
                                <td><?= $i++ ?></td>
                                 <td><?= esc($row['job_role']) ?></td>
                                   <td><?= esc($row['department_name']) ?></td>
                                 <td>
                                    <?php  $postingId = $row['posting_id'];
                                     $userId    = $row['user_id'];
                                     $count = $db->table('tbl_candidate_job_status')
                                            ->where('posting_id', $postingId)
                                            ->where('user_id', $userId)
                                            ->where('admin_candidate_status !=', 'Closed') // ✅ extra condition
                                            ->countAllResults();
                                    ?>
                                    <a href="<?= base_url('admin/apply_canidate_records/' . $row['posting_id'] . '/' . $row['user_id']); ?>"> <?= $count; ?>
                                    </a>
                                 </td>
                                <td><?= date('d/m/y', strtotime($row['created_date'])) ?></td>
                                <td><?= esc($row['employment_type']) ?></td>
                                <td><?= esc($row['experience_min'].'-'.$row['experience_max'] )?></td>
                                <td>
                                    <?php if (!empty($row['salary_negotiation']) && $row['salary_negotiation'] === 'yes') : ?>
                                        Negotiable
                                    <?php else : ?>
                                        <?= esc($row['salary_min'] . ' - ' . $row['salary_max']) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                        <?php
                                $closed_count = $db->table('tbl_candidate_job_status')
                                            ->where('posting_id', $postingId)
                                            ->where('user_id', $userId)
                                            ->where('admin_candidate_status', 'Closed') // 
                                            ->countAllResults();
                                            // echo $db->getLastQuery();
                                             // echo $closed_count;
                                             ?>
                                    <?= esc($row['vacancies']-$closed_count) ?>
                                    <?php $admin_status_posting_count = $row['vacancies']-$closed_count; ?>
                                    <?php
                                        if ($admin_status_posting_count === 0) {
                                        $db = \Config\Database::connect();

                                        $builder = $db->table('tbl_recruiter_posting');
                                        $builder->where('posting_id', $postingId);
                                        $builder->where('user_id', $userId);

                                        $builder->update(['admin_status' => 'closed']); // <-- change column & value as needed
                                    }



                                     ?> 

                                </td>
                                <td><?= esc($row['shift_time']) ?></td>
                              <!--   <td>  <select class="form-control form-control-sm admin-status-dropdown" data-id="<?//= $row['posting_id'] ?>">
                                <option value="Open" <?//= $row['admin_status'] == 'Open' ? 'selected' : '' ?>>Open</option>
                                <option value="Closed" <?//= $row['admin_status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
                                <option value="Hold" <?//= $row['admin_status'] == 'Hold' ? 'selected' : '' ?>>Hold</option>
                                </select></td> -->
                              
                            </tr>
                             <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5">No recruiter details found.</td>
                                    </tr>
                                <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>