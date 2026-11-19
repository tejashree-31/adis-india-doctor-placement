<style type="text/css">
  .site-section {
    padding-top: 1rem !important;
    padding-bottom: 7rem;
    position: relative;
    z-index: 2;
}
.img-fluid {
    max-width: 25%;
}
.blog-quote{
    margin:20px 0;
    padding:15px 20px;
    border-left:4px solid #ff4b6e;
    background:#fff7f9;
}

.blog-quote p{
    margin:0;
    text-align:justify;
    line-height:1.7;
    font-size:16px;
}
</style>
<section class="site-section" id="next-section">
  <div class="container">
  <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url('display-blogs') ?>">Display News</a></li>
              <li class="breadcrumb-item active" aria-current="page">Single News</li>
            </ol>
        </nav>
</div>

  
      <div class="container">
        
        <?php if (!empty($single_blog)): ?>
        <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-8 blog-content">
            <h3 class="mb-3"><?= esc($single_blog['blog_title']); ?></h3>
            
            <p class="text-center"><img src="<?= base_url('admin_blog/images/'.$single_blog['blog_image']); ?>" alt="Image" class="img-fluid rounded"></p>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae expedita cumque necessitatibus ducimus debitis totam, quasi praesentium eveniet tempore possimus illo esse, facilis? Corrupti possimus quae ipsa pariatur cumque, accusantium tenetur voluptatibus incidunt reprehenderit, quidem repellat sapiente, id, earum obcaecati.</p> -->

            <blockquote class="blog-quote">
    <p><?= esc($single_blog['blog_comment'], 'raw'); ?></p>
</blockquote>
          </div>
          <div class="col-lg-2"></div>
       
        </div>
        <?php else: ?>
        <p>Blog not found.</p>
        <?php endif; ?>
      </div>
    </section>