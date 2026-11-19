<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);

 ?>
 <style>

</style>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"> Paid Client <a href="<?= base_url('admin/billing_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"> <i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;&nbsp;<a class="btn btn-sm btn-primary" title="paid Payment"  id="downloadBtn_paid_payment"><i class="fas fa-download"></i></a></h1>
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
                                <th>Registration Fees</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Institute Name</th>
                                <th>Client Name</th>
                                <th>Registration Fees</th>
                                <th>Registration Date</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($PaidClientDisplay)) : ?>
                                 <?php $i = 1; ?>
                                <?php foreach ($PaidClientDisplay as $row) : ?>
                                <?php  $currentMonth = date('Y-m');  ?>
                                <?php
                                    $feesRegMonth = !empty($row['client_fees_reg_date'])
                                        ? date('Y-m', strtotime($row['client_fees_reg_date']))
                                        : '';
                                
                                    $rowStyle = ($feesRegMonth === $currentMonth)
                                        ? 'background-color:#d9f2ff;'  // light blue
                                        : '';
                                ?>
                                <tr style="<?= $rowStyle ?>">
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($row['institute_name']) ?></td>
                                    <td><?= esc($row['recruiter_name']) ?></td>
                                    <td><?= esc($row['client_reg_fees']) ?></td>
                                    <td><?= date('d/m/y', strtotime($row['client_fees_reg_date'])) ?></td>
                           
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
<script>
document.getElementById("downloadBtn_paid_payment").addEventListener("click", function() {
    // Get DataTable instance
    var table = $('#dataTable').DataTable();

    // Get all rows data (ignore pagination)
    var data = table.rows({ search: 'applied' }).nodes().toArray();

    // Create a new table element
    var cloneTable = document.createElement("table");

    // Optional: add header row
    var thead = table.columns().header().to$().clone(); // jQuery clone
    var newThead = document.createElement("thead");
    var tr = document.createElement("tr");
    thead.each(function(index, th){
        if (index !== thead.length - 1) { // skip last column (Action)
            var newTh = document.createElement("th");
            newTh.innerText = th.innerText;
            tr.appendChild(newTh);
        }
    });
    newThead.appendChild(tr);
    cloneTable.appendChild(newThead);

    // Add all tbody rows
    var newTbody = document.createElement("tbody");
    data.forEach(function(row){
        var newTr = row.cloneNode(true);
        newTr.removeChild(newTr.lastElementChild); // remove last column
        newTbody.appendChild(newTr);
    });
    cloneTable.appendChild(newTbody);

    // Convert to sheet
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.table_to_sheet(cloneTable);

    // Optional: add thin borders
    var range = XLSX.utils.decode_range(ws['!ref']);
    for (var R = range.s.r; R <= range.e.r; ++R) {
        for (var C = range.s.c; C <= range.e.c; ++C) {
            var cell_address = {c:C, r:R};
            var cell_ref = XLSX.utils.encode_cell(cell_address);
            if (!ws[cell_ref]) continue;
            ws[cell_ref].s = {
                border: {
                    top: {style:"thin", color:{rgb:"000000"}},
                    bottom: {style:"thin", color:{rgb:"000000"}},
                    left: {style:"thin", color:{rgb:"000000"}},
                    right: {style:"thin", color:{rgb:"000000"}}
                }
            };
        }
    }

    XLSX.utils.book_append_sheet(wb, ws, "Paid Payment");
    XLSX.writeFile(wb, "paid_payment.xlsx");
});
</script>