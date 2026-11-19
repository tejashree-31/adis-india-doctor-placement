<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Blog</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/*    #editor { min-height:400 px; }*/
</style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Edit Blog</h1>
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>
    <form action="<?= base_url('update-blog') ?>" method="post" id="blogForm" enctype="multipart/form-data">
        <!-- Blog Title -->
        <input type="hidden" name="blog_id" value="<?= isset($single_blog_edit['blog_id']) ? esc($single_blog_edit['blog_id']) : ''; ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Blog Title</label>
            <input type="text" id="title" name="blog_title" class="form-control"  value="<?= isset($single_blog_edit['blog_title']) ? esc($single_blog_edit['blog_title']) : ''; ?>">
        </div>
        <div class="mb-3">
            <label>Select Image</label>
        <input type="file" id="imageInput" name="blog_image" accept="image/*">
        </div>

        <!-- Preview the selected image -->
        <div class="mb-3">
        <?php if(!empty($single_blog_edit['blog_image'])): ?>
            <img id="preview" src="<?= base_url('admin_blog/images/'.$single_blog_edit['blog_image']); ?>" 
                 style="max-width:200px; border:1px solid #ccc; padding:5px;">
            <?php else: ?>
            <img id="preview" src="" style="max-width:200px; display:none; border:1px solid #ccc; padding:5px;">
            <?php endif; ?>
        </div>

        <!-- CKEditor -->
        <div class="mb-3">
        <label for="blog_comment" class="form-label">Content</label>
        <textarea name="blog_comment" id="editor" style="height: 400px!important;">
            <?= isset($single_blog_edit['blog_comment']) ? esc($single_blog_edit['blog_comment']) : 'Start writing your blog...'; ?>
        </textarea>
    </div>
       <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<!-- CKEditor 5 Classic Build -->
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
