<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    return "Cache is cleared";
});
Route::get('/get-order-status/{pid}/{event}','OrderController@alertOrderStatus');

Auth::routes();

Route::get('/', function () {
    return Redirect('login');
});

Route::get('/baa', function () {
    return view('baa.baa');
})->middleware('auth');

Route::get('/rppa', function () {
    return view('baa.rppa');
})->middleware('auth');

Route::post('agreement','PracticeController@agreement')->middleware('auth')->name('agreement');

Route::post('update-drug-position','PracticeController@updateDrugPosition')->name('update-drug-position');
Route::post('rp_agreement','PracticeController@rp_agreement')->middleware('auth')->name('rp_agreement');

Route::post('rppa_admin','PracticeController@rp_admin_agreement')->middleware('auth')->name('rppa_admin');

Route::post('baa_admin','PracticeController@baa_admin_agreement')->middleware('auth')->name('baa_admin');

Route::get('download_agreement/{aid}/{type}', 'PracticeController@download_agreement')->middleware('auth');

Route::group(['middleware' => ['auth','baa']], function () {

     //list of BAA signed practices
Route::get('signed', 'PracticeController@getSignedPractices');
Route::get('view-baa/{id}', 'PracticeController@showBAA');
Route::get('view-rppa/{id}', 'PracticeController@showRPPA');
Route::get('edit-rppa/{id}', 'PracticeController@editRPPA');
Route::get('edit-baa/{id}', 'PracticeController@editBAA');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/resend-enrollment/{pid}', 'PatientController@send_enrollment_message');
Route::resource('patient','PatientController');
Route::get('patient-search','PatientController@searchPatient');
Route::post('patient-search','PatientController@searchPatient');
Route::get('patient/order/{id}/{oid?}','PatientController@patientOrder')->name('patient-order');

Route::match(['get', 'post'], 'report/client_dashboard/', 'ReportsController@client_dashboard');

Route::match(['get', 'post'], 'report/all_cwp_act/', 'ReportsController@all_compliance_activity');


Route::post('report/generate', 'ReportsController@get_report');

/**  Overview Routes */
Route::get('overview', 'DashboardController@overview');

Route::get('get-pharmacies','DashboardController@get_pharmacies');

/**  Sponser Routes */
Route::get('sponser-maintenance','BannerController@bannerListing');

Route::post('sponsor-addupdate','BannerController@sponsorsAddUpdate');

Route::match(['get', 'post'],'admin/search-all', 'PracticeController@searchAllAccess')->name('search-all');







/**  Drug Routes */

Route::get('drug-maintenance/{id?}', 'DrugController@practiceDrugListing');
Route::get('/drug/list', 'DrugController@index');
Route::get('/drug-search-maintenance', 'DrugController@drugSearch');
Route::post('/drug/add-update', 'DrugController@addUpdate');
Route::get('/get-drug-cat/{type?}','DrugController@drugCat');


/** ADD EDIT GROUP */
Route::post('/group/add-update', 'PracticeController@groupAddUpdate');
Route::get('/get-group-detail/{id}', 'PracticeController@getGroupDetail');
Route::get('/get-all-groups', 'PracticeController@getAllGroups');

/** ADD EDIT PRAACTICE */
Route::post('/practice/add-update', 'PracticeController@practiceAddUpdate');
Route::post('/check-user-mail','CommonMethodController@checkUserEmail')->name('check-user-mail');
Route::get('/get-practice/{id}', 'PracticeController@getParacticeDetails');

Route::post('/check-practice-code','CommonMethodController@checkPracticeCode')->name('check-practice-code');
Route::post('/check-practice-phone','CommonMethodController@checkPracticePhone')->name('check-practice-phone');
Route::post('/check-license-number','CommonMethodController@checkPracticeLicenseNumber')->name('check-license');
Route::post('/check-email','CommonMethodController@checkEmail')->name('check-email');
Route::post('/check-zip','CommonMethodController@checkZip')->name('check-zip');
Route::post('/check-phone','CommonMethodController@checkPhone')->name('check-phone');



Route::post('check-email-update','CommonMethodController@check_email_update')->name('check_email_update');
Route::post('check-phone-update','CommonMethodController@check_phone_update')->name('check_phone_update');

// order Routes
Route::get('get-pres-name','OrderController@getPresName');
Route::get('check-rx-number','CommonMethodController@checkRxNumber')->name('check_rx_number');
Route::get('/drug-search', 'DrugController@orderSearchDrug');
Route::get('/get-saving-offers', 'DrugController@getSavingOffers');
Route::post('/send-edits-to-hcp', 'OrderController@sendEditsToHcp');
Route::post('/alter-order-lower-cost', 'OrderController@alterOrderLowerCost');
Route::get('search-drug-marketer','DrugController@searchDrugMarketer');
Route::get('search-drug-strength','DrugController@searchDrugStrength');
Route::get('search-drug-lower-cost','DrugController@searchDrugLowerCost');
Route::get('get-pres-name','OrderController@getPresName');
Route::get('get-hcp-comments/{id}','OrderController@getHcpComments');
Route::post('/add-hcp-comments', 'OrderController@addHcpComments');
Route::resource('order','OrderController');


// patient request
Route::match(['GET', 'POST'],'/orders/{id?}', 'OrderController@show')->name('orders');
Route::get('specific-patient-orders/{id}','OrderController@specificPatientOrders')->name('specific_patient_orders');
Route::post('/patient/request-process', 'PatientController@patientRequestProcess')->name('patient-request-process');
Route::post('patient/refill', 'PatientController@refillNow');
// patient prifile info


Route::get('get-patinet-info','OrderController@getPatineInfo')->name('get-patient-info');
Route::get('update-patient-info','OrderController@updatePatientInfo')->name('update-patient-info');
Route::post('save-answer','OrderController@orderAnswer')->name('save-answer');
Route::post('save-card-image','OrderController@saveCardImage')->name('save-card-image');
Route::get('get-patient-details','ReportsController@getPatientInfo');
Route::post('/create-refill-order', 'OrderController@refillOrderRequest');
Route::get('/create-enrollment-refill-order/{id?}/{token?}', 'OrderController@refillOrderEnrollmentRequest');

Route::get('patient/enroll/{key}/{id}','PatientController@enrollPatient');
//Reports
Route::match(['get', 'post'], 'report/user-statistics','PracticeController@userStatistic');

Route::post('/get_categories_by_post', 'PracticeController@get_categories');
Route::post('add-ordersheet', 'PracticeController@saveOrderSheet');
Route::post('add-drugcategory', 'PracticeController@saveDrugCategory');
Route::post('add-ordersheet-drug', 'PracticeController@saveOrderSheetDrug');
Route::get('get-sheetcategories/{id}','PracticeController@getOrderSheetCategories');
Route::get('get-sheetcategory-drugs/{id}','PracticeController@getOrderSheetDrugs');
Route::get('view-ordersheet/{id}','PracticeController@viewOrderSheet');
Route::get('delete-ordersheet/{id}','PracticeController@deleteOrderSheet');
Route::get('delete-sheetcategory/{id}','PracticeController@deleteSheetCategory');
Route::get('delete-sheetdrug/{id}','PracticeController@deleteSheetDrug');

Route::match(['get', 'post'], 'report/client-dashboard/{web_stat?}', 'PracticeController@clientDashboard');
Route::match(['get', 'post'], 'report/accounting', 'ReportsController@accountingReport');
Route::post('report/search-rxno','ReportsController@searchRxNo');
Route::post('report/search-rx-details','ReportsController@searchRxDetails');
Route::post('report/email-invoice-accounting', 'ReportsController@send_invoice');
Route::get('report/print-invoice-accounting', 'ReportsController@print_inovice_accounting');
Route::get('report/print-fax-accounting/{id}', 'ReportsController@printFaxAccounting');
Route::get('report/download-invoice', 'ReportsController@downloadInvoice');


});

