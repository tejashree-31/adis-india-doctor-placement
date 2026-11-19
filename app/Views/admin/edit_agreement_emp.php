<?php 
use Config\Database;
$db = Database::connect();
$builder = $db->table('tbl_agreement');
$Professional_Fees = $builder->select('*')->where('agreement_id','1')->get()->getRow();
 $Professionals=  $Professional_Fees->agreement_description;
 $replacement= $Professional_Fees->replecement_month;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Post Vacuncy</title>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<style>
    .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 35px !important;
    user-select: none;
    -webkit-user-select: none;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 35px !important;
}  
.has-value {
    background-color: #d9fdd3 !important; /* faint green */
} 
</style>
</head>
<body>
<div class="container mt-5">
    <!-- <h1 class="mb-4">Edit Empolyee</h1> -->
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
    <?php endif; ?>
   
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Client Agreement &nbsp;<a href="<?= base_url('admin/client-agreement-details') ?>" class="btn btn-light">
    <i class="fa fa-arrow-left"></i>
</a></h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('update-agreement-form') ?>" method="post" id="blogForm" enctype="multipart/form-data">
               <input type="hidden" name="uid" value="<?= isset($single_emp_edit['uid']) ? esc($single_emp_edit['uid']) : ''; ?>">
                
               <div class="row g-3">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="email_id" class="form-label">Professional Fees</label>
                      <!-- <textarea name="job_description" class="form-control" id="job_description"><?= isset($single_posting_edit['job_description']) ? esc(trim($single_posting_edit['job_description'])) : 'Job description...'; ?></textarea> -->
                            <?php
                            $recruiterDesc = trim($single_emp_edit['agreement_description'] ?? '');
                            $value = ($recruiterDesc === '') ? $Professionals : $recruiterDesc;

                            // If value exists → highlight green
                            $cssClass = ($recruiterDesc !== '') ? 'has-value' : '';
                            ?>

						<textarea name="agreement_description" 
                                  id="editor" 
                                  class="<?= $cssClass ?>" 
                                  style="height: 400px!important;">
                            <?= $value ?>
                        </textarea>
                    </div>
                  </div>
                </div>
                <div class="row g-3">
                	<div class="col-md-8">
                	   <label for="email_id" class="form-label">Replecement Month</label>
                	   <?php
                        $rep = trim($single_emp_edit['replecement_month'] ?? '');
                        $value = ($rep === '') ? $replacement : $rep;

                        // if value exists -> add green background class
                        $cssClass = ($rep !== '') ? 'has-value' : '';
                        ?>

						<input type="text" name="replecement_month" class="form-control form-control-md <?= $cssClass ?>"  value="<?= $value; ?>">
                    </div>
                </div>
             
               
                <div class="row g-3 mt-2">
               
                    <div class="col-md-3">
                         <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </div>
                    <div class="col-md-3">
                       
                    </div>
                </div>

                
             
                <!-- <button type="submit" class="btn btn-primary">Update</button> -->
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
.create(document.querySelector('#editor'), {
    toolbar: [
        'heading','bold','italic','link','bulletedList','numberedList',
        'blockQuote','undo','redo','imageUpload'
    ],
    placeholder: 'Write your blog here...',
    // Enable Base64 image upload
    removePlugins: [ 'CKBox', 'CKFinder', 'EasyImage', 'RealTimeCollaborativeComments', 'MathType' ]
})
.then(editor => console.log('Editor ready'))
.catch(error => console.error(error));
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = 'block'; // show image
        }
        reader.readAsDataURL(file); // convert image to base64
    }
});
</script>
</body>
</html>
