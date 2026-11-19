<?php 
use Config\Database;
 $db = Database::connect();
?>
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>

/* ===============================
   WHY SECTION GRID (3–3 Layout)
================================= */
.why-grid { 
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 22px;
  max-width: 1050px;
  margin: 0 auto;
}
  .section h2::after{
      content:"";
      width:50%!important;
      height:3px !important;
      background:#FBDDDF!important;
      position:absolute;
      left:25%;
      bottom:-10px;
      animation:underlineMove 3s infinite alternate;
    }
/* ===============================
   CARD DESIGN
================================= */
.why-card {
  background: #fff;
  padding: 20px 16px;
  border-radius: 16px;
  text-align: center;
  transition: all 0.3s ease;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  min-height: 160px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

/* Animated Gradient Border */
.why-card::before{
  content:"";
  position:absolute;
  inset:0;
  border-radius:16px;
  padding:2px;
  background:#FBDDDF!important;
  animation:rotateBorder 6s linear infinite;
  opacity:0;
  transition:0.4s ease;
}

.why-card:hover::before{
  opacity:1;
}

@keyframes rotateBorder{
  0%{transform:rotate(0deg);}
  100%{transform:rotate(0deg);}
}

/* Hover Lift */
.why-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

/* ===============================
   ICON DESIGN (Smaller)
================================= */
.icon-box {
  width: 45px;
  height: 45px;
  margin: 0 auto 10px;
  border-radius: 50%;
  background: #f5949a;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.3s ease;
}

.icon-box i {
  font-size: 18px;
  color: #fff;
}

.why-card:hover .icon-box{
  transform: scale(1.1);
}

/* ===============================
   TITLE FONT (Smaller)
================================= */
.why-card h5 {
  font-size: 13.5px;
  font-weight: 600;
  margin: 0;
  line-height: 1.4;
}

/* ===============================
   RESPONSIVE
================================= */
@media (max-width: 992px) {
  .why-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 576px) {
  .why-grid {
    grid-template-columns: 1fr;
  }
}

/**/====================================
   .program-section {
  padding: 60px 5%;
  background: #f5f7fb;
}

.program-wrapper {
  display: flex;
  gap: 25px;
  flex-wrap: wrap;
}

.program-card {
  flex: 1;
  min-width: 200px;
  background: #fff;
  border-radius: 18px;
  overflow: hidden;
  text-align: center;
  transition: 0.4s ease;
  position: relative;
}

.program-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  display: block;
}

/* Title Styling Improved */
.program-card h4 {
  padding: 18px 15px;
  font-size: 15px;
  font-weight: 600;
  color: #1e2a38;
  margin: 0;
  background: #ffffff;
  border-bottom-left-radius: 18px;
  border-bottom-right-radius: 18px;
  transition: 0.4s ease;
}

/* Card Hover */
.program-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.08);
}

/* Title Animated Effect */
.program-card:hover h4 {
  background: #0d6efd;
  color: #ffffff;
  transform: translateY(-4px);
  box-shadow: 0 -8px 20px rgba(0,0,0,0.08);
}

</style>
<section class="site-section py-5" style="background-color:#FBDDDF; margin-top: -64px;padding-bottom: 1rem !important;">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-12" data-aos="fade">
        <h1 class="section-title mb-3 text-center" style="font-weight:700; color:#333;font-size: 28px;">Adis India Placement Pvt Ltd — Advancing Clinical Excellence and Patient Safety</h1>
        <p style="margin:0 auto; color:#000; line-height:1.8; text-align:justify;">For over a decade, Adis India Placement Pvt Ltd Doctor Placement Consultancy in India has been deeply embedded in the healthcare ecosystem, observing patient care pathways, clinical workflows, and the multidisciplinary coordination that defines quality healthcare delivery. The organization has studied Medical Recruitment challenges, compliance pressures, and skill gaps that impact patient safety and clinical outcomes. What began as comprehensive organizational diagnostics evolved into a specialized practice: delivering competency based training that enhances clinical excellence, strengthens patient cantered care, and drives measurable improvements in quality indicators. Grounded in real-world healthcare operations not theoretical frameworks Adis India Placement Pvt Ltd delivers capability building solutions that address the intersection of clinical competence, regulatory compliance, and operational efficiency.</p>
      </div>
    </div>
  </div>

