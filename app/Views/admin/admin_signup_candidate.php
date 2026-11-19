<?php
use Config\Database;
$db = Database::connect();
?>
 <style type="text/css">
     /* Table Header Styling */
  .switch {
  position: relative;
  display: inline-block;
  width: 44px;   /* medium */
  height: 22px;  /* medium */
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  background-color: #ccc; /* default grey */
  border-radius: 34px;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  transition: .3s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  border-radius: 50%;
  transition: .3s;
}

/* ON state */
input:checked + .slider {
  background-color: #28a745;
}

input:checked + .slider:before {
  transform: translateX(22px);
}

 </style>
<div class="container-fluid">
    <!-- Page Heading -->
     <!-- <h4 class=" mb-2 text-gray-800">Signup Candidate Details</h4> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
             <h4 class="mb-2 text-gray-800">Signup Candidate Details <a href="<?= base_url('admin/admindashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;&nbsp;<a class="btn btn-sm btn-primary" title="Signup Candidate"  id="downloadBtn_signup_candidate"><i class="fas fa-download"></i></a></h4>
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
                                <th>Mobile Number</th>
                                <th>Spouse Profession</th>
                                <th>Job Role</th>
                                <th>Register date</th>
                                 <th>Status</th>
                                 <!-- <th>Action</th> -->
                                 <th>Otp status</th>
                                 <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Spouse Profession</th>
                                <th>Job Role</th>
                                <th>Register date</th>
                                <th>Status</th>
                                <!-- <th>Action</th> -->
                                <th>otp Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($AllsignupCandidate)) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($AllsignupCandidate as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= !empty($row['full_name']) ? esc($row['full_name']) : '-'; ?></td>
                                        <td><?= esc($row['email']) ?></td>
                                        
                                        <td><?= esc($row['mobile_no']) ?></td>
                                        <td><?php $abc = $db->table('tbl_jobseeker')
                                            ->where('uid', $row['uid'])
                                            ->get()
                                            ->getRowArray(); ?>
                                            <?php if(!empty($abc['spouse_type']) && $abc['spouse_type'] != 'N/A'): ?>
                                                <?= esc($abc['spouse_type']) ?>
                                            <?php else: ?>
                                                <div style="text-align:center;">-</div>
                                            <?php endif; ?>
                                        </td>
                                        <?php
                                            $job = $db->table('tbl_job_role')
                                                      ->where('job_id', $row['job_id'])
                                                      ->get()
                                                      ->getRowArray();
                                            ?>

                                            <td><?= !empty($job['job_role']) ? esc($job['job_role']) : '-' ?></td>
                                        <td><?= date('d/m/y', strtotime($row['registered_date'])) ?></td>
                                        <td class="text-center" style="">
                                            <?//= esc($row['login_status']) ?>
                                           <?php 
                                           

                                            if ($row['login_status'] == 'active') {
                                                echo '<span style="color: #2e7d32; background-color: #c8e6c9; padding: 3px 8px; border-radius: 5px;"></span>';
                                            } else {
                                                echo '<span style="color: #c62828; background-color: #ffcdd2; padding: 3px 8px; border-radius: 5px;"></span>';
                                            }
                                        ?>
                                        </td>
                                     <!--    <td class="text-center">
                                            
                                            
                                        </td> -->
                                        <td class="text-center">
                                            <label class="switch">
                                                <input type="checkbox" 
                                                       class="statusToggle" 
                                                       data-id="<?= $row['uid']; ?>" 
                                                       <?= ($row['status'] == 'active') ? 'checked' : '' ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['login_status'] == 'active') { ?>
                                                <span >-</span>
                                            <?php }else{ ?>
                                                <a href="<?= base_url('admin/delete-candidate-signup/'.$row['uid']) ?>" class="btn btn-sm btn-danger delete-emp" data-uid="<?= $row['uid'] ?>"> <i class="fa fa-trash"></i> </a>
                                            <?php
                                            } ?>&nbsp;
                                            <?php
                                            if ($row['login_status'] == 'active') { ?>
                                                <span >-</span>
                                            <?php }else{ ?>
                                             <a href="<?= base_url('admin/edit-candidate-form-id/'.$row['uid']) ?>" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i></a>
                                               <?php
                                            } ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById("downloadBtn_signup_candidate").addEventListener("click", function() {
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

    XLSX.utils.book_append_sheet(wb, ws, "Signup Candidate");
    XLSX.writeFile(wb, "signup_candidate.xlsx");
});
</script>
