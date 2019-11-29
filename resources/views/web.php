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

/* ------------------ Sales Team URLs ----------- */
Route::group(['prefix' => 'sales/{role}','middleware' => ['auth'] ], function(){
	Route::get('dashboard','SalesTeamController@dashboard')->name('sl.dashboard'); 
	Route::get('leave-management','LeaveManageController@leave_mng')->name('sl.leave_mng');
	Route::get('salary','EmployeeController@salary')->name('sl.salary'); 
	Route::get('apply-leave', 'LeaveManageController@apply_leave')->name('sl.apply_leave');
	Route::get('my-leaves','LeaveManageController@my_leaves')->name('sl.my_leave'); 
	Route::post('apply-leave', 'LeaveManageController@apply_leavePost');
	Route::get('password-management','EmployeeController@password_mng')->name('sl.pw_mng');
	Route::get('holiday-calender', 'SalesTeamController@calender')->name('sl.holiday');
	Route::get('send-eod','EODController@send_sales_eods')->name('sl.send_eod');
	Route::post('send-eod','EODController@send_sales_eods_save')->name('sl.send_eodPost');      
	Route::get('eod-list','EODController@sales_eods')->name('sl.eods'); 
	Route::get('projects','SalesTeamController@projects_list')->name('sl.projects');
	Route::get('profile','SalesTeamController@profile')->name('sl.profile'); 
	Route::get('edit-profile','EmployeeController@getProfileEdit')->name('sl.edit_profile');    
	Route::post('edit-profile', 'EmployeeController@postProfileEdit');        
});

Route::get('viewpayroll', 'PayrollController@view_payroll')->name('viewpayroll');
Route::get('calculate-monthly-salary', 'SalaryManageController@calculate_salary');
Route::group(['prefix' => '{role}' ], function(){
       Route::get('apply-leave', 'LeaveManageController@apply_leave')->name('cm.apply_leave');
	   Route::post('apply-leave', 'LeaveManageController@apply_leavePost');
	   Route::get('my-leaves','LeaveManageController@my_leaves')->name('em.my_leave');
	   Route::get('leave-listing','LeaveManageController@leave_list')->name('cm.leave_list');
	   Route::get('leave-info/{id?}','LeaveManageController@leave_info')->name('cm.leave_info');
	   Route::post('action-leave','LeaveManageController@changeleavestatus')->name('cm.change_leave_status');
	   Route::get('leave-retract','LeaveManageController@retract_leave')->name('em.retract_leave');
	   Route::get('retract-leave', 'LeaveManageController@retract_leave_list');
	  /*===================================== Project Routes ================================== */
	   Route::get('all-projects','ProjectManageController@project_lists')->name('cm.project_list');
	   Route::get('add-new-project','ProjectManageController@add_project')->name('cm.add_project');
	   Route::get('edit-project/{id}','ProjectManageController@add_project')->name('cm.edit_project');
	   Route::post('save-project','ProjectManageController@save_project')->name('cm.save_project');
	   Route::get('project-info/{id}','ProjectManageController@project_details')->name('cm.project_info');
	   Route::get('add-support-project/{project}','ProjectManageController@new_support_project')->name('cm.new_support_project');
	   Route::post('add-support-project','ProjectManageController@add_support_project')->name('cm.add_support_project');
	   Route::get('view-new-support','ProjectManageController@view_new_support')->name('cm.view_new_support');
	   Route::get('add-dedicated-project/{project}','ProjectManageController@new_dedicated_project')->name('cm.new_dedicated_project');
	   Route::post('save-dedicated-project','ProjectManageController@save_dedicated_project')->name('cm.save_dedicated_project');
	   Route::get('add-fixed-project/{project}/{fix_id?}','ProjectManageController@add_fixed_project')->name('cm.add_fixed_project');
	   Route::get('edit-fixed-project/{project}/{fix_id?}','ProjectManageController@add_fixed_project')->name('cm.edit_fixed_project');
	   Route::post('add-fixed-project','ProjectManageController@save_fixed_project')->name('cm.save_fixed_project');
	   Route::get('update-fixed-project/{project}','ProjectManageController@edit_all_fixed')->name('cm.edit_all_fixed');
	   Route::post('update-fixed-project','ProjectManageController@edit_all_fixedPost')->name('cm.edit_fixed');

	   Route::get('assign-project','ProjectManageController@assign_project')->name('cm.assign_project');
	   Route::post('assign-project','ProjectManageController@assign_projectPost')->name('cm.assign_project');
	   Route::get('get-project-emp-list','ProjectManageController@get_project_emp')->name('cm.get_project_emp');
	   Route::get('view-project-team/{project?}','ProjectManageController@view_project_team')->name('cm.view_project_team');
	   Route::get('assign-update','ProjectManageController@assign_update_page')->name('cm.assign_update_page');
	   Route::post('assign-update','ProjectManageController@assign_updatePost')->name('cm.assign_update_page');
	   Route::get('project-history/{project?}','ProjectManageController@project_history')->name('cm.project_history');
	   Route::get('my-projects','ProjectManageController@my_project')->name('cm.my_project');

	   Route::get('add-reminder','ProjectManageController@new_reminder')->name('cm.add_reminder');
	   Route::post('add-reminder','ProjectManageController@save_reminder')->name('cm.add_reminder');

	   Route::get('password-management','EmployeeController@password_mng')->name('cm.pw_mng');
	   Route::get('leave-management','LeaveManageController@leave_mng')->name('cm.leave_mng');
	   /*===================================== Project Routes ================================== */

	/*===================================== EODS Routes ================================== */
	     Route::get('send-eod','EODController@send_eods')->name('cm.send_eod');
	     Route::post('send-eod','EODController@save_eods')->name('cm.send_eod');
	     Route::get('see-team-eod', 'EODController@getSeeTeamEOD')->name('cm.team_eods');
	     Route::get('eods-details', 'EODController@eod_details')->name('admin.eod_details');
	/*===================================== EODS Routes ================================== */

	  /*===================================== Payrolls Routes ================================== */

		     Route::get('payrolls-employees-list','PayrollController@adminPayrollsEmp')->name('a.ePayroll');
		     Route::get('payrolls-list/{id}','PayrollController@payslipLists')->name('c.payroll');     
			 Route::get('payrolls-details/{id?}','PayrollController@payrollDetails')->name('c.payrolldetails'); 
			 Route::get('payroll-view', function(Request $request){ return view('common.payroll.dateview'); })->name('c.payrollview'); 

			 Route::get('payroll-view','PayrollController@view_ern')->name('ern_page');
			 Route::post('save_income_deduction','PayrollController@save_income_deduction')->name('save_income_deduction');
			 Route::post('delete_earning_deduction','PayrollController@delete_earning_deduction')->name('delete_earning_deduction');
			 Route::post('recalculate','PayrollController@recalculate')->name('recalculate');
			 Route::post('download_payslip','PayrollController@get_payslip_details_by_id')->name('download_payslip');
			 Route::get('payment-status','PayrollController@changePaymentStatus')->name('payment_status'); 
			 
			 /*===================================== Payrolls Routes ================================== */ 

	Route::get('setting','SettingController@setting')->name('setting');
	Route::post('setting','SettingController@setting_post')->name('setting');
	Route::post('add_setting','SettingController@add_setting')->name('add_setting');
 
});
Route::get('payroll-pages/{type}','PayrollController@payroll_pages')->name('payroll_pages');
Route::get('payroll-status','PayrollController@changePayRollStatusEmp')->name('payroll_status'); 
Route::get('management-payroll-status','PayrollController@changePayRollStatus')->name('mg.payroll_status');

Route::group(['prefix' => 'businessAnalyst' ], function(){
		   Route::get('dashboard','BusinessAnalystController@dashboard')->name('ba.dashboard');
		   Route::get('holiday-calender', 'EmployeeController@holidayCalender')->name('ba.holiday');
		   Route::get('handover-projects','ProjectManageController@hand_overs_projects')->name('ba.handover_projects');
});

