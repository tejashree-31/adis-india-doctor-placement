<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);

 ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Invoice Genration <a href="<?= base_url('admin/billing_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;</h1>
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
                                <th>Institute Name</th>
                                <th>Candidate Name</th>
                                <th>Joining Date</th>
                                <th>Candidate Salary</th>
                                <th>Final Agreement %</th>
                                <th>Advanced Payment</th>
                                <th>Client Payment</th>
                                <th>GST Status</th>
                                <th>GST Client Payment</th>
                                <th>Invoice</th>
                                <th>Sent Invoice</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Institute Name</th>
                                <th>Candidate Name</th>
                                <th>Joining Date</th>
                                <th>Candidate Salary</th>
                                 <th>Final Agreement %</th>
                                 <th>Advanced Payment</th>
                                 <th>Client Payment</th>
                                <th>GST Status</th>
                                <th>GST Client Payment</th>
                                <th>Invoice</th>
                                <th>Sent Invoice</th>
                                <th>Action</th>
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
                                    
                                    $rowStyle = ($joiningMonth === $currentMonth)
                                        ? 'background-color:#d9f2ff;'  // light blue
                                        : '';
                                ?>
                            <tr style="<?= $rowStyle ?>">
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['job_role']) ?></td>
                                <td><?= esc($row['institute_name']) ?></td>
                                <td><?= esc($row['full_name'])?></td>
                                <td><?= date('d/m/y', strtotime($row['joining_date'])) ?></td>
                                <td> <?= !empty($row['conformed_salary']) ? esc($row['conformed_salary']) : 'N/A' ?></td>
                                <td><?= isset($row['final_agreement']) && !empty($row['final_agreement']) ? esc($row['final_agreement']) : 'N/A' ?></td>
                                <td><?= isset($row['advanced_payment']) && !empty($row['advanced_payment']) ? esc($row['advanced_payment']) : 'N/A' ?></td>
                                <td><?= isset($row['client_payment']) && !empty($row['client_payment']) ? esc($row['client_payment']) : 'N/A' ?></td>
                                    <td><?php if ($row['gst_status'] === 'yes'): ?>
                                        <span style="color: green; font-weight: 600;">Include GST</span>
                                    <?php elseif ($row['gst_status'] === 'no'): ?>
                                        <span>-</span>
                                    <?php else: ?>
                                        <span style="color: #9e9e9e; font-weight: 600;">NA</span>
                                    <?php endif; ?></td>
                                <td><?php if ($row['gst_status'] === 'yes'){ ?>
                                    <?= isset($row['client_payment_gst']) && !empty($row['client_payment_gst']) ? esc($row['client_payment_gst']) : 'N/A' ?>
                                    <?php }else { ?>
                                        <span>-</span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($row['conformed_salary'])){ ?>
                                    <a href="<?= base_url('generate-pdf/'.$row['job_status_id']) ?>"
                                       class="btn btn-success"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       title="Invoice PDF" target="_blank" rel="noopener noreferrer">
                                       <i class="fa fa-download"></i>
                                    </a>
                                    <?php }else { 
                                        echo "-";
                                        ?>
                                        
                                    <?php } ?>
                                    
                                </td>
                                <td class="text-center">
                                     <label class="simple-chk">
                                    <?php if (!empty($row['conformed_salary'])){ ?>
                                      <?php if ($row['payment_recived_status'] == '') { ?>
                                            <!-- ENABLED CHECKBOX -->
                                            <input type="checkbox" 
                                                   name="send_email" 
                                                   class="send_email" 
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


                                <td><a href="<?= base_url('admin/edit-conformed-salary/'.$row['job_status_id']) ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></a></td>
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