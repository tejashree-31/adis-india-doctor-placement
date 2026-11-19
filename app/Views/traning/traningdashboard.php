<style type="text/css">
 .card {
    transition: all 0.4s ease-in-out;
    border-radius: 16px;
    overflow: hidden;
    position: relative;

    /* Glass Effect */
    background: rgba(255, 255, 255, 0.25) !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Hover Animation */
.card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 25px 45px rgba(0,0,0,0.2);
}

/* Light Reflection Animation */
.card::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 60%;
    height: 100%;
    background: linear-gradient(
        120deg,
        rgba(255,255,255,0.4),
        rgba(255,255,255,0.1)
    );
    transform: skewX(-20deg);
    transition: 0.6s;
}

.card:hover::before {
    left: 120%;
}

/* Left Border Glow Effect */
.card.border-left-primary:hover {
    border-left: 5px solid #4e73df !important;
    box-shadow: 0 25px 45px rgba(78, 115, 223, 0.35);
}

.card.border-left-success:hover {
    border-left: 5px solid #1cc88a !important;
    box-shadow: 0 25px 45px rgba(28, 200, 138, 0.35);
}

/* Icon Animation */
.card:hover .fa-2x {
    transform: scale(1.2) rotate(5deg);
    transition: 0.4s ease;
    color: #4e73df !important;
}

/* Smooth Link Effect */
.custom-link {
    text-decoration: none !important;
    color: inherit;
    display: block;
}
</style>



                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Training Records Dashboard</h1>
                        <!-- <a href="<?//= base_url('admin/view_recruiter_posting')?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="<?= base_url('traning/traning_daily_records')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Daily Recods</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //echo $job_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <a href="<?= base_url('traning/traning_total_records')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                   Total Records</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php //echo $registred_jobseeker_candidate; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                      
                       

                        
                       
                    </div>
                  

                    <!-- Content Row -->

                 

                </div>
             

            </div>
            <!-- End of Main Content -->

            