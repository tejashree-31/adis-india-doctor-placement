<?php
use Config\Database;
$db = Database::connect();
 ?>
<style type="text/css">
</style>
<div class="container-fluid">
    <!-- Page Heading -->
    <!--<h1 class="h3 mb-2 text-gray-800">Total Closed Candidate</h1>-->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="mb-2 text-gray-800">Total Closed Candidate <a href="<?= base_url('admin/admindashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a></h4>
        </div>
        <div class="card-body">
             <div id="updateSuccessMsg"
            style="display:none; color:green; font-weight:600; margin:10px 0; text-align: 'center';">
                </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Current Location</th>
                            <th>Resume</th>
                            <th>Candidate Agreement</th>
                             <th>Sent Agreement</th>
                            <th>status</th>
                            <th>Action</th>
                           
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>Current Location</th>
                            <th>Resume</th>
                            <th>Candidate Agreement</th>
                            <th>Sent Agreement</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (!empty($candidate_closed_details)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($candidate_closed_details as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    
                                    <td><?= esc($row['full_name']) ?></td>
                                    <!-- <td><?//= date('d/m/y', strtotime($row['created_date'])) ?></td> -->
                                 
                                    <td><?= esc($row['email']) ?></td>
                                    <td><?= esc($row['mobile_number']) ?></td>
                                    <td><?= esc($row['city_name']) ?></td>
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
                                    <td class="text-center">
                                          <a href="<?= base_url('candidate-agreement-pdf/'.$row['job_status_id']) ?>"
                                                                   class="btn btn-sm btn-primary"
                                                                   data-bs-toggle="tooltip"
                                                                   data-bs-placement="top"
                                                                   title="Invoice PDF" target="_blank" rel="noopener noreferrer">
                                                                   <i class="fa fa-download"></i>
                                        </a>
                                    </td>
                                   <td class="text-center">
                                        <label class="simple-chk">
                                            <?php if (!empty($row['candidate_placement_salary'])){ ?>
                                              <?php if ($row['candidte_agre_status'] == '') { ?>
                                                    <!-- ENABLED CHECKBOX -->
                                                    <input type="checkbox" 
                                                           name="candidte_agre_status" 
                                                           class="candidte_agre_status" 
                                                           data-job_status_id="<?= $row['job_status_id']; ?>">
                                                <?php } else { ?>
                                                    <!-- DISABLED & CHECKED CHECKBOX -->
                                                    <input type="checkbox" 
                                                           checked 
                                                           disabled>
                                                <?php } ?>
                                                    
                                             <?php }else { 
                                                echo "-";
                                                ?>
                                                
                                            <?php } ?>
                                    </td>
                                    <td style="background: green;color:#fff;">
                                        Closed

                                    </td>
                                     <td><a href="<?= base_url('admin/edit-candidate-agreement-salary/'.$row['jobseeker_id'].'/'.$row['job_status_id']) ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">No Closed Candidate details found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>