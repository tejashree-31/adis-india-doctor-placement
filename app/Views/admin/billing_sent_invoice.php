<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);

 ?>
 <style>

</style>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Invoice Status <a href="<?= base_url('admin/billing_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;</h1>
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
                                <th>Postion</th>
                                <th>Client Name</th>
                                <th>Candidate Name</th>
                                <th>Joining Date</th>
                                <th>Total Bill</th>
                                <th>TDS Status</th>
                                <th>Advanced Payment</th>
                                <th>Recived Payment</th>
                                <th>TDS Payment</th>
                                <th>Discount</th>
                                <th>Outstanding Payment</th>
                                <th>Invoice Date</th>
                                <th>Payment Type</th>
                                <th>Recived Status</th>
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Client Name</th>
                                <th>Candidate Name</th>
                                <th>Joining Date</th>
                                <th>Total Bill</th>
                                <th>TDS Status</th>
                                <th>Advanced Payment</th>
                                <th>Recived Payment</th>
                                <th>TDS Payment</th>
                                 <th>Discount</th>
                                <th>Outstanding Payment</th>
                                <th>Invoice Date</th>
                                <th>Recived Status</th>
                                <th>Payment Type</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($closedPostvaciesdisply)) : ?>
                                 <?php $i = 1; ?>
                                <?php foreach ($closedPostvaciesdisply as $row) : ?>
                            <!-- ====================Outstanding Payment============================= -->
                           <?php $advanced = !empty($row['advanced_payment']) ? (float)str_replace(',', '', $row['advanced_payment']) : 0;

                              $received         = !empty($row['client_recived_payment']) ? (float)str_replace(',', '', $row['client_recived_payment']) : 0;

                                $gst_amount       = !empty($row['client_payment_gst']) 
                                                    ? (float)str_replace(',', '', $row['client_payment_gst']) 
                                                    : 0;

                                $original_payment = !empty($row['client_payment']) 
                                                    ? (float)str_replace(',', '', $row['client_payment']) 
                                                    : 0;

                                $gst_status       = !empty($row['gst_status']) ? $row['gst_status'] : 'no';




                            if ($advanced > 0) {
                                $total_bill = $advanced + $received;      // advance + received
                            } else {
                                $total_bill = $received;                  // only received
                            }

                            if ($gst_status === 'yes')
                            {

                               
                                $final = $gst_amount - $total_bill;

                            } else {

                               
                                $final = $original_payment - $total_bill;
                            }
                             // $gst_amount;
                              ?>

                               
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($row['job_role']) ?></td>
                                <td><?= esc($row['recruiter_name']) ?></td>
                                <td><?= esc($row['full_name'])?></td>
                                <td><?= date('d/m/y', strtotime($row['joining_date'])) ?></td>
                                <td>
                                    <?php if ($row['gst_status'] === 'yes'){ ?>

                                        <?= isset($row['client_payment_gst']) && !empty($row['client_payment_gst']) ? esc($row['client_payment_gst']) : 'N/A' ?>
                                    <?php
                                    }else{ ?>
                                        <?= isset($row['client_payment']) && !empty($row['client_payment']) ? esc($row['client_payment']) : 'N/A' ?>

                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($row['tds_status'] === 'yes'){ ?>
                                        <span> Include TDS</span>
                                   
                                    <?php
                                    }else{ ?>
                                       <span>-</span>

                                    <?php
                                    }
                                    ?> 

                                </td>
                               
                                <td>
                                 <?= (!empty($row['advanced_payment']))
                                        ? number_format((float)str_replace(',', '', $row['advanced_payment']), 2, '.', ',') 
                                        : 'N/A'; 
                                    ?>
                                </td>
                                <td>
                                    <?= (!empty($row['client_recived_payment']))
                                        ? number_format((float)str_replace(',', '', $row['client_recived_payment']), 2, '.', ',') 
                                        : 'N/A'; 
                                    ?>
                                  </td>
                                   <td>
                                     <?= (!empty($row['tds_amount']))
                                        ? number_format((float)str_replace(',', '', $row['tds_amount']), 2, '.', ',') 
                                        : 'N/A'; 
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['discount_check'] === 'yes'){ ?>

                                       <?= (!empty($row['discount_amount']))
                                        ? number_format((float)str_replace(',', '', $row['discount_amount']), 2, '.', ',') 
                                        : 'N/A'; 
                                    ?>
                                    <?php
                                    }else{ ?>
                                       <span>-</span>

                                    <?php
                                    }
                                    ?>   


                                </td>
                                <td>
                                        <?php //echo number_format($final, 2); ?>

                                        <?php if (!empty($row['discount_check']) && $row['discount_check'] === 'yes') { ?>

                                        <?php 
                                            // $after_discount = $final - $row['discount_amount'];
                                            $discount_new = !empty($row['discount_amount']) ? (float)$row['discount_amount'] : 0;

                                            $after_discount = (float)$final - $discount_new;
                                            echo number_format($after_discount, 2);
                                        ?>

                                    <?php } else { ?>

                                        <?php echo number_format($final, 2); ?>

                                    <?php } ?>
                                </td>
                              
                                <td><?= date('d/m/y', strtotime($row['invoice_send_date'])) ?></td>
                                <td>
                                    <?= isset($row['payment_type']) && !empty($row['payment_type']) ? esc($row['payment_type']) : 'N/A' ?>
                                        
                                </td>
                                <td class="text-center">    
                                        <label class="simple-chk"> 
                                        <?php 
                                        $payment_type = isset($row['payment_type']) ? $row['payment_type'] : '';
                                         if ($row['payment_recived_status'] == 'Send_invoice') { ?>

                                                <?php if (empty($row['client_recived_payment'])) { ?>
                                                    <!-- CASE 1: Payment Status = Send_invoice & client_recived_payment is empty -->
                                                    <!--<h6>hello</h6>-->
                                                    <input type="checkbox"
                                                        name="send_email_recived_client_payment"
                                                        class="send_email_recived_client_payment"
                                                        data-job_status_id="<?= $row['job_status_id']; ?>" disabled>

                                                <?php } else { ?>

                                                    <?php if ($payment_type == 'Part Payment' || $payment_type == '') { //echo "hello"; ?>
                                                        <!-- CASE 2: Send_invoice + Payment Received + Part Payment -->
                                                        <input type="checkbox"
                                                            name="send_email_recived_client_payment"
                                                            class="send_email_recived_client_payment"
                                                            data-job_status_id="<?= $row['job_status_id']; ?>"
                                                            style="accent-color: #CEF2B1;" disabled>

                                                    <?php } else { //echo "bye"?>
                                                        <!-- CASE 3: Send_invoice + Full Payment -->
                                                        <input type="checkbox"
                                                            name="send_email_recived_client_payment"
                                                            class="send_email_recived_client_payment"
                                                            data-job_status_id="<?= $row['job_status_id']; ?>"
                                                            style="accent-color: #CEF2B1;">
                                                    <?php } ?>

                                                <?php } ?>

                                            <?php } else { ?>

                                                <!-- CASE 4: payment_recived_status != Send_invoice -->

                                                <?php if ($payment_type == 'Part Payment' || $payment_type == ' ') { ?>
                                                    <input type="checkbox"
                                                        name="send_email_recived_client_payment"
                                                        class="send_email_recived_client_payment"
                                                        data-job_status_id="<?= $row['job_status_id']; ?>" disabled>

                                                <?php } else { ?>
                                                    <input type="checkbox"
                                                        name="send_email_recived_client_payment"
                                                        class="send_email_recived_client_payment"
                                                        data-job_status_id="<?= $row['job_status_id']; ?>">
                                                <?php } ?>

                                            <?php } ?>


                                        </label>
                                </td>
                                <td><a href="<?= base_url('admin/edit-recived-client-payment/'.$row['job_status_id']) ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></a></td>
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