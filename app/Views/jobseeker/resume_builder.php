<?php 
$session = session();
// print_r($_SESSION);
// exit();
$db = \Config\Database::connect();
if ($session->has('uid')) {
$uid = $session->get('uid');
$builder = $db->table('tbl_jobseeker');
$jobseeker = $builder->where('uid', $uid)->get()->getRowArray();
}


 ?>
<style>

  .site-section{
    background:linear-gradient(135deg,#FDECEF,#FBDDDF,#FFF7F8);
    padding:70px 0;
}

/* =========================================
   PRICING CARD
============================================ */

.pricing-card{
    position:relative;
    overflow:hidden;
    min-height:430px;   
    border-radius:20px;
    background:rgba(255,255,255,.90);
    backdrop-filter:blur(12px);
    -webkit-backdrop-filter:blur(12px);

    border:1px solid rgba(255,255,255,.6);
    border-radius:22px;

    box-shadow:0 12px 30px rgba(245,149,156,.15);

    transition:all .35s ease;
}

.pricing-card:hover{

    transform:translateY(-10px);

    box-shadow:0 25px 45px rgba(245,149,156,.30);

}

/* Glass Shine */

.pricing-card::before{

    content:"";

    position:absolute;

    width:180px;

    height:180px;

    top:-90px;

    right:-90px;

    background:rgba(255,255,255,.35);

    border-radius:50%;

}

/* =====================================
   HEADER
============================================ */

.pricing-header{

    background:linear-gradient(135deg,#F5959C,#ff7b84);

      padding:16px 15px;

    text-align:center;

    color:#fff;

}

.pricing-header h3{

     font-size:22px;
    margin-bottom:5px;

    font-weight:700;

    margin:5px 0;

}

.price{

       font-size:36px;

    font-weight:700;

    margin:8px 0;

    line-height:1;

}

.plan{

    font-size:14px;

    opacity:.9;

}

/* =========================
   BODY
========================= */

.pricing-body{

      padding:15px 22px;

}

.pricing-body ul{

    list-style:none;

    padding:0;

    margin:0;

}

.pricing-body ul li{

    padding:11px 0;

    font-size:14px;

    color:#555;

    border-bottom:1px solid rgba(0,0,0,.08);

}

.pricing-body ul li:last-child{

    border:none;

}

/* =========================
   BUTTON
========================= */

.pricing-footer{

      padding:15px 20px 20px;

}

.plan-btn{

    width:100%;

    border:none;

    border-radius:40px;

    padding:10px;

    color:#fff;

    font-weight:600;

    background:linear-gradient(135deg,#F5959C,#ff7584);

    box-shadow:0 8px 20px rgba(245,149,156,.30);

    transition:.3s;

}

.plan-btn:hover{

    transform:scale(1.03);

    color:#fff;

}

/* =========================
   GOLD CARD
========================= */

.popular{

    transform:scale(1.05);

    border:2px solid transparent;

    background-image:
        linear-gradient(#fff,#fff),
        linear-gradient(135deg,#ffb347,#ff7b84);

    background-origin:border-box;

    background-clip:padding-box,border-box;

    box-shadow:0 25px 55px rgba(255,170,80,.35);

}

.popular:hover{

    transform:scale(1.07) translateY(-10px);

}

/* Ribbon */

.ribbon{

    position:absolute;

    top:18px;

    right:-40px;

    transform:rotate(45deg);

    background:linear-gradient(135deg,#ffb347,#ff9800);

    color:#fff;

    font-size:10px;

    font-weight:700;

    letter-spacing:1px;

    padding:8px 45px;

    z-index:9;

}
.download-icon{
    width:60px;
    height:60px;
    margin:0 auto 15px;
    border-radius:50%;
    background:rgba(255,255,255,.2);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    color:#fff;
}

/* =========================
   Responsive
========================= */

@media(max-width:991px){

    .popular{

        transform:none;

    }

    .popular:hover{

        transform:translateY(-8px);

    }

    .pricing-card{

        min-height:auto;

    }

}

</style>



<section class="site-section" id="next-section">

  <div class="container">

    <div class="text-center mb-5">
        <h2 class="font-weight-bold">Choose Your Resume Plan</h2>
        <p class="text-muted">
            Create an ATS-Friendly Resume & Download Instantly
        </p>
    </div>

    <div class="row">

        <!-- FREE -->
        <div class="col-lg-4 mb-4">

            <div class="pricing-card h-100">

                <div class="pricing-header">
                      <div class="download-icon">
                      <div style="font-size:40px;">📥</div>
                      </div>
                    <h3>FREE</h3>
                    <h2 class="price">₹0</h2>
                    <p class="plan">Forever Free</p>
                </div>

                <div class="pricing-body">

                    <ul>
                        <li>✔ 1 Resume</li>
                        <li>✔ Basic Resume Template</li>
                        <li>✔ PDF Download</li>
                        
                    </ul>

                </div>

                <div class="pricing-footer">
                    <button type="button"
                          class="plan-btn"
                          onclick="window.location.href='<?= base_url('jobseeker/free_download_resume') ?>'">
                      Get Started
                  </button>
                </div>

            </div>

        </div>

        <!-- GOLD -->
        <div class="col-lg-4 mb-4">
            
            <div class="pricing-card h-100">
                <div class="ribbon">
                    MOST POPULAR
                </div>

                <div class="pricing-header">
                      <div class="download-icon">
                      <div style="font-size:40px;">📥</div>
                      </div>
                    <h3>GOLD</h3>
                    <h2 class="price">₹199</h2>
                    <p class="plan">One Time</p>
                </div>

                <div class="pricing-body">

                    <ul>
                        <li>✔ 1 Resume</li>
                        <li>✔ Basic Resume Template</li>
                        <li>✔ PDF Download</li>
                        
                    </ul>

                </div>

                <!-- <div class="pricing-footer">
                    <button class="plan-btn">
                        Get Started
                    </button>
                </div> -->
                <div class="pricing-footer d-flex gap-2 justify-content-center">

                    <!--  <button type="button"
                            class="plan-btn"
                            onclick="window.location.href='<?= base_url('resume-preview') ?>'">
                        👁 Preview
                    </button> -->
                    <a href="<?= base_url('resume-preview') ?>"
                   target="_blank"
                   class="plan-btn">
                    👁 Preview
                    </a>

                    <!-- <a href="<?//= base_url('resume-gold-download') ?>" target="_blank" class="plan-btn">
                   🚀 Get Started
                    </a> -->
                    <button type="button" class="plan-btn" onclick="payNow('Gold',295)">
                        🚀 Get Started
                    </button>

                </div>

            </div>

        </div>

        <!-- PREMIUM -->
        <div class="col-lg-4 mb-4">

           <!--  <div class="pricing-card h-100">

                <div class="pricing-header">
                    <h3>PREMIUM</h3>
                    <h2 class="price">₹499</h2>
                    <p class="plan">Lifetime Access</p>
                </div>

                <div class="pricing-body">

                    <ul>
                        <li>✔ Everything in Gold</li>
                        <li>✔ All Resume Templates</li>
                        <li>✔ AI Resume Builder</li>
                        
                    </ul>

                </div>

                <div class="pricing-footer">
                    <button class="plan-btn">
                        Go Premium
                    </button>
                </div>

            </div> -->
            <div class="pricing-card h-100">

                <div class="pricing-header">
                      <div class="download-icon">
                      <div style="font-size:40px;">📥</div>
                      </div>
                    <h3>PREMIUM</h3>
                    <h2 class="price">₹299</h2>
                    <p class="plan">Lifetime Access</p>
                </div>

                <div class="pricing-body">

                    <ul>
                        <li>✔ 1 Resume</li>
                        <li>✔ Basic Resume Template</li>
                        <li>✔ PDF Download</li>
                        
                    </ul>

                </div>

                <div class="pricing-footer">
                    <button class="plan-btn">
                        Get Started
                    </button>
                </div>

            </div>

        </div>

    </div>

  </div>

</section>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

function payNow(plan, amount)
{
    var options = {

        key: "rzp_live_TFjuOnaUKdsUO1",

        amount: amount * 100,

        currency: "INR",

        name: "Your Website",

        description: plan + " Membership",

          prefill: {
            name: "John Doe",
            email: "john@example.com",
            contact: "9876543210"
        },
        readonly: {
            contact: true
        },
        handler: function (response)
        {
            $.ajax({

                url: "<?= base_url('membership/paymentSuccess') ?>",

                type: "POST",

                data: {
                    payment_id: response.razorpay_payment_id,
                    order_id: response.razorpay_order_id,
                    signature: response.razorpay_signature,
                    plan: plan,
                    amount: amount
                },

                success: function(res)
                {
                    window.location.href =
                        "<?= base_url('membership-success') ?>";
                }

            });
        },

        theme: {
            color: "#F5959C"
        }
    };

    var rzp = new Razorpay(options);

    rzp.open();
}
</script>
