<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\JobseekerModel;
use App\Models\HomeModel;
use App\Models\TrainingModel;
// use App\Models\AdminModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use CodeIgniter\I18n\Time;
require_once APPPATH . 'ThirdParty/tcpdf/tcpdf.php';
use DateTime;


class TraningController extends BaseController
{
    public function __construct()
    {
        // parent::__construct();
        $this->db = \Config\Database::connect(); // This connects once

    }
    // public function index()
    // {
    //     echo view('jobportal/header');
    //     echo view('jobportal/footer');
    // }

    public function traning_page()
    {
        echo view('jobportal/header');
        echo view('traning/traning_page');
        echo view('jobportal/footer');
    }

  
    
     public function fetch_states()
    {
        $country_id = $this->request->getPost('country_id');

        $db = \Config\Database::connect();
        $states = $db->query(
            "SELECT * FROM tbl_states WHERE country_id = ?", 
            [$country_id]
        )->getResultArray();

        $options = '<option value="">Select State</option>';

        foreach($states as $state){

            // Maharashtra default select
            $selected = ($state['state_name'] == 'Maharashtra') ? 'selected' : '';

            $options .= '<option value="'.$state['state_id'].'" '.$selected.'>'
                        .$state['state_name'].
                        '</option>';
        }

        echo $options;
    }
    public function fetch_districts()
    {
        $state_id = $this->request->getPost('state_id');
        $db = \Config\Database::connect();

        $districts = $db->table('tbl_district')
                        ->where('state_id', $state_id)
                        ->get()
                        ->getResultArray();

        $output = '<option value="">Select District</option>';

        foreach ($districts as $dist) {
            $output .= '<option value="'.$dist['district_id'].'">'.$dist['district_name'].'</option>';
        }

        return $output;
    }

        public function fetch_cities()
        {
            $district_id = $this->request->getPost('district_id');

            $db = \Config\Database::connect();
            $builder = $db->table('cities');
            $builder->where('district_id', $district_id);
            $query = $builder->get();

            $data = $query->getResult();

            return $this->response->setJSON($data);
        }

        // public function traning_enquiry_save()
        // {
        //     $db      = \Config\Database::connect();
        //     $builder = $db->table('tbl_trainer_enquery');

        //     // Collect POST data
        //     $trainerFullName = $this->request->getPost('trainer_full_name');
        //     $trainerEmail = $this->request->getPost('trainer_email');
        //     $data = [
        //         'trainer_full_name'       => $this->request->getPost('trainer_full_name'),
        //         'trainer_mobile_no'       => $this->request->getPost('trainer_mobile_no'),
        //         'trainer_email'           => $this->request->getPost('trainer_email'),
        //         'trainer_gender'          => $this->request->getPost('trainer_gender'),
        //         'country_id'              => $this->request->getPost('country_id'),
        //         'state_id'                => $this->request->getPost('state_id'),
        //         'district_id'             => $this->request->getPost('district_id'),
        //         'city_id'                 => $this->request->getPost('city_id'),
        //         'trainer_address'         => $this->request->getPost('trainer_address'),
        //         'o_id'                    => $this->request->getPost('o_id'),
        //         'traning_type'            => $this->request->getPost('traning_type'),
        //         'appo_date'               => $this->request->getPost('appo_date'),
        //         'appo_time'               => $this->request->getPost('appo_time'),
        //         'type_meeting'            => $this->request->getPost('type_meeting'),
        //         'approx_parpt'            => $this->request->getPost('approx_parpt'),
        //         'expected_time_duration'  => $this->request->getPost('expected_time_duration'),
        //     ];



        //     $builder->insert($data);
        //     $this->sendMailToTrainer($trainerFullName,$trainerEmail);
        //     // Set flashdata for success message
        //     $session = session();
        //     $session->setFlashdata('success', 'Trainer Enquiry submitted successfully!');

        //     // Redirect back to the form page
        //     return redirect()->back();
        // }

