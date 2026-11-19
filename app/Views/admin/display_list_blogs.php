<?php
use Config\Database;
$db = Database::connect();
 ?>
 <style type="text/css">
#dataTable{
    table-layout: fixed;
    width:100%;
}

#dataTable th:nth-child(1),
#dataTable td:nth-child(1){
    width:60px;
    text-align:center;
}

#dataTable td{
    vertical-align: top;
    word-break: break-word;
    white-space: normal;
}

#dataTable td:nth-child(3){   /* Award Comment */
    max-width:400px;
}

#dataTable td img{
    width:180px;
    height:110px;
    object-fit:cover;
    border-radius:6px;
}

.award-desc{
    max-width:800px;
    line-height:1.6;
}

.award-desc.short{
    display:-webkit-box;
    -webkit-line-clamp:4;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.read-toggle{
    color:#c00;
    font-weight:600;
    cursor:pointer;
    text-decoration:none;
}
 </style>
<div class="container-fluid">
    <!-- Page Heading -->
    <h4 class="mb-2 text-gray-800">Blog Details</h4>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
        </div>
        <div class="card-body">
            <div id="flash-message"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Blog Title</th>
                            <th>Blog Comment</th>
                            <th>Blog Images</th>
                            <th>Rigster Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sr.No</th>
                            <th>Blog Title</th>
                            <th>Blog Comment</th>
                            <th>Blog Images</th>
                            <th>Rigster Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (!empty($blogs_display)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($blogs_display as $row) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($row['blog_title']); ?></td>
                                    <!--<td class="comment-text"><?//= esc($row['blog_comment'], 'raw'); ?></td>-->
                                        
                                         <td>
                                        <div class="award-desc">
                                            <?= $row['blog_comment']; ?>
                                        </div>
                                    </td>
                                    <td><img src="<?= base_url('admin_blog/images/'.$row['blog_image']); ?>" 
                             class="card-img-top" 
                             alt="<?= esc($row['blog_title']); ?>" ></td>
                                    <td><?= date('F d, Y', strtotime($row['created_at'])); ?></td>
                                    <td> <!-- Edit Button -->
                                          <a href="<?= base_url('admin/edit_blog/'.$row['blog_id']); ?>" class="btn btn-sm btn-primary">Edit</a>

                                          <!-- Delete Button -->
                                          <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?= $row['blog_id']; ?>">
                                              Delete
                                        </button>
                                          </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">No recruiter details found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>