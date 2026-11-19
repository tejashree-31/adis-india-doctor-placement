<?php
use Config\Database;
$db = Database::connect();
$jobseeker_count = $db->table('tbl_user'); 
$job_count = $jobseeker_count->where('user_type','jobseekar')->countAllResults(); 

$registred_jobseeker_candidate = $db->table('tbl_jobseeker')->countAllResults();


$interview_count = $db->table('tbl_candidate_job_status'); 
$interview_schedule_count = $interview_count->where('admin_candidate_status','Interview Schedule')->countAllResults();

$hold_count = $db->table('tbl_candidate_job_status'); 
$interview_hold_count = $hold_count->where('admin_candidate_status','Hold')->countAllResults(); 
$closed_count = $db->table('tbl_candidate_job_status'); 
$interview_closed_count = $closed_count->where('admin_candidate_status','Closed')->countAllResults(); 
$rejected_count = $db->table('tbl_candidate_job_status'); 
$interview_rejected_count = $rejected_count->where('admin_candidate_status','Rejected')->countAllResults(); 

$apply_count = $db->table('tbl_candidate_job_status');
$applied_candidate = $apply_count->where('admin_candidate_status','Open')->countAllResults(); 
//echo $applied_candidate;

$today = date('Y-m-d');
// echo $today;
$daily_count = $db->table('tbl_user'); 
$daily_candidate_count = $daily_count
    ->where('user_type', 'jobseekar')
    ->where('registered_date', $today)  // only today's registrations
    ->countAllResults();
    // =========== graph 10-11-2025 ===========
    
       $months = [];
$applied_count = [];
$interviewschedule_count = [];
$nohold_count = [];
$closed_candidate_count = [];
$rejected_candidate_count = [];
$signup_count_graph = [];  // ✅ FIXED
$jobseeker_reg_count = []; // ✅ FIXED

$monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
// $start = new DateTime('2025-04-01');
$currentMonth = date('m');
$currentYear  = date('Y');

// ✅ Current Financial Year (NOT next)
if ($currentMonth >= 4) {
    $startYear = $currentYear;       // Apr–Dec → same year
} else {
    $startYear = $currentYear - 1;   // Jan–Mar → previous year
}

$start = new DateTime($startYear . '-04-01');

// ✅ First graph loop
for ($i = 0; $i < 12; $i++) {
    $month = $start->format('m');
    $year = $start->format('Y');

    $months[] = $monthNames[(int)$month - 1] . ' ' . substr($year, 2);

    $applied_count[] = $db->table('tbl_candidate_job_status')
        ->where('admin_candidate_status', 'Open')
        ->where('MONTH(applied_at)', $month)
        ->where('YEAR(applied_at)', $year)
        ->countAllResults();

    $interviewschedule_count[] = $db->table('tbl_candidate_job_status')
        ->where('admin_candidate_status', 'Interview Schedule')
        ->where('MONTH(applied_at)', $month)
        ->where('YEAR(applied_at)', $year)
        ->countAllResults();

    $nohold_count[] = $db->table('tbl_candidate_job_status')
        ->where('admin_candidate_status', 'Hold')
        ->where('MONTH(applied_at)', $month)
        ->where('YEAR(applied_at)', $year)
        ->countAllResults();

    $closed_candidate_count[] = $db->table('tbl_candidate_job_status')
        ->where('admin_candidate_status','Closed')
        ->where('MONTH(joining_date)', $month)
        ->where('YEAR(joining_date)', $year)
        ->countAllResults();

    $rejected_candidate_count[] = $db->table('tbl_candidate_job_status')
        ->where('admin_candidate_status','Rejected')
        ->where('MONTH(applied_at)', $month)
        ->where('YEAR(applied_at)', $year)
        ->countAllResults();

    $start->modify('+1 month');
}

// ✅ Reset start again for signup bar chart
$currentMonth = date('m');
$currentYear  = date('Y');

// ✅ Financial Year fix
if ($currentMonth >= 4) {
    $startYear = $currentYear;       // Apr–Dec
} else {
    $startYear = $currentYear - 1;   // Jan–Mar
}

// ✅ Start from April
$start = new DateTime($startYear . '-04-01');