        public function traning_enquiry_save()
        {
            $db      = \Config\Database::connect();
            $builder = $db->table('tbl_trainer_enquery');

            $trainer_full_name = $this->request->getPost('trainer_full_name');
            $trainerEmail    = $this->request->getPost('trainer_email');
            $trainer_mobile = $this->request->getPost('trainer_mobile_no');
            $triner_gender = $this->request->getPost('trainer_gender');
            $trainer_country_id = $this->request->getPost('country_id');
            $trainer_state_id = $this->request->getPost('state_id');
            $trainer_district_id = $this->request->getPost('district_id');
            $trainer_city_id = $this->request->getPost('city_id');
            $trainer_address = $this->request->getPost('trainer_address');
            $o_id =$this->request->getPost('o_id');
            $traning_type = $this->request->getPost('traning_type');
            $appo_date = $this->request->getPost('appo_date');
            $appo_time = $this->request->getPost('appo_time');
            $type_meeting = $this->request->getPost('type_meeting');
            $approx_parpt = $this->request->getPost('approx_parpt');
            $expected_time_duration = $this->request->getPost('expected_time_duration');


            $data = [
                'trainer_full_name'       => $trainer_full_name,
                'trainer_mobile_no'       => $trainer_mobile,
                'trainer_email'           => $trainerEmail,
                'trainer_gender'          => $triner_gender,
                'country_id'              => $trainer_country_id,
                'state_id'                => $trainer_state_id,
                'district_id'             => $trainer_district_id,
                'city_id'                 => $trainer_city_id,
                'trainer_address'         => $trainer_address,
                'o_id'                    => $o_id,
                'traning_type'            => $traning_type,
                'appo_date'               => $appo_date,
                'appo_time'               => $appo_time,
                'type_meeting'            => $type_meeting,
                'approx_parpt'            => $approx_parpt,
                'expected_time_duration'  => $expected_time_duration,
            ];

            
                
            $tblCountry = $db->table('tbl_country')->select('country_name')->where('country_id',$trainer_country_id)
            ->get()->getRow();
            $country_name = $tblCountry->country_name;

            $tblState = $db->table('tbl_states')->select('state_name')->where('state_id',$trainer_state_id)->get()->getRow();
            $state_name = $tblState->state_name;

            $tblDistrict = $db->table('tbl_district')->select('district_name')->where('district_id',$trainer_district_id)->get()->getRow();

            $district_name = $tblDistrict->district_name;

            $tblcity = $db->table('cities')->select('name')->where('id',$trainer_city_id)->get()->getRow();
            $city_name = $tblcity->name;

            $tblorganisation = $db->table('tbl_organisation')->select('organisation_name')->where('o_id',$o_id)->get()->getRow();
            $organisation_name = $tblorganisation->organisation_name;
            
            
            
            if ($builder->insert($data)) {

                // ✅ Send email only after successful insert
                $this->sendMailToTrainer($trainer_full_name,$trainerEmail);
                
                $pdf_string = $this->generate_enquiry_pdf($trainer_full_name,$trainer_mobile,$trainerEmail,$triner_gender,$country_name,$state_name,$district_name,$city_name,$trainer_address,$organisation_name,$traning_type,$appo_date,$appo_time,$type_meeting,$approx_parpt,$expected_time_duration);
                $this->sendMailToAdmintrainer($pdf_string);
                
                session()->setFlashdata('success', 'Trainer Enquiry submitted successfully!');
            } else {

                session()->setFlashdata('error', 'Something went wrong. Please try again.');
            }

            return redirect()->back();
        }

        private function sendMailToTrainer($trainer_full_name,$trainerEmail)
        {
            require_once APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
            require_once APPPATH . 'Libraries/PHPMailer/SMTP.php';
            require_once APPPATH . 'Libraries/PHPMailer/Exception.php';

               $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

                try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.hostinger.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Gmail ID
                        $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                // App Password
                        $mail->SMTPSecure = 'tls';                             // or use: PHPMailer::ENCRYPTION_STARTTLS
                        $mail->Port       = 587;
            
                        // ✅ ADD THIS BLOCK to disable SSL verification
                        $mail->SMTPOptions = [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true,
                            ],
                        ];

