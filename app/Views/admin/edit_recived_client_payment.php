<?php 
use Config\Database;
$db = Database::connect();
$monthYear = date('M') . date('Y');
$builder = $db->table('tbl_candidate_job_status');
$builder->selectMax('invoice_number');
$row = $builder->get()->getRowArray();

if (!empty($row['invoice_number'])) {
    // Example ref_no = "adisindia/Nov2025/007"
    $parts = explode('/', $row['invoice_number']);
    $lastNumber = intval(end($parts)); // 7
    $newNumber = $lastNumber + 1;
} else {

    // FIRST invoice → start at 1 (→ 001)
    $newNumber = 1;
}
$runningNo = sprintf('%03d', $newNumber); // 3 digits padded
$db_invoice = esc($single_posting_edit['invoice_number']); 
$ref_no = "Adisindia/$monthYear/$db_invoice";

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Client Recived</title>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<style>
  
</style>
</head>
<body>
<div class="container mt-5">
    <!-- <h1 class="mb-4">Edit Empolyee</h1> -->
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
    <?php endif; ?>
        <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    
            <h5 class="mb-0">
                Client Recived Payment
                <a href="<?= base_url('admin/billing-sent-invoice') ?>" class="btn btn-light btn-sm ms-2">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </h5>

            <span><b>Invoice No : </b><?php echo $ref_no ?></span>

        </div>
        <div class="card-body">
            <form action="<?= base_url('update-client-recived-form') ?>" method="post" id="update-client_recived-form" enctype="multipart/form-data">
                <!-- <input type="text" name="invoice_number" value="<?//= isset($single_posting_edit['invoice_number']) ? esc($single_posting_edit['invoice_number']) : ''; ?>"> -->
               <input type="hidden" name="job_status_id" value="<?= isset($single_posting_edit['job_status_id']) ? esc($single_posting_edit['job_status_id']) : ''; ?>">
                
               <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                      <label for="email_id" class="form-label"> Client Recived Payment</label>
                      <input type="text" class="form-control form-control-md" id="salary_max" name="client_recived_payment" value="" placeholder="Enter Client Payment">
                            <span id="salary_maxError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>
                 
                    <div class="col-md-4">
                        <div class="mb-3">
                      <label for="email_id" class="form-label"> Discount Amount</label>
                      <div class="d-flex ">
                        <label class="simple-chk">

                                <input type="checkbox" 
                                    id="discount_chk" 
                                    name="discount_check" 
                                    class="mt-2"
                                    value="yes"
                                    <?= ($single_posting_edit['discount_check'] ?? '') === 'yes' ? 'checked disabled' : '' ?>
                                >

                            </label>

                            &nbsp;&nbsp;
                            <?php  if($single_posting_edit['discount_check'] =='yes')
                            { ?>

                               <input type="text" 
                                   class="form-control form-control-md" 
                                   id="disscount1" 
                                   name="discount_amount"
                                   value="<?= esc($single_posting_edit['discount_amount'] ?? '') ?>" 
                                   placeholder="Enter Discount" disabled>
                            <?php 
                            }else{ ?>

                                    
                                    
                                     <input type="text" 
                                   class="form-control form-control-md" 
                                   id="disscount" 
                                   name="discount_amount"
                                   value="<?= esc($single_posting_edit['discount_amount'] ?? '') ?>" 
                                   placeholder="Enter Discount"
                                   <?= ($single_posting_edit['discount_check'] ?? '') === 'yes' ? ' ' : 'disabled' ?>
                            >
                            <?php
                            } ?>
                            
                            
                        </div>
                        <span id="disscount_maxError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                      <label for="email_id" class="form-label">Payment Type</label>
                        <?php
                            $payment_type = isset($single_posting_edit['payment_type']) ? trim(strtolower($single_posting_edit['payment_type'])) : '';
                            ?>

                            <select name="payment_type" class="form-control">
                                <option value="">Select Payment Type</option>

                                <option value="Full Payment" 
                                    <?= ($payment_type == 'full payment') ? 'selected' : '' ?>>
                                    Full Payment
                                </option>

                                <option value="Part Payment" 
                                    <?= ($payment_type == 'part payment') ? 'selected' : '' ?>>
                                    Part Payment
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
               
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <div class="col-auto">
                        <div class="form-check d-flex align-items-center" style="margin-top: 8px;">

                            <input  class="form-check-input" type="checkbox" id="tds_status" name="tds_status" class="mt-2" value="yes" <?= ($single_posting_edit['tds_status'] ?? '') === 'yes' ? 'checked disabled' : '' ?>
                                style="width: 18px; height: 18px; margin-top: 0; ">&nbsp;
                          

                            <label class="form-check-label ms-2" for="include_gst" style="font-size: 14px;">Include TDS</label>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <?php  if($single_posting_edit['tds_status'] =='yes')
                            { ?>

                               <input type="text" 
                                   class="form-control form-control-md" 
                                   id="tds_status_amount" 
                                   name="tds_amount"
                                   value="<?= esc($single_posting_edit['tds_amount'] ?? '') ?>" 
                                   placeholder="Enter TDS" disabled>
                            <?php 
                            }else{ ?>

                                    
                                    
                                <input type="text" 
                                   class="form-control form-control-md" 
                                   id="tds_status_amount" 
                                   name="tds_amount"
                                   value="<?= esc($single_posting_edit['tds_status_amount'] ?? '') ?>" 
                                   placeholder="Enter TDS"
                                   <?= ($single_posting_edit['tds_amount'] ?? '') === 'yes' ? ' ' : 'disabled' ?>
                            >
                        <?php
                            } ?>
                    </div>
                    <div class="col-md-3">
                        <?php if($single_posting_edit['payment_recived_status']=='Send_invoice') { ?>
                            <?php if($single_posting_edit['payment_type'] =='Part Payment' || $single_posting_edit['payment_type'] ==''){ ?>
                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                <?php }else
                                { ?>
                                    <button type="submit" class="btn btn-primary mt-3" disabled>Update</button>
                               <?php  } ?>
                     <?php }else{ ?>
                            <button type="submit" class="btn btn-primary mt-3" disabled>Update</button>
                    <?php
                     } ?>

                    </div>
                 
                </div>
                <!-- <button type="submit" class="btn btn-primary">Update</button> -->
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
//     $(document).ready(function () {

//     $("#conformed_salary").on("input blur", function () {

//         // ✅ Only numbers allowed
//         this.value = this.value.replace(/[^0-9]/g, '');

//         let value = $(this).val().trim();

//         // ✅ Required field validation
//         if (value === "") {
//             $("#salaryError").text("Salary is required");
//         } else {
//             $("#salaryError").text("");
//         }
//     });
    
    
    

 





// });


</script>


</body>
</html>
