<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>admin_assests/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet" />

    <!-- Custom styles-->
    <link href="<?= base_url(); ?>admin_assests/assets/css/sb-admin-2.min.css" rel="stylesheet" />

    <style>
        .bg-gradient-primary {
            background-image: url('<?= base_url(); ?>assets/jobportal/images/6.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Ensure the image fits well in all screen sizes */
        .login-image-wrapper img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Optional: Reduce padding for small screens */
        @media (max-width: 575.98px) {
            .p-5 {
                padding: 2rem !important;
            }

            .login-image-wrapper {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- Login Image -->
                            <div class="col-lg-6 login-image-wrapper">
                                <img src="<?= base_url(); ?>assets/jobportal/images/gifimage.gif" alt="Login Image" />
                            </div>

                            <!-- Login Form -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900">Welcome Back!</h1>
                                        <?php if(session()->getFlashdata('error')): ?>
                                                <div style="color: red; font-weight: bold;">
                                                    <?= session()->getFlashdata('error'); ?>
                                                </div>
                                            <?php endif; ?>
                                    </div>

                                    <form class="user" method="post" action="<?= base_url('loginformadmin') ?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="name" placeholder="Enter Name..." required />
                                        </div>
                                       <!--<div class="form-group">-->
                                       <!--     <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required />-->
                                       <!-- </div>-->
                                       
                                        <div class="form-group position-relative">
    
                                            <input type="password" class="form-control form-control-user pe-5"
                                                name="password" id="password" placeholder="Password" required
                                            />

                                            <!-- Eye Button -->
                                            <span 
                                                toggle="#password" class="fa fa-eye field-icon toggle-password"
                                                style=" position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer; color:#777; ">
                                            </span>
                                        </div>
                                     
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login" />
                                    </form>

                                    
                                    <div class="text-center">
                                        <a class="small" href="#">Forgot Password?</a>
                                    </div>
                                </div>
                            </div> <!-- End Login Form -->
                        </div> <!-- End Row -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Files -->
    <script src="<?= base_url(); ?>admin_assests/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>admin_assests/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>admin_assests/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url(); ?>admin_assests/assets/js/sb-admin-2.min.js"></script>
    <script>
    $(document).on('click', '.toggle-password', function () {

        $(this).toggleClass("fa-eye fa-eye-slash");

        let input = $($(this).attr("toggle"));

        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }

    });
</script>
</body>

</html>