Route::group(['prefix' => 'accountent' ], function(){
		   Route::get('dashboard','AccountentController@dashboard')->name('ac.dashboard');
		   Route::get('holiday-calender', 'EmployeeController@holidayCalender')->name('ac.holiday');
		   //Route::get('holiday-calender', 'EmployeeController@holidayCalender');
});

Route::get('get-assets-list','ITExecutiveController@get_assets_list')->name('assets_list');
Route::get('previous-cmp-details','EmployeeController@importPreviuesCmpDetails')->name('hr.importExCmp');

Route::get('/', 'AuthController@index')->middleware('guest');

Route::get('login', 'AuthController@index')->middleware('guest');

Route::post('/login','AuthController@login')->name('login');

Route::get('/logout','AuthController@logout');

Route::get('/update_avail_leave','AuthController@updatevalue');

Route::get('/forget-password','AuthController@getForgetPassword');

Route::post('/forget-password','AuthController@postForgetPassword');

Route::get('/verify_reset_token/{token}','AuthController@verify_reset_token');

Route::post('/reset-password','AuthController@post_reset_password');

Route::get('/credit-leave','AjaxController@creditLeave');

Route::get('/leavecount/{id}', 'LeavecountController@leavecount');

Route::group(['middleware' => ['auth']], function () {

	Route::get('/profile','ProfileController@profile');

	Route::post('/postChangePassword','ProfileController@postChangePassword');

	Route::post('/profile/update/profile-pic','ProfileController@updateProfilePic');

	Route::get('/readNotification/{id}','NotificationController@notification');

	Route::get('/markasreadall/{id}','NotificationController@markasread');

	Route::get('/getSystem/{id}/{master_system_id}','AjaxController@getSystem');

	Route::get('/getAsset/{id}/{asset_type_id}','AjaxController@getAsset');

	Route::get('/getUser/{id}','AjaxController@getUser');

	Route::get('/getNewSystemId/{system_name_id}','AjaxController@getNewSystemId');

	Route::get('/getMasterSystemById/{id}','AjaxController@getMasterSystemById');

	Route::get('/getEod/{id}','AjaxController@getEod');

	Route::get('/getSubEod/{id}','AjaxController@getSubEod');

	Route::get('/getProject/{id}','AjaxController@getProject');



	Route::get('/resignations','ResignController@resignations');

	Route::get('/resign','ResignController@getApplyResign');

	Route::post('/resign','ResignController@postApplyResign');

	Route::get('/resignation/{id}','ResignController@previewResign');

	Route::get('/retract', 'ResignController@restract');

	Route::get('/retract/{id}','ResignController@previewRetract');

	Route::get('/resignation_kt/{id}','ResignController@previewkt');

	Route::get('/retract_leave1/{id}','AdminLeaveController@previewRetract_leave');

	Route::get('/retract_leave/{id}','EmployeeLeaveController@getRetractApplyLeave');

});



