<?php
use CodeIgniter\Router\RouteCollection;
$routes->setAutoRoute(true);
// $routes->setDefaultController('Home');
// $routes->setDefaultMethod('all_login');
/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('/', 'ClientController::index');
$routes->get('recruiter-login', 'Home::all_login');
$routes->post('recruiter-sign-up', 'Home::recruiter_sign_up');
$routes->get('about', 'ClientController::about_us');
$routes->get('gallery', 'ClientController::gallery');
$routes->get('contact_us', 'ClientController::contact_us');
$routes->get('apply-job/(:num)/(:num)','ClientController::apply_candidate_job/$1/$2');
$routes->get('trending-job/(:num)','ClientController::trending_job/$1');
$routes->post('jobseeker-login','ClientController::saveLoginFormCandidate');
$routes->get('client/job_login_otp_front/(:num)/(:num)','ClientController::jobLoginOtpFront/$1/$2');
$routes->post('jobseeker-verify-otp-front', 'ClientController::saVeverifyOtpFront');
$routes->get('client/jobseeker_view_profile/(:num)/(:num)','ClientController::jobseeker_view_profile/$1/$2');
$routes->get('search-job','ClientController::get_search_job');
$routes->get('display-blogs','ClientController::display_blogs');
$routes->get('single_blog_display/(:num)','ClientController::single_blog_display/$1');
$routes->get('award-details/(:num)','ClientController::award_details/$1');
$routes->get('client/jobseeker_profile_front/(:num)/(:num)','ClientController::jobseeker_profile_front/$1/$2');
$routes->get('home-logout', 'ClientController::home_logout');
$routes->get('signup', 'Home::register_form');
$routes->post('home/save_signup', 'Home::save_signup');
$routes->get('home/verify_otp_page', 'Home::verify_otp_page');
$routes->get('home/verify_otp_page/(:any)', 'Home::verify_otp_page/$1');
$routes->post('verify_otp', 'Home::verify_otp');
$routes->get('jobseeker-login', 'Home::jobseeeker_login');
$routes->get('resend_otp', 'Home::resend_otp'); // For GET request recruiter-login
$routes->post('recruiterlogin', 'Home::recruiter_login');
$routes->get('/home/recruter_login_otp', 'Home::recruter_login_otp');
$routes->post('/home/verify_recruter_otp', 'Home::verify_recruter_otp'); 

$routes->get('terms_of_service', 'ClientController::terms_of_service');
$routes->get('privacy', 'ClientController::privacy');
$routes->get('all_jobs', 'ClientController::all_jobs');
$routes->post('contact_save','ClientController::contact_save');


// ================ 01-11-2025 ======================================
$routes->get('client-sign-up/(:num)/(:num)', 'ClientController::signUpCandidate/$1/$2');
$routes->post('client/client-jobseeker-signup', 'ClientController::client_jobseeker_signup');
$routes->get('client-sign-otp_new/(:num)/(:num)', 'ClientController::client_sign_otp_new/$1/$2');
$routes->post('client/verify_client_jobseeker_otp', 'ClientController::verify_client_jobseeker_otp');
$routes->get('client/jobseeker_form_client/(:num)/(:num)','ClientController::jobseeker_form_client/$1/$2');
$routes->post('client/save_jobseeker_form_client', 'ClientController::save_jobseeker_form_client');