</section>

<section class="section">
  <h2><b>Why to Choose Adis India placement for Healthcare Training</b></h2>

  <div class="why-grid">

     
    <div class="why-card"  style="cursor:pointer;" data-modal="modal1">
      <div class="icon-box"><i class="fa-solid fa-hospital"></i></div>
      <h5>Deep Industry Integration</h5>
    </div>

    <div class="why-card"  style="cursor:pointer;" data-modal="modal2">
      <div class="icon-box"><i class="fa-solid fa-file-shield"></i></div>
      <h5>Healthcare Compliance-Driven Competency Framework</h5>
    </div>

    <div class="why-card" data-modal="modal3" style="cursor:pointer;">
      <div class="icon-box"><i class="fa-solid fa-user-doctor"></i></div>
      <h5>Context-Aware Clinical Skill Application</h5>
    </div>

    <div class="why-card" data-modal="modal4" data-bs-toggle="modal" style="cursor:pointer;">
      <div class="icon-box"><i class="fa-solid fa-balance-scale"></i></div>
      <h5>Balancing Clinical Realities with Learning & Development Needs</h5>
    </div>

    <div class="why-card"  data-modal="modal5" data-bs-toggle="modal" style="cursor:pointer;">
      <div class="icon-box"><i class="fa-solid fa-chart-line"></i></div>
      <h5>Measurable Impact on Clinical & Organizational KPIs</h5>
    </div>

    <div class="why-card"  data-modal="modal6" data-bs-toggle="modal" style="cursor:pointer;">
      <div class="icon-box"><i class="fa-solid fa-network-wired"></i></div>
      <h5>Sustainable Capability Building Ecosystems</h5>
    </div>

  </div>
</section>

<!-- Modal 1 Template -->
    <div class="custom-modal" id="modal1">
      <div class="modal-content">
        <span class="close">&times;</span>
        
        <h3>Deep Industry Integration</h3>
        <p>Adis India Placement Pvt Ltd doesn't retrofit generic corporate learning interventions for healthcare settings—the learning architecture is purpose-built around clinical protocols, patient safety frameworks, infection prevention guidelines, and care delivery models. Content design incorporates real scenarios from emergency departments, ICUs, OPDs, diagnostic centers, and nursing stations, reflecting the actual clinical and operational challenges healthcare professionals navigate during every shift.</p>
        
        <div class="modal-footer">
          <!-- <button class="btn-primary">Save</button> -->
          <button class="btn-secondary">Closed</button>
        </div>
      </div>
    </div>

  <!-- Modal 2 -->
  <div class="custom-modal" id="modal2">
    <div class="modal-content">
      <span class="close">&times;</span>
      
      <h3>Healthcare Compliance-Driven Competency Framework</h3>
      <p>Every training module is strategically aligned with NABH (National Accreditation Board for Hospitals & Healthcare Providers), JCI (Joint Commission International), ISO 9001:2015 & ISO 7101:2023 quality standards, and other regulatory requirements. Adis India Placement Pvt Ltd ensures that competency development directly supports accreditation readiness, audit preparedness, and demonstrates evidence-based practice excellence that satisfies both internal quality assurance teams and external assessors</p>
      
      <div class="modal-footer">
        <button class="btn-secondary">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Modal 3 -->
  <div class="custom-modal" id="modal3">
    <div class="modal-content">
      <span class="close">&times;</span>
      
      <h3>Context-Aware Clinical Skill Application </h3>
      <p>Training interventions recognize that "therapeutic communication" differs fundamentally when applied during informed consent discussions, adverse event disclosure, end-of-life conversations, or discharge counseling. Similarly, "team collaboration" takes distinct forms in code blue situations, surgical handoffs, or multidisciplinary rounds. Adis India Placement Pvt Ltd designs competency-based learning that addresses these clinical contexts with precision and relevance.</p>
      
      <div class="modal-footer">
        <button class="btn-secondary">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Modal 4 -->
  <div class="custom-modal" id="modal4">
    <div class="modal-content">
      <span class="close">&times;</span>
      
      <h3>Balancing Clinical Realities with Learning & Development Needs</h3>
      <p>The organization has conducted extensive organizational behavior studies across hospitals facing nurse-patient ratio challenges, physician burnout, high attrition rates, and 24/7 operational demands. Training methodologies at Adis India Placement Pvt Ltd incorporate microlearning, simulation-based practice, and bedside coaching models that maximize knowledge retention and skill transfer despite staffing constraints and time limitations.</p>
      
      <div class="modal-footer">
        <button class="btn-secondary">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Modal 5 -->
  <div class="custom-modal" id="modal5">
    <div class="modal-content">
      <span class="close">&times;</span>
      
      <h3>Measurable Impact on Clinical & Organizational KPIs </h3>
      <p>Beyond training attendance metrics and satisfaction scores, Adis India Placement Pvt Ltd establishes clear linkages between learning interventions and organizational performance indicators: reduction in hospital-acquired infections (HAIs), improvement in patient satisfaction scores (HCAHPS/patient feedback), decrease in medication errors and sentinel events, enhanced accreditation scores, reduced grievance escalations, and improved employee engagement indices.</p>
      
      <div class="modal-footer">
        <button class="btn-secondary">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Modal 6 -->
  <div class="custom-modal" id="modal6">
    <div class="modal-content">
      <span class="close">&times;</span>
      
      <h3>Sustainable Capability Building Ecosystems, Not Standalone Events </h3>
      <p>Healthcare transformation requires systematic, continuous learning cultures rather than episodic training events. Adis India Placement Pvt Ltd deploys comprehensive talent development frameworks that integrate onboarding programs, competency assessments, skill gap analysis, structured learning pathways, knowledge management systems, and performance support tools—creating organizational capability that sustains clinical excellence over time.</p>
      
      <div class="modal-footer">
        <button class="btn-secondary">Cancel</button>
      </div>
    </div>
  </div>

