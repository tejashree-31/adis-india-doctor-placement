<!-- Fancybox CSS -->

<style>
  .gallery-img {
    width: 100%;
    height: 200px; /* Medium size */
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .gallery-img:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  }

  /* Gap below each image/video */
  .gallery-item {
    margin-bottom: 40px; /* Gap for each card */
    position: relative;
  }

  /* Play icon overlay for video */
  .play-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 50px;
    color: white;
    opacity: 0.8;
    pointer-events: none;
  }

  .gallery-item:hover .play-icon {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1.1);
    transition: 0.3s;
  }
</style>

<section class="site-section block__62272 py-5" id="gallery-section" style="margin-top: -64px;"> 
  <div class="container">
    <!-- Filter Buttons -->
    <div class="row justify-content-center mb-4">
      <div id="filters" class="filters text-center button-group col-md-8">
        <button class="btn btn-primary active" data-filter="*">All</button>
        <button class="btn btn-primary" data-filter=".web">Photos</button>
        <button class="btn btn-primary" data-filter=".design">Videos</button>
      </div>
    </div>  

    <!-- Gallery Grid -->
    <div id="posts" class="row">

      <!-- Image 1 -->
      <div class="item web col-6 col-md-4 col-lg-3 gallery-item">
        <a data-fancybox="gallery" href="assets/jobportal/images/gallery/1.jpg">
          <img class="img-fluid gallery-img" src="assets/jobportal/images/gallery/1.jpg" alt="Gallery Image 1">
        </a>
      </div>

      <!-- Image 2 -->
      <div class="item web col-6 col-md-4 col-lg-3 gallery-item">
        <a data-fancybox="gallery" href="assets/jobportal/images/gallery/7.jpg">
          <img class="img-fluid gallery-img" src="assets/jobportal/images/gallery/7.jpg" alt="Gallery Image 2">
        </a>
      </div>

      <!-- Image 3 -->
      <div class="item web col-6 col-md-4 col-lg-3 gallery-item">
        <a data-fancybox="gallery" href="assets/jobportal/images/gallery/8.jpg">
          <img class="img-fluid gallery-img" src="assets/jobportal/images/gallery/8.jpg" alt="Gallery Image 3">
        </a>
      </div>

      <!-- Image 4 -->
      <div class="item web col-6 col-md-4 col-lg-3 gallery-item">
        <a data-fancybox="gallery" href="assets/jobportal/images/gallery/9.jpg">
          <img class="img-fluid gallery-img" src="assets/jobportal/images/gallery/9.jpg" alt="Gallery Image 4">
        </a>
      </div>

      <!-- Video 1 -->
      <div class="item design col-6 col-md-4 col-lg-3 gallery-item">
        <a data-fancybox="gallery" href="https://www.youtube.com/watch?v=c8dnHbT2QKo">
          <img class="img-fluid gallery-img" src="https://img.youtube.com/vi/c8dnHbT2QKo/hqdefault.jpg" alt="Video Thumbnail">
          <span class="play-icon">&#9658;</span>
        </a>
      </div>

     <!-- Video 2 -->
<div class="item design col-6 col-md-4 col-lg-3 gallery-item">
  <a data-fancybox="gallery" href="https://www.youtube.com/watch?v=h7kNhiVovKY">
    <img class="img-fluid gallery-img" src="https://img.youtube.com/vi/h7kNhiVovKY/hqdefault.jpg" alt="Video Thumbnail">
    <span class="play-icon">&#9658;</span>
  </a>
</div>

<!-- Video 3 -->
<div class="item design col-6 col-md-4 col-lg-3 gallery-item">
  <a data-fancybox="gallery" href="https://www.youtube.com/watch?v=0-oRnJaOM8M">
    <img class="img-fluid gallery-img" src="https://img.youtube.com/vi/0-oRnJaOM8M/hqdefault.jpg" alt="Video Thumbnail">
    <span class="play-icon">&#9658;</span>
  </a>
</div>



    </div>
  </div>
</section>

<!-- Fancybox JS -->