Route::group(['middleware' => ['auth','admin']], function () {



	Route::get('/admin/dashboard','AdminController@dashboard');

	Route::get('/admin/teams','AdminController@teams');

	Route::get('/admin/assign-team-members','AdminController@getAddAssignTeam');

	Route::post('/admin/assign-team-members','AdminController@postAddAssignTeam');

	Route::get('/admin/team-members/{team_leader_id}','AdminController@teamMembers');

	Route::get('/admin/remove/team-member/{team_member_id}','AdminController@removeTeamMember');

	Route::get('/admin/resignations', 'AdminController@resignations');

	Route::get('/admin/resignations/accepted/{id}', 'AdminController@resignationsaccepted');

	Route::get('/admin/resignations/rejected/{id}', 'AdminController@resignationsrejected');

	Route::get('/admin/retract', 'AdminController@restract');

	Route::get('/admin/retract/accepted/{id}', 'AdminController@restractaccepted');

	Route::get('/admin/retract/rejected/{id}', 'AdminController@restractrejected');

    Route::get('/admin/ktassign/confirm/{id}', 'AdminController@ktassign_confirm');

	Route::get('/admin/ktassign/rejected/{id}', 'AdminController@ktassign_rejected');

	Route::get('/admin/kt_list/', 'AdminController@kt_list');

	Route::get('/admin/view-notification/', 'AdminController@view_notification');

	Route::get('/admin/settings','AdminController@settings');



	/*=======================Admin Dashboard Starts==========================*/



	Route::get('/admin/dashboard','AdminController@dashboard');



	/*=======================Employee routes starts==========================*/

	Route::get('/admin/employees', 'EmployeeController@employees');

	Route::get('/admin/add-employee', 'EmployeeController@getAddEmployee');

	Route::post('/admin/add-employee', 'EmployeeController@postAddEmployee');

	Route::get('/admin/employee/profile/{id}', 'EmployeeController@getEmployeeProfile');

	Route::get('/admin/employee/{id}', 'EmployeeController@getEditEmployee');

	Route::post('/admin/employee/update', 'EmployeeController@postEditEmployee');

	Route::get('/admin/employee/delete/{id}', 'EmployeeController@deleteEmployee');

	Route::get('/admin/export/employee-sheet', 'EmployeeController@exportEmployees');

	Route::post('/admin/import/employee-sheet', 'EmployeeController@importEmployees');


	/*=======================Employee routes ends============================*/



	/*==========================Project routes starts===========================*/

	Route::get('/admin/projects', 'ProjectController@projects');

	Route::get('/admin/add-project', 'ProjectController@getAddProject');

	Route::post('/admin/add-project', 'ProjectController@postAddProject');

	Route::get('/admin/project/{id}', 'ProjectController@getEditProject');

	Route::post('/admin/project/update', 'ProjectController@postEditProject');

	Route::get('/admin/project/delete/{id}', 'ProjectController@deleteProject');

	/*==========================Project routes ends==============================*/



	/*==========================Employee Project routes starts===========================*/

	Route::get('/admin/employee-projects', 'EmployeeProjectController@employee_projects');

	//Route::get('/admin/assign-project', 'EmployeeProjectController@getAssignProject');

	//Route::post('/admin/assign-project', 'EmployeeProjectController@postAssignProject');

	Route::get('/admin/employee-project/{id}', 'EmployeeProjectController@getEditEmployeeProject');

	Route::post('/admin/employee-project/update', 'EmployeeProjectController@postEditEmployeeProject');

	Route::get('/admin/employee-project/delete/{id}', 'EmployeeProjectController@deleteEmployeeProject');

	/*==========================Employee Project routes ends==============================*/



	/*==========================Leave routes starts===========================*/

	//Route::get('/admin/retract-leave', 'AdminLeaveController@retract_leave_list');

	Route::get('/admin/leave-types', 'AdminLeaveController@leave_types');

	Route::get('/admin/add-leave-type', 'AdminLeaveController@getAddLeaveType');

	Route::post('/admin/add-leave-type', 'AdminLeaveController@postAddLeaveType');

	Route::get('/admin/leave-type/{id}', 'AdminLeaveController@getEditLeaveType');

	Route::post('/admin/leave-type/update', 'AdminLeaveController@postEditLeaveType');

	//Route::get('/admin/leave-listing', 'AdminLeaveController@leave_listing');

	Route::get('/admin/leave/approve/{id}', 'AdminLeaveController@approveLeave');

	Route::get('/admin/leave/discard/{id}', 'AdminLeaveController@discardLeave');

	Route::post('/admin/leave/discard/{id}', 'AdminLeaveController@discardLeavewithreason');

	Route::get('/admin/leave/delete/{id}', 'AdminLeaveController@deleteLeave');

	Route::get('/admin/retract_leave/accepted/{id}', 'AdminLeaveController@restractleaveaccepted');

	Route::get('/admin/retract_leave/rejected/{id}', 'AdminLeaveController@restractleaverejected');



	/*==========================Leave routes ends==============================*/



	/*==========================Asset routes starts===========================*/

	 Route::post('/admin/assets/all_assets', 'AssetController@assets');

	Route::get('/admin/assets/all_assets', 'AssetController@all_assets');

	Route::get('/admin/assets/all_system', 'AssetController@all_systems');

	Route::post('/admin/assets/all_system', 'AssetController@systems');



	Route::get('/admin/system/{id}/{master_system_id}', 'AssetController@getEditSystem');

	Route::post('/admin/system/update/{master_asset_id}', 'AssetController@postEditSystem');



	//Route::get('/admin/systems', 'AssetController@systems');

	Route::get('/admin/add-system', 'AssetController@getAddSystem');

	Route::post('/admin/add-system', 'AssetController@postAddSystem');

	//Route::get('/admin/system/{id}', 'AssetController@getEditSystem');

	//Route::post('/admin/system/update', 'AssetController@postEditSystem');



    Route::get('/admin/monitor/{id}', 'AssetController@getEditMonitor');

	Route::post('/admin/monitor/update', 'AssetController@postEditMonitor');

	Route::get('/admin/keyboard/{id}', 'AssetController@getEditKeyboard');

	Route::post('/admin/keyboard/update', 'AssetController@postEditKeyboard');

	Route::get('/admin/mouse/{id}', 'AssetController@getEditMouse');

	Route::post('/admin/mouse/update', 'AssetController@postEditMouse');

	Route::get('/admin/cabinet/{id}', 'AssetController@getEditCabinet');

	Route::post('/admin/cabinet/update', 'AssetController@postEditCabinet');

	Route::get('/admin/ac/{id}', 'AssetController@getEditAc');

	Route::post('/admin/ac/update', 'AssetController@postEditAc');

	Route::get('/admin/almirah/{id}', 'AssetController@getEditAlmirah');

	Route::post('/admin/almirah/update', 'AssetController@postEditAlmirah');

	Route::get('/admin/camera/{id}', 'AssetController@getEditCamera');

	Route::post('/admin/camera/update', 'AssetController@postEditCamera');

	Route::get('/admin/chair/{id}', 'AssetController@getEditChair');

	Route::post('/admin/chair/update', 'AssetController@postEditChair');

	Route::get('/admin/desk/{id}', 'AssetController@getEditDesk');

	Route::post('/admin/desk/update', 'AssetController@postEditDesk');

	Route::get('/admin/desktop/{id}', 'AssetController@getEditDesktop');

	Route::post('/admin/desktop/update', 'AssetController@postEditDesktop');

	Route::get('/admin/dvr/{id}', 'AssetController@getEditDvr');

	Route::post('/admin/dvr/update', 'AssetController@postEditDvr');

	Route::get('/admin/fan/{id}', 'AssetController@getEditFan');

	Route::post('/admin/fan/update', 'AssetController@postEditFan');

	Route::get('/admin/hdd/{id}', 'AssetController@getEditHdd');

	Route::post('/admin/hdd/update', 'AssetController@postEditHdd');

	Route::get('/admin/headphone/{id}', 'AssetController@getEditHeadphone');

	Route::post('/admin/headphone/update', 'AssetController@postEditHeadphone');

	Route::get('/admin/i_mac/{id}', 'AssetController@getEditIMac');

	Route::post('/admin/i_mac/update', 'AssetController@postEditIMac');

	Route::get('/admin/keyboard/{id}', 'AssetController@getEditKeyboard');

	Route::post('/admin/keyboard/update', 'AssetController@postEditKeyboard');

	Route::get('/admin/laptop/{id}', 'AssetController@getEditLaptop');

	Route::post('/admin/laptop/update', 'AssetController@postEditLaptop');

	Route::get('/admin/mac_mini/{id}', 'AssetController@getEditMac_mini');

	Route::post('/admin/mac_mini/update', 'AssetController@postEditMac_mini');

	Route::get('/admin/motherboard/{id}', 'AssetController@getEditMotherboard');

	Route::post('/admin/motherboard/update', 'AssetController@postEditMotherboard');

	Route::get('/admin/mouse/{id}', 'AssetController@getEditMouse');

	Route::post('/admin/mouse/update', 'AssetController@postEditMouse');

	Route::get('/admin/network_switch/{id}', 'AssetController@getEditNetwork_switch');

	Route::post('/admin/network_switch/update', 'AssetController@postEditNetwork_switch');

	Route::get('/admin/pen_drive/{id}', 'AssetController@getEditPen_drive');

	Route::post('/admin/pen_drive/update', 'AssetController@postEditPen_drive');

	Route::get('/admin/printer/{id}', 'AssetController@getEditPrinter');

	Route::post('/admin/printer/update', 'AssetController@postEditPrinter');

	Route::get('/admin/processer/{id}', 'AssetController@getEditProcesser');

	Route::post('/admin/processer/update', 'AssetController@postEditProcesser');

	Route::get('/admin/ram/{id}', 'AssetController@getEditRam');

	Route::post('/admin/ram/update', 'AssetController@postEditRam');

	Route::get('/admin/repeater/{id}', 'AssetController@getEditRepeater');

	Route::post('/admin/repeater/update', 'AssetController@postEditRepeater');

	Route::get('/admin/router/{id}', 'AssetController@getEditRouter');

	Route::post('/admin/router/update', 'AssetController@postEditRouter');

	Route::get('/admin/smps/{id}', 'AssetController@getEditSmps');

	Route::post('/admin/smps/update', 'AssetController@postEditSmps');

	Route::get('/admin/ups/{id}', 'AssetController@getEditUps');

	Route::post('/admin/ups/update', 'AssetController@postEditUps');

	Route::get('/admin/ups_battery/{id}', 'AssetController@getEditUps_battery');

	Route::post('/admin/ups_battery/update', 'AssetController@postEditUps_battery');

	Route::get('/admin/web_cam/{id}', 'AssetController@getEditWeb_cam');

	Route::post('/admin/web_cam/update', 'AssetController@postEditWeb_cam');



	//Route::get('/admin/assets', 'AssetController@assets');

	Route::get('/admin/add-asset', 'AssetController@getAddAsset');

	Route::post('/admin/add-asset', 'AssetController@postAddAsset');

	Route::get('/admin/asset/{id}', 'AssetController@getEditAsset');

	Route::post('/admin/asset/post', 'AssetController@postEditAsset');

	Route::post('/admin/asset/update', 'AssetController@postEditAsset');

	Route::get('/admin/asset/delete/{id}', 'AssetController@deleteAsset');

	Route::get('admin/asset_master/{type_id}', 'AjaxController@getMasterAssetByType');

	Route::get('admin/getAssetByAssetType_unique/{master_asset_id}/{type_id}', 'AjaxController@getAssetByAssetType_unique');

	Route::get('admin/assetsByAssetType/{type_id}', 'AjaxController@getAssetByAssetType');

	Route::get('admin/free_assets/{type_id}/{asset_assoc_id}', 'AjaxController@freeAssets');

	Route::get('admin/assignAsset/{system_id}/{asset_id}/{asset_assoc_id}', 'AjaxController@assignAsset');

	Route::get('admin/assignAsset_laptop/{system_id}/{asset_id}/{asset_assoc_id}', 'AjaxController@assignAsset_laptop');

	Route::get('admin/assignAsset_mac_mini/{system_id}/{asset_id}/{asset_assoc_id}', 'AjaxController@assignAsset_mac_mini');

	Route::get('admin/assignAsset_i_mac/{system_id}/{asset_id}/{asset_assoc_id}', 'AjaxController@assignAsset_i_mac');

	Route::get('admin/assetRelease/{id}', 'AjaxController@releaseAsset');

	Route::get('admin/release-system-asset/{system_id}/{id}/{asset_type_id}/{master_asset_id}', 'AssetController@releaseSystemAsset');

	Route::get('/admin/export/asset-sheet', 'AssetController@exportAssetExcel');

	Route::get('/admin/export/system-sheet', 'ITExecutiveController@exportSystemExcel');

	Route::post('/admin/import/asset-sheet', 'AssetController@importAssetExcel');



	Route::get('/admin/export/asset-sheet-monitor', 'AssetController@exportAssetExcelMonitor');

	Route::get('/admin/export/asset-sheet-ac', 'AssetController@exportAssetExcelAc');

	Route::get('/admin/export/asset-sheet-almirah', 'AssetController@exportAssetExcelAlmirah');

	Route::get('/admin/export/asset-sheet-cabinet', 'AssetController@exportAssetExcelCabinet');

	Route::get('/admin/export/asset-sheet-chair', 'AssetController@exportAssetExcelChair');

	Route::get('/admin/export/asset-sheet-desk', 'AssetController@exportAssetExcelDesk');

	Route::get('/admin/export/asset-sheet-desktop', 'AssetController@exportAssetExcelDesktop');

	Route::get('/admin/export/asset-sheet-dvr', 'AssetController@exportAssetExcelDvr');

	Route::get('/admin/export/asset-sheet-fan', 'AssetController@exportAssetExcelFan');

	Route::get('/admin/export/asset-sheet-hdd', 'AssetController@exportAssetExcelHdd');

	Route::get('/admin/export/asset-sheet-headphone', 'AssetController@exportAssetExcelHeadphone');

	Route::get('/admin/export/asset-sheet-i_mac', 'AssetController@exportAssetExcelImac');

	Route::get('/admin/export/asset-sheet-keyboard', 'AssetController@exportAssetExcelKeyboard');

	Route::get('/admin/export/asset-sheet-laptop', 'AssetController@exportAssetExcelLaptop');

	Route::get('/admin/export/asset-sheet-mac_mini', 'AssetController@exportAssetExcelMac_mini');

	Route::get('/admin/export/asset-sheet-motherboard', 'AssetController@exportAssetExcelMotherboard');

	Route::get('/admin/export/asset-sheet-mouse', 'AssetController@exportAssetExcelMouse');

	Route::get('/admin/export/asset-sheet-network_switch', 'AssetController@exportAssetExcelNetwork_switch');

	Route::get('/admin/export/asset-sheet-pen_drive', 'AssetController@exportAssetExcelPen_drive');

	Route::get('/admin/export/asset-sheet-printer', 'AssetController@exportAssetExcelPrinter');

	Route::get('/admin/export/asset-sheet-processer', 'AssetController@exportAssetExcelProcesser');

	Route::get('/admin/export/asset-sheet-ram', 'AssetController@exportAssetExcelRam');

	Route::get('/admin/export/asset-sheet-repeater', 'AssetController@exportAssetExcelRepeater');

	Route::get('/admin/export/asset-sheet-router', 'AssetController@exportAssetExcelRouter');

	Route::get('/admin/export/asset-sheet-smps', 'AssetController@exportAssetExcelSmps');

	Route::get('/admin/export/asset-sheet-ups', 'AssetController@exportAssetExcelUps');

	Route::get('/admin/export/asset-sheet-ups_battery', 'AssetController@exportAssetExcelUps_battery');

	Route::get('/admin/export/asset-sheet-web_cam', 'AssetController@exportAssetExcelWeb_cam');



	Route::post('/admin/import/asset-sheet', 'AssetController@importAssetExcel');

	Route::post('/admin/import_monitor/asset-sheet', 'AssetController@importAssetExcel_monitor');

	Route::post('/admin/import_ac/asset-sheet', 'AssetController@importAssetExcel_ac');

	Route::post('/admin/import_almirah/asset-sheet', 'AssetController@importAssetExcel_almirah');

    Route::post('/admin/import_cabinet/asset-sheet', 'AssetController@importAssetExcel_cabinet');

    Route::post('/admin/import_camera/asset-sheet', 'AssetController@importAssetExcel_camera');

	Route::post('/admin/import_chair/asset-sheet', 'AssetController@importAssetExcel_chair');

	Route::post('/admin/import_desk/asset-sheet', 'AssetController@importAssetExcel_desk');

	Route::post('/admin/import_desktop/asset-sheet', 'AssetController@importAssetExcel_desktop');

	Route::post('/admin/import_dvr/asset-sheet', 'AssetController@importAssetExcel_dvr');

	Route::post('/admin/import_fan/asset-sheet', 'AssetController@importAssetExcel_fan');

	Route::post('/admin/import_hdd/asset-sheet', 'AssetController@importAssetExcel_hdd');

	Route::post('/admin/import_headphone/asset-sheet', 'AssetController@importAssetExcel_headphone');

	Route::post('/admin/import_i_mac/asset-sheet', 'AssetController@importAssetExcel_i_mac');

	Route::post('/admin/import_keyboard/asset-sheet', 'AssetController@importAssetExcel_keyboard');

	Route::post('/admin/import_laptop/asset-sheet', 'AssetController@importAssetExcel_laptop');

	Route::post('/admin/import_mac_mini/asset-sheet', 'AssetController@importAssetExcel_mac_mini');

	Route::post('/admin/import_motherboard/asset-sheet', 'AssetController@importAssetExcel_motherboard');

	Route::post('/admin/import_mouse/asset-sheet', 'AssetController@importAssetExcel_mouse');

	Route::post('/admin/import_network_switch/asset-sheet', 'AssetController@importAssetExcel_network_switch');

	Route::post('/admin/import_pen_drive/asset-sheet', 'AssetController@importAssetExcel_pen_drive');

	Route::post('/admin/import_printer/asset-sheet', 'AssetController@importAssetExcel_printer');

	Route::post('/admin/import_processer/asset-sheet', 'AssetController@importAssetExcel_processer');

	Route::post('/admin/import_ram/asset-sheet', 'AssetController@importAssetExcel_ram');

	Route::post('/admin/import_repeater/asset-sheet', 'AssetController@importAssetExcel_repeater');

	Route::post('/admin/import_router/asset-sheet', 'AssetController@importAssetExcel_router');

	Route::post('/admin/import_smps/asset-sheet', 'AssetController@importAssetExcel_smps');

	Route::post('/admin/import_ups/asset-sheet', 'AssetController@importAssetExcel_ups');

	Route::post('/admin/import_ups_battery/asset-sheet', 'AssetController@importAssetExcel_ups_battery');

	Route::post('/admin/import_web_cam/asset-sheet', 'AssetController@importAssetExcel_web_cam');





	Route::get('/admin/export_desktop/system-sheet', 'AssetController@exportSystemDesktopExcel');

	Route::get('/admin/export_laptop/system-sheet', 'AssetController@exportSystemLaptopExcel');

	Route::get('/admin/export_mac_mini/system-sheet', 'AssetController@exportSystemMacMiniExcel');

	Route::get('/admin/export_i_mac/system-sheet', 'AssetController@exportSystemIMacExcel');



	/*==========================Asset routes ends==============================*/



	/*==========================Holidays routes starts===========================*/

	Route::get('/admin/holiday-calender', 'HolidayController@holidayCalender');

	Route::get('/admin/holidays', 'HolidayController@holidays');

	Route::get('/admin/add-holiday', 'HolidayController@getAddHoliday');

	Route::post('/admin/add-holiday', 'HolidayController@postAddHoliday');

	Route::get('/admin/holiday/{id}', 'HolidayController@getEditHoliday');

	Route::post('/admin/holiday/update', 'HolidayController@postEditHoliday');

	Route::get('/admin/holiday/delete/{id}', 'HolidayController@deleteHoliday');

	Route::get('/admin/export/holiday-sheet', 'HolidayController@exportHolidayExcel');

	Route::post('/admin/import/holiday-sheet', 'HolidayController@importHolidayExcel');

	/*==========================Holidays routes end==============================*/



	/*==========================EOD routes starts===========================*/

	Route::get('/admin/eods', 'EODController@eod_list');

	Route::get('/admin/hr-eods', 'EODController@hr_eod_list')->name('admin.hreod');
	Route::get('/admin/it-executive-eods', 'EODController@it_eod_list')->name('admin.iteod'); 

	Route::get('/admin/hr-eods-details', 'EODController@hr_eod_details')->name('admin.hr_eod_details');
	Route::get('/admin/it-eods-details', 'EODController@it_eod_details')->name('admin.it_eod_details');



	Route::post('/admin/eods', 'EODController@eod_list_filter');

	Route::get('/admin/eod/{eod_id}', 'EODController@getEODToAdmin');

	Route::get('/admin/eod/delete/{eod_id}', 'EODController@deleteEOD');

	Route::get('/admin/hr_eod/delete/{eod_id}', 'EODController@deleteHR_EOD')->name('admin.hr_eod_delete');
	Route::get('/admin/it_eod/delete/{eod_id}', 'EODController@deleteIT_EOD')->name('admin.it_eod_delete');

	/*==========================EOD routes ends==============================*/



	/*==========================   Attendance Start   ==============================*/

	Route::get('/admin/attendance', 'AttendanceController@attendance');

	Route::post('admin/submitAttendance', 'AttendanceController@submitAttendance');

	Route::post('admin/getcurentAttendance', 'AttendanceController@getcurentAttendance');

	Route::get('/admin/export/attendance-sheet', 'AttendanceController@exportAttendanceExcel');

	Route::post('/admin/import/attendance-sheet', 'AttendanceController@importAttendanceExcel');





	/*==========================   Attendance End   ==============================*/



	/*==========================Requests routes starts===========================*/

	Route::get('admin/request/profile-update', 'AdminRequestController@profileUpdateRequest');

	Route::get('admin/request/profile/{id}', 'AdminRequestController@getProfileUpdateRequest');

	Route::get('admin/request/profile/approve/{id}', 'AdminRequestController@approveProfileUpdateRequest');

	Route::get('admin/request/profile/discard/{id}', 'AdminRequestController@discardProfileUpdateRequest');

	/*==========================Requests routes ends==============================*/

	Route::get('admin/systemBySystemType/{system_type_id}/{asset_type_id}', 'AjaxController@getSystemNameBySystemType');



	/*=========================Admin Dashboard Ends============================*/

});







