<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Job Alert</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background:#f5f5f5;">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td align="center">

<!-- MAIN WRAPPER -->
<table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#FBDDDF; margin:20px 0; border-radius:8px; overflow:hidden;">

    <!-- HEADER IMAGE -->
    <tr>
        <td align="center" style="padding:0; margin:0;">
            <img src="https://www.adisindiaplacement.com/assets/jobportal/images/home/abc.jpg"
                 alt="Adis India"
                 width="600"
                 style="display:block; max-width:600px; width:100%; height:auto;">
        </td>
    </tr>

    <!-- TITLE -->
    <tr>
        <td style="padding: 20px 18px 5px 18px; color:#000; font-size:22px; font-weight:bold; text-align:center;">
            Top jobs matching your profile
        </td>
    </tr>

    <!-- INTRO -->
    <tr>
        <td style="padding: 8px 18px 20px 18px; color:#333; font-size:14px; line-height:20px; text-align:center;">
            Hi <b><?= $candidateName ?></b>,<br>
            We found job opportunities where you'd be a great fit!
        </td>
    </tr>

    <!-- JOB CARDS -->
    <?php if(!empty($jobs)): ?>
        <?php foreach ($jobs as $job): ?>
        <tr>
            <td style="padding:10px 18px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #000; border-radius:6px; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
                    <tr>
                        <!-- THUMBNAIL -->
                        <td width="70" style="padding:10px;">
                            <img src="https://www.adisindiaplacement.com/assets/jobportal/images/color_logo.png"
                                 width="55"
                                 style="display:block; border-radius:4px;">
                        </td>

                        <td width="15"></td>

                        <!-- JOB DETAILS -->
                        <td style="padding:10px;">
                            <div style="color:#000; font-size:16px; font-weight:bold; line-height:20px;">
                                <?= $job['job_role'] ?>
                            </div>
                            <div style="color:#333; font-size:14px; line-height:18px; padding-top:3px;">
                                <?= $job['city_name'] ?>
                            </div>

                            <!-- BUTTON -->
                            <div style="padding-top:10px;">
                                <a href="https://www.adisindiaplacement.com/" target="_blank"
                                   style="background:#e63946; padding:6px 14px; color:#fff; text-decoration:none; font-size:12px; border-radius:20px; display:inline-block;">
                                   Quick Apply
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td style="padding:15px; color:#333; font-size:14px; text-align:center;">No jobs available right now.</td>
        </tr>
    <?php endif; ?>

    <!-- READ MORE -->
    <tr>
        <td align="center" style="padding:15px;">
            <a href="https://www.adisindiaplacement.com/" target="_blank"
             style="color:#d62828; font-size:13px; text-decoration:none; font-family: serif;">
             <u><i>Read more</i></u>
            </a>
        </td>
    </tr>

    <!-- SOCIAL ICONS -->
    <tr>
        <td align="center" style="padding:15px;">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <?php
                    $socials = [
                        'facebook' => 'https://www.facebook.com/adisindiaplacement',
                        'linkedin' => 'https://www.linkedin.com/company/adisindiaplacement/',
                        'twitter' => 'https://x.com/adisindia2015',
                        'website' => 'https://www.adisindiaplacement.com/',
                        'youtube' => 'https://www.youtube.com/@adisindiaplacement/',
                        'whatsapp' => 'https://whatsapp.com/channel/0029Vb6apis6buMC6fUdvc2q',
                    ];
                    foreach($socials as $icon => $link):
                    ?>
                    <td style="padding:0 3px;">
                        <a href="<?= $link ?>" target="_blank">
                            <img src="https://www.adisindiaplacement.com/assets/jobportal/images/icons/<?= $icon ?>.png" width="24" height="24">
                        </a>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="padding:15px; font-size:14px; color:#555; line-height:16px;" align="center">
            Adis India Placement Pvt Ltd<br>
            Office No A330, Gera Imperium Getway, Nashik Phata, Maharashtra 411034<br>
            <b>www.adisindiaplacement.com</b> - <b>contact@adisindiaplacement.com</b><br><br>
            This is an automated email. Do not reply.<br>
            If you wish to unsubscribe, click <b>Unsubscribe</b>.<br><br>
            ©2025 Adis India Placement Pvt Ltd. All rights reserved.
        </td>
    </tr>

</table>
</td>
</tr>
</table>

</body>
</html>