            $mail->setFrom('training@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
                $mail->addAddress($trainerEmail, $trainer_full_name);

                $message = view('email/trainingmailtemplate', [
                    'trainer_full_name' => $trainer_full_name
                ]);

                $mail->isHTML(true);
                $mail->Subject = "Healthcare Training Program  Enquiry Received";
                $mail->Body    = $message;

                $mail->send();
                echo "Mail sent to: {$trainerEmail}<br>";
                // echo $message;

            } catch (\PHPMailer\PHPMailer\Exception $e) {
                echo "Mail Error for {$trainerEmail}: " . $mail->ErrorInfo . "<br>";
            }
        }
        
        private function generate_enquiry_pdf(
        $trainer_full_name,
        $trainer_mobile,
        $trainerEmail,
        $triner_gender,
        $country_name,
        $state_name,
        $district_name,
        $city_name,
        $trainer_address,
        $organisation_name,
        $traning_type,
        $appo_date,
        $appo_time,
        $type_meeting,
        $approx_parpt,
        $expected_time_duration
        ){
    // $appx_date = date("d M Y", strtotime($appo_date));
if (!empty($appo_date) && $appo_date != '0000-00-00') {
     $appx_date = date("d M Y", strtotime($appo_date));
} else {
     $appx_date ="-";
}
// ====================== time  ==========================

if (!empty($appo_time) && $appo_time != '00:00:00') {
    $appx_time =  date("h:i A", strtotime($appo_time));
} else {
    $appx_time = "-";
}

$pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->AddPage();

// ---------------- HEADER ----------------
// Logo (path change करा)
$logo = FCPATH . 'assets/images/logo.png'; 
if(file_exists($logo)){
    $pdf->Image($logo, 15, 10, 35);
}

$pdf->SetFont('helvetica', 'B', 16);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(0, 15, 'Trainer Enquiry Report', 0, 1, 'R');

$pdf->Ln(5);

// Title Bar
$pdf->SetFillColor(0, 51, 102);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Enquiry Details', 0, 1, 'C', true);

$pdf->Ln(5);

// Reset text color
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 11);

// ---------------- TABLE CONTENT ----------------
$html = <<<HTML
<table cellpadding="8" border="0" width="100%" style="border-collapse: collapse;">
    <tr style="background-color:#f2f2f2;">
        <td width="35%"><b>Full Name</b></td>
        <td width="65%">$trainer_full_name</td>
    </tr>
    <tr>
        <td><b>Mobile Number</b></td>
        <td>$trainer_mobile</td>
    </tr>
    <tr style="background-color:#f9f9f9;">
        <td><b>Email</b></td>
        <td>$trainerEmail</td>
    </tr>
    <tr>
        <td><b>Gender</b></td>
        <td>$triner_gender</td>
    </tr>
    <tr style="background-color:#f9f9f9;">
        <td><b>Organisation</b></td>
        <td>$organisation_name</td>
    </tr>
    <tr>
        <td><b>Training Type</b></td>
        <td>$traning_type</td>
    </tr>
    <tr style="background-color:#f9f9f9;">
        <td><b>Meeting Type</b></td>
        <td>$type_meeting</td>
    </tr>
    <tr>
        <td><b>Appointment Date</b></td>
        <td>$appx_date</td>
    </tr>
    <tr style="background-color:#f9f9f9;">
        <td><b>Appointment Time</b></td>
        <td>$appx_time</td>
    </tr>
    <tr>
        <td><b>Participants</b></td>
        <td>$approx_parpt</td>
    </tr>
    <tr style="background-color:#f9f9f9;">
        <td><b>Expected Duration</b></td>
        <td>$expected_time_duration</td>
    </tr>
    <tr>
        <td><b>Location</b></td>
        <td>$city_name, $district_name, $state_name, $country_name</td>
    </tr>
    <tr style="background-color:#f9f9f9;">
        <td><b>Address</b></td>
        <td>$trainer_address</td>
    </tr>
