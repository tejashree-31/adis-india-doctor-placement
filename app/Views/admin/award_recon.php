<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Blog</title>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<style>
    #editor { min-height: 400px; }
/*    .card { max-width: 900px; margin: auto; }*/
</style>
</head>
<body>
<div class="container mt-4">

    <!-- <h3 class="mb-4 text-center">Add Blog</h3> -->

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Awards & Recognition</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('save-award') ?>" method="post" id="blogForm" enctype="multipart/form-data">
                <!-- Blog Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Awards Title</label>
                    <input type="text" id="title" name="award_title" class="form-control form-control-md" placeholder="Enter Awards Title" required>
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="imageInput" class="form-label">Select Image</label>
                    <input type="file" id="imageInput" name="award_image" class="form-control form-control-md" accept="image/*">
                </div>

                <!-- Preview Image -->
                <div class="mb-3">
                    <img id="preview" src="" style="max-width:200px; display:none; border:1px solid #ccc; padding:5px;">
                </div>

                <!-- Blog Content -->
                <div class="mb-3">
                    <label for="editor" class="form-label">Content</label>
                    <textarea name="content" id="editor" class="form-control" style="height: 400px!important;">Start writing your blog...</textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Publish</button>
            </form>
        </div>
    </div>
</div>

<!-- CKEditor 5 Classic Build -->
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
.create(document.querySelector('#editor'), {
    toolbar: ['heading','bold','italic','link','bulletedList','numberedList','blockQuote','undo','redo','imageUpload'],
    placeholder: 'Write your blog here...',
    removePlugins: ['CKBox','CKFinder','EasyImage','RealTimeCollaborativeComments','MathType']
})
.then(editor => console.log('Editor ready'))
.catch(error => console.error(error));

// Image preview
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>
