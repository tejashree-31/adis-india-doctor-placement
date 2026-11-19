<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);

 ?>
 <style>

</style>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"> Free Client <a href="<?= base_url('admin/billing_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"> <i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3"> 
                <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
                <?php endif; ?>
                <div id="updateSuccessMsg_status" class="alert alert-success" style="display:none;">
                        Recived Payment Updated Successfully!
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Institute Name</th>
                                <th>Client Name</th>
                                <!-- <th>Registration Fees</th> -->
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Institute Name</th>
                                <th>Client Name</th>
                                <!-- <th>Registration Fees</th> -->
                                <th>Registration Date</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($FreeClientDisplay)) : ?>
                                 <?php $i = 1; ?>
                                <?php foreach ($FreeClientDisplay as $row) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($row['institute_name']) ?></td>
                                    <td><?= esc($row['recruiter_name']) ?></td>
                                    <!-- <td><?//= esc($row['client_reg_fees']) ?></td> -->
                                    <td><?= date('d/m/y', strtotime($row['created_date'])) ?></td>
                           
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