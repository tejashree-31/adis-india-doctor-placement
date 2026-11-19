 <section class="site-section">
  <div class="container mt-5">
    <div class="row">
      <?php if (!empty($blogs_display)): ?>
        <?php foreach ($blogs_display as $blog):
           
         ?>
          <div class="col-md-6 col-lg-3 mb-4">
            <div class="blog-card">
              <a href="<?= base_url('single_blog_display/'.$blog['blog_id']); ?>">
                <img src="<?= base_url('admin_blog/images/'.$blog['blog_image']); ?>" 
                     class="card-img-top" 
                     alt="<?= esc($blog['blog_title']); ?>" >
              </a>
            </div>
            <div class="card-body">
              <h5 class="card-title">
                <a href="<?= base_url('single_blog_display/'.$blog['blog_id']); ?>" class="text-black">
                  <?= esc($blog['blog_title']); ?>
                </a>
              </h5>
              <p class="card-meta">
                <?= date('F d, Y', strtotime($blog['created_at'])); ?> | 
                <a href="<?= base_url('single_blog_display/'.$blog['blog_id']); ?>">0 Comments</a>
              </p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No blogs available.</p>
      <?php endif; ?>
    </div>
  </div>
</section>