<section class="section program-section">
    <div class="container">

    <div class="row mb-4 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-2">Training Areas</h2>
      </div>
    </div>
    <div class="scroll-wrapper d-flex align-items-center">
      <button class="arrow" id="btnLeft">&#8249;</button>
      <div class="scroll-area flex-grow-1" id="scrollArea">
        
            <a style="text-decoration:none; color:inherit;" href="">
                <div class="card" style="width:353px;height:36px;font-size:14px">
                   Behavioral Competency Development
                </div>
            </a>
            <a style="text-decoration:none; color:inherit;" href="">
                <div class="card" style="width:353px;height:36px;font-size:14px">
                  Clinical Care Skills Enhancement
                </div>
            </a>
            <a style="text-decoration:none; color:inherit;" href="">
                 <div class="card" style="width:353px;height:36px;font-size:14px">
                  Quality Management & Audit Readiness
                </div>
            </a>
             <a style="text-decoration:none; color:inherit;" href="">
                 <div class="card" style="width:353px;height:36px;font-size:14px">
                  Leadership Development Programs
                </div>
            </a>
            <a style="text-decoration:none; color:inherit;" href="">
                 <div class="card" style="width:353px;height:36px;font-size:14px">
                 Specialized Workshops
                </div>
            </a>
        
         
      </div>
      <button class="arrow" id="btnRight">&#8250;</button>
    </div>

  </div>
  <!--<div class="program-wrapper">-->

  <!--  <div class="program-card">-->
  <!--    <img src="<?= base_url('assets/jobportal/images/traning/behavioral.jpeg') ?>" alt="">-->
  <!--    <h4>Behavioral Competency Development</h4>-->
  <!--  </div>-->

  <!--  <div class="program-card">-->
  <!--    <img src="<?= base_url('assets/jobportal/images/traning/clinical.jpeg') ?>" alt="">-->
  <!--    <h4>Clinical Care Skills Enhancement</h4>-->
  <!--  </div>-->

  <!--  <div class="program-card">-->
  <!--    <img src="<?= base_url('assets/jobportal/images/traning/quality.jpeg') ?>" alt="">-->
  <!--    <h4>Quality Management & Audit Readiness</h4>-->
  <!--  </div>-->

  <!--  <div class="program-card">-->
  <!--    <img src="<?= base_url('assets/jobportal/images/traning/leadership.jpeg') ?>" alt="">-->
  <!--    <h4>Leadership Development Programs</h4>-->
  <!--  </div>-->

  <!--  <div class="program-card">-->
  <!--    <img src="<?= base_url('assets/jobportal/images/traning/workshop.jpeg') ?>" alt="">-->
  <!--    <h4>Specialized Workshops</h4>-->
  <!--  </div>-->

  <!--</div>-->
