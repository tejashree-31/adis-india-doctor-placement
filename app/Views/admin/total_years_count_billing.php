<?php
use Config\Database;
$db = Database::connect();


?>
 
 <style>

</style>

<div class="container-fluid">
    
    <div class="card shadow mb-4">
        <div class="card-header py-3"> 
            <h1 class="h3 mb-2 text-gray-800">
                <!-- <i class="fas fa-calendar-alt fa-lg"></i> -->
                 Total Years Count &nbsp;
                <a href="<?= base_url('admin/billing_dashboard'); ?>" 
                   class="btn btn-sm btn-primary " 
                   title="Back">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>&nbsp;&nbsp;<a class="btn btn-sm btn-primary" title="Total Years Count"  id="downloadBtn_total_years"><i class="fas fa-download"></i></a>
            </h1>
      <form method="post" action="<?= base_url('admin/total_years_count_billing') ?>" class="d-flex">

            <div class="mr-2">
                <label class="small text-muted">Start Date</label>
                <input type="month" name="start_date"
                       value="<?= $start_date ?? '' ?>"
                       class="form-control form-control-sm">
            </div>

            <div class="mr-2">
                <label class="small text-muted">End Date</label>
                <input type="month" name="end_date"
                       value="<?= $end_date ?? '' ?>"
                       class="form-control form-control-sm">
            </div>

            <div class="mt-4">
                <button class="btn btn-primary btn-sm">Submit</button>
            </div>

    </form>
    <form method="post" action="<?= base_url('admin/total_years_count_billing') ?>" class="d-inline">
    <input type="hidden" name="start_date" value="">
    <input type="hidden" name="end_date" value="">
    <button type="submit" class="btn btn-danger btn-sm">Reset</button>
