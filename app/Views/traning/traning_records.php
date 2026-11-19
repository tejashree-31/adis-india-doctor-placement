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
             <h4 class="mb-2 text-gray-800">Total Training Details <a href="<?= base_url('traning/traningdashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a></h4>
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
                                <th>Full Name</th>
                                <th>Mobile No</th>
                             
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Organisation</th>
                                <th>Training Type</th>
                                <th>Meeting Type</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Participants</th>
                                <th>Expected Duration</th>
                                <th>Address</th>
                                <th>Register date</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Full Name</th>
                                <th>Mobile No</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Organisation</th>
                                <th>Training Type</th>
                                <th>Meeting Type</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Participants</th>
                                <th>Expected Duration</th>
                                <th>Address</th>
                                <th>Register date</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($Alltraingrecords)) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($Alltraingrecords as $row) : ?>
                                    <?php 
                                            $fullAddr = ucwords(strtolower($row['trainer_address'])) . ' - ' . ucwords(strtolower($row['name']));
                                            $shortAddr = substr($fullAddr, 0, 35) . '...';
                                        ?>
                                    <?php if (!empty($row['appo_date']) && $row['appo_date'] != '0000-00-00') {
                                             $appx_date = date("d M Y", strtotime($row['appo_date']));
                                        } else {
                                             $appx_date ="-";
                                        } ?>
                                        <?php
                                        if (!empty($row['appo_time']) && $row['appo_time'] != '00:00:00') {
                                            $appx_time =  date("h:i A", strtotime($row['appo_time']));
                                        } else {
                                            $appx_time = "-";
                                        }
                                        ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= esc(ucwords(strtolower($row['trainer_full_name']))) ?></td>
                                        <td><?= $row['trainer_mobile_no'] ?></td>
                                        <td><?= $row['trainer_email'] ?></td>
                                        <td><?= $row['trainer_gender'] ?></td>
                                        <td><?= esc(ucwords(strtolower($row['organisation_name']))) ?></td>
                                        <td><?= $row['traning_type'] ?></td>
                                        <td><?= $row['type_meeting'] ?></td>
                                        <td><?= $appx_date ?></td>
                                        <td><?= $appx_time ?></td>
                                        <td><?= $row['approx_parpt'] ?></td>

                                        <td><?= $row['expected_time_duration'] ?></td>
                                        <td>
                                            <span class="addr-short"><?= esc($shortAddr) ?></span>
                                            <span class="addr-full d-none"><?= esc($fullAddr) ?></span>

                                            <a href="javascript:void(0)" class="addr-toggle">More</a>
                                        </td>
                                        
                                        <td><?= date('d/m/y', strtotime($row['created_at'])) ?></td>
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