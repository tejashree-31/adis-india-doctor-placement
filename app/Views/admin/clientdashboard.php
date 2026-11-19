<?php
use Config\Database;
$db = Database::connect();
$recruiter_count = $db->table('tbl_user'); 
$recu_count = $recruiter_count->where('user_type','recruiter')->countAllResults(); 

$recruiter_registered_count = $db->table('tbl_recruiter')
                                 ->countAllResults();
$postingTable = $db->table('tbl_recruiter_posting');
$open_count = $postingTable->where('admin_status', 'Open')->where('status', 'Publish')->countAllResults(false);
   $postingTable = $db->table('tbl_recruiter_posting');
// Count Closed
$closed_count = $postingTable->where('admin_status', 'Closed')->countAllResults(); 

$tbl_candidate_job_status = $db->table('tbl_candidate_job_status');
$closed_vacuncies = $tbl_candidate_job_status->where('admin_candidate_status', 'Closed')->countAllResults(); 

//daily signup client 
$today = date('Y-m-d');
// echo $today;
$daily_count = $db->table('tbl_user'); 
$daily_recu_count = $daily_count
    ->where('user_type', 'recruiter')
    ->where('registered_date', $today)  // only today's registrations
    ->countAllResults();
    
    // ==========================07-11-2025 ===================//
    $months = [];
    $signup_count = [];
    $registered_count = [];
    $monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
 // ✅ Current date
$currentMonth = date('n'); // 1 to 12
$currentYear  = date('Y');

// ✅ Decide financial year start
if ($currentMonth >= 4) {
    // April onwards
    $startYear = $currentYear;
} else {
    // Jan to March
    $startYear = $currentYear - 1;
}

// ✅ Start from April
$start = new DateTime($startYear . '-04-01');

for ($i = 0; $i < 12; $i++) {
    $month = $start->format('m');
    $year  = $start->format('Y');

    $months[] = $monthNames[(int)$month - 1] . ' ' . substr($year, 2);

    $signup_count[] = $db->table('tbl_user')
        ->where('user_type', 'recruiter')
        ->where('MONTH(registered_date)', $month)
        ->where('YEAR(registered_date)', $year)
        ->countAllResults();

    $registered_count[] = $db->table('tbl_recruiter')
        ->where('MONTH(created_date)', $month)
        ->where('YEAR(created_date)', $year)
        ->countAllResults();

    $daily_signup_count[] = $db->table('tbl_user')
        ->where('user_type','recruiter')
        ->where('MONTH(registered_date)', $month)
        ->where('YEAR(registered_date)', $year)
        ->countAllResults();

    $start->modify('+1 month');
}
    
    // ============= Total free client ==================
    $free_client_count = $db->table('tbl_recruiter'); 
    $total_free_count = $free_client_count
        ->where('client_reg_type','free')
        ->countAllResults();
    // ============= Total paid client ==================
    $paid_client_count = $db->table('tbl_recruiter'); 
    $total_paid_count = $paid_client_count
        ->where('client_reg_type','paid')
        ->countAllResults();
?>     

<!---================07-11-2025 =============================-->
<style type="text/css">
    #splineChart {
    width: 550px !important;
    height: 350px !important;
    margin: auto;
}

#pieChart {
    width: 300px !important;
    height: 300px !important;
    margin: auto;
    margin-top: 56px;
}
#pieChart + div ul {
    display: flex !important;
    justify-content: center;
    flex-wrap: nowrap !important;
    gap: 20px;
    list-style: none;
    padding: 0;
    margin-top: 15px;
}

/* ✅ Legend clickable cursor */
.chartjs-legend li {
    cursor: pointer !important;
}
</style>

                <!-- End of Topbar -->
                <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
                <!-- Chart.js -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
                <!-- Data Labels Plugin -->
                <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                         <h4 class=" mb-2 text-gray-800">Client Dashboard</h4>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="<?= base_url('admin/admin_signup_recruiter') ?>"> 
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Signup Client</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $recu_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                               <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                         
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <a href="<?= base_url('admin/client_details') ?>"> 
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">registered Clients
                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <!-- <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div> -->
                                                    </div>
                                                    <div class="col">
                                                         <?php //$total_count = $open_count + $closed_count; ?>
                                                             <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($recruiter_registered_count) ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <a href="<?= base_url('admin/daily-count') ?>"> 
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Daily Signup Client</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($daily_recu_count) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                               
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                     Paid Client</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_paid_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                               
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        

                      
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <a href="<?= base_url('admin/all-post-vacancies') ?>">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                  Open vacancies</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $open_count; ?></div>
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
                            <div class="card border-left-primary shadow h-100 py-2">
                                <a href="<?= base_url('admin/all-closed-client-details') ?>">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Closed Clients</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $closed_count; ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <a href="<?= base_url('admin/closed-vacuncies-details') ?>">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Closed vacancies
                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <!-- <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div> -->
                                                    </div>
                                                    <div class="col">
                                                         <!-- <?php $total_count = $open_count + $closed_count; ?> -->
                                                             <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $closed_vacuncies; ?></div>
                                                    </div>
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
                                
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Free Client</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($total_free_count) ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- Content Row -->
                <!-- </div> -->
                <!-- /.container-fluid -->
            <!--</div>-->
            
                   <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div style="text-align:center;">
                               <canvas id="pieChart" ></canvas>
                                <div class="chart-legend" id="legendBox"></div>
                            </div>

                            <!-- Required JS Libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