/*=======================Employee Dashboard starts========================*/

Route::group(['middleware' => ['auth','employee']], function () {

	Route::get('/employee/dashboard','EmployeeController@dashboard');

	Route::get('/employee/view-notification/', 'EmployeeController@view_notification');

	Route::get('/employee/holiday-calender', 'EmployeeController@holidayCalender');

	Route::get('/employee/assigned-projects', 'EmployeeController@getAssisnedProject');

	Route::get('/employee/salary','EmployeeController@salary')->name('e.salary');   

	/*==========================Leave routes starts===========================*/

	//Route::get('/employee/apply-leave', 'EmployeeLeaveController@getAddLeave');

	//Route::post('/employee/apply-leave', 'EmployeeLeaveController@postAddLeave');

	Route::get('/employee/my-leaves', 'EmployeeLeaveController@myLeaves');

	Route::post('/employee/retract/leave/{id}', 'EmployeeLeaveController@submitretarctleave');

	/*==========================Leave routes ends==============================*/



	/*==========================EOD routes starts===========================*/



	//Route::get('/employee/send-eod', 'EODController@getSendEOD');

	//Route::post('/employee/send-eod', 'EODController@postSendEOD');

	Route::get('/employee/sent-eods', 'EODController@sent_eod');

	Route::get('/employee/eod/{eod_id}', 'EODController@getEOD');

	/*==========================EOD routes ends==============================*/



	/*==========================Profile Update request routes starts===========================*/

	Route::get('/employee/profile', 'EmployeeController@getProfile');

	Route::get('/employee/profile/edit', 'EmployeeController@getProfileEdit');

	Route::post('/employee/profile/edit', 'EmployeeController@postProfileEdit');

	Route::post('/employee/addAttendance', 'EmployeeController@addAttendance');



	/*==========================Profile Update request routes ends==============================*/

    Route::get('/teamLead/projects', 'ProjectController@projects');

	Route::get('/teamLead/add-project', 'ProjectController@getAddProject');

	Route::post('/teamLead/add-project', 'ProjectController@postAddProject');

	Route::get('/teamLead/project/{id}', 'ProjectController@getEditProject');

	Route::post('/teamLead/project/update', 'ProjectController@postEditProject');

	Route::get('/teamLead/project/delete/{id}', 'ProjectController@deleteProject');

	/*==========================Project routes ends==============================*/

	//Route::get('/teamLead/assign-project', 'EmployeeProjectController@getAssignProject');

	//Route::post('/teamLead/assign-project', 'EmployeeProjectController@postAssignProject');

	Route::get('/teamLead/employee-projects', 'EmployeeProjectController@employee_projects');

	Route::get('/teamLead/employee-project/{id}', 'EmployeeProjectController@getEditEmployeeProject');

	Route::post('/teamLead/employee-project/update', 'EmployeeProjectController@postEditEmployeeProject');

	Route::get('/teamLead/employee-project/delete/{id}', 'EmployeeProjectController@deleteEmployeeProject');
	//Route::get('/teamLead/leave-listing', 'HrManagerController@leave_listing');



	/*==========================Resignation routes starts===========================*/

	Route::get('/employee/resignation/retract/{id}', 'ResignController@retractResign');

	Route::get('/employee/resignation/submit/{id}', 'ResignController@submitResign');

	Route::post('/employee/addnewdetails/{user_id}', 'EmployeeController@addnewdetails');

	Route::get('/employee/retract/', 'EmployeeController@restract');

	Route::post('/employee/retract', 'EmployeeController@postapplyretract');

	Route::post('/employee/assignkt/', 'ResignController@assignkt');

	Route::get('/employee/del_kt', 'EmployeeController@del_kt');



	/*==========================Resignation routes ends==============================*/



});

