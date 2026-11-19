<?php
use Config\Database;
$db = Database::connect();
// echo "<pre>";
// print_r($recuiterPostingData);

 ?>
 <style type="text/css">
     .latest-month {
    background-color: #edefff; /* faint blue */
}
.toggle-input{
  display:none;
}

/* Mini Toggle Background */
.toggle-label{
  width:65px;
  height:28px;
  background:linear-gradient(90deg,#ff2e2e,#cc0000);
  border-radius:30px;
  position:relative;
  cursor:pointer;
  transition:0.3s ease;
  box-shadow:0 2px 6px rgba(0,0,0,0.2);
}

/* Circle */
.toggle-label::before{
  content:"✖";
  position:absolute;
  width:22px;
  height:22px;
  background:#eee;
  border-radius:50%;
  top:3px;
  left:3px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:12px;
  color:red;
  font-weight:bold;
  transition:0.3s ease;
}

/* Checked State */
.toggle-input:checked + .toggle-label{
  background:linear-gradient(90deg,#7ed957,#2fb344);
}

.toggle-input:checked + .toggle-label::before{
  content:"✔";
  left:40px;
  color:#2fb344;
}
 </style>
 
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Post vacancy Details <a href="<?= base_url('admin/client_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>&nbsp;&nbsp;<a class="btn btn-sm btn-primary" title="Post Vacuncy"  id="downloadBtn_post_vacuncy"><i class="fas fa-download"></i></a></h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3"> 
                <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
                <?php endif; ?>
                <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Client Name</th>
                                <th>Posting Date</th>
                                <th>Department</th>
                                <th>Experiance</th>
                                <th>Salary</th>
                                 <th>City</th>
                                 <th>Post Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Postion</th>
                                <th>Client Name</th>
                                <th>Posting Date</th>
                                <th>Department</th>
                                <th>Experiance</th>
                                <th>Salary</th>
                                 <th>City</th>
                                 <th>Post Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($AllpostVacancy)) : ?>
                                 <?php $i = 1; ?>
                                <?php foreach ($AllpostVacancy as $row) : ?>
                                
                                 <?php
                                    $createdMonth = date('Y-m', strtotime($row['created_date']));
                                    $currentMonth = date('Y-m');
                                    $highlightClass = ($createdMonth === $currentMonth) ? 'latest-month' : '';
                                ?>
                               
                            <tr class="<?= $highlightClass ?>">
                                <td><?= $i++ ?></td>
                                 <td><?= esc($row['job_role']) ?></td>
                                 <td><?= esc($row['recruiter_name']) ?></td>
                                <td><?= date('d/m/y', strtotime($row['created_date'])) ?></td>
                                <td><?= esc($row['department_name']) ?></td>
                                <td><?= esc($row['experience_min'].'-'.$row['experience_max'] )?></td>
                                <td><?= esc($row['salary_min'].'-'.$row['salary_max'] )?></td>
                                <td><?= esc($row['city_name']) ?></td>
                                <td> 
                                    
                                   <input type="checkbox" id="toggle<?= $row['posting_id']; ?>" class="toggle-input"
                                    data-id="<?= $row['posting_id']; ?>" <?= ($row['posting_status'] == 'Post Active') ? 'checked' : ''; ?>>

                                    <label for="toggle<?= $row['posting_id']; ?>" 
                                           class="toggle-label"></label>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/edit-post-vacuncy/'.$row['posting_id']) ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                               
                                     <a href="<?= base_url('admin/delete-post-vacuncy/'.$row['posting_id']) ?>" class="btn btn-sm btn-danger delete-post" data-uid="<?= $row['posting_id'] ?>" title="Delete"> <i class="fa fa-trash"></i> </a>
                                </td>
                              
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
document.getElementById("downloadBtn_post_vacuncy").addEventListener("click", function() {
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

    XLSX.utils.book_append_sheet(wb, ws, "Post Vacuncy");
    XLSX.writeFile(wb, "post_vacuncy.xlsx");
});
</script>