<?php
use Config\Database;
$db = Database::connect();
 ?>
 <style type="text/css">

 </style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
             <h4 class="mb-2 text-gray-800">Daily count Clients <a href="<?= base_url('admin/client_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a></h4>
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
                            <th>Mobile Number</th>
                            <th>Registred Date</th>
                            <th>Status</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Registred Date</th>
                            <th>Status</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (!empty($AlldailyCount)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($AlldailyCount as $row) : ?>
                                <?php $recruiter = $db->table('tbl_recruiter')
                                                ->where('uid', $row['uid'])
                                                ->get()
                                                ->getRow(); 
                                                ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>

                                    <td ><?php
                                        if ($recruiter && $recruiter->form_status == 'active') { ?>
                                            <?= esc($row['email']) ?>
                                         <?php } else { ?>
                                             
                                            <a href="<?= base_url('admin/add_recruiter_front/' . $row['uid']); ?>"><?= esc($row['email']) ?></a> 
                                              <?php 
                                        }  ?>
                                    </td>
                                    <td><?= esc($row['mobile_no']) ?></td>
                                    <td><?= date('d/m/y', strtotime($row['registered_date'])) ?></td>
                                    <td class="text-center">
                                        <?php 
                                            $recruiter = $db->table('tbl_recruiter')
                                                ->where('uid', $row['uid'])
                                                ->get()
                                                ->getRow();

                                            if ($recruiter && $recruiter->form_status == 'active') {
                                                echo '<span style="color: #2e7d32; background-color: #c8e6c9; padding: 3px 8px; border-radius: 5px;">Active</span>';
                                            } else {
                                                echo '<span style="color: #c62828; background-color: #ffcdd2; padding: 3px 8px; border-radius: 5px;">Inactive</span>';
                                            }
                                        ?>
                                    </td>
                                  
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">No recruiter details found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>