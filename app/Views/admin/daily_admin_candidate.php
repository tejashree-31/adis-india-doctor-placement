<?php
use Config\Database;
$db = Database::connect();
?>
 <style type="text/css">
     /* Table Header Styling */


 </style>
<div class="container-fluid">
    <!-- Page Heading -->
     <!-- <h4 class=" mb-2 text-gray-800">Signup Candidate Details</h4> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
             <h4 class="mb-2 text-gray-800">Daily Candidate Details <a href="<?= base_url('admin/admindashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a></h4>
            <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Email</th>
                                <th>Register date</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Email</th>
                                <th>Register date</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($AlldailyCandidate)) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($AlldailyCandidate as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= esc($row['email']) ?></td>
                                        
                                        <td><?= date('d/m/y', strtotime($row['registered_date'])) ?></td>
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