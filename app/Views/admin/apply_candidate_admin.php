<?php
use Config\Database;
$db = Database::connect();
?>
 <style type="text/css">
     /* Table Header Styling */
         .big-checkbox {
    transform: scale(1.6);   /* ⬅ size increase */
    -webkit-transform: scale(1.6);
    margin-right: 5px;       /* spacing */
}

 </style>
<div class="container-fluid">
    <!-- Page Heading -->
     <!-- <h4 class=" mb-2 text-gray-800">Registered Candidate Details</h4> -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="mb-2 text-gray-800">Applied Candidate <a href="<?= base_url('admin/admindashboard'); ?>" class="btn btn-sm btn-primary" title="Back"><i class="fas fa-long-arrow-alt-left"></i></a></h4>
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
                                <th>Current Location</th>
                                <th>Job Role</th>
                                <th>Client Name</th>
                                <th>Organization Name</th>
                                <th>Resume</th>
                                <th>Send Resume</th>
                                 <th>Applied Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr.No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Current Location</th>
                                <th>Job Role</th>
                                <th>Client Name</th>
                                <th>Organization Name</th>
                                <th>Resume</th>
                                <th>Send Resume</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                           
                            <?php if (!empty($AllapplyCandidate)) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($AllapplyCandidate as $row) : ?>
                                
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= esc($row['full_name']) ?></td>
                                        <td><?= esc($row['jobseeker_email']) ?></td>
                                        <td><?= esc($row['mobile_number']) ?></td>
                                        <td><?= esc($row['name']) ?></td>
                                        <td><?= esc($row['job_role']) ?></td>
                                        <td><?= esc($row['recruiter_name']) ?></td>
                                        <td><a href="<?= base_url('admin/view_recruiter_posting/' . $row['uid']); ?>"><b><?= esc($row['company_display_name']) ?></b></a></td>
                                        <td><?php if (!empty($row['resume'])): ?>
                                             <a href="javascript:void(0)"
                                   onclick="viewAndDownload('<?= base_url('jobseeker/resume/'.$row['resume']); ?>')"
                                               class="resume-btn" data-placement="top" title="Download File">
                                              <i class="fa fa-download" style="background:#860C15; color:#fff; border-radius:50%; padding:10px;"></i>
                                            </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No Resume</span>
                                                <?php endif; ?>
                                        </td>
                                        <!--  <td class="text-center">-->
                                        <!--    <?//php if ($row['send_resume_client'] === "yes") : ?>-->
    
                                        <!--    <input type="checkbox"-->
                                        <!--        name="send_email_resume_to_client"-->
                                        <!--        class="send_email_resume_to_client big-checkbox"-->
                                        <!--        data-email_send_id="<?//= $row['user_id']; ?>"-->
                                        <!--        checked-->
                                        <!--        >-->

                                        <!--        <?//php else : ?>-->

                                        <!--    <input type="checkbox"-->
                                        <!--        name="send_email_resume_to_client"-->
                                        <!--        class="send_email_resume_to_client big-checkbox"-->
                                        <!--        data-email_send_id="<?= $row['user_id']; ?>">-->

                                        <!--    <?//php endif; ?>-->
                                        <!--</td>-->
                                        <td class="text-center">
                                                <input type="checkbox"
                                                    name="send_email_resume_to_client"
                                                    class="send_email_resume_to_client big-checkbox"
                                                    data-user-id="<?= $row['user_id']; ?>"
                                                    data-jobseeker-id="<?= $row['jobseeker_id']; ?>"
                                                    <?= ($row['send_resume_client'] === "yes") ? 'checked' : ''; ?>
                                                >
                                        </td>
                                        <td><?= date('d/m/y', strtotime($row['applied_at'])) ?></td>
                                        <td style="background-color:#FF5533; color: #fff;">
                                            <?= esc($row['admin_candidate_status']); ?>
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