// ============================= Recruiter==============================================
$routes->get('/recruiter/register_form', 'RecruiterController::recruterRegistrationForm'); 
$routes->get('logout', 'Home::logout');
$routes->post('/recruiter/save_recruiter_form', 'RecruiterController::save_recruiter_form');
$routes->get('recruiter/recruiter_posting_form', 'RecruiterController::recruiter_posting_form');
$routes->post('recruiter/add_job_role', 'RecruiterController::add_job_role');
$routes->post('recruiter/add_qualification', 'RecruiterController::add_qualification');
$routes->post('get-courses', 'RecruiterController::getCourses');
$routes->post('recruiter/add_course', 'RecruiterController::add_course');
$routes->post('recruiter/add_department', 'RecruiterController::add_department');
$routes->post('recruiter/save_recruiter_posting', 'RecruiterController::saveRecruiterPosting');
$routes->get('recruiter/publishsavedraft', 'RecruiterController::publishsavedraft');
$routes->get('recruiter/preview/(:num)', 'RecruiterController::preview/$1');
$routes->post('recruiter/saveorupdate', 'RecruiterController::saveorupdate');
$routes->post('recruiter/upade_recruiter_posting', 'RecruiterController::upade_recruiter_posting');
$routes->get('recruiter/recruiter_job_responce', 'RecruiterController::recruiter_job_responce');
$routes->get('recruiter/view_job_recruiter', 'RecruiterController::view_job_recruiter');
$routes->get('recruiter/update_recruiter_profile', 'RecruiterController::update_recruiter_profile'); 
$routes->post('recruiter/upload_company_profile', 'RecruiterController::upload_company_profile'); 
$routes->post('recruiter/add_about', 'RecruiterController::add_about'); 
$routes->post('recruiter/edit_recruiter', 'RecruiterController::edit_recruiter'); 
$routes->post('recruiter/add_gallery', 'RecruiterController::add_gallery'); 
$routes->get('recruiter/delete_gallery_item/(:num)', 'RecruiterController::delete_gallery_item/$1');
$routes->post('recruiter/publishstatusupdate', 'RecruiterController::publishstatusupdate');
$routes->get('recruiter/forgot_password', 'RecruiterController::forgot_password');
$routes->post('recruiter/send_reset_link', 'RecruiterController::send_reset_link');
$routes->get('recruiter/reset_password/(:any)', 'RecruiterController::reset_password/$1');
$routes->post('recruiter/update_password', 'RecruiterController::update_password');
$routes->get('recruiter/savedraft_page', 'RecruiterController::savedraft_page');
$routes->get('recruiter/publish_page', 'RecruiterController::publish_page');
$routes->get('recruiter/edit_job_recruiter', 'RecruiterController::edit_job_recruiter');
$routes->post('recruiter/upade_recruiter_posting_new', 'RecruiterController::upade_recruiter_posting_new');
$routes->get('recruiter/preview', 'RecruiterController::preview_recruiter');
$routes->post('recruiter/previewstatusupdate', 'RecruiterController::previewstatusupdate');
//====================== Admin =========================================================
$routes->get('admin', 'AdminController::adminlogin');
$routes->post('loginformadmin', 'AdminController::loginformadmin');
$routes->get('admin/admindashboard', 'AdminController::admindashboard');
$routes->get('admin/logout', 'AdminController::logout');
$routes->get('admin/client_dashboard', 'AdminController::client_dashboard');
$routes->get('admin/client_details', 'AdminController::client_details');
$routes->get('admin/view_recruiter_posting/(:num)', 'AdminController::viewRecruiterPosting/$1');
$routes->post('admin/update_admin_status', 'AdminController::update_admin_status');
$routes->get('admin/apply_canidate_records/(:num)/(:num)', 'AdminController::apply_canidate_records/$1/$2');
$routes->get('admin/candidate_details', 'AdminController::candidate_details'); 
$routes->get('admin/candidateClosedDetailsData', 'AdminController::display_total_closed_candidate'); 
$routes->get('admin/add_blogs','AdminController::Add_blogs'); 
$routes->get('admin/display_blogs','AdminController::display_blogs');
$routes->post('save-blog', 'AdminController::save_blog');
$routes->post('admin/delete_blog/(:num)', 'AdminController::delete_blog/$1');
$routes->get('admin/edit_blog/(:num)', 'AdminController::edit_blog/$1');
$routes->post('update-blog', 'AdminController::update_blog');
$routes->get('admin/add-employer','AdminController::add_employers'); 
$routes->post('save-employer', 'AdminController::saveEmployeer');
$routes->post('check-institute', 'AdminController::checkInstitute');
$routes->post('admin/get_pincode','AdminController::display_pincode');
$routes->get('admin/add_post_vacuncy/(:num)','AdminController::add_post_vacuncy/$1');
$routes->get('admin/edit-emp/(:num)','AdminController::edit_emp/$1');
$routes->post('update-emp', 'AdminController::update_emp');
$routes->get('admin/delete-emp/(:num)','AdminController::delete_emp/$1');
$routes->post('save-post-vacuncy', 'AdminController::savePostvacuncy');
$routes->post('admin/upload_company_profile', 'AdminController::upload_company_profile');
$routes->get('admin/admin_signup_recruiter', 'AdminController::admin_signup_recruiter');
$routes->get('admin/add_recruiter_front/(:num)','AdminController::add_recruiter_front/$1');
$routes->post('admin/save-front-employer','AdminController::save_front_employer');
$routes->get('admin/daily-count','AdminController::daily_count'); 
$routes->get('admin/all-post-vacancies','AdminController::all_post_vacancies'); 
$routes->get('admin/all-closed-client-details','AdminController::all_closed_client_details');
$routes->get('admin/closed-vacuncies-details','AdminController::closed_vacuncies_details');
$routes->post('admin/add_city','AdminController::add_city');

