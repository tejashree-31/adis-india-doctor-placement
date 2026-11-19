<?php
use Config\Database;
$db = Database::connect();
?>
 <style type="text/css">
     /* Table Header Styling */
    
td {
    white-space: normal !important;
    word-wrap: break-word;
    /*word-break: break-word;*/
}
 </style>
<div class="container-fluid">
    <!-- Page Heading -->
     <!-- <h4 class=" mb-2 text-gray-800">Registered Candidate Details</h4> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="mb-2 text-gray-800">Contact Details
               
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
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th style="width:10%">Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($Allcontact_details)) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($Allcontact_details as $row) : ?>
    
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= esc($row['name']) ?></td>
                                        <td><?= esc($row['contact_email']) ?></td>
                                        <td><?= esc($row['subject']) ?></td>
                                       <td>
                                            <?php
                                                $fullMsg  = $row['message'] ?? '';
                                                $shortMsg = mb_strlen($fullMsg) > 30 
                                                    ? mb_substr($fullMsg, 0, 30) . '...' 
                                                    : $fullMsg;
                                            ?>
                                        
                                            <span class="msg-short"><?= esc($shortMsg) ?></span>
                                            <span class="msg-full d-none"><?= esc($fullMsg) ?></span>
                                        
                                            <?php if (mb_strlen($fullMsg) > 30): ?>
                                                <a href="javascript:void(0)" class="msg-toggle">More</a>
                                            <?php endif; ?>
                                        </td>
                                       <td><?php
        $timestamp = strtotime(str_replace('/', '-', $row['created_at']));
        echo $timestamp ? date('d-m-y', $timestamp) : '';
    ?></td>
                                       
                                      
                                    
                                       <td>
                                            <a href="<?= base_url('admin/delete-contact/'.$row['id']) ?>"
                                               class="btn btn-sm btn-danger delete-contact">
                                               Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">No Contact details found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
        </div>

                    </div>

                </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.msg-toggle').forEach(function (btn) {

        btn.addEventListener('click', function () {

            const td = this.closest('td');
            const shortMsg = td.querySelector('.msg-short');
            const fullMsg  = td.querySelector('.msg-full');

            if (fullMsg.classList.contains('d-none')) {
                shortMsg.classList.add('d-none');
                fullMsg.classList.remove('d-none');
                this.textContent = 'Less';
            } else {
                fullMsg.classList.add('d-none');
                shortMsg.classList.remove('d-none');
                this.textContent = 'More';
            }

        });

    });

});
</script>



