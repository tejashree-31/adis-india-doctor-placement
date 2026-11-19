<?php
use Config\Database;
$db = Database::connect();
?>
 <style type="text/css">
     /* Table Header Styling */


 </style>
<div class="container-fluid">
    <!-- Page Heading -->
     <!-- <h4 class=" mb-2 text-gray-800">Registered Candidate Details</h4> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="mb-2 text-gray-800">Registered Candidate Details <a href="<?= base_url('admin/admindashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;&nbsp;<a class="btn btn-sm btn-primary" title="Registered candidate"  id="downloadBtn_reg_candidate"><i class="fas fa-download"></i></a></h4>
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
                                <th>Email</th>
                                <th>Qualification</th>
                                <th>job_role</th>
                                <th>Mobile Number</th>
                                <th>Insurance Policy</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Qualification</th>
                                <th>job_role</th>
                                <th>Mobile Number</th>
                                <th>Insurance Policy</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($AllregistraionCandidate)) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($AllregistraionCandidate as $row) : ?>
                                    <?php 
                                    $allCities = explode(', ', $row['expected_city_names']);
                                    $visibleCities = array_slice($allCities, 0, 3);
                                    $hiddenCities = array_slice($allCities, 3);
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= esc($row['full_name']) ?></td>
                                         <td><?= esc($row['email']) ?></td>
                                        <td><?= esc($row['course_name']) ?></td>
                                        <td><?= esc($row['job_role']) ?></td>
                                        <td><?= esc($row['mobile_number']) ?></td>
                                        <td>
                                            <?php
                                            $insurance = $row['insurance_policy'] ?? 'N/A';

                                            if ($insurance == 'Yes') {
                                              $bg = '#b7e4c7';   // medium light green
                                                $color = '#1b4332';
                                            } elseif ($insurance == 'No') {
                                                $bg = '#f5b7b1'; // darker light red
                                                $color = '#922b21';
                                            } else {
                                                $bg = '#f8d7a3'; // darker light orange
                                                $color = '#9c640c';
                                                $insurance = 'N/A';
                                            }
                                            ?>

                                            <span style="
                                                background:<?= $bg ?>;
                                                color:<?= $color ?>;
                                                padding:5px 12px;
                                                border-radius:20px;
                                                font-size:13px;
                                                font-weight:600;
                                                display:inline-block;
                                            ">
                                                <?= esc($insurance) ?>
                                            </span>
                                        </td>
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




<script>
document.getElementById("downloadBtn_reg_candidate").addEventListener("click", function() {
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

    XLSX.utils.book_append_sheet(wb, ws, "Registred Candidate");
    XLSX.writeFile(wb, "Registred_candidate.xlsx");
});
</script>
