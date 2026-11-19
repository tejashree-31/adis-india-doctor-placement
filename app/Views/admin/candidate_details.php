<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
 // print_r($candidate_details);
 // exit()
 ?>
 <style type="text/css">
     /* Table Header Styling */


 </style>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <h4 class="mb-2 text-gray-800">Candidate Details</h4>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
                        </div>
                        <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>Current location</th>
                    <th>Job Role</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Register date</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Sr.No</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>Current location</th>
                    <th>Job Role</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Register date</th>
                </tr>
            </tfoot>
            <tbody>
                <?php if (!empty($candidate_details)) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($candidate_details as $row) : ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td><?= esc($row['full_name']) ?></td>
                            <td><?= esc($row['email']) ?></td>
                            <td><?= esc($row['mobile_number']) ?></td>
                            <td><?= esc($row['current_city_name'] ?? '') ?></td>
                            <td><?= esc($row['job_role']) ?></td>
                            <td class="text-center">
                                <?php if (!empty($row['resume'])): ?>
                                     <a href="javascript:void(0)"
                                   onclick="viewAndDownload('<?= base_url('jobseeker/resume/'.$row['resume']); ?>')"
                                               class="resume-btn" data-placement="top" title="Download File">
                                              <i class="fa fa-download" style="background:#860C15; color:#fff; border-radius:50%; padding:10px;"></i>
                                            </a>
                                <?php else: ?>
                                    <span class="text-muted">No Resume</span>
                                <?php endif; ?>
                            </td>
                            <td class="
                                <?php if ($row['admin_candidate_status'] === 'Closed') echo 'status-closed'; ?>
                                <?php if ($row['admin_candidate_status'] === 'Hold') echo 'status-hold'; ?>
                                <?php if ($row['admin_candidate_status'] === 'Interview Schedule') echo 'status-interview'; ?>
                                <?php if ($row['admin_candidate_status'] === 'Rejected') echo 'status-rejected'; ?>
                                <?php if ($row['admin_candidate_status'] === 'Open') echo 'status-open'; ?>
                            ">
                                <?= esc($row['admin_candidate_status']) ?>
                            </td>
                            <td><?= date('d/m/y', strtotime($row['created_date'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">No candidate details found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

                    </div>

                </div>