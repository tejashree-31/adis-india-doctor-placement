<?php 
use Config\Database;
$db = Database::connect();
$builder = $db->table('tbl_recruiter');
$finalagreement = $builder->select('final_agreement,advanced_payment')->where('uid',$single_posting_edit['user_id'])->get()->getRow();
// Check if data found
// ============ with out gst calculation  ============================================
$final_agreement = isset($finalagreement->final_agreement) ? $finalagreement->final_agreement : 0;
$final_agreement = floatval(preg_replace('/[^0-9.]/', '', $final_agreement));
$Candidate_salary = (float) $single_posting_edit['conformed_salary']; // Monthly salary
$advanced_payment = isset($finalagreement->advanced_payment) ? $finalagreement->advanced_payment : 0;
$Annual_CTC = $Candidate_salary * 12; // Annual salary
// Final client payment (with percentage applied)
$final_client_payment = ($final_agreement / 100) * $Annual_CTC;
$final_agreement = round($final_agreement, 2);
$Candidate_salary = round($Candidate_salary, 2);
$Annual_CTC = round($Annual_CTC, 2);
$final_client_payment = round($final_client_payment, 2);
// ========================== with gst calculation  =====================
$gst_rate = 18; // GST percentage

// ✅ Calculate GST amount and total with GST
$gst_amount = ($final_client_payment * $gst_rate) / 100;
$total_with_gst = $final_client_payment + $gst_amount;

// ✅ Round GST-related values
$gst_amount = round($gst_amount, 2);
$total_with_gst = round($total_with_gst, 2);

// ✅ Output both versions
$total_client_payment_with_gst = number_format($total_with_gst, 2);
//echo "Total Client Payment (With GST): ₹" . number_format($total_with_gst, 2) . "<br>";

$final_client_payment_number_format = number_format($final_client_payment, 2);