</form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                
               <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">

                        <thead style="background-color: #FFE5CC;">
                            <tr>
                                <th>Month</th>
                                <th>Total Registration</th>
                                <th>Total Bill </th>
                                <th>Total TDS</th>
                                <th>Total Received</th>
                                <th>Total Advanced</th>
                                <td>Total Disccount </td>
                                <th>Total Pending</th>

                            </tr>
                        </thead>

                        <tbody>
                    <?php
                    $totalReg = 0;
                    $totalRec = 0;
                    $totalPen = 0;
                    $totalBillPayment =0;
                    $totaltotalAdvancedpayment = 0;
                    $totaltdspaymentAmount = 0;
                    $total_discount = 0;
                    ?>
                    <?php if (!empty($months)) : ?>
                        <?php foreach ($months as $m): ?>
                            <?php
                            $monthNumber = date("m", strtotime($m['month']));

                            // TOTAL REGISTRATION
                            $builder = $db->table('tbl_recruiter');
                            $builder->select('COALESCE(SUM(REPLACE(client_reg_fees, ",", "")), 0) AS total_fees', false);
                            $builder->where('client_reg_type', 'paid');
                            $builder->where('YEAR(client_fees_reg_date)', $m['year'], false);
                            $builder->where('MONTH(client_fees_reg_date)', $monthNumber, false);
                            $result = $builder->get()->getRow();
                            $totalAmount = (float)$result->total_fees;

                            // TOTAL RECEIVED
                            $builder_recive = $db->table('tbl_candidate_job_status');
                            $builder_recive->select('COALESCE(SUM(REPLACE(client_recived_payment, ",", "")), 0) AS total_received', false);
                            $builder_recive->where('payment_recived_status', 'Recived_payment');
                            $builder_recive->where('YEAR(payment_recived_date)', $m['year'], false);
                            $builder_recive->where('MONTH(payment_recived_date)', $monthNumber, false);
                            $result = $builder_recive->get()->getRow();
                            $totalReceived = (float)$result->total_received;

                            // TOTAL PENDING
                            $pendingRows = $db->table('tbl_candidate_job_status tcjs')
                                ->select('tcjs.*, rp.*, r.*')
                                ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
                                ->join('tbl_recruiter r', 'rp.user_id = r.uid')
                                ->where('tcjs.admin_candidate_status', 'Closed')
                                ->where('tcjs.payment_recived_status', 'Recived_payment')
                                ->where('rp.status', 'Publish')
                                ->where('YEAR(tcjs.payment_recived_date)', $m['year'], false)
                                ->where('MONTH(tcjs.payment_recived_date)', $monthNumber, false)
                                ->get()
                                ->getResultArray();

                                $totalPending = 0;
                                foreach ($pendingRows as $row) {
                                    $advanced  = !empty($row['advanced_payment']) ? (float)str_replace(',', '', $row['advanced_payment']) : 0;
                                    $received  = !empty($row['client_recived_payment']) ? (float)str_replace(',', '', $row['client_recived_payment']) : 0;
                                    $gstAmount = !empty($row['client_payment_gst']) ? (float)str_replace(',', '', $row['client_payment_gst']) : 0;
                                    $original  = !empty($row['client_payment']) ? (float)str_replace(',', '', $row['client_payment']) : 0;
                                    $gstStatus = $row['gst_status'] ?? 'no';

                                    $totalBill = ($advanced > 0) ? ($advanced + $received) : $received;

                                    $pending = ($gstStatus === 'yes')
                                                ? ($gstAmount - $totalBill)
                                                : ($original - $totalBill);

                                    if (!empty($row['discount_check']) && $row['discount_check'] === 'yes') {
                                        $discount = !empty($row['discount_amount']) ? (float)str_replace(',', '', $row['discount_amount']) : 0;
                                        $pending -= $discount;
                                    }

                                    if ($pending < 0) $pending = 0;

                                    $totalPending += $pending;
                                }

                               // Total Bill Count 
                                $TotalBillRows = $db->table('tbl_candidate_job_status tcjs')
                                ->select('tcjs.*, rp.*, r.*')
                                ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
                                ->join('tbl_recruiter r', 'rp.user_id = r.uid')
                                ->where('tcjs.admin_candidate_status', 'Closed')
                                ->where('tcjs.payment_recived_status', 'Recived_payment')
                                ->where('rp.status', 'Publish')
                                ->where('YEAR(tcjs.joining_date)', $m['year'], false)
                                ->where('MONTH(tcjs.joining_date)', $monthNumber, false)
                                ->get()
                                ->getResultArray();
                                $totalBillPaymentClient = 0;
                                foreach ($TotalBillRows as $row) {

                                    if ($row['gst_status'] === 'yes') {
                                        // GST amount
                                        $amount = !empty($row['client_payment_gst'])
                                                  ? (float)str_replace(',', '', $row['client_payment_gst'])
                                                  : 0;
                                    } else {
                                        // Normal amount
                                        $amount = !empty($row['client_payment'])
                                                  ? (float)str_replace(',', '', $row['client_payment'])
                                                  : 0;
                                    }

                                    $totalBillPaymentClient += $amount;
                                }
                                $totalBillPaymentClientFormatted = number_format($totalBillPaymentClient, 2);

                                // ========== Total Advanced ======================== 
                                $advRows = $db->table('tbl_recruiter')
                                ->select('advanced_payment')
                                ->where('advanced_payment !=', '')      
                                ->where('advanced_payment IS NOT NULL')  
                                ->where('YEAR(created_date)', $m['year'], false)
                                ->where('MONTH(created_date)', $monthNumber, false)
                                ->get()
                                ->getResultArray();

                            $totalAdvanced = 0;

                            foreach ($advRows as $ar) {

                                
                                $advanced_amount = floatval($ar['advanced_payment']);

                                $totalAdvanced += $advanced_amount;
                            }

                            $totalAdvancedFormatted = number_format($totalAdvanced, 2);  
                            
                            // ========================Total Tds ==============================

                            $advtdsAmountRows = $db->table('tbl_candidate_job_status')
                                ->select('tds_amount')
                                ->where('tds_status !=', '')      
                                ->where('tds_status IS NOT NULL')  
                                ->where('YEAR(payment_recived_date)', $m['year'], false)
                                ->where('MONTH(payment_recived_date)', $monthNumber, false)
                                ->get()
                                ->getResultArray();

                            $total_tds_amount = 0;

                            foreach ($advtdsAmountRows as $ar) {

                                
                                $totalTdsAmount = floatval($ar['tds_amount']);

                                $total_tds_amount += $totalTdsAmount;
                            }

                            $totalTDSFormatted = number_format($total_tds_amount, 2);  

                            // ========================Total Disscount ==============================

                            $discountRows = $db->table('tbl_candidate_job_status tcjs')
                            ->select('tcjs.*, rp.*, r.*')
                            ->join('tbl_recruiter_posting rp', 'tcjs.posting_id = rp.posting_id')
                            ->join('tbl_recruiter r', 'rp.user_id = r.uid')
                            ->where('tcjs.admin_candidate_status', 'Closed')
                            ->where('rp.status', 'Publish')

                            // ⭐ ADD NEW CONDITIONS ⭐
                            ->where('tcjs.discount_check', 'yes')
                            ->where('tcjs.discount_amount !=', '')
                            ->where('tcjs.discount_amount IS NOT NULL')

                            ->where('YEAR(tcjs.invoice_send_date)', $m['year'], false)
                            ->where('MONTH(tcjs.invoice_send_date)', $monthNumber, false)
                            ->get()
                            ->getResultArray();

                            $totalDiscount = 0;

                            foreach ($discountRows as $d) {
                                // comma remove + float convert
                                $amount = floatval(str_replace(",", "", $d['discount_amount']));
                                $totalDiscount += $amount;
                            }

                            $totalDiscountFormatted = number_format($totalDiscount, 2);  // 10,000.00

                            // Add to totals
                            $totalReg += $totalAmount;
                            $totalRec += $totalReceived;
                            $totalPen += $totalPending;
                            $totalBillPayment += $totalBillPaymentClient;
                            $totaltotalAdvancedpayment +=$totalAdvanced;
                             $totaltdspaymentAmount +=$total_tds_amount;
                            $total_discount += $totalDiscount;

                            // Format for display
                            $totalAmountFormatted = number_format($totalAmount, 2);
                            $totalReceivedFormatted = number_format($totalReceived, 2);
                            $pendingFormatted = number_format($totalPending, 2);
                             
                            ?>
                            <tr>
                                <td class="text-center"><?= $m['month'] . ' ' . $m['year'] ?></td>

                                <td class="reg text-center"><?= $totalAmountFormatted ?></td>
                                <td class="bill text-center"><?= $totalBillPaymentClientFormatted ?></td>
                                <td><?= $totalTDSFormatted; ?></td>
                                <td class="rec text-center"><?= $totalReceivedFormatted ?></td>
                                <td class="totaltotalAdv text-center"><?= $totalAdvancedFormatted ?></td>
                                <td class="desc text-center"><?= $totalDiscountFormatted ?></td>
                                <td class="pen text-center"><?= $pendingFormatted ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>

                <!-- ✅ TOTAL FOOTER ROW -->
                <tfoot style="background:#7FEB7F; font-weight:bold;">
                    <tr>
                        <td class="text-center">Total</td>
                        <td class="text-center" id="totalReg"><?= number_format($totalReg, 2) ?></td>
                        <td class="text-center" id="totalBillPayment"><?= number_format($totalBillPayment, 2) ?></td>
                         <td><?= number_format($totaltdspaymentAmount,2) ?></td>

                        <td  class="text-center" id="totalRec"><?= number_format($totalRec, 2) ?></td>
                        <td  class="text-center" id="totaltotalAdvancedpayment"><?= number_format($totaltotalAdvancedpayment, 2) ?></td>
                        <td class="text-center" id="total_discount"><?= number_format($total_discount,2)?></td>
                        <td class="text-center" id="totalPen"><?= number_format($totalPen, 2) ?></td>
                    </tr>
                </tfoot>