$(document).ready(function () {
    Chart.register(ChartDataLabels);

    const labels = ["Open Vacancies", "Closed Client", "Closed Vacancies", "Daily Client"];
    const values = [<?= $open_count; ?>, <?= $closed_count; ?>, <?= $closed_vacuncies; ?>, <?= $daily_recu_count; ?>];
    const colors = ["#2196F3", "#FF6384", "#FFAB40", "#00C853"];

    const ctx = document.getElementById('pieChart').getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colors,
                borderWidth: 1,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        color: '#333',
                        font: { size: 14 },
                        boxWidth: 20,
                        padding: 15
                    }
                },
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: (value) => {
                        return value; // display actual value instead of percentage
                    }
                }
            },
            layout: {
                padding: { bottom: 30 }
            }
        },
        plugins: [ChartDataLabels]
    });
});
</script>

                        </div>
                        <div class="col-xl-6 col-md-6 mb-4"> 
                            <div style="text-align:center;">
                                <canvas id="splineChart"></canvas>
                            </div>

                            <div style="text-align:center; margin-top:10px;">
                                <button class="dataset-btn" style="color: #fff; background: #50BF6B; border: #50BF6B;">Signup</button>
                                <button class="dataset-btn" style="color: #fff; background: #F59251; border:#F59251">Registered</button>
                                <!-- <button class="dataset-btn" style="color: #fff; background: #E37568; border:#E37568">Daily Signup</button> -->
                            </div>

                              <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        
                                        // --- Pass PHP arrays to JS ---
                                        const months = <?php echo json_encode($months); ?>;
                                        const signup = <?php echo json_encode($signup_count); ?>;
                                        const registered = <?php echo json_encode($registered_count); ?>;

                                        let ctx = document.getElementById("splineChart").getContext("2d");

                                        // Gradient fills
                                        const gradientSignup = ctx.createLinearGradient(0, 0, 0, 350);
                                        gradientSignup.addColorStop(0, "rgba(0,200,83,0.5)");
                                        gradientSignup.addColorStop(1, "rgba(0,200,83,0)");

                                        const gradientRegistered = ctx.createLinearGradient(0, 0, 0, 350);
                                        gradientRegistered.addColorStop(0, "rgba(255,193,7,0.5)");
                                        gradientRegistered.addColorStop(1, "rgba(255,193,7,0)");

                                        const chart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: months,
                                                datasets: [
                                                    {
                                                        label: "Signup",
                                                        data: signup,
                                                        borderColor: "#00C853",
                                                        backgroundColor: gradientSignup,
                                                        borderWidth: 2,
                                                        tension: 0.4,
                                                        fill: true,
                                                        pointRadius: 3,
                                                        pointHoverRadius: 20,
                                                        hitRadius: 20
                                                    },
                                                    {
                                                        label: "Registered",
                                                        data: registered,
                                                        borderColor: "#FFC107",
                                                        backgroundColor: gradientRegistered,
                                                        borderWidth: 2,
                                                        tension: 0.4,
                                                        fill: true,
                                                        pointRadius: 3,
                                                        pointHoverRadius: 20,
                                                        hitRadius: 20
                                                    }
                                                ]
                                            },
                                            options: {
                                                responsive: false,
                                                animation: { duration: 1500, easing: 'easeOutQuart' },
                                                plugins: {
                                                    legend: {
                                                        position: 'bottom',
                                                        onClick: function(e, legendItem, legend) {
                                                            const dsIndex = legendItem.datasetIndex;
                                                            chart.data.datasets.forEach((d,i) => d.hidden = i!==dsIndex);
                                                            chart.update({duration:800, easing:'easeOutCubic'});
                                                        }
                                                    },
                                                    datalabels: { display: false }
                                                },
                                                elements: { point: { radius: 3, hoverRadius: 20, hitRadius: 20 } },
                                                scales: { y: { beginAtZero: true
                                                 } },
                                                 layout:{
                                                    padding:{ top:40 }
                                                 }
                                            },
                                            plugins: [ChartDataLabels]
                                        });

                                        // Show value on click
                                        document.getElementById('splineChart').onclick = function(evt) {
                                            const points = chart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
                                            if(points.length) {
                                                const firstPoint = points[0];
                                                const dataset = chart.data.datasets[firstPoint.datasetIndex];
                                                const value = dataset.data[firstPoint.index];

                                                chart.data.datasets.forEach(ds => ds.datalabels = { display:false });

                                                dataset.datalabels = {
                                                    display: true,
                                                    align: 'top',
                                                    anchor: 'end',
                                                    font: { weight: 'bold', size:14 },
                                                    formatter: value => value
                                                };
                                                chart.update();
                                            }
                                        };

                                        // Buttons to show single dataset
                                        document.querySelectorAll('.dataset-btn').forEach((btn, idx) => {
                                            btn.addEventListener('click', function () {
                                                chart.data.datasets.forEach((d, i) => d.hidden = i !== idx);
                                                chart.update({duration:800, easing:'easeOutCubic'});
                                            });
                                        });

                                    });
                            </script>
                        </div>
                    </div>
                </div>
            <!-- End of Main Content -->

            