// ==============================invoice Number=============================================
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
     
     // ==================================================
     // echo $final_client_payment;
        if (!empty($advanced_payment)) {
            $total_balance = $final_client_payment - $advanced_payment;
        } else {
            $total_balance = $single_posting_edit['conformed_salary'];
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Conformed Salary</title>
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
                Conformed Salary
                <a href="<?= base_url('admin/billing_admin_closed_vacuncy') ?>" class="btn btn-light btn-sm ms-2">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </h5>

            <span><b>Invoice No : </b><?php echo $ref_no ?></span>

        </div>
        <div class="card-body">
            <form action="<?= base_url('update-conformed-salary-form') ?>" method="post" id="update-conformed-salary-form" enctype="multipart/form-data">
               <input type="hidden" name="job_status_id" value="<?= isset($single_posting_edit['job_status_id']) ? esc($single_posting_edit['job_status_id']) : ''; ?>">
                
               <div class="row g-3">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="email_id" class="form-label">Candidate Salary</label>
                      <input type="text" class="form-control form-control-md" id="salary_max" name="conformed_salary" value="<?= isset($single_posting_edit['conformed_salary']) ? esc($single_posting_edit['conformed_salary']) : ''; ?>" required>
                            <span id="salary_maxError" style="color:red; display:none;">Please enter only numbers</span>
                        
                    </div>
                  </div>
                  
                    <div class="col-md-6">
                        <div class="mb-3">
                      <label for="email_id" class="form-label">Advanced Payment</label>
                      <input type="text" class="form-control form-control-md" id="salary_max" name="advanced_payment" value="<?= isset($advanced_payment) ? esc($advanced_payment) : ' '; ?>"  readonly>
                            <span id="salary_maxError" style="color:red; display:none;">Please enter only numbers</span>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="email_id" class="form-label">Client Payment</label>
                       <?php $client_payment_value = isset($single_posting_edit['client_payment']) ? trim($single_posting_edit['client_payment']) : '';
                            if ($client_payment_value === '' || $client_payment_value == 0 || $client_payment_value == 0.00) {
                                $bg_color = 'background-color: #fff9c4;'; // faint yellow
                            } else {
                                 $final_val = floatval(str_replace(',', '', $final_client_payment_number_format));
                                 $db_val    = floatval(str_replace(',', '', $single_posting_edit['client_payment']));
                                if($final_val  == $db_val)
                                {
                                    $bg_color = 'background-color: #d9fdd3;';
                                }else
                                {
                                    $bg_color = 'background-color: #fff9c4;';
                                }
                            }
                        ?>
                      <input type="text" class="form-control form-control-md" id="client_payment" name="client_payment" value=" <?= $final_client_payment_number_format ?>" readonly  style="<?= $bg_color ?>">
                            
                        
                    </div>
                  </div>
                </div>

               <div class="row align-items-center g-2">
                    <div class="col-auto">
                        <div class="form-check d-flex align-items-center" style="margin-top: 8px;">
                            <input class="form-check-input" name="gst_status" type="checkbox" id="include_gst" style="<?= $bg_color ?>width: 15px; height: 15px; margin-top: 0; "  value="yes"
                        <?= (isset($single_posting_edit['gst_status']) && $single_posting_edit['gst_status'] === 'yes') ? 'checked' : '' ?>>

                            <label class="form-check-label ms-2" for="include_gst" style="font-size: 14px;">Include GST</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="client_payment_gst" class="form-label mb-1" style="font-size: 14px;">GST Client Payment</label>
                        <input type="text" 
                               class="form-control form-control-sm" 
                               id="client_payment_gst" 
                               name="client_payment_gst" 
                               value="<?= $total_client_payment_with_gst; ?>" 
                               readonly style="<?= $bg_color ?>">
                    </div>

                    <div class="col-md-6"></div>
                </div>
                <div class="row align-items-center g-2" style="margin-top: 19px;">
                    <div class="col-auto">
                        <div class="form-check d-flex align-items-center" >
                            <input class="form-check-input" name="advanced_payment_status" type="checkbox" id="advance_payement_cli" style="width: 15px; height: 15px; margin-top: 0;"  value="yes"
                        <?= (isset($single_posting_edit['advanced_payment_status']) && $single_posting_edit['advanced_payment_status'] === 'yes') ? 'checked' : '' ?>>

                            <label class="form-check-label ms-2" for="advance_payement_cli" style="font-size: 14px;">Advanced Payment</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="total_client_payment_gst" class="form-label mb-1" style="font-size: 14px;">Total Client Payment</label>


                        <input type="text" 
                               class="form-control form-control-sm" 
                               id="total_client_payment_gst" 
                               name="total_client_payment_gst" 
                               value="<?= $total_balance; ?>" 
                               readonly style="<?= $bg_color ?>">
                    </div>

                    <div class="col-md-6"></div>
                </div>
             
               
                <div class="row g-3 mt-2">
               
                    <div class="col-md-3">
                        <?php if($single_posting_edit['payment_recived_status']=='') { ?>
                         <button type="submit" class="btn btn-primary mt-3">Update</button>
                     <?php }else{ ?>
                            <button type="submit" class="btn btn-primary mt-3" disabled>Update</button>
                    <?php
                     } ?>

                    </div>
                    <div class="col-md-9" style="margin-top:20px;">
                        <span style="background-color: #fff3cd; color: #856404;border-radius: 5px; font-weight: 400;">
                            Note: If the salary has been updated, please click the “Update” button to update the Client Payment.
                        </span>
                    </div>
                </div>
                <!-- <button type="submit" class="btn btn-primary">Update</button> -->
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

    $("#conformed_salary").on("input blur", function () {

        // ✅ Only numbers allowed
        this.value = this.value.replace(/[^0-9]/g, '');

        let value = $(this).val().trim();

        // ✅ Required field validation
        if (value === "") {
            $("#salaryError").text("Salary is required");
        } else {
            $("#salaryError").text("");
        }
    });

 





});
</script>


</body>
</html>