$routes->get('admin/signup_admin_candidate','AdminController::signup_admin_candidate');
$routes->get('admin/registration_admin_candidate','AdminController::registration_admin_candidate');
$routes->get('admin/daily_admin_candidate','AdminController::daily_admin_candidate');
$routes->get('admin/interview_schedule_candidate','AdminController::interview_schedule_candidate');
$routes->get('admin/hold_candidate','AdminController::hold_candidate');
$routes->get('admin/reject_candidate','AdminController::reject_candidate');
$routes->get('admin/apply_candidate_admin','AdminController::apply_candidate_admin');

$routes->get('admin/edit-post-vacuncy/(:num)','AdminController::edit_post_vacuncy/$1');
$routes->post('update-posting-form', 'AdminController::update_posting_form');
$routes->get('admin/delete-post-vacuncy/(:num)','AdminController::delete_post_vacuncy/$1');

$routes->post('admin/fetch_states','AdminController::fetch_states');
$routes->post('admin/fetch_districts','AdminController::fetch_districts');
$routes->post('admin/fetch_cities','AdminController::fetch_cities');

$routes->post('admin/fetch_states_edit','AdminController::fetch_states_edit');
$routes->post('admin/fetch_districts_edit','AdminController::fetch_districts_edit');
$routes->post('admin/fetch_cities_edit','AdminController::fetch_cities_edit');
$routes->get('admin/delete-candidate-signup/(:num)','AdminController::delete_candidate_signup/$1');
$routes->get('admin/edit-candidate/(:num)','AdminController::edit_candidate/$1');
$routes->post('update-candidate', 'AdminController::update_candidate');

// =============== 11-11-2025 ========================================
$routes->get('admin/billing_dashboard', 'AdminController::billing_dashboard');
$routes->get('admin/billing_admin_closed_vacuncy', 'AdminController::billing_admin_closed_vacuncy');
$routes->get('admin/edit-conformed-salary/(:num)','AdminController::edit_conformed_salary/$1');
$routes->post('update-conformed-salary-form', 'AdminController::update_conformed_salary_form');
$routes->get('admin/billing-sent-invoice', 'AdminController::billing_sent_invoice');
$routes->get('generate-pdf/(:num)', 'AdminController::generate_pdf/$1');
$routes->get('client-reg-recip-pdf/(:num)', 'AdminController::client_reg_recip_pdf/$1');
$routes->get('admin/client-agreement-details', 'AdminController::client_agreement_details');
$routes->get('admin/edit_agreement_emp/(:num)','AdminController::edit_agreement_emp/$1');
$routes->post('update-agreement-form', 'AdminController::update_agreement_form');
$routes->get('client-agreement-pdf/(:num)', 'AdminController::client_agreement_pdf/$1');
$routes->post('admin/update_admin_email_status','AdminController::update_admin_email_status');

$routes->get('admin/edit-recived-client-payment/(:num)','AdminController::edit_recived_client_payment/$1');
$routes->post('update-client-recived-form', 'AdminController::update_client_recived_form');
$routes->post('admin/update_recived_client_payment_status','AdminController::update_recived_client_payment_status');
$routes->get('admin/recived_payment_status', 'AdminController::recived_payment_status');
$routes->get('admin/pending_client_payment', 'AdminController::pending_client_payment');
$routes->get('admin/paid_payment_client', 'AdminController::paid_payment_client');
$routes->get('admin/free_payment_client', 'AdminController::free_payment_client');
$routes->get('admin/advance_payment_client','AdminController::advance_payment_client');
$routes->get('admin/total_years_count_billing','AdminController::total_years_count_billing');
$routes->post('admin/total_years_count_billing', 'AdminController::total_years_count_billing');

$routes->post('admin/update_client_email_status','AdminController::update_client_email_status');
$routes->post('admin/update_Resume_Client_email_Status','AdminController::update_Resume_Client_email_Status');

$routes->post('admin/tblUserOtpStatus','AdminController::tblUserOtpStatus');
// =========== 09-01-2026 ===================================
$routes->get('advanced-payment-recip-pdf/(:num)', 'AdminController::advanced_payment_recip_pdf/$1');
// ================ 13-01-2026 ====================================

$routes->get('candidate-agreement-pdf/(:num)', 'AdminController::candidate_agreement_pdf/$1');
// ==================== 16-01-2025 ======================================================
$routes->get('admin/edit-candidate-agreement-salary/(:num)/(:num)','AdminController::edit_candidate_agreement_salary/$1/$2');
$routes->post('update-candidate-agreement','AdminController::update_candidate_agreement');

// ==================== 22-01-2026 ==========================================

$routes->get('admin/contact_details','AdminController::contact_details');



$routes->post('admin/sendagreementCandidate','AdminController::sendagreementCandidate');

$routes->get('admin/candidate_agreement_deatil','AdminController::candidate_agreement_deatil');

$routes->get('admin/delete-contact/(:num)', 'AdminController::delete_contact/$1');

