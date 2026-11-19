<?php
$db = \Config\Database::connect();
$experience = $db->table('tbl_jobseeker_experience')
                 ->where('jobseeker_id', $jobseeker['jobseeker_id'])
                 ->orderBy('start_date', 'DESC')
                 ->get()
                 ->getResultArray();
?>

<style>body{
    background:#e5e5e5;
}

.resume-page{
    width:794px;
    min-height:1123px;
    margin:30px auto;
    background:#fff;
    display:flex;
    box-shadow:0 0 20px rgba(0,0,0,.2);
    box-sizing:border-box;
}
.left-side{
    width:50%;
    background:#f4f4f4;
    padding:35px;
}

.right-side{
    width:65%;
    padding:40px;
}

.profile-img{
    width:160px;
    display:block;
    margin:auto;
}

.name-box{
    background:#222;
    color:#fff;
    text-align:center;
    padding:12px;
    margin-top:-5px;
}

.section{
    margin-top:35px;
}

.section h4{
    border-bottom:1px solid #ccc;
    padding-bottom:8px;
}

.resume-section{
    margin-top:32px;
}
.resume-section-sp
{
    margin-top:20px;
}
.contact-box{
    margin:25px 0;
}
.second-page{
    width:794px;
    min-height:1123px;
    margin:30px auto;
    background:#fff;
    box-shadow:0 0 20px rgba(0,0,0,.2);
    display:flex;
    position:relative;
    box-sizing:border-box;
}

.second-left{
    width:50%;
    background:#f4f4f4;
    padding:35px;
    box-sizing:border-box;
}

.second-right{
    width:65%;
    padding:40px;
    box-sizing:border-box;
}
.section-personal p{
    display:flex;
    margin:8px 0;
}

.section-personal .label{
    width:136px;
    font-weight:600;
    flex-shrink:0;
}
.signature-section{
    position:absolute;
    bottom:50px;
    left:40px;
    right:40px;
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
}

.date-box{
    font-size:16px;
}

.sign-box{
    text-align:center;
    min-width:180px;
}


</style>