</table>

            </div>
        </div>
    </div>

</div>

<script>

function formatMonthYearInput(id) {
    const input = document.getElementById(id);
    input.addEventListener('input', () => {
        const value = input.value; // YYYY-MM
        if(value){
            const [year, month] = value.split('-');
            input.dataset.display = new Date(year, month-1).toLocaleString('default', { month: 'long', year: 'numeric' });
        }
    });
}

formatMonthYearInput('start_date');
formatMonthYearInput('end_date');
</script>

<script type="text/javascript">
    $('.abc').DataTable({
    pageLength: 12
});
</script>

<script>
document.getElementById("downloadBtn_total_years").addEventListener("click", function () {

    // Original table
    var table = document.getElementById("dataTable1");

    // Clone full table (thead + tbody + tfoot)
    var cloneTable = table.cloneNode(true);

    // Excel workbook
    var wb = XLSX.utils.book_new();

    // Convert table to sheet (includes footer)
    var ws = XLSX.utils.table_to_sheet(cloneTable, {
        raw: true
    });

    // Auto column width
    var range = XLSX.utils.decode_range(ws['!ref']);
    ws['!cols'] = [];
    for (var C = range.s.c; C <= range.e.c; ++C) {
        ws['!cols'].push({ wch: 20 });
    }

    XLSX.utils.book_append_sheet(wb, ws, "Total Years Count");

    XLSX.writeFile(wb, "Total_Years_Billing_Report.xlsx");
});
</script>