/*=======================Employee Dashboard Ends==========================*/





/*========================Hr Manager Dashboard starts========================*/

Route::group(['middleware' => ['auth','hrManager']], function () {

	Route::get('/hrManager/dashboard','HrManagerController@dashboard');

	Route::get('/hrManager/salary','HrManagerController@salary')->name('hr.salary'); 

	Route::get('/hrManager/teams','HrManagerController@teams');

	Route::get('/hrManager/assign-team-members','HrManagerController@getAddAssignTeam');

	Route::post('/hrManager/assign-team-members','HrManagerController@postAddAssignTeam');

	Route::get('/hrManager/team-members/{team_leader_id}','HrManagerController@teamMembers');

	Route::get('/hrManager/remove/team-member/{team_member_id}','HrManagerController@removeTeamMember');



	Route::get('/hrManager/view-notification/', 'HrManagerController@view_notification');



	/*=======================Employee routes starts==========================*/

	Route::get('/hrManager/employees', 'HrManagerController@employees');

	Route::get('/hrManager/add-employee', 'HrManagerController@getAddEmployee');

	Route::post('/hrManager/add-employee', 'HrManagerController@postAddEmployee');

	Route::get('/hrManager/employee/profile/{id}', 'HrManagerController@getEmployeeProfile');

	Route::get('/hrManager/employee/{id}', 'HrManagerController@getEditEmployee');

	Route::post('/hrManager/employee/update', 'HrManagerController@postEditEmployee');

	Route::get('/hrManager/employee/delete/{id}', 'HrManagerController@deleteEmployee');

	Route::get('/hrManager/export/employee-sheet', 'HrManagerController@exportEmployees');

	Route::post('/hrManager/import/employee-sheet', 'HrManagerController@importEmployees');

	/*=======================Employee routes ends============================*/





	/*==========================Leave routes starts===========================*/

	Route::post('/hrManager/retract/leave/{id}', 'EmployeeLeaveController@submitretarctleave');

	Route::get('/hrManager/leave-types', 'HrManagerController@leave_types');

	Route::get('/hrManager/add-leave-type', 'HrManagerController@getAddLeaveType');

	Route::post('/hrManager/add-leave-type', 'HrManagerController@postAddLeaveType');

	Route::get('/hrManager/leave-type/{id}', 'HrManagerController@getEditLeaveType');

	Route::post('/hrManager/leave-type/update', 'HrManagerController@postEditLeaveType');

	//Route::get('/hrManager/leave-listing', 'HrManagerController@leave_listing');

	Route::get('/hrManager/leave/approve/{id}', 'HrManagerController@approveLeave');

	Route::get('/hrManager/leave/discard/{id}', 'HrManagerController@discardLeave');

	Route::get('/hrManager/leave/delete/{id}', 'HrManagerController@deleteLeave');



	//Route::get('/hrManager/apply-leave', 'HrManagerController@getAddLeave');

	//Route::post('/hrManager/apply-leave', 'HrManagerController@postAddLeave');

	Route::get('/hrManager/my-leaves', 'HrManagerController@myLeaves');



	/*==========================Leave routes ends==============================*/



	/*==========================Holidays routes starts===========================*/

	Route::get('/hrManager/holiday-calender', 'HrManagerController@holidayCalender');

	Route::get('/hrManager/holidays', 'HrManagerController@holidays');

	Route::get('/hrManager/add-holiday', 'HrManagerController@getAddHoliday');

	Route::post('/hrManager/add-holiday', 'HrManagerController@postAddHoliday');

	Route::get('/hrManager/holiday/{id}', 'HrManagerController@getEditHoliday');

	Route::post('/hrManager/holiday/update', 'HrManagerController@postEditHoliday');

	Route::get('/hrManager/holiday/delete/{id}', 'HrManagerController@deleteHoliday');

	Route::get('/hrManager/export/holiday-sheet', 'HrManagerController@exportHolidayExcel');

	Route::post('/hrManager/import/holiday-sheet', 'HrManagerController@importHolidayExcel');

	/*==========================Holidays routes end==============================*/



	/*==========================   Attendance Start   ==============================*/

	Route::get('/hrManager/attendance', 'HrManagerController@attendance');

	Route::post('hrManager/submitAttendance', 'HrManagerController@submitAttendance');

	Route::post('hrManager/getcurentAttendance', 'HrManagerController@getcurentAttendance');

	Route::get('/hrManager/export/attendance-sheet', 'HrManagerController@exportAttendanceExcel');

	Route::post('/hrManager/import/attendance-sheet', 'HrManagerController@importAttendanceExcel');



	/*==========================   Attendance End   ==============================*/



	/*==========================Requests routes starts===========================*/

	Route::get('hrManager/request/profile-update', 'HrManagerController@profileUpdateRequest');

	Route::get('hrManager/request/profile/{id}', 'HrManagerController@getProfileUpdateRequest');

	Route::get('hrManager/request/profile/approve/{id}', 'HrManagerController@approveProfileUpdateRequest');

	Route::get('hrManager/request/profile/discard/{id}', 'HrManagerController@discardProfileUpdateRequest');



	Route::post('/hrManager/addAttendance', 'HrManagerController@addAttendance');

	Route::get('/hrManager/leave-details', 'HrManagerController@leave_details');

	/*==========================Requests routes ends==============================*/



	/*========================== HR EOD routes starts===========================*/

	Route::get('hrManager/send-hr-eod', 'HrManagerController@getSendEOD')->name('hr.send_eod');

	Route::post('hrManager/send-hr-eod', 'HrManagerController@postSendEOD');

	Route::get('hrManager/sent-hr-eods', 'HrManagerController@sent_eod')->name('hr.eods');

	/*========================== HR  EOD routes ends==============================*/



	/*==========================Profile Update request routes starts===========================*/

	Route::get('/hrManager/profile/edit', 'HrManagerController@getProfileEdit');

	Route::post('/hrManager/profile/edit', 'HrManagerController@postProfileEdit');

	/*==========================Profile Update request routes ends==============================*/



	/*==========================Resignation routes starts===========================*/

	Route::get('/hrManager/resignations', 'HrManagerController@resignations');

	Route::get('/hrManager/resignation/retract/{id}', 'ResignController@retractResign');

	Route::get('/hrManager/resignation/submit/{id}', 'ResignController@submitResign');

	/*==========================Resignation routes ends==============================*/



});