Route::get('delete-card','OrderController@deleteCard');
Route::get('edit/order','OrderController@editOrder');
Route::post('general/question-thread','OrderController@generalQuestionThread');
Route::get('practice/acknowledge/{id}/{type}','PracticeController@acknowledgePractice');

Route::post('delete-drug', function(){
    if(!empty(Request::post('d_id')))
    {
        $query = \App\Drug::where('id', Request::post('d_id'))->delete();
        if($query){ echo 1; }else{ echo 2; }
    }
})->name('delete-drug');

Route::get('/update-session-practice/{id?}', function ($id=false) {

    if($id)
    {
        $practices = App\Practice::where('id', $id )->with('users')->first();

        Session::put('practice', $practices);
        if(auth::user()->hasRole('super_admin')||auth::user()->hasRole('practice_super_group'))
        return redirect()->to('patient');
        else
        return redirect()->to('overview');
    }else{ Session::forget('practice');
        if(auth::user()->hasRole('super_admin') || auth::user()->hasRole('practice_super_group') )
        return redirect()->to('patient');
        else
        return redirect()->to('overview');
         }

})->name('update_session_practice');





Route::get('send-message/{mobileNumber}','OrderController@sendMessage');

Route::get('/get-order-reporter','OrderController@get_precription_by_id');




