<style type="text/css">
  .site-section {
    padding-top: 1rem !important;
    padding-bottom: 7rem;
    position: relative;
    z-index: 2;
}
</style>
<section class="site-section" id="next-section">
  <div class="container">
  <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
              
              <li class="breadcrumb-item active" aria-current="page">Award & Recognition</li>
            </ol>
        </nav>
</div>

  
      <div class="container">
        
        <?php if (!empty($single_award_data)): ?>
        <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-8 blog-content">
            <h3 class="mb-3"><?= esc($single_award_data['award_title']); ?></h3>
            
            <p><img src="<?= base_url('award_image/images/'.$single_award_data['award_image']); ?>" alt="Image" class="img-fluid rounded"></p>
            <!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae expedita cumque necessitatibus ducimus debitis totam, quasi praesentium eveniet tempore possimus illo esse, facilis? Corrupti possimus quae ipsa pariatur cumque, accusantium tenetur voluptatibus incidunt reprehenderit, quidem repellat sapiente, id, earum obcaecati.</p> -->

            <blockquote><p><?= esc($single_award_data['content'], 'raw'); ?></p></blockquote>
          </div>
          <div class="col-lg-2"></div>
       
        </div>
        <?php else: ?>
        <p>Blog not found.</p>
        <?php endif; ?>
      </div>
    </section>