/*=======================Hr Manager Dashboard Ends==========================*/





/*========================IT Executive Dashboard starts========================*/
Route::post('/itExecutive/eod-save', 'EODController@save_it_eods')->name('it.eod');
Route::get('itExecutive/sent-eods', 'EODController@it_eods')->name('it.eod_list');

Route::group(['middleware' => ['auth','itExecutive']], function () {

	Route::get('/itExecutive/dashboard','ITExecutiveController@dashboard');

	Route::get('/itExecutive/holiday-calender', 'ITExecutiveController@holidayCalender');

	Route::get('/itExecutive/profile', 'ITExecutiveController@getProfile');

	Route::get('/itExecutive/profile/edit', 'ITExecutiveController@getProfileEdit');

	Route::post('/itExecutive/profile/edit', 'ITExecutiveController@postProfileEdit');

	Route::post('/itExecutive/addAttendance', 'ITExecutiveController@addAttendance');

	Route::get('/itExecutive/view-notification/', 'ITExecutiveController@view_notification');

	/*==========================Asset routes starts===========================*/

	//Route::get('/itExecutive/systems', 'ITExecutiveController@systems');

	Route::get('/itExecutive/add-system', 'ITExecutiveController@getAddSystem');

	Route::post('/itExecutive/add-system', 'ITExecutiveController@postAddSystem');

	Route::get('/itExecutive/system/{id}/{master_system_id}', 'ITExecutiveController@getEditSystem');

	Route::post('/itExecutive/system/update/{master_asset_id}', 'ITExecutiveController@postEditSystem');

	//Route::post('/itExecutive/assets/all_assets', 'ITExecutiveController@assets');

	Route::post('/itExecutive/assets/all_assets', 'ITExecutiveController@assets');

	Route::get('/itExecutive/assets/all_assets', 'ITExecutiveController@all_assets');

	Route::get('/itExecutive/assets/all_system', 'ITExecutiveController@all_systems');

	Route::post('/itExecutive/assets/all_system', 'ITExecutiveController@systems');

	Route::get('/itExecutive/add-asset', 'ITExecutiveController@getAddAsset');

	Route::post('/itExecutive/add-asset', 'ITExecutiveController@postAddAsset');

	Route::get('/itExecutive/monitor/{id}', 'ITExecutiveController@getEditMonitor');

	Route::post('/itExecutive/monitor/update', 'ITExecutiveController@postEditMonitor');

	Route::get('/itExecutive/keyboard/{id}', 'ITExecutiveController@getEditKeyboard');

	Route::post('/itExecutive/keyboard/update', 'ITExecutiveController@postEditKeyboard');

	Route::get('/itExecutive/mouse/{id}', 'ITExecutiveController@getEditMouse');

	Route::post('/itExecutive/mouse/update', 'ITExecutiveController@postEditMouse');

	Route::get('/itExecutive/cabinet/{id}', 'ITExecutiveController@getEditCabinet');

	Route::post('/itExecutive/cabinet/update', 'ITExecutiveController@postEditCabinet');

	Route::get('/itExecutive/ac/{id}', 'ITExecutiveController@getEditAc');

	Route::post('/itExecutive/ac/update', 'ITExecutiveController@postEditAc');

	Route::get('/itExecutive/almirah/{id}', 'ITExecutiveController@getEditAlmirah');

	Route::post('/itExecutive/almirah/update', 'ITExecutiveController@postEditAlmirah');

	Route::get('/itExecutive/camera/{id}', 'ITExecutiveController@getEditCamera');

	Route::post('/itExecutive/camera/update', 'ITExecutiveController@postEditCamera');

	Route::get('/itExecutive/chair/{id}', 'ITExecutiveController@getEditChair');

	Route::post('/itExecutive/chair/update', 'ITExecutiveController@postEditChair');

	Route::get('/itExecutive/desk/{id}', 'ITExecutiveController@getEditDesk');

	Route::post('/itExecutive/desk/update', 'ITExecutiveController@postEditDesk');

	Route::get('/itExecutive/desktop/{id}', 'ITExecutiveController@getEditDesktop');

	Route::post('/itExecutive/desktop/update', 'ITExecutiveController@postEditDesktop');

	Route::get('/itExecutive/dvr/{id}', 'ITExecutiveController@getEditDvr');

	Route::post('/itExecutive/dvr/update', 'ITExecutiveController@postEditDvr');

	Route::get('/itExecutive/fan/{id}', 'ITExecutiveController@getEditFan');

	Route::post('/itExecutive/fan/update', 'ITExecutiveController@postEditFan');

	Route::get('/itExecutive/hdd/{id}', 'ITExecutiveController@getEditHdd');

	Route::post('/itExecutive/hdd/update', 'ITExecutiveController@postEditHdd');

	Route::get('/itExecutive/headphone/{id}', 'ITExecutiveController@getEditHeadphone');

	Route::post('/itExecutive/headphone/update', 'ITExecutiveController@postEditHeadphone');

	Route::get('/itExecutive/i_mac/{id}', 'ITExecutiveController@getEditIMac');

	Route::post('/itExecutive/i_mac/update', 'ITExecutiveController@postEditIMac');

	Route::get('/itExecutive/keyboard/{id}', 'ITExecutiveController@getEditKeyboard');

	Route::post('/itExecutive/keyboard/update', 'ITExecutiveController@postEditKeyboard');

	Route::get('/itExecutive/laptop/{id}', 'ITExecutiveController@getEditLaptop');

	Route::post('/itExecutive/laptop/update', 'ITExecutiveController@postEditLaptop');

	Route::get('/itExecutive/mac_mini/{id}', 'ITExecutiveController@getEditMac_mini');

	Route::post('/itExecutive/mac_mini/update', 'ITExecutiveController@postEditMac_mini');

	Route::get('/itExecutive/motherboard/{id}', 'ITExecutiveController@getEditMotherboard');

	Route::post('/itExecutive/motherboard/update', 'ITExecutiveController@postEditMotherboard');

	Route::get('/itExecutive/mouse/{id}', 'ITExecutiveController@getEditMouse');

	Route::post('/itExecutive/mouse/update', 'ITExecutiveController@postEditMouse');

	Route::get('/itExecutive/network_switch/{id}', 'ITExecutiveController@getEditNetwork_switch');

	Route::post('/itExecutive/network_switch/update', 'ITExecutiveController@postEditNetwork_switch');

	Route::get('/itExecutive/pen_drive/{id}', 'ITExecutiveController@getEditPen_drive');

	Route::post('/itExecutive/pen_drive/update', 'ITExecutiveController@postEditPen_drive');

	Route::get('/itExecutive/printer/{id}', 'ITExecutiveController@getEditPrinter');

	Route::post('/itExecutive/printer/update', 'ITExecutiveController@postEditPrinter');

	Route::get('/itExecutive/processer/{id}', 'ITExecutiveController@getEditProcesser');

	Route::post('/itExecutive/processer/update', 'ITExecutiveController@postEditProcesser');

	Route::get('/itExecutive/ram/{id}', 'ITExecutiveController@getEditRam');

	Route::post('/itExecutive/ram/update', 'ITExecutiveController@postEditRam');

	Route::get('/itExecutive/repeater/{id}', 'ITExecutiveController@getEditRepeater');

	Route::post('/itExecutive/repeater/update', 'ITExecutiveController@postEditRepeater');

	Route::get('/itExecutive/router/{id}', 'ITExecutiveController@getEditRouter');

	Route::post('/itExecutive/router/update', 'ITExecutiveController@postEditRouter');

	Route::get('/itExecutive/smps/{id}', 'ITExecutiveController@getEditSmps');

	Route::post('/itExecutive/smps/update', 'ITExecutiveController@postEditSmps');

	Route::get('/itExecutive/ups/{id}', 'ITExecutiveController@getEditUps');

	Route::post('/itExecutive/ups/update', 'ITExecutiveController@postEditUps');

	Route::get('/itExecutive/ups_battery/{id}', 'ITExecutiveController@getEditUps_battery');

	Route::post('/itExecutive/ups_battery/update', 'ITExecutiveController@postEditUps_battery');

	Route::get('/itExecutive/web_cam/{id}', 'ITExecutiveController@getEditWeb_cam');

	Route::post('/itExecutive/web_cam/update', 'ITExecutiveController@postEditWeb_cam');

    Route::get('/itExecutive/getAssetByAssetType_unique/{master_asset_id}/{type_id}', 'AjaxController@getAssetByAssetType_unique');

	Route::post('/itExecutive/asset/update', 'ITExecutiveController@postEditAsset');

	Route::get('/itExecutive/asset/delete/{id}', 'ITExecutiveController@deleteAsset');

	Route::get('itExecutive/asset_master/{type_id}', 'AjaxController@getMasterAssetByType');

	Route::get('itExecutive/assetsByAssetType/{type_id}', 'AjaxController@getAssetByAssetType');

	Route::get('itExecutive/free_assets/{type_id}/{asset_assoc_id}', 'AjaxController@freeAssets');

	Route::get('itExecutive/assignAsset/{system_id}/{asset_id}/{asset_assoc_id}', 'AjaxController@assignAsset');

	Route::get('itExecutive/assignAsset_laptop/{system_id}/{asset_id}/{asset_assoc_id}', 'AjaxController@assignAsset_laptop');

	Route::get('itExecutive/assignAsset_mac_mini/{system_id}/{asset_id}/{asset_assoc_id}', 'AjaxController@assignAsset_mac_mini');

	Route::get('itExecutive/assignAsset_i_mac/{system_id}/{asset_id}/{asset_assoc_id}', 'AjaxController@assignAsset_i_mac');

	Route::get('itExecutive/assetRelease/{id}', 'AjaxController@releaseAsset');

	Route::get('itExecutive/release-system-asset/{system_id}/{id}/{asset_type_id}/{master_asset_id}', 'ITExecutiveController@releaseSystemAsset');



	Route::get('/itExecutive/export/asset-sheet', 'ITExecutiveController@exportAssetExcel');

	Route::get('/itExecutive/export/asset-sheet-monitor', 'ITExecutiveController@exportAssetExcelMonitor');

	Route::get('/itExecutive/export/asset-sheet-ac', 'ITExecutiveController@exportAssetExcelAc');

	Route::get('/itExecutive/export/asset-sheet-almirah', 'ITExecutiveController@exportAssetExcelAlmirah');

	Route::get('/itExecutive/export/asset-sheet-cabinet', 'ITExecutiveController@exportAssetExcelCabinet');

	Route::get('/itExecutive/export/asset-sheet-chair', 'ITExecutiveController@exportAssetExcelChair');

	Route::get('/itExecutive/export/asset-sheet-desk', 'ITExecutiveController@exportAssetExcelDesk');

	Route::get('/itExecutive/export/asset-sheet-desktop', 'ITExecutiveController@exportAssetExcelDesktop');

	Route::get('/itExecutive/export/asset-sheet-dvr', 'ITExecutiveController@exportAssetExcelDvr');

	Route::get('/itExecutive/export/asset-sheet-fan', 'ITExecutiveController@exportAssetExcelFan');

	Route::get('/itExecutive/export/asset-sheet-hdd', 'ITExecutiveController@exportAssetExcelHdd');

	Route::get('/itExecutive/export/asset-sheet-headphone', 'ITExecutiveController@exportAssetExcelHeadphone');

	Route::get('/itExecutive/export/asset-sheet-i_mac', 'ITExecutiveController@exportAssetExcelImac');

	Route::get('/itExecutive/export/asset-sheet-keyboard', 'ITExecutiveController@exportAssetExcelKeyboard');

	Route::get('/itExecutive/export/asset-sheet-laptop', 'ITExecutiveController@exportAssetExcelLaptop');

	Route::get('/itExecutive/export/asset-sheet-mac_mini', 'ITExecutiveController@exportAssetExcelMac_mini');

	Route::get('/itExecutive/export/asset-sheet-motherboard', 'ITExecutiveController@exportAssetExcelMotherboard');

	Route::get('/itExecutive/export/asset-sheet-mouse', 'ITExecutiveController@exportAssetExcelMouse');

	Route::get('/itExecutive/export/asset-sheet-network_switch', 'ITExecutiveController@exportAssetExcelNetwork_switch');

	Route::get('/itExecutive/export/asset-sheet-pen_drive', 'ITExecutiveController@exportAssetExcelPen_drive');

	Route::get('/itExecutive/export/asset-sheet-printer', 'ITExecutiveController@exportAssetExcelPrinter');

	Route::get('/itExecutive/export/asset-sheet-processer', 'ITExecutiveController@exportAssetExcelProcesser');

	Route::get('/itExecutive/export/asset-sheet-ram', 'ITExecutiveController@exportAssetExcelRam');

	Route::get('/itExecutive/export/asset-sheet-repeater', 'ITExecutiveController@exportAssetExcelRepeater');

	Route::get('/itExecutive/export/asset-sheet-router', 'ITExecutiveController@exportAssetExcelRouter');

	Route::get('/itExecutive/export/asset-sheet-smps', 'ITExecutiveController@exportAssetExcelSmps');

	Route::get('/itExecutive/export/asset-sheet-ups', 'ITExecutiveController@exportAssetExcelUps');

	Route::get('/itExecutive/export/asset-sheet-ups_battery', 'ITExecutiveController@exportAssetExcelUps_battery');

	Route::get('/itExecutive/export/asset-sheet-web_cam', 'ITExecutiveController@exportAssetExcelWeb_cam');



	Route::get('/itExecutive/export_desktop/system-sheet', 'ITExecutiveController@exportSystemDesktopExcel');

	Route::get('/itExecutive/export_laptop/system-sheet', 'ITExecutiveController@exportSystemLaptopExcel');

	Route::get('/itExecutive/export_mac_mini/system-sheet', 'ITExecutiveController@exportSystemMacMiniExcel');

	Route::get('/itExecutive/export_i_mac/system-sheet', 'ITExecutiveController@exportSystemIMacExcel');

	//Route::get('/itExecutive/export/system-sheet', 'ITExecutiveController@exportSystemExcel');

	Route::post('/itExecutive/import/asset-sheet', 'ITExecutiveController@importAssetExcel');

	Route::post('/itExecutive/import_monitor/asset-sheet', 'ITExecutiveController@importAssetExcel_monitor');

	Route::post('/itExecutive/import_ac/asset-sheet', 'ITExecutiveController@importAssetExcel_ac');

	Route::post('/itExecutive/import_almirah/asset-sheet', 'ITExecutiveController@importAssetExcel_almirah');

    Route::post('/itExecutive/import_cabinet/asset-sheet', 'ITExecutiveController@importAssetExcel_cabinet');

    Route::post('/itExecutive/import_camera/asset-sheet', 'ITExecutiveController@importAssetExcel_camera');

	Route::post('/itExecutive/import_chair/asset-sheet', 'ITExecutiveController@importAssetExcel_chair');

	Route::post('/itExecutive/import_desk/asset-sheet', 'ITExecutiveController@importAssetExcel_desk');

	Route::post('/itExecutive/import_desktop/asset-sheet', 'ITExecutiveController@importAssetExcel_desktop');

	Route::post('/itExecutive/import_dvr/asset-sheet', 'ITExecutiveController@importAssetExcel_dvr');

	Route::post('/itExecutive/import_fan/asset-sheet', 'ITExecutiveController@importAssetExcel_fan');

	Route::post('/itExecutive/import_hdd/asset-sheet', 'ITExecutiveController@importAssetExcel_hdd');

	Route::post('/itExecutive/import_headphone/asset-sheet', 'ITExecutiveController@importAssetExcel_headphone');

	Route::post('/itExecutive/import_i_mac/asset-sheet', 'ITExecutiveController@importAssetExcel_i_mac');

	Route::post('/itExecutive/import_keyboard/asset-sheet', 'ITExecutiveController@importAssetExcel_keyboard');

	Route::post('/itExecutive/import_laptop/asset-sheet', 'ITExecutiveController@importAssetExcel_laptop');

	Route::post('/itExecutive/import_mac_mini/asset-sheet', 'ITExecutiveController@importAssetExcel_mac_mini');
	Route::post('/itExecutive/import_motherboard/asset-sheet', 'ITExecutiveController@importAssetExcel_motherboard');
	Route::post('/itExecutive/import_mouse/asset-sheet', 'ITExecutiveController@importAssetExcel_mouse');
	Route::post('/itExecutive/import_network_switch/asset-sheet', 'ITExecutiveController@importAssetExcel_network_switch');
	Route::post('/itExecutive/import_pen_drive/asset-sheet', 'ITExecutiveController@importAssetExcel_pen_drive');
	Route::post('/itExecutive/import_printer/asset-sheet', 'ITExecutiveController@importAssetExcel_printer');
	Route::post('/itExecutive/import_processer/asset-sheet', 'ITExecutiveController@importAssetExcel_processer');
	Route::post('/itExecutive/import_ram/asset-sheet', 'ITExecutiveController@importAssetExcel_ram');
	Route::post('/itExecutive/import_repeater/asset-sheet', 'ITExecutiveController@importAssetExcel_repeater');
	Route::post('/itExecutive/import_router/asset-sheet', 'ITExecutiveController@importAssetExcel_router');
	Route::post('/itExecutive/import_smps/asset-sheet', 'ITExecutiveController@importAssetExcel_smps');
	Route::post('/itExecutive/import_ups/asset-sheet', 'ITExecutiveController@importAssetExcel_ups');
	Route::post('/itExecutive/import_ups_battery/asset-sheet', 'ITExecutiveController@importAssetExcel_ups_battery');
	Route::post('/itExecutive/import_web_cam/asset-sheet', 'ITExecutiveController@importAssetExcel_web_cam');
	Route::post('/itExecutive/import_system/import','ITExecutiveController@import_system_list')->name('it.uploadsystem');

	/*==========================Asset routes ends==============================*/

	/*==========================Leave routes starts===========================*/
    Route::post('/itExecutive/retract/leave/{id}', 'EmployeeLeaveController@submitretarctleave');
	//Route::get('/itExecutive/apply-leave', 'ITExecutiveController@getAddLeave');
	//Route::post('/itExecutive/apply-leave', 'ITExecutiveController@postAddLeave');
	Route::get('/itExecutive/my-leaves', 'ITExecutiveController@myLeaves');
	/*==========================Leave routes ends==============================*/

	/*==========================Resignation routes starts===========================*/
	Route::get('/itExecutive/resignation/retract/{id}', 'ResignController@retractResign');
	Route::get('/itExecutive/resignation/submit/{id}', 'ResignController@submitResign');
	Route::get('/itExecutive/retract/', 'ITExecutiveController@restract');
	Route::post('/itExecutive/retract/', 'ITExecutiveController@postapplyretract');
	Route::get('itExecutive/systemBySystemType/{system_type_id}/{asset_type_id}', 'AjaxController@getSystemNameBySystemType');
	/*==========================Resignation routes ends==============================*/
});
//Route::group(['middleware' => 'auth'], function () {
Route::get('/teamLead/dashboard', 'TeamLeadController@getDashboard');
Route::get('/teamLead/profile/edit', 'EmployeeController@getProfileEdit');
Route::post('/teamLead/profile/edit', 'EmployeeController@postProfileEdit');
//});
/*=======================IT Executive Dashboard Ends==========================*/


