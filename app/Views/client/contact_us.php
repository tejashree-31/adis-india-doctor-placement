
<section class="contact-us" style="background: #fbfbfb;">
  <div class="container">
    <div class="row">
      
      <!-- Contact Form -->
      <div class="col-12 col-md-6 mb-4">
        <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
<?php elseif(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
<?php endif; ?>
        <h2 class="fw-bold mb-3">Get in Touch</h2>
        <form action="<?= base_url('contact_save'); ?>" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="contact_name" name="name" placeholder="Enter your full name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="contact_email" placeholder="Enter your email" required>
            <span id="emailError" style="color:red; font-size:13px; display:none;"></span>
          </div>
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" required>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary w-100">Send Message</button>
        </form>
      </div>

      <!-- Contact Info -->
      <div class="col-12 col-md-6 mb-4">
  <h2 class="fw-bold mb-3 text-center">Contact Details</h2>

  <div class="contact-card">
    <p><b style="font-size: 22px;">Office Address:</b><br>
      A-303, Gera Imperium Gateways,<br>
      Near Nashik Phata, PCMC,<br>
      Pune - 411034
    </p>
  </div>

  <div class="contact-card">
    <p><b style="font-size: 22px;">Contact details</b></p>
    <p><b>Phone:</b> 096075 59547</p>
    <!-- <p><b>Email:</b> adisjobsplacement@gmail.com</p> -->
    <p><b>Email:</b> contact@adisindiaplacement.com</p>
  </div>

  <div class="contact-card">
    <p><b style="font-size: 22px;">Office Timings</b></p>
    <span style="color: #000;">9 am to 6 pm </span>
    <span style="color: #000;">Mon to Sat </span>
    <p>Sunday Off </p>
    
  </div>
</div>

    </div>
  </div>
<div class="container-fluid p-0 m-0">
  <div class="mapouter">
    <div class="gmap_canvas">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3781.172671431036!2d73.819344!3d18.6113017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcf834679835a55%3A0x5d5d151f05f1d25f!2sAdis%20India%20Placement%20Pvt%20Ltd%20-%20Best%20doctors%20placement%20consultancy!5e0!3m2!1sen!2sin!4v1758617504613!5m2!1sen!2sin"
        width="100%"
        height="450"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</div>
</section>

<script>
const emailInput = document.getElementById('email');
const emailError = document.getElementById('emailError');

// Typing validation
emailInput.addEventListener('input', function () {
    const value = this.value;

    // Invalid characters / invalid format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (value !== '' && !emailRegex.test(value)) {
        emailError.innerText = 'Please enter a valid email address';
        emailError.style.display = 'block';
    } else {
        emailError.style.display = 'none';
    }
});

// Submit validation
function validateEmail() {
    const email = emailInput.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === '') {
        emailError.innerText = 'Email address is required';
        emailError.style.display = 'block';
        emailInput.focus();
        return false;
    }

    if (!emailRegex.test(email)) {
        emailError.innerText = 'Enter valid email address';
        emailError.style.display = 'block';
        emailInput.focus();
        return false;
    }

    return true;
}
</script>