/**   Clinical advisory   */
Route::post('clinical-addupdate','OrderController@clinicalAddUpdate');

/*Accounting Export*/
Route::post('accounting/export','ReportsController@accountingExport');





Route::post('/get-precription', 'OrderController@get_precription_by_id')->name('get-precription');


Route::get('our-terms',function(){
    return view('static-pages.our_terms');
});

Route::get('privacy-policy',function(){
    return view('static-pages.privacy');
});

Route::post('update-tote-board', 'OrderController@updateMobileOrderStatus');

Route::get('/survey/home', 'SurveyController@index');
Route::get('/survey/report', 'SurveyController@reports');
Route::POST('/survey/get-report-data', 'SurveyController@getReportData');
Route::get('/get-survey-report', 'SurveyController@getSurveyReport');
Route::get('/get-survey-recipients/{survey_id}/{question_id}/{option_id}', 'SurveyController@getSurveyRecipients');
Route::get('/survey/inventory', 'SurveyController@inventory');
Route::get('/survey/edit-copy', 'SurveyController@editSurvey');
Route::post('/survey/edit-copy', 'SurveyController@copyEdit');
Route::get('/survey/questions/{id}/{category}', 'SurveyController@selectQuestions');
Route::post('/survey/save-questions', 'SurveyController@saveQuestions');
Route::post('/survey/delete-image', 'SurveyController@deleteImage');
Route::get('/survey/delete-survey/{id}', 'SurveyController@deleteSurvey');
Route::get('/survey/send-survey/{id}', 'SurveyController@sendSurvey');
Route::post('/survey/send-survey', 'SurveyController@saveSendSurvey');
Route::post('/get-pracatices', 'SurveyController@getPractices');
Route::post('/get-drugs', 'SurveyController@getDrugs');
Route::post('/get-marketer', 'SurveyController@getMarketer');
Route::post('/get-minor-theraputic', 'SurveyController@getMinorTheraputic');
Route::post('/get-prescriber', 'SurveyController@getPrescriber');
Route::post('/get-rxno', 'SurveyController@getRxNo');
Route::post('/get-refills', 'SurveyController@getRefillsRemaining');
Route::post('/get-phonenumbers', 'SurveyController@getPhoneNumbers');
Route::post('/get-patient-records', 'SurveyController@getPatientRecords');
Route::post('/get-surveys', 'SurveyController@getSurveys');
Route::post('/send-bulk-surveys', 'ReportsController@sendBulkSurveys');
Route::post('/send-refill-bulk-reminders', 'ReportsController@sendBulkReminders');
Route::post('/send-message-patient', 'ReportsController@sendMessagePatient');
Route::post('/send-bulkrx-surveys', 'ReportsController@sendBulkRxSurveys');
Route::resource('survey', 'SurveyController');


Route::get('/chat', 'ChatsController@index');
Route::get('messages', 'ChatsController@fetchMessages');
Route::post('messages', 'ChatsController@sendMessage');

Route::get('report/sponsor_drug','ReportsController@sponsor_drug');
Route::post('drug/remove_sponsored','DrugController@remove_sponsored');
Route::post('import/drug','BannerController@importDrug');
Route::post('import/survey-patients','SurveyController@importSurveyPatients');

Route::get('/leave-and-removechat/{id?}', 'ChatsController@leaveAndRemoveChat');
Route::get('/end_chat_by_admin/{id}', 'ChatsController@leaveAndRemoveChatbyadmin');
Route::get('/contacts', 'ChatsController@get');

Route::get('/contacts_admin/{id?}', 'ChatsController@get_contacts_for_admin');

Route::get('/contact_pharmacy', 'ChatsController@get_pharmacy_session');
Route::get('/conversation/{id?}', 'ChatsController@getMessagesFor');
Route::post('/conversation/send', 'ChatsController@send');

