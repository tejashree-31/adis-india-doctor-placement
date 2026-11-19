<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);

 ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Client Closed Details <a href="<?= base_url('admin/client_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;</h1>
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
                                <th>Client Name</th>
                                <th>Posting Date</th>
                                <th>Status</th>
                                <!-- <th>Status</th> -->
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Client Name</th>
                                <th>Posting Date</th>
                                <th>Status</th>
                          
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($ClosedClientDetails)) : ?>
                                 <?php $i = 1; ?>
                                <?php foreach ($ClosedClientDetails as $row) : ?>

                               
                            <tr>
                                <td><?= $i++ ?></td>
                                 <td><?= esc($row['job_role']) ?></td>
                                 <td><?= esc($row['recruiter_name']) ?></td>
                                <td><?= date('d/m/y', strtotime($row['created_date'])) ?></td>
                                <td style="background: #2eb774;color:#fff;"><?= esc($row['admin_status']) ?></td>
                              
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