</table>

<br><br>
<hr>
<p style="font-size:10px;text-align:right;color:#777;">
    Generated on: ".date('d-m-Y H:i')."
</p>
HTML;

$pdf->writeHTML($html, true, false, true, false, '');

// ---------------- FOOTER ----------------
$pdf->SetY(-20);
$pdf->SetFont('helvetica', 'I', 9);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(0, 10, 'This is an auto-generated enquiry report.', 0, 0, 'C');

return $pdf->Output('Trainer_Enquiry_Report.pdf', 'S');
}

    private function sendMailToAdmintrainer($pdf_string)
    {
            require_once APPPATH . 'Libraries/PHPMailer/PHPMailer.php';
            require_once APPPATH . 'Libraries/PHPMailer/SMTP.php';
            require_once APPPATH . 'Libraries/PHPMailer/Exception.php';

                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

                try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.hostinger.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = env('EMAIL_SMTP_USERNAME', ''); // Gmail ID
                        $mail->Password   = env('EMAIL_SMTP_PASSWORD', '');                // App Password
                        $mail->SMTPSecure = 'tls';                             // or use: PHPMailer::ENCRYPTION_STARTTLS
                        $mail->Port       = 587;
            
                        // ✅ ADD THIS BLOCK to disable SSL verification
                        $mail->SMTPOptions = [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true,
                            ],
                        ];

                $mail->setFrom('training@adisindiaplacement.com', 'Adis India Placement Pvt Ltd');
                $mail->addAddress('training@adisindiaplacement.com'); // Admin Email
        
                // ---------------- EMAIL CONTENT ----------------
                $mail->isHTML(true);
                $mail->Subject = "New Trainer Enquiry Submitted";
        
                $mail->Body = '
                <div style="font-family: Arial, sans-serif; font-size:14px; line-height:1.6;">
                    <p>Dear Trainer,</p>
        
                    <p>
                        A new trainer enquiry has been submitted through the website.
                        Please find the attached PDF document containing the complete
                        details provided by the trainer.
                    </p>
        
                    <p>
                        Kindly review the attached document and proceed with the necessary action.
                    </p>
        
                    <br>
                    <p style="color:#777;font-size:12px;">
                        This is an auto-generated email from Adis India Pvt Ltd.
                    </p>
                </div>
                ';
        
                // ---------------- ATTACH PDF STRING ----------------
                $mail->addStringAttachment(
                    $pdf_string,
                    "Trainer_Enquiry.pdf",
                    'base64',
                    'application/pdf'
                );
        
                // ---------------- SEND ----------------
                $mail->send();
        
            } catch (\PHPMailer\PHPMailer\Exception $e) {
                log_message('error', 'Mail error: ' . $e->getMessage());
            }
    }
     public function traningdashboard()
    {
        $session = session();
        // print_r($_SESSION);
        // exit();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }

        $username = session()->get('name');

        // print_r($_SESSION);
        echo view('admin/header');
        echo view('traning/traningdashboard');
        echo view('admin/footer');
         
       // echo "Welcome, $username!";
    // Load dashboard view
    }
    
     public function traning_daily_records()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $TrainingModel = new TrainingModel();
        $db = \Config\Database::connect();
        $AllDailytraingrecords = $TrainingModel->daily_training_records();
        echo view('admin/header');
        echo view('traning/traning_daily_records',['AllDailytraingrecords'=>$AllDailytraingrecords]);
        echo view('admin/footer');

    }

    public function traning_total_records()
    {
        $session = session();
        if (!session()->has('name')) {
        return redirect()->to('admin'); // redirect if not logged in
        }
        $TrainingModel = new TrainingModel();
        $db = \Config\Database::connect();
        $Alltraingrecords = $TrainingModel->all_training_records();
        echo view('admin/header');
        echo view('traning/traning_records',['Alltraingrecords'=>$Alltraingrecords]);
        echo view('admin/footer');
    }
        

  

        


}