$routes->post('upload-agreement-ajax', 'AdminController::uploadAgreementAjax');


$routes->post('admin/update-ChangeToggle-status','AdminController::update_ChangeToggle_status');
$routes->get('admin/award_recon','AdminController::award_recon');
$routes->post('save-award', 'AdminController::save_award');
$routes->get('admin/display_award_recon','AdminController::display_award_recons');
$routes->post('admin/delete_award/(:num)', 'AdminController::delete_award/$1');
$routes->get('admin/edit_award/(:num)', 'AdminController::edit_award/$1');
$routes->post('update-award', 'AdminController::update_award');

$routes->post('admin/add_lead_url','AdminController::add_lead_url');

$routes->get('admin/insurancy_policy_data','AdminController::insurancy_policy_data');

// ============================02-07-2026 ============================================


$routes->get('admin/edit-candidate-form-id/(:num)','AdminController::edit_candidate_form_id/$1');
$routes->post('update_signup_candidate_new','AdminController::update_signup_candidate_new');


// ============================= Jobseekar ==============================================
$routes->post('jobseeker/Saveloginform', 'JobseekerController::Saveloginform');
$routes->get('jobseeker/job_login_otp', 'JobseekerController::job_login_otp');
$routes->post('jobseeker/verify_jobseeker_otp', 'JobseekerController::verify_jobseeker_otp');
$routes->get('jobseeker/jobseeker_form','JobseekerController::jobseeker_form');
$routes->get('jobseeker/logout_jobseeker', 'JobseekerController::logout_jobseeker');
$routes->post('jobseeker/save_jobseeker_form', 'JobseekerController::save_jobseeker_form');
$routes->get('jobseeker/jobseeker_profile', 'JobseekerController::jobseeker_profile'); 
$routes->get('jobseeker/update_jobseeker_profile','JobseekerController::update_jobseeker_profile');
$routes->get('jobseeker/jobseeker_recruiter_profile/(:num)/(:num)/(:num)/(:num)', 'JobseekerController::jobseeker_recruiter_profile/$1/$2/$3/$4');
$routes->post('jobseeker/apply_job','JobseekerController::apply_job');
$routes->post('jobseeker/save_job','JobseekerController::save_job');
$routes->post('jobseeker/update_jobseeker','JobseekerController::update_jobseeker');
$routes->get('jobseeker/jobseeker_save_jobs','JobseekerController::jobseeker_save_jobs');
$routes->get('jobseeker/jobseeker_applied_jobs','JobseekerController::jobseeker_applied_jobs');

$routes->post('jobseeker/new_Saveloginform', 'JobseekerController::new_Saveloginform');
$routes->get('jobseeker/job_login_otp_new', 'JobseekerController::job_login_otp_new');
$routes->post('jobseeker/jobseeker_new_login','JobseekerController::jobseeker_new_login');
$routes->get('jobseeker/forgot_password','JobseekerController::forgot_password');
$routes->post('jobseeker/send_reset_link', 'JobseekerController::send_reset_link');
$routes->post('jobseeker/update_password', 'JobseekerController::update_password');
$routes->get('jobseeker/reset_password_jobseeker/(:any)','JobseekerController::reset_password_jobseeker/$1');
// ====================11-04-2026  =============//
$routes->post('jobseeker/new_send_jobseeker', 'JobseekerController::new_send_jobseeker');
// ========================== 27-06-2026 ==============================================//
$routes->get('jobseeker/resume_builder', 'JobseekerController::resume_builder');
$routes->get('jobseeker/free_download_resume', 'JobseekerController::free_download_resume');

$routes->get('resume-preview', 'JobseekerController::resumePreview');
$routes->get('resume-gold-download', 'JobseekerController::resume_gold_download');



$routes->get('cron/send-vacancy-mail', 'Cron::sendVacancyMail');

$routes->post('google-login','JobseekerController::googleLogin');

$routes->post('jobseeker/save_resume_home_form', 'JobseekerController::save_resume_home_form');

// ================================= Training Controller =======================================================
$routes->get('traning-page','TraningController::traning_page');
$routes->post('fetch_states','TraningController::fetch_states');
$routes->post('fetch_districts','TraningController::fetch_districts');
$routes->post('fetch_cities','TraningController::fetch_cities');
$routes->post('traning_enquiry_save', 'TraningController::traning_enquiry_save');
$routes->get('mailer-page','TraningController::mailer_image');
$routes->get('traning/traningdashboard','TraningController::traningdashboard');
$routes->get('traning/traning_daily_records','TraningController::traning_daily_records');
$routes->get('traning/traning_total_records','TraningController::traning_total_records');

$routes->get('resume-builder-home', 'JobseekerController::resumeBuilderHome');




