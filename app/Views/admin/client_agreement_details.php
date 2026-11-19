<?php
use Config\Database;
$db = Database::connect();
 ?>
 <style type="text/css">
.big-checkbox {
    transform: scale(1.6);   /* ⬅ size increase */
    -webkit-transform: scale(1.6);
    margin-right: 5px;       /* spacing */
}
 </style>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
           
             <h4 class="mb-2 text-gray-800">Client Agreement Details <a href="<?= base_url('admin/client_dashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a>
              
             </h4>
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
                            <th>Registraion Date</th>
                            <th>Address</th>
                            <th>Owner</th>
                            <th>Mobile No.</th>
                             <th>Send Mail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>Institute</th>
                            <th>Registraion Date</th>
                            <th>Address</th>
                            <th>Owner</th>
                            <th>Mobile No.</th>
                             <th>Send Mail</th>
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
                                    <td><?= esc(ucwords(strtolower($row['institute_name']))) ?> </td>
                                    <td><?= date('d/m/y', strtotime($row['created_date'])) ?></td>
                                    
                                   <td><?php
                                            $fullAddr = ucwords(strtolower($row['area_name'])) . ' - ' . ucwords(strtolower($row['name']));
                                            $shortAddr = substr($fullAddr, 0, 35) . '...';
                                        ?>
                                        <span class="addr-short"><?= esc($shortAddr) ?></span>
                                        <span class="addr-full d-none"><?= esc($fullAddr) ?></span>

                                        <a href="javascript:void(0)" class="addr-toggle">More</a>
                                    </td>
                                    <td><?= esc(ucwords(strtolower($row['recruiter_name']))) ?></td>
                                    <td><?= esc($row['mobile_no']) ?></td>
                                    <td class="text-center">
                                        <?php if ($row['send_agreement_client'] === "yes") : ?>
    
                                            <input type="checkbox"
                                                name="send_email_agreement_to_client"
                                                class="send_email_agreement_to_client big-checkbox"
                                                data-email_send_id="<?= $row['uid']; ?>"
                                                checked
                                                >

                                        <?php else : ?>

                                            <input type="checkbox"
                                                name="send_email_agreement_to_client"
                                                class="send_email_agreement_to_client big-checkbox"
                                                data-email_send_id="<?= $row['uid']; ?>">

                                        <?php endif; ?>
                                    </td>
                                    <td><?php
                                          if ($tbl_recruiter_posting_id == $tbl_recruiter_admin_count && $tbl_recruiter_posting_id != 0) { 

                                            ?>
                                                <?php echo 'No Openings';?>

                                          <?php }else{ ?>
                                            <button class="btn btn-sm btn-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal_<?= $row['uid']; ?>">
                                             <i class="fa fa-eye"></i>
                                            </button>
                                            <a href="<?= base_url('admin/edit_agreement_emp/'.$row['uid']) ?>" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i></a>
                                               
                                            <!-- <a href="<?//= base_url('admin/delete-emp/'.$row['uid']) ?>" class="btn btn-sm btn-danger delete-emp" data-uid="<?//= $row['uid'] ?>"> <i class="fa fa-trash"></i> </a> -->
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
                                                    Client Agreement — <?= esc($row['recruiter_name']) ?>
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
                                                                <strong class="label_head">Agreement    :</strong>
                                                               <a href="<?= base_url('client-agreement-pdf/'.$row['uid']) ?>"
                                                                   class="btn btn-success"
                                                                   data-bs-toggle="tooltip"
                                                                   data-bs-placement="top"
                                                                   title="Invoice PDF" target="_blank" rel="noopener noreferrer">
                                                                   <i class="fa fa-download"></i>
                                                                </a>
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
