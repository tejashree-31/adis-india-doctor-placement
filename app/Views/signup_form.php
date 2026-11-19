
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<style type="text/css">
	label {
    font-weight: 600;
    color: #666;
}
body {
  background: #f1f1f1;
}
.box8{
  box-shadow: 0px 0px 5px 1px #999;
}
.mx-t3{
  margin-top: -3rem;
}
</style>

    <title>Signup</title>
</head>
<body>
    <!-- <h2>Signup Form</h2> -->
    <?php if (session()->getFlashdata('success')) : ?>
        <p style="color: green;"><?php echo session()->getFlashdata('success'); ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <p style="color: red;"><?php echo session()->getFlashdata('error'); ?></p>
    <?php endif; ?>
    <div class="container mt-3">
  <form action="<?php echo base_url('home/save_signup'); ?>" method="post">
    <div class="row jumbotron box8">
      <div class="col-sm-12 mx-t3 mb-4">
        <h2 class="text-center text-info">Register</h2>
      </div>
      <div class="col-sm-6 form-group">
        <label for="name-f">Sponsor ID (Optional):</label>
        <input class="form-control" type="number"  name="sponsor_id" id="name-f sponsor_id" placeholder="Enter your first name." >
      </div>
      <div class="col-sm-6 form-group">
        <label for="name-l">Name </label>
        <input type="text" class="form-control" name="name" id="name-l name" placeholder="Enter your Name." >
      </div>
      <div class="col-sm-6 form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email." >
      </div>
      <div class="col-sm-6 form-group">
        <label for="address-1">Password</label>
        <input type="password" class="form-control" name="password" id="address-1 password" placeholder="password." >
      </div>
      <div class="col-sm-6 form-group mb-0">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
  	</div>
  	
  </form>
</div>

    <!-- <form action="<?php echo base_url('signup/register'); ?>" method="post">
        <label for="sponsor_id">Sponsor ID (Optional):</label>
        <input type="number" name="sponsor_id" id="sponsor_id">

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Register</button>
    </form> -->
</body>
</html>

