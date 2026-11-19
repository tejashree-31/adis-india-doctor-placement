
<style>
    .block_title
    {
        font-size: 14px;
    }
    #barChart {
        width: 100% !important;
        min-height: 350px !important;
    }
    /*.chart-canvas {
        width: 50% !important;
        max-width: 300px !important;
        height: auto !important;
    }*/
    .chart-canvas {
        width: 360px !important;
        height: 360px !important;
        max-width: 100% !important;
        display: block;
        margin-left:10%;   /* RIGHT SIDE ला push करतो */
    /*    font-size: 10px;*/
    }
</style>
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Billing Dashboard</h1>
                <!-- <a href="<?//= base_url('admin/view_recruiter_posting')?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
            </div>
            <form method="get" class="mb-3">
        <div class="row align-items-end">
        
            <div class="col-md-3">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control"
                    value="<?= $_GET['start_date'] ?? '' ?>">
            </div>

            <div class="col-md-3">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control"
                    value="<?= $_GET['end_date'] ?? '' ?>">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>

            <div class="col-md-2">
                <a href="<?= base_url('admin/billing_dashboard') ?>" class="btn btn-secondary w-100">Reset</a>
            </div>

        </div>
    </form>
            <div class="row">
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="<?= base_url('admin/billing_admin_closed_vacuncy')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Invoice Genration   </div>
                                        <div class="h5 mb-0 font-weight-bold text-brown-800"> <?= $CountPostVaciesdisplay ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-envelope fa-2x text-primary" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <a href="<?= base_url('admin/billing-sent-invoice')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1 ">
                                            Invoice Status</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $CountInvoiceclosedPostvaciesdisply?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-envelope fa-2x text-success" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="<?= base_url('admin/recived_payment_status')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                           Received Payment</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$CountRecivePaymenteClientdisply ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-check-circle fa-2x text-primary" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <a href="<?= base_url('admin/pending_client_payment')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                          Pending Payment</div>
                                         <div class="h5 mb-0 font-weight-bold text-gray-800"
                                         ><?= $CountPendingPaymenteClientdisply ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-hourglass-half fa-2x text-success" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
        
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="<?= base_url('admin/paid_payment_client')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                           Paid Client</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $CountPaidClientDisplay ?></div>
                                    </div>
                                    <div class="col-auto">
                                     <i class="fa fa-rupee-sign fa-2x text-primary" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <a href="<?= base_url('admin/free_payment_client')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                          Free Client</div>
                                         <div class="h5 mb-0 font-weight-bold text-gray-800"
                                         ><?= $CountFreeClientDisplay ?></div>
                                    </div>
                                    <div class="col-auto">
                                       <i class="fa fa-star fa-2x text-success" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
        
        
            </div>
            <div class="row">
                <!-- <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="<?= base_url('admin/paid_payment_client')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 block_title">
                                           Paid Client</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $CountPaidClientDisplay ?></div>
                                    </div>
                                    <div class="col-auto">
                                     <i class="fa fa-rupee-sign fa-2x text-primary" style="font-size: 23px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
         -->
                <!-- <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <a href="<?= base_url('admin/free_payment_client')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1 block_title">
                                          Free Client</div>
                                         <div class="h5 mb-0 font-weight-bold text-gray-800"
                                         ><?= $CountFreeClientDisplay ?></div>
                                    </div>
                                    <div class="col-auto">
                                       <i class="fa fa-star fa-2x text-success" style="font-size: 23px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div> -->
        
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="<?= base_url('admin/advance_payment_client')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                           Advance Payment Amt.</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($totalAdvance, 2); ?><?//= $getAdvancedClientCount ?></div>
                                    </div>
                                    <div class="col-auto">
                                  <i class="fa fa-coins fa-2x  text-primary" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                 <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                       
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                         Register Amt.</div>
                                         <div class="h6 mb-0 font-weight-bold text-gray-800"
                                         ><?= number_format($totalAmount, 2) ?></div>
                                    </div>
                                    <div class="col-auto">
                                       <i class="fa fa-star fa-2x text-success" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                           Total Recived Amt. </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800"><?= number_format($totalReceived, 2); ?></div>
                                    </div>
                                    <div class="col-auto">
                                  <i class="fa fa-coins fa-2x  text-primary" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                       
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                         Total Pending Amt.</div>
                                         <div class="h6 mb-0 font-weight-bold text-gray-800"
                                         ><?= $totalPendingFormatted ?></div>
                                    </div>
                                    <div class="col-auto">
                                       <i class="fa fa-hourglass-half fa-2x text-success" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <!-- <a href="<?= base_url('admin/total_years_count_billing')?>" class="custom-link"> -->
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                           Total Bill Amt. </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $totalBillPaymentClientFormatted ?></div>
                                    </div>
                                    <div class="col-auto">
                                  <i class="fas fa-calendar-alt fa-2x  text-primary" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        <!-- </a> -->
                        
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="<?= base_url('admin/total_years_count_billing')?>" class="custom-link">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                           Total Year Revenue </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800"><?//= number_format($totalReceived, 2); ?></div>
                                    </div>
                                    <div class="col-auto">
                                  <i class="fas fa-calendar-alt fa-2x  text-primary" style="font-size: 15px;margin-bottom: 30px;"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
             <!-- <div class="row"> -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
             <!-- <h4 class="h3 mb-0 text-gray-800">Billing Dashboard</h4> -->
                <h5 class="text-gray-800"><b>Total Income</b> : <b><?= $total_income ?></b></h5>
            <!-- </div>  -->
            </div>
        </div>
        
        <div class="container-fluid">
            <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> -->
            <!-- <h1 class="h3 mb-0 text-gray-800">Graphs</h1> -->
            <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <canvas id="barChart"></canvas>

            </div>
            <div class="col-xl-6 col-md-6 mb-4" style="">
                <canvas id="donutChart" class="chart-canvas"></canvas>
            </div>
            
        </div>
            <!-- </div>  -->
        </div>
             

            </div>
            <!-- End of Main Content -->
            
            
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
            <script>
    var months = <?= json_encode($months); ?>;
    var total_bill_amount = <?= json_encode($total_bill_amount); ?>;
    var total_received_amount = <?= json_encode($total_received_amount); ?>;

    var ctx = document.getElementById('barChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: "Total Bill Amount",
                    data: total_bill_amount,
                    backgroundColor: "#BD7E95",
                },
                {
                    label: "Total Received Amount",
                    data: total_received_amount,
                    backgroundColor: "#911F48",
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
            <script>
    var labels = <?= json_encode($donutLabels); ?>;
    var values = <?= json_encode($donutValues); ?>;

    var ctx = document.getElementById('donutChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    "#4FE868",  // Advance
                    "#26A69A",  // Registration
                    "#FF7043",  // Pending
                    "#FFC107"   // Discount (NEW)
                ],
                borderWidth: 1
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { padding: 20, boxWidth: 20 }
                },
                datalabels: {
                    color: "#000",
                    formatter: (value) => value.toLocaleString(),
                    font: { weight: "bold" }
                }
            },
            cutout: "60%"  // donut thickness
        }
    });
</script>

            