<div class="resume-page">

    <div class="left-side">

        <img src="<?= !empty($jobseeker['candi_profile_cropped_image'])
    ? base_url('jobseeker/candidate_job_profile/' . $jobseeker['candi_profile_cropped_image'])
    : base_url('assets/images/default-user.png'); ?>"
     class="profile-img"
     alt="Profile Image">

        <h2 class="name-box">
            <?= !empty($jobseeker['job_role']) ? esc($jobseeker['job_role']) : 'Job Role'; ?>
        </h2>

        <div class="section">
            <h4>🎓 EDUCATION</h4>

            <?php if (!empty($jobseeker['sup_id'])) { ?>
            <p>
                <b>Superspeciality Degree</b><br>
                <?= esc($jobseeker['superspeciality_name']); ?><br>
                <?= !empty($jobseeker['sup_year_month']) ? date('F, Y', strtotime($jobseeker['sup_year_month'])) : ''; ?>
            </p>
            <?php } ?>

            <?php if (!empty($jobseeker['int_degree_id']) || !empty($jobseeker['iq_clg_name'])) { ?>
                <p>
                    <b>International Qualification</b><br>
                    <?= esc($jobseeker['iq_clg_name']); ?><br>
                    <?= !empty($jobseeker['iq_year_month']) ? date('Y', strtotime($jobseeker['iq_year_month'])) : ''; ?>
                </p>
            <?php } ?>

            <?php if (!empty($jobseeker['pg_id']) || !empty($jobseeker['pg_clg_name'])) { ?>
                <p>
                    <b>Master Degree</b><br>
                    <?= esc($jobseeker['pg_clg_name']); ?><br>
                    <?= !empty($jobseeker['pg_year_month']) ? date('Y', strtotime($jobseeker['pg_year_month'])) : ''; ?>
                </p>
            <?php } ?>

            <?php if (!empty($jobseeker['ug_id']) || !empty($jobseeker['ug_clg_name'])) { ?>
                <p>
                    <b>Bachelor Degree</b><br>
                    <?= esc($jobseeker['ug_clg_name']); ?><br>
                    <?= !empty($jobseeker['ug_year_month']) ? date('Y', strtotime($jobseeker['ug_year_month'])) : ''; ?>
                </p>
            <?php } ?>
        </div>

        <?php if (!empty($jobseeker['language_name'])) { ?>
            <div class="section">
                <h4>🌍 LANGUAGES</h4>

                <ul>
                    <?php foreach (explode(',', $jobseeker['language_names']) as $language) { ?>
                        <li><?= esc(trim($language)); ?></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>

        <?php if (!empty($jobseeker['linkdin_profile']) && strtolower($jobseeker['linkdin_profile']) == 'yes') { ?>
            <div class="section">
                <h4>🔗 LINKEDIN PROFILE</h4>

                <p><?= esc($jobseeker['linkedin_url']); ?></p>
            </div>
            <?php } ?>

    </div>

    <div class="right-side">

        <h1>HELLO</h1>

        <h3>I am Dr. <?php echo $jobseeker['full_name'] ?></h3>

       <p>
        With 
        <?= $jobseeker['experience_years']; ?> years
        <?php if (!empty($jobseeker['experience_months']) && $jobseeker['experience_months'] > 0) { ?>
            <?= $jobseeker['experience_months']; ?> months
        <?php } ?>
        of medical experience, I am committed to delivering compassionate care, accurate diagnosis, and the highest standards of healthcare.
    </p>

        <hr>

        <div class="contact-box">
            📞 +91 <?= esc($jobseeker['mobile_number']); ?> &nbsp;&nbsp;
            ✉ <?= esc($jobseeker['email']); ?>
        </div>

        <div class="resume-section-sp">

            <h3>🩺 SPECIALIZATION</h3>
            <p><?= esc($jobseeker['job_role']); ?></p>
        </div>

        <?php if (!empty($experience)) { ?>
        <div class="resume-section">

            <h3>💼 WORK EXPERIENCE</h3>

            <?php foreach ($experience as $exp) { ?>

                <h4>
                    <?= esc($exp['company_name']); ?>
                    <?php if (!empty($exp['designation'])) { ?>
                        - <?= esc($exp['designation']); ?>
                    <?php } ?>
                </h4>

               <p>
                    <?= !empty($exp['start_date']) ? date('M Y', strtotime($exp['start_date'])) : ''; ?>

                    <?php
                    if ($exp['currently_working'] == '1') {
                        echo ' - Present';
                    } elseif (!empty($exp['end_date'])) {
                        echo ' - ' . date('M Y', strtotime($exp['end_date']));
                    }
                    ?>
                </p>
                <p>
                    <?= esc($exp['job_description']); ?>
                </p>

            <?php } ?>

        </div>
        <?php } ?>


    <?php if (!empty($jobseeker['key_skills'])) { ?>
        <div class="section">
            <h4>🛠️ KEY SKILLS</h4>

            <?php
            $skills = html_entity_decode($jobseeker['key_skills']);

            if (strpos($skills, '<li') !== false) {

                preg_match_all('/<li\b[^>]*>.*?<\/li>/is', $skills, $matches);
                $skillArray = $matches[0];

            } elseif (strpos($skills, '<p') !== false) {

                preg_match_all('/<p\b[^>]*>.*?<\/p>/is', $skills, $matches);
                $skillArray = $matches[0];

            } else {

                $skillArray = preg_split('/[\r\n,]+/', strip_tags($skills));
            }

            $remainingSkills = [];
            $skillCount = 0;
            if (
                strpos($skills, '<ul') !== false ||
                strpos($skills, '<ol') !== false ||
                strpos($skills, '<li') !== false ||
                strpos($skills, '<p') !== false
            ) {

             foreach ($skillArray as $skill) {

                $skill = trim($skill);

                if ($skill != '') {

                    $skillCount++;

                    if ($skillCount <= 4) {

                        echo $skill;

                    } else {

                        $remainingSkills[] = $skill;
                    }
                }
            }

            } else {

                
                $skillArray = preg_split('/[\r\n,]+/', $skills);
                $skillCount = 0;
                $remainingSkills = [];
                echo '<ul>';
           foreach ($skillArray as $skill) {

                    $skill = trim($skill);

                    if ($skill != '') {

                        $skillCount++;

                        if ($skillCount <= 4) {

                            echo $skill;

                        } else {

                            $remainingSkills[] = $skill;
                        }
                    }
                }
            }
            ?>
        </div>
    <?php } ?>

    </div>

</div>

<!-- SECOND PAGE -->

<div class="second-page">

    <div class="second-left">
        <div class="section-personal">
            <h4>👤 PERSONAL DETAILS</h4>

            <?php if (!empty($jobseeker['birth_date'])) { ?>
                <p>
                    <span class="label">📅 Date Of Birth</span> <span><?= date('d F Y', strtotime($jobseeker['birth_date'])); ?></span>
                </p>
            <?php } ?>

            <?php if (!empty($jobseeker['gender'])) { ?>
                <p>
                    <span class="label">
                        <?php
                        if ($jobseeker['gender'] == 'Female') {
                            echo '👩 Gender';
                        } elseif ($jobseeker['gender'] == 'Male') {
                            echo '👨 Gender';
                        } else {
                            echo '⚧ Gender';
                        }
                        ?>
                    </span>  <span><?= esc($jobseeker['gender']); ?></span>
                </p>
            <?php } ?>

            <?php if (!empty($jobseeker['marital_status'])) { ?>
                <p>
                    <span class="label">👪 Marital Status</span><span><?= ($jobseeker['marital_status'] == 'Never Married')
                            ? 'Single'
                            : esc($jobseeker['marital_status']); ?></span>
                </p>
            <?php } ?>

            <?php if (!empty($jobseeker['mobile_number'])) { ?>
                <p>
                    <span class="label">📞 Mobile No.</span><span> <?= esc($jobseeker['mobile_number']); ?></span>
                </p>
            <?php } ?>

            <?php if (!empty($jobseeker['email'])) { ?>
                <p> <span class="label">📩 Email</span>
                    <span> <?= esc($jobseeker['email']); ?></span>
                </p>
            <?php } ?>

            <?php if (!empty($jobseeker['candidate_full_address'])) { ?>
                <p>
                    <span class="label">🏠 Location</span>
                    <span><?= esc($jobseeker['candidate_full_address']); ?></span>
                </p>
            <?php } ?>

        </div>

    </div>

    <div class="second-right">

     <?php if (!empty($remainingSkills)) { ?>

<div class="section">
    <h4>🛠️ KEY SKILLS (Continued)</h4>

    <?php

    if (strpos($skills, '<ol') !== false) {

        echo '<ol>';

        foreach ($remainingSkills as $skill) {
            echo $skill;
        }

        echo '</ol>';

    } elseif (strpos($skills, '<ul') !== false) {

        echo '<ul>';

        foreach ($remainingSkills as $skill) {
            echo $skill;
        }

        echo '</ul>';

    } else {

        foreach ($remainingSkills as $skill) {
            echo $skill;
        }
    }
    ?>

</div>

<?php } ?>
        <?php if (!empty($jobseeker['publications'])) { ?>
        <div class="section">
            <h4>📚 PUBLICATIONS</h4>
            <?php
            $publications = html_entity_decode($jobseeker['publications']);

          
            if (
                strpos($publications, '<ul') !== false ||
                strpos($publications, '<ol') !== false ||
                strpos($publications, '<li') !== false ||
                strpos($publications, '<p') !== false
            ) {

                echo $publications;

            } else {

                
                $publicationsArray = preg_split('/[\r\n,]+/', $publications);

                echo '<ul>';
                foreach ($publicationsArray as $publi) {
                    $publi = trim(strip_tags($publi));

                    if ($publi != '') {
                        echo '<li>' . esc($publi) . '</li>';
                    }
                }
                echo '</ul>';
            }
            ?>
        </div>
        <?php } ?>
    </div>

    <div class="signature-section">
    <div class="date-box">
        <b>Date:</b> <?= date('d/m/Y'); ?>
    </div>

    <div class="sign-box">
        <b>Signature</b><br><br>

        <?php if(!empty($jobseeker['full_name'])){ ?>
            Dr. <?= esc($jobseeker['full_name']); ?>
        <?php } ?>
    </div>
</div>

</div>
<script>
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});

document.addEventListener('keydown', function(e) {

    // Ctrl+P, Ctrl+S, Ctrl+U
    if (
        (e.ctrlKey && ['p', 's', 'u'].includes(e.key.toLowerCase())) ||
        
        // F12
        e.key === 'F12' ||

        // Ctrl+Shift+I / J / C
        (e.ctrlKey && e.shiftKey &&
            ['i', 'j', 'c'].includes(e.key.toLowerCase()))
    ) {
        e.preventDefault();
        return false;
    }
});
</script>