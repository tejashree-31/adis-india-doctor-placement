<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);

 ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Candidate Details <a href="<?= base_url('admin/view_recruiter_posting/'.$userId); ?>" class="btn btn-sm btn-primary"><i class="fas fa-long-arrow-alt-left"></i></a></h1> 
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Candidate Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Current Location</th>
                                <th>Resume</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Candidate Name</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Current Location</th>
                                <th>Resume</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($candidates)) : ?>
                                 <?php $i = 1; ?>
                                <?php foreach ($candidates as $row) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['full_name']) ?></td>
                                <td><?= esc($row['email']) ?> </td>
                                <td><?= esc($row['mobile_number']) ?></td>
                                <td><?= esc($row['current_city_name']) ?></td>
                                <td class="text-center">
                                    <?php if (!empty($row['resume'])): ?>
                                        <a href="<?= base_url('jobseeker/resume/'.$row['resume']); ?>" download title="Download Resume">
                                            ⬇️
                                        </a>
                                    <?php else: ?>
                                        <span>No Resume</span>
                                    <?php endif; ?>
                                </td>
                                
                    <td>
                        <select class="form-control form-control-sm admin-status-dropdown"
                                data-id="<?= $row['job_status_id'] ?>">

                            <option value="Open"
                                <?= $row['admin_candidate_status'] == 'Open' ? 'selected' : '' ?>>
                                Open
                            </option>

                            <option value="Closed"
                                <?= $row['admin_candidate_status'] == 'Closed' ? 'selected' : '' ?>>
                                Closed
                            </option>

                            <option value="Hold"
                                <?= $row['admin_candidate_status'] == 'Hold' ? 'selected' : '' ?>>
                                Hold
                            </option>

                            <option value="Interview Schedule"
                                <?= $row['admin_candidate_status'] == 'Interview Schedule' ? 'selected' : '' ?>>
                                Interview Schedule
                            </option>

                            <option value="Rejected"
                                <?= $row['admin_candidate_status'] == 'Rejected' ? 'selected' : '' ?>>
                                Rejected
                            </option>

                            <option value="Profile_shared_client"
                                <?= $row['admin_candidate_status'] == 'Profile_shared_client' ? 'selected' : '' ?>>
                                Profile Shared with Client
                            </option>

                        </select>
                    </td>

                              
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