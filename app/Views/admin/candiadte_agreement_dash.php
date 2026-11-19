<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);
// $builder = $db->table('tbl_recruiter');
// $advanced_payment = $builder->select('final_agreement')->where('uid',$single_posting_edit['user_id'])->get()->getRow();

 ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Candidate Agreement&nbsp;</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3"> 
                <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
                <?php endif; ?>
                <div id="updateSuccessMsg" class="alert alert-success" style="display:none;">
                        Updated Successfully!
                </div>
                <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Client Name</th>
                                <th>Candidate Name</th>
                                <th>Joining Date</th>
                                <th>Send agreement</th>
                               
                                

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Client Name</th>
                                <th>Candidate Name</th>
                                <th>Joining Date</th>
                                 <th>Send agreement</th>
                              
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($closedPostvaciesdisply)) : ?>
                                 <?php $i = 1; ?>
                                <?php foreach ($closedPostvaciesdisply as $row) : ?>

                                <?php  $currentMonth = date('Y-m');  ?>
                                <?php
                                    $joiningMonth = !empty($row['joining_date'])
                                        ? date('Y-m', strtotime($row['joining_date']))
                                        : '';
                                     // echo $joiningMonth;
                                    // echo "<br";
                                    // echo $currentMonth;
                                    $rowStyle = ($joiningMonth === $currentMonth)
                                        ? 'background-color:#d9f2ff;'  // light blue
                                        : '';
                                ?>
                            <tr style="<?= $rowStyle ?>">
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['job_role']) ?></td>
                                <td><?= esc($row['recruiter_name']) ?></td>
                                <td><?= esc($row['full_name'])?></td>
                                <td><?= date('d/m/y', strtotime($row['joining_date'])) ?></td>
                                <td>
                                   <?php if (!empty($row['candidate_sign_agre'])) : ?>

                                        <!-- File already uploaded -->
                                        <a href="<?= base_url('uploads_candidate/agreements/' . $row['candidate_sign_agre']) ?>"
                                           target="_blank"
                                           class="btn btn-sm btn-success">
                                            📄 View Agreement
                                        </a>

                                    <?php else : ?>

                                        <!-- File not uploaded yet -->
                                        <input type="file"
                                               class="agreementUpload"
                                               data-id="<?= $row['job_status_id'] ?>"
                                               accept="application/pdf">

                                        <div class="uploadStatus" id="status-<?= $row['job_status_id'] ?>"></div>
                                        <div class="uploadedFile" id="file-<?= $row['job_status_id'] ?>"></div>

                                    <?php endif; ?>

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