Route::post('startSession', 'ChatsController@startSession');
Route::post('send_first_request', 'ChatsController@sendPracticeRequest');


Route::get('print-order', 'OrderController@orderPrint');
Route::post('delete-hcp-order', 'OrderController@deleteHcpOrder');
Route::get('check-ndc-number','CommonMethodController@checkNdcNumber')->name('check_ndc_number');
Route::resource('permissions', 'PermissionsController');
Route::resource('modules', 'ModulesController');
Route::resource('roles', 'RolesController');
Route::resource('user-roles', 'UserRolesController');

Route::get('get_base_fee','PracticeController@getBaseFee');

Route::get('report/zero_refill/{download?}', 'ReportsController@zero_refill_remainings_orders');
Route::get('report/near_expiration/{download?}', 'ReportsController@near_expiration');
Route::match(['GET', 'POST'], 'report/pat_out_pocket/{download?}', 'ReportsController@pat_out_pocket');
Route::match(['GET', 'POST'], 'report/query_setup', 'ReportsController@querySetupReport');
Route::post('/get-query-setup-filter', 'ReportsController@getQuerySetupFilters');

Route::get('report/comp_report/least_medication', 'ReportsController@least_medication');

Route::get('report/comp_report/best_medication', 'ReportsController@best_medication');

Route::get('report/comp_report/greater_sixty_days', 'ReportsController@greater_sixty_days');

Route::get('report/comp_report/forty_to_fiftynine_days', 'ReportsController@forty_to_fiftynine_days');

Route::get('report/get_report_statistics/{rx_number}', 'ReportsController@get_statistics');

Route::get('/reports/categories', 'ReportsController@get_leftmenu_cats');

Route::get('/reports/orders_by_minor/{minor_cat}', 'ReportsController@get_leftmenu_orders');


Route::get('/reports/rating/{order_id}', 'ReportsController@get_order_rating_by_id');

/** ADD EDIT FACILITATOR */
Route::post('/facilitator/add-update', 'RolesController@facilitatorAddUpdate');
Route::get('/get-facilitator-detail/{id}', 'RolesController@getFacilitatorDetail');
Route::get('/get-all-facilitators', 'RolesController@getAllFacilitators');

Route::get('report/refills-due','ReportsController@refills_due_tab');


Route::get('querytest',function(){

   $ab = \App\User::find(468);//->practices();
dd($ab);

    $pusr=\App\User::where('email','hafizhassanimtiaz@gmail.com')->whereHas('practices',function($q){
        $q->where('practice_id','=',576);
    })->first();
dd($pusr);

  $practicObj =  \App\Practice::find(1);

  $user = \App\User::find(1);

if($user){
$p = $practicObj->users()->attach($user);
}

dump($p);




$a = \App\User::where('email','hafizhassanimtiaz@gmail.com')->whereHas('roles', function ($query) {
    return $query->where('role_id', '!=', 3);
})->first();




dump($a);





if($a){
    echo "yes";
return $a;
}






if(!is_null($a)){
    echo "yes";
return $a;
}
});



/////////////// Qamar Code /////////////////////////
Route::get('/report/pip_market', 'PipReportController@pip_market');

Route::post('/report/get_law_orders', 'PipReportController@get_cases_detail_by_law_practice_id');

Route::get('/report/pip_investment', 'PipReportController@pip_investment');

Route::post('/report/submit_investment', 'PipReportController@submit_investment');

Route::get('/report/investment_list', 'PipReportController@investment_list');

Route::post('/report/investment_detail', 'PipReportController@get_quarter_investment_by_practice_quarter');


Route::match(['get', 'post'], '/report/get_fax_view', 'PipReportController@fax_view_invoice');


Route::get('/report/pip_invoice_download', 'PipReportController@downloadInvoice');

Route::get('/report/pip_invoice_print', 'PipReportController@print_inovice_accounting');

Route::post('/report/email-invoice-pip', 'PipReportController@send_invoice_pip');

Route::post('/report/email_prescription', 'PipReportController@send_precription_pip');

Route::post('order-listing','OrderController@orders_listing');

Route::post('practice-drug-listing','DashboardController@practice_drug_listing');


Route::post('similar-drug-filter','DrugController@similar_drug_filter');