</section>

 <section class="site-section py-5" style="background-color:#FBDDDF;padding-bottom: 1rem !important;">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-12" data-aos="fade">
        <h1 class="section-title mb-3 text-center" style="font-weight:700; color:#333;font-size: 28px;">Learning Partnership</h1>
        <p style="margin:0 auto; color:#000; line-height:1.8; text-align:justify;">Adis India Placement Pvt Ltd offers comprehensive Annual Learning Partnership programs designed to function as your extended L&D division throughout the year. The partnership begins with systematic Training Needs Analysis (TNA) to identify competency gaps, followed by Customized Curriculum Design aligned with institutional objectives and accreditation standards, and Multi-Modal Learning Delivery combining classroom sessions, simulations, e-learning, and bedside coaching. The engagement culminates with rigorous Learning Impact Assessments using the appropriate evaluation framework and detailed Return on Investment (ROI) mapping that quantifies training effectiveness through clinical quality metrics, patient safety indicators, accreditation scores, employee engagement levels, and measurable organizational performance improvements.</p>
      </div>
    </div>
  </div>

</section>


<!-- <section class="section contact-us" style="background: #fbfbfb;">
  <h2>Contact Us</h2>
</section> -->
<section class="contact-us" style="background: #fbfbfb;">
  <div class="container">
    
    <!-- Section Heading -->
    <section class="section contact-us" style="background: #fbfbfb;">
    <div class="section-title text-center">
      <h2>Contact Us</h2>
      
    </div>
  </section>

    <div class="row align-items-stretch">

      <!-- Contact Form -->
      <div class="col-12 col-md-8 mb-4">
        <div class="contact-form-box">

         <?php if(session()->getFlashdata('success')): ?>
    <div style="margin-bottom:15px; padding:10px; border-radius:5px; background-color:#d4edda; color:#155724;">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
          <h4 class="fw-bold mb-4">Training Enquiry form </h4>

          <form action="<?= base_url('traning_enquiry_save'); ?>" method="post">

            <div class="row mb-3">
              <div class="col-md-6">
                <label>Full Name</label>
                <input type="text" class="form-control" name="trainer_full_name" required>
              </div>
              <div class="col-md-6">
                <label>Mobile No </label>
                <input type="text" class="form-control" name="trainer_mobile_no" id="trainer_mobile_no" placeholder="Enter 10-digit mobile" required>
           <div id="mobileError" style="color:red; display:none; font-size:12px;">Only 10-digit numbers allowed</div>
              </div>
            </div>
            <div class="row mb-3">
  
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="trainer_email" class="form-control" placeholder="Enter Email" required>
              </div>

              <div class="col-md-6">
                <label class="form-label d-block">Gender</label>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="trainer_gender" id="genderMale" value="Male" required>
                  <label class="form-check-label" for="genderMale">Male</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="trainer_gender" id="genderFemale" value="Female">
                  <label class="form-check-label" for="genderFemale">Female</label>
                </div>

              </div>

            </div>
         
            <div class="row mb-3">
                <div class="col-md-3">
                   <label for="city" class="form-label">City/Town <span style="color: red;">* </span></label>
                        
                        <select class="form-control form-control-md" name="city_id" id="city_id" data-live-search="true" title="City/Town" required style="padding: 7px 12px;">
                            <option value="">Select City</option>
                            <?php 
                      $citi = $db->query("SELECT * FROM cities")->getResultArray();
                      foreach ($citi as $c): ?>
                        <option value="<?= esc($c['id']) ?>"><?= esc($c['name']) ?></option>
                    <?php endforeach; ?>
                        </select>
                </div>
              <div class="col-md-9">
                <label class="form-label">Address </label>
                <textarea class="form-control" name="trainer_address" rows="2" placeholder="Eneter Address" required></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <label for="country" class="form-label">Type Of Organisation  <span style="color: red;">* </span></label>
                <select class="form-control form-control-md" name="o_id" id="o_id" data-live-search="true" title="o_id" required>
                    <option value="">Select Organisation</option>
                    <?php 
                      $type_org = $db->query("SELECT * FROM tbl_organisation")->getResultArray();
                      foreach ($type_org as $to): ?>
                        <option value="<?= esc($to['o_id']) ?>"><?= esc($to['organisation_name']) ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
               <div class="col-md-8">
                <label for="country" class="form-label">Select Type of Training<span style="color: red;">* </span></label>
                   <select class="form-control" id="trainingType" name="traning_type" data-live-search="true">
                      <option value="">Select</option>
                      <option value="behavioral">Behavioral Competency Development</option>
                      <option value="clinical">Clinical Care Skills Enhancement</option>
                      <option value="quality">Quality Management & Audit Readiness</option>
                      <option value="leadership">Leadership Development Programs</option>
                      <option value="workshop">Specialized Workshops</option>
                      <option value="ld">Learning & Development Partnership Solutions</option>
                  </select>
              </div>
            </div>
            <div class="row mb-3" id="appointmentBlock" style="display:none;">
              <div class="col-md-6">
                <label>Date of Appointment</label>
                <input type="date" class="form-control" name="appo_date">
              </div>
              <div class="col-md-6">
                <label>Time (24:00 Hrs Format)</label>
                <input type="time" class="form-control" name="appo_time">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-3">
                  <label for="type_meeting" class="form-label">Type of Meeting<span style="color: red;">* </span></label>
                  <select class="form-control" id="type_meeting" name="type_meeting"  data-live-search="true">
                      <option value="">Select</option>
                      <option value="In Person">In Person</option>
                      <option value="Virtual">Virtual</option>
                      <option value="Telephonic">Telephonic</option>
                  </select>
              </div>

              <div class="col-md-5">
                <label for="parti" class="form-label">Approximate Participants</label>
                 <select id="participants" name="approx_parpt" class="form-control" data-live-search="true">
                      <option value="">Select</option>
                      <option value="0 – 10">0 – 10</option>
                      <option value="10 – 30">10 – 30</option>
                      <option value="30 – 50">30 – 50</option>
                      <option value="50 – 70">50 – 70</option>
                      <option value="70 – 100">70 – 100</option>
                      <option value="100 +">100 +</option>
                  </select>

                  <div id="participantAlert" style="display:none; color:red; margin-top:10px;font-size: 12px;font-weight: 600;">
                      For better impact, create batches of min 30 participants.
                  </div>
              </div>
              <div class="col-md-4">
            
               <label for="expected_time_duration" class="form-label">Expected Time Duration<span style="color: red;">* </span></label>
                  <select class="form-control" id="expected_time_duration" name="expected_time_duration"  data-live-search="true">
                      <option value="">Select Hours</option>
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="6">6</option>
                  </select>

              </div>

            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>

          </form>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="col-12 col-md-4 mb-4">
        <div class="contact-info-box h-100">

          <h4 class="fw-bold mb-4 text-center">Contact Details</h4>

          <div class="contact-card">
            <h6>Office Address</h6>
            <p>
            A-303, Gera Imperium Gateways,
            Near Nashik Phata, PCMC,
            Pune - 411034
            </p>
          </div>

          <div class="contact-card">
            <h6>Contact Details</h6>
            <p><b>Name:</b> Miss. Shambhavi<br>
              <b>Phone:</b> 8767591642<br>
            <b>Email:</b> Training@adisindiaplacement.com</p>
          </div>

          <div class="contact-card">
            <h6>Office Timings</h6>
            <p>9 am to 6 pm<br>
              Mon to Sat<br>
              Sunday Off</p>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>



<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const cards = document.querySelectorAll(".training-card");
    const imageBox = document.getElementById("trainingImage");

    if (!cards.length || !imageBox) return;

    function changeImage(card) {

        cards.forEach(c => c.classList.remove("active"));
        card.classList.add("active");

        const newImg = card.getAttribute("data-img");

        imageBox.style.opacity = "0";

        setTimeout(function () {
            imageBox.style.backgroundImage = "url('" + newImg + "')";
            imageBox.style.opacity = "1";
        }, 200);
    }

    cards.forEach(card => {

        // Desktop Hover
        card.addEventListener("mouseenter", function () {
            changeImage(this);
        });

        // Mobile Tap
        card.addEventListener("click", function () {
            changeImage(this);
        });

    });

});


</script>
<script>
AOS.init({
duration:1000,
once:true
});
</script>
<script type="text/javascript">

</script>