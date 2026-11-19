<?php 
use Config\Database;
$db = Database::connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Award</title>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<style>
   
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
            <h5 class="mb-0">Edit Award &nbsp;<a href="<?= base_url('admin/display_award_recon') ?>" class="btn btn-light">
    <i class="fa fa-arrow-left"></i>
</a></h5>
        </div>
        <div class="card-body">
           <form action="<?= base_url('update-award') ?>" method="post" id="blogForm" enctype="multipart/form-data">
                <!-- <input type="hidden" id="user_type" name="user_type" class="form-control form-control-md" value="recruiter"> -->
                <input type="hidden" name="award_id" value="<?= isset($single_award_edit['award_id']) ? esc($single_award_edit['award_id']) : ''; ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Award Title</label>
                            <input type="text" id="title" name="award_title" class="form-control"  value="<?= isset($single_award_edit['award_title']) ? esc($single_award_edit['award_title']) : ''; ?>">
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="mb-3">
                            <label>Select Image</label>
                            <input type="file" id="imageInput" name="blog_image" accept="image/*">
                        </div>

                    </div>
                    <div class="col-md-3">
                            <div class="mb-3">
                             <?php if(!empty($single_award_edit['award_image'])): ?>
                                <img id="preview" src="<?= base_url('award_image/images/'.$single_award_edit['award_image']); ?>" 
                                     style="max-width:200px; border:1px solid #ccc; padding:5px;">
                                <?php else: ?>
                                <img id="preview" src="" style="max-width:200px; display:none; border:1px solid #ccc; padding:5px;">
                                <?php endif; ?>
                          </div>
                    </div>
                  
                </div>
                 <div class="row g-3">
               
                    <div class="col-md-12">
                         <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea name="content" id="editor" style="height: 400px!important;">
                                    <?= isset($single_award_edit['content']) ? esc($single_award_edit['content']) : 'Start writing your blog...'; ?>
                                </textarea>
                        </div>
                    </div>
                 </div>
            
               
                <div class="row g-3">
                      <div class="col-md-4">
                        <div class="mb-3">
                              <button type="submit" class="btn btn-primary mt-3">Update</button>

                        </div>
                    </div>
                </div>
             

                
             
                <!-- <button type="submit" class="btn btn-primary">Update</button> -->
            </form>
        </div>
    </div>
</div>

</body>
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
</html>
