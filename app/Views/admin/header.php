<!DOCTYPE html>
<html lang="en">
<?php
$session = session();
$username = $session->get('name');
$user_type = $session->get('user_type');


?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url(); ?>assets/jobportal/images/color_logo.png" type="image/png"><title>Adis India Placement</title>
    <link href="<?= base_url(); ?>admin_assests/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>admin_assests/assets/css/custom.css?v=<?= filemtime(FCPATH . 'admin_assests/assets/css/custom.css'); ?>"
      rel="stylesheet"
      type="text/css">
    <link href="<?= base_url(); ?>admin_assests/assets/css/admin_model.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="<?= base_url(); ?>admin_assests/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>admin_assests/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jobportal/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
    .nav-link .img-profile {
    height: 3rem !important;
    width: 3rem !important;
}
/* WhatsApp Main Icon */

    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php if ($user_type != 'Trainer') { ?>
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin/admindashboard'); ?>">
                <div class="sidebar-brand-icon">
                  <img src="<?php echo base_url(); ?>assets/jobportal/images/white_logo.png" alt="Free Website Template by Free-Template.co" style="height: 50px;">
                </div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url('admin/admindashboard'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Candidate Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/candidate_details'); ?>">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Candidate Details</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Interface
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/client_dashboard'); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Client Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/client_details'); ?>">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Client Details</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/client-agreement-details'); ?>">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Client Agreement</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Latest News </span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                        <a class="collapse-item" href="<?= base_url('admin/add_blogs'); ?>">Add News</a>
                        <a class="collapse-item" href="<?= base_url('admin/display_blogs'); ?>">Display News</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Employer</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('admin/add-employer'); ?>">Add employee</a>
                        <!-- <a class="collapse-item" href="utilities-animation.html">Display employee</a> -->
                       
                    </div>
                </div>
            </li>
             <hr class="sidebar-divider d-none d-md-block">
              <?php if (session()->get('name') === 'admin'): ?>
            <div class="sidebar-heading">
               Billing
            </div>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/billing_dashboard'); ?>">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Billing Dashboard</span></a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/candidate_agreement_deatil'); ?>">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Candidate Agreement</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('admin/contact_details'); ?>">
                    <i class="fas fa-user"></i>
                    <span>Contact Records</span></a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsethree"
                    aria-expanded="true" aria-controls="collapsethree">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Awards & Recognition</span>
                </a>
                <div id="collapsethree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                        <a class="collapse-item" href="<?= base_url('admin/award_recon'); ?>">Add Awards</a>
                        <a class="collapse-item" href="<?= base_url('admin/display_award_recon'); ?>">Display Awards</a>
                    </div>
                </div>
            </li>
            <!-- <li class="nav-item">
                    <a class="nav-link collapsed"
                       href="#"
                       data-toggle="collapse"
                       data-target="#collapsefour"
                       aria-expanded="true"
                       aria-controls="collapsefour">

                        <i class="fab fa-whatsapp whatsapp-circle"></i>

                        <span>WhatsApp</span>
                    </a>

                    <div id="collapsefour"
                         class="collapse"
                         aria-labelledby="headingTwo"
                         data-parent="#accordionSidebar">

                          <div id="collapsefour"
                             class="collapse"
                             aria-labelledby="headingTwo"
                             data-parent="#accordionSidebar">

                            <div class="bg-white py-2 collapse-inner rounded">

                                <a class="collapse-item"
                                   href="<?= base_url('admin/whatsapp_dashboard'); ?>">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Dashboard</span>
                                </a>

                                <a class="collapse-item"
                                   href="<?= base_url('admin/whatsapp_conversations'); ?>">
                                    <i class="fas fa-comments"></i>
                                    <span>Conversations</span>
                                </a>

                                <a class="collapse-item"
                                   href="<?= base_url('admin/whatsapp_templates'); ?>">
                                    <i class="fas fa-file-alt"></i>
                                    <span>Templates</span>
                                </a>

                                <a class="collapse-item"
                                   href="<?= base_url('admin/whatsapp_bulk_send'); ?>">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Bulk Send</span>
                                </a>

                                <a class="collapse-item"
                                   href="<?= base_url('admin/whatsapp_campaigns'); ?>">
                                    <i class="fas fa-bullhorn"></i>
                                    <span>Campaigns</span>
                                </a>

                                <a class="collapse-item"
                                   href="<?= base_url('admin/whatsapp_logs'); ?>">
                                    <i class="fas fa-history"></i>
                                    <span>Logs</span>
                                </a>

                                <a class="collapse-item"
                                   href="<?= base_url('admin/whatsapp_failed_message'); ?>">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Failed Message</span>
                                </a>

                                <a class="collapse-item"
                                   href="<?= base_url('admin/whatsapp_settings'); ?>">
                                    <i class="fas fa-cog"></i>
                                    <span>Settings</span>
                                </a>

                            </div>
                        </div>
                    </div>
            </li> -->
            <li class="nav-item">

                    <a class="nav-link collapsed"
                       href="#"
                       data-toggle="collapse"
                       data-target="#collapseWhatsApp"
                       aria-expanded="false"
                       aria-controls="collapseWhatsApp">

                        <i class="fab fa-whatsapp whatsapp-circle"></i>
                        <span>WhatsApp</span>
                    </a>

                    <div id="collapseWhatsApp"
                         class="collapse"
                         aria-labelledby="headingWhatsApp"
                         data-parent="#accordionSidebar">

                        <div class="bg-white py-2 collapse-inner rounded">

                            <!-- Dashboard -->
                            <a class="collapse-item"
                               href="<?= base_url('admin/whatsapp_dashboard'); ?>">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>

                            <!-- Conversations -->
                            <a class="collapse-item"
                               href="<?= base_url('admin/whatsapp_conversations'); ?>">
                                <i class="fas fa-comments"></i>
                                <span>Conversations</span>
                            </a>

                            <!-- Templates -->
                            <a class="collapse-item"
                               href="<?= base_url('admin/whatsapp_templates'); ?>">
                                <i class="fas fa-file-alt"></i>
                                <span>Templates</span>
                            </a>

                            <!-- Bulk Send -->
                            <a class="collapse-item"
                               href="<?= base_url('admin/whatsapp_bulk_send'); ?>">
                                <i class="fas fa-paper-plane"></i>
                                <span>Bulk Send</span>
                            </a>

                            <!-- Campaigns -->
                            <a class="collapse-item"
                               href="<?= base_url('admin/whatsapp_campaigns'); ?>">
                                <i class="fas fa-bullhorn"></i>
                                <span>Campaigns</span>
                            </a>

                            <!-- Logs -->
                            <a class="collapse-item"
                               href="<?= base_url('admin/whatsapp_logs'); ?>">
                                <i class="fas fa-history"></i>
                                <span>Logs</span>
                            </a>

                            <!-- Failed Message -->
                            <a class="collapse-item"
                               href="<?= base_url('admin/whatsapp_failed_message'); ?>">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>Failed Message</span>
                            </a>

                            <!-- Settings -->
                            <a class="collapse-item"
                               href="<?= base_url('admin/whatsapp_settings'); ?>">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>

                        </div>
                    </div>

            </li>
            <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('traning/traningdashboard'); ?>">
                    <i class="fas fa-user"></i>
                    <span>Training Records</span></a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/insurancy_policy_data'); ?>">
                    <i class="fas fa-user"></i>
                    <span>Insurance policy</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            <!-- Sidebar Message -->
        </ul>
        <?php }else{ ?>
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('traning/traningdashboard'); ?>">
                <div class="sidebar-brand-icon">
                  <img src="<?php echo base_url(); ?>assets/jobportal/images/white_logo.png" alt="Free Website Template by Free-Template.co" style="height: 50px;">
                </div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('traning/traningdashboard'); ?>">
                    <i class="fas fa-user"></i>
                    <span>Training Records</span></a>
                </li>
            </ul>
        <?php
        } ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                      
                    
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                           <?php if (session()->get('user_type') === 'admin'){ ?>
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= esc($user_type) ?></span>
                                       <!-- <i class="fas fa-user-circle fa-2x text-gray-300"></i> -->
                                    <img class="img-profile rounded-circle"
                                        src="<?= base_url(); ?>assets/jobportal/images/home/admin.png">
                                </a>
                            <?php }elseif(session()->get('user_type') === 'Hr'){ ?>

                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= esc($user_type) ?></span>
                                       <!-- <i class="fas fa-user-circle fa-2x text-gray-300"></i> -->
                                    <img class="img-profile rounded-circle"
                                        src="<?= base_url(); ?>assets/jobportal/images/home/hr_new.png">
                                </a>

                            <?php }else{ ?>

                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= esc($user_type) ?></span>
                                       <!-- <i class="fas fa-user-circle fa-2x text-gray-300"></i> -->
                                    <img class="img-profile rounded-circle"
                                        src="<?= base_url(); ?>assets/jobportal/images/traning/training_logo.jpg" style="height: 2rem !important; width: 2rem !important;">
                                </a>
                            <?php
                            } ?>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('admin/logout'); ?>" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>