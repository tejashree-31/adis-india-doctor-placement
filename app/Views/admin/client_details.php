<?php
use Config\Database;
$db = Database::connect();
 ?>
 <style type="text/css">

 </style>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
             <h4 class="mb-2 text-gray-800">Client Details <a href="<?= base_url('admin/client_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>  &nbsp;&nbsp;<a class="btn btn-sm btn-primary" title="Registred Clients"  id="downloadBtn_registred_client"><i class="fas fa-download"></i></a></h4>
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
                            <th>Institute</th>
                            <!--<th>Industry</th>-->
                            <th>Date</th>
                            <th>Address</th>
                            <th>Owner</th>
                            <th>Mobile No.</th>
                            <!--<th>Email Id</th>-->
                            <th>No Vacancy</th>
                            <!--<th>Final Agreement %</th>-->
                            <!--<th>Advanced Payment</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>Institute</th>
                            <!--<th>Industry</th>-->
                            <th>Date</th>
                            <th>Address</th>
                            <th>Owner</th>
                            <th>Mobile No.</th>
                            <!--<th>Email Id</th>-->
                            <th>No Vacancy</th>
                            <!--<th>Final Agreement %</th>-->
                            <!--<th>Advanced Payment</th>-->
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (!empty($recuiterData)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($recuiterData as $row) : ?>
                                <?php 
                                    $tbl_recruiter_posting_id= $db->table('tbl_recruiter_posting')->where('user_id',$row['uid'])->countAllResults();

                                    $tbl_recruiter_admin_count = $db->table('tbl_recruiter_posting')->where('user_id',$row['uid'])->where('admin_status','Closed')->countAllResults();
                             

                                ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td>
                                   

                                        <a href="<?= base_url('admin/view_recruiter_posting/' . $row['uid']); ?>">
                                            <b><?= esc(ucwords(strtolower($row['institute_name']))) ?></b>
                                        </a>
                                    
                                    </td>
                                    <!--<td><?//= esc($row['industry_name']) ?></td>-->
                                    <td><?= date('d/m/y', strtotime($row['created_date'])) ?></td>
                                    <td>
                                        <?php 
                                            $fullAddr = ucwords(strtolower($row['area_name'])) . ' - ' . ucwords(strtolower($row['name']));
                                            $shortAddr = substr($fullAddr, 0, 20) . '...';
                                        ?>
                                        
                                        <span class="addr-short"><?= esc($shortAddr) ?></span>
                                        <span class="addr-full d-none"><?= esc($fullAddr) ?></span>

                                        <a href="javascript:void(0)" class="addr-toggle">More</a>
                                    </td>
                                    <td><?= esc(ucwords(strtolower($row['recruiter_name']))) ?></td>
                                    <td><?= esc($row['mobile_no']) ?></td>
                                    <!--<td><?//= esc($row['email']) ?></td>-->
                                    <td class="text-center">
                                        <?php 
                                             $builder = $db->table('tbl_recruiter_posting'); 
                                            $count = $builder->where('user_id', $row['uid'])->where('admin_status','Open')->where('status','Publish')->countAllResults();
                                           
                                            echo $count;
                                         

                                        ?>
                                    </td>
                                    <!--<td class="text-center"><?//= isset($row['final_agreement']) && !empty($row['final_agreement']) ? esc($row['final_agreement']) : 'N/A' ?></td>-->
                                     <!--<td class="text-center"><?//= !empty($row['advanced_payment']) ? esc($row['advanced_payment']) : '-' ?></td>-->
                                    <td><?php
                                          if ($tbl_recruiter_posting_id == $tbl_recruiter_admin_count && $tbl_recruiter_posting_id != 0) { ?>
                                                <?php echo 'No Openings';?>

                                          <?php }else{ ?>
                                                
                                                <?php if ($row['client_reg_type'] == 'paid') { ?>
                                                <button class="btn btn-sm btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal_<?= $row['uid']; ?>" >
                                                <i class="fa fa-eye"></i></button>
                                                <?php }else{ ?>
                                                    <button class="btn btn-sm btn-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modal_<?= $row['uid']; ?>">
                                                    <i class="fa fa-eye"></i></button>
    
                                                <?php  } ?>
                                                    
                                                    
                                                <a href="<?= base_url('admin/edit-emp/'.$row['uid']) ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                               
                                                <a href="<?= base_url('admin/delete-emp/'.$row['uid']) ?>" class="btn btn-sm btn-danger delete-emp" data-uid="<?= $row['uid'] ?>"><i class="fa fa-trash"></i></a>
                                            <?php } ?>

                                    </td>
                                </tr>
                                    
                                    <div class="modal fade" id="modal_<?= $row['uid']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content" style="border-radius: 22px;
                                background: rgba(255,255,255,0.12);
                                backdrop-filter: blur(18px);
                                border: 1px solid rgba(255,255,255,0.25);
                                box-shadow: 0 12px 35px rgba(0,0,0,0.45);">
                                            <!-- Header -->
                                            <div class="modal-header1">
                                                <h5 class="modal-title1">
                                                    Client Details — <?= esc($row['recruiter_name']) ?>
                                                </h5>
                                            </div>
                                            <!-- Body -->
                                            <div class="modal-body1" >
                                                <div class="row row_line">
                                                    <div class="col-md-6 mb-3">
                                                            <p>
                                                                <strong class="label_head">Email  :</strong>
                                                                <span class="text_color"> <?= $row['email']?></span>
                                                            </p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <p>
                                                            <strong class="label_head">Industry Name  :</strong>
                                                            <span class="text_color"> <?= $row['industry_name']; ?></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <p>
                                                            <strong class="label_head">Registration Type :</strong>
                                                            <span class="text_color"> <?= !empty($row['client_reg_type']) ? $row['client_reg_type'] : 'N/A'; ?></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                            <p>
                                                                <strong class="label_head">Registration Date  :</strong>
                                                                <span class="text_color"> <?= (!empty($row['client_fees_reg_date']) && $row['client_fees_reg_date'] !== '0000-00-00') 
                                                            ? $row['client_fees_reg_date'] 
                                                            : 'N/A'; 
                                                                ?></span>
                                                            </p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                            <p>
                                                                <strong class="label_head">Final Agreement  :</strong>
                                                                <span class="text_color"><?= isset($row['final_agreement']) && $row['final_agreement'] !== '' ? $row['final_agreement'] . '%' : 'N/A'; ?></span>
                                                            </p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                            <p>
                                                                <strong class="label_head">Advanced Payment   :</strong>
                                                                <span class="text_color"><?= !empty($row['advanced_payment']) ? esc($row['advanced_payment']) : '-' ?></span>
                                                            </p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                            <p>
                                                                <strong class="label_head">Client Registration Recipt   :</strong>
                                                               <?php if ($row['client_reg_type'] == 'paid') { ?>
                                                                    <a href="<?= base_url('client-reg-recip-pdf/' . $row['uid']) ?>"
                                                                       class="btn btn-success"
                                                                       data-bs-toggle="tooltip"
                                                                       data-bs-placement="top"
                                                                       title="Invoice PDF"
                                                                       target="_blank"
                                                                       rel="noopener noreferrer">
                                                                        <i class="fa fa-download"></i>
                                                                    </a>
                                                                <?php } else { ?>
                                                                   <span>NA</span>
                                                                 <?php } ?>
                                                            </p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                            <p>
                                                                <strong class="label_head">Advanced Payment Recipt   :</strong>
                                                                <?php $advance = floatval($row['advanced_payment'] ?? 0); ?>
                                                                 <?php if ($advance > 0) { ?>
                                                                    <a href="<?= base_url('advanced-payment-recip-pdf/' . $row['uid']) ?>"
                                                                       class="btn btn-success"
                                                                       data-bs-toggle="tooltip"
                                                                       data-bs-placement="top"
                                                                       title="Invoice PDF"
                                                                       target="_blank"
                                                                       rel="noopener noreferrer">
                                                                        <i class="fa fa-download"></i>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    NA
                                                                <?php } ?>
                                                            </p>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                         <p>
                                                                <strong class="label_head">Lead From :</strong>
                                                                <span class="text_color"><?= !empty($row['lead_name']) ? esc($row['lead_name']) : '-' ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                
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
document.getElementById("downloadBtn_registred_client").addEventListener("click", function() {
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

    XLSX.utils.book_append_sheet(wb, ws, "RegisteredClients");
    XLSX.writeFile(wb, "Registered_clients.xlsx");
});
</script>