// ✅ Bar chart loop
for ($i = 0; $i < 12; $i++) {
    $month = $start->format('m');
    $year  = $start->format('Y');

    $signup_count_graph[] = $db->table('tbl_user')
        ->where('user_type','jobseekar')
        ->where('MONTH(registered_date)', $month)
        ->where('YEAR(registered_date)', $year)
        ->countAllResults();

    $jobseeker_reg_count[] = $db->table('tbl_jobseeker')
        ->where('MONTH(created_date)', $month)
        ->where('YEAR(created_date)', $year)
        ->countAllResults();

    $start->modify('+1 month');
}
    
 ?>
      <style type="text/css">
                     #splineChart {
                width: 550px !important;
                height: 350px !important;
                margin: auto;
            }
            #barChart
            {
                  width: 550px !important;
                height: 362px !important;
                margin: auto;
            }

            /* ✅ Legend clickable cursor */
            .chartjs-legend li {
                cursor: pointer !important;
            }

         
            .dataset-btn {
          
                border-radius: 6px;
                border: none;
                font-size: 12px;
                margin: 2px;
                cursor: pointer;
                white-space: nowrap;
                color: #fff;
                font-weight: 600;
                transition: 0.2s;
            }

            .dataset-btn:hover {
                opacity: 0.8;
                transform: scale(1.04);
            }

            .legend-buttons {
                display: flex;
       
                align-items: center;
                flex-wrap: nowrap;
          
                margin-top: 15px;
                    margin-left: 34px;
            }
 </style>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

            <script>
                Chart.register(ChartDataLabels);
            </script>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Candidate Dashboard</h1>
                        <a href="<?= base_url('admin/view_recruiter_posting')?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="<?= base_url('admin/signup_admin_candidate')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Signup Candidate</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $job_count; ?></div>
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
                                <a href="<?= base_url('admin/registration_admin_candidate')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    registered Candidate</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $registred_jobseeker_candidate; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="<?= base_url('admin/daily_admin_candidate')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Daily Candidate</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $daily_candidate_count; ?></div>
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
                                <a href="<?= base_url('admin/apply_candidate_admin')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                  Applied Candidate</div>
                                                 <div class="h5 mb-0 font-weight-bold text-gray-800"
                                                 ><?php echo $applied_candidate; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                       

                        
                       
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <a href="<?= base_url('admin/interview_schedule_candidate')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Interview Shedule
                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $interview_schedule_count; ?></div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <a href="<?= base_url('admin/hold_candidate')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                   No of Hold</div>
                                                 <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $interview_hold_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <a href="<?= base_url('admin/candidateClosedDetailsData')?>">
                                    <div class="card-body">
                                         <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                   Closed Candidate</div>
                                                 <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $interview_closed_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="<?= base_url('admin/reject_candidate')?>" class="custom-link">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Rejectd Candidate</div>
                                                 <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $interview_rejected_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                </div>
                
                
                 <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div style="">
                                <canvas id="splineChart"></canvas>
                            </div>

                            <div class="legend-buttons">
                                <button class="dataset-btn" data-index="0" style="background:#00C853;">Applied</button>
                                <button class="dataset-btn" data-index="1" style="background:#FFC107;">Interview</button>
                                <button class="dataset-btn" data-index="2" style="background:#17A2B8;">Hold</button>
                                <button class="dataset-btn" data-index="3" style="background:#6F42C1;">Closed</button>
                                <button class="dataset-btn" data-index="4" style="background:#DC3545;">Rejected</button>
                                <!-- <button class="dataset-btn" data-index="5" style="background:#FF9800;">Daily</button> -->
                            </div>

                            <script>
                                document.addEventListener("DOMContentLoaded", function () {

                                // ✅ PHP data for candidate side
                                const months = <?php echo json_encode($months); ?>;
                                const Applied = <?php echo json_encode($applied_count); ?>;
                                const interview = <?php echo json_encode($interviewschedule_count); ?>;
                                const hold = <?php echo json_encode($nohold_count); ?>;
                                const closed = <?php echo json_encode($closed_candidate_count); ?>;
                                const rejected = <?php echo json_encode($rejected_candidate_count); ?>;
                              

                                let ctx = document.getElementById("splineChart").getContext("2d");

                                // ✅ Same gradient look
                                const createGradient = (color) => {
                                    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
                                    gradient.addColorStop(0, color);
                                    gradient.addColorStop(1, color.replace("0.5", "0"));
                                    return gradient;
                                };

                                const chart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: months,
                                        datasets: [
                                            { label: "Applied", data: Applied, borderColor:"#00C853", backgroundColor:createGradient("rgba(0,200,83,0.5)"), borderWidth:2, tension:0.4, fill:true, pointRadius:3 },
                                            { label: "Interview", data: interview, borderColor:"#FFC107", backgroundColor:createGradient("rgba(255,193,7,0.5)"), borderWidth:2, tension:0.4, fill:true, pointRadius:3 },
                                            { label: "Hold", data: hold, borderColor:"#17A2B8", backgroundColor:createGradient("rgba(23,162,184,0.5)"), borderWidth:2, tension:0.4, fill:true, pointRadius:3 },
                                            { label: "Closed", data: closed, borderColor:"#6F42C1", backgroundColor:createGradient("rgba(111,66,193,0.5)"), borderWidth:2, tension:0.4, fill:true, pointRadius:3 },
                                            { label: "Rejected", data: rejected, borderColor:"#DC3545", backgroundColor:createGradient("rgba(220,53,69,0.5)"), borderWidth:2, tension:0.4, fill:true, pointRadius:3 }
                                            // { label: "Daily Signup", data: daily, borderColor:"#FF9800", backgroundColor:createGradient("rgba(255,152,0,0.5)"), borderWidth:2, tension:0.4, fill:true, pointRadius:3 }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        animation: { duration: 1500, easing: 'easeOutQuart' },

                                elements: {
                                    point: {
                                        radius: 4,
                                        hoverRadius: 10,
                                        hitRadius: 20,
                                        borderWidth: 2
                                    }
                                },
                                        plugins: {
                                            legend: {
                                                position: 'bottom',
                                                onClick: function(e, legendItem) {
                                                    const dsIndex = legendItem.datasetIndex;
                                                    chart.data.datasets.forEach((d,i) => d.hidden = i!==dsIndex);
                                                    chart.update({duration:800});
                                                }
                                            },
                                            datalabels: { display: false }
                                        },
                                        scales: { y: { beginAtZero: true } },
                                         layout:{
                                                                                padding:{ top:40 }
                                                                             }
                                    },
                                    plugins: [ChartDataLabels]
                                });

                                // ✅ Click value visible
                                document.getElementById('splineChart').onclick = function(evt) {
                                    const points = chart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
                                    if(points.length) {
                                        const first = points[0];
                                        const ds = chart.data.datasets[first.datasetIndex];
                                        chart.data.datasets.forEach(d => d.datalabels = { display:false });
                                        ds.datalabels = { display:true, align:'top', anchor:'end', font:{weight:'bold',size:14} };
                                        chart.update();
                                    }
                                };

                                // ✅ Buttons toggle dataset display
                                document.querySelectorAll('.dataset-btn').forEach((btn, idx) => {
                                    btn.addEventListener('click', function () {
                                        chart.data.datasets.forEach((d, i) => d.hidden = i !== idx);
                                        chart.update();
                                    });
                                });

                            });
                            </script>
                        </div>
                        <div class="col-md-6 mb-4">
                            <canvas id="barChart"></canvas>

                            <script>
                                                var months = <?= json_encode($months); ?>;
                                             var signup_count = <?= json_encode($signup_count_graph); ?>;
                                            var registered_count = <?= json_encode($jobseeker_reg_count); ?>;


                                                var ctx = document.getElementById('barChart').getContext('2d');

                                                new Chart(ctx, {
                                                    type: 'bar',
                                                    data: {
                                                        labels: months,
                                                        datasets: [
                                                            {
                                                                label: "Signup Count",
                                                                data: signup_count,
                                                                backgroundColor: "#3F51B5",
                                                                borderWidth: 1,
                                                               barPercentage: 0.8,       // ✅ thoda chota
                                                        categoryPercentage: 0.12, // ✅ space increase
                                                        barThickness: 15,         // ✅ nice thickness + spacing
                                                            },
                                                            {
                                                                label: "Registered Count",
                                                                data: registered_count,
                                                                backgroundColor: "#26A69A",
                                                                borderWidth: 1,
                                                                barPercentage: 0.8,       // ✅ thoda chota
                                                            categoryPercentage: 0.12, // ✅ space increase
                                                            barThickness: 15,         // ✅ nice thickness + spacing
                                                                // borderRadius: 6
                                                            }
                                                        ]
                                                    },
                                                    options: {
                                                         // responsive: true,
                                                         //    maintainAspectRatio: false,
                                                        responsive: true,
                                                        plugins: {
                                                     legend: {
                                                    position: 'bottom',  // ✅ Legend below chart
                                                     labels: {
                                                        boxWidth: 20,
                                                        padding: 20  // ✅ label text + chart मधे gap
                                                    }
                                                },
                                                            tooltip: {
                                                                enabled: true
                                                            },
                                                            datalabels: {
                                                                anchor: 'end',
                                                                align: 'top',
                                                                font: {
                                                                    weight: 'bold'
                                                                }
                                                            }
                                                        },
                                                  scales: {
                                                    x: {
                                                        ticks: {
                                                            autoSkip: false,  // ✅ every month wajib disel
                                                            maxRotation: 0,  // ✅ serial neat angle
                                                            minRotation: 0
                                                        }
                                                    },
                                                    y: {
                                                        beginAtZero: true,
                                                        ticks: {
                                                            precision: 0
                                                        }
                                                    }
                                                },
                                                        layout:{
                                                                                padding:{ top:30 }
                                                                             }
                                                    }
                                                });
                                        </script>

                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            