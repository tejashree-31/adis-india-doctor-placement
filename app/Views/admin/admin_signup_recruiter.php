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
             <h4 class="mb-2 text-gray-800">Admin Signup Clients <a href="<?= base_url('admin/client_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;&nbsp;<a class="btn btn-sm btn-primary" title="Signup Clients"  id="downloadBtn"><i class="fas fa-download"></i></a></h4>
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
                        <?php if (!empty($AllsignupRecruiter)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($AllsignupRecruiter as $row) : ?>
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

<script>
document.getElementById("downloadBtn").addEventListener("click", function() {
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

    XLSX.utils.book_append_sheet(wb, ws, "Signup Clients");
    XLSX.writeFile(wb, "Signup_clients.xlsx");
});
</script>