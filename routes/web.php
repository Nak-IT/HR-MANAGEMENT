<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JSONController;
use App\Http\Controllers\AJAXController;
use App\Http\Controllers\PersonalInfoEmpController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\IdentificationController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CategoryEmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmploymentStatusController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\GovernmentEmployedDoctorController;
use App\Http\Controllers\HiredMedicalOfficerController;
use App\Http\Controllers\HiredNotMedicalOfficerController;
use App\Http\Controllers\UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Report\EmployedReport_Detail_Controller;
use App\Http\Controllers\Report\EmployedReport_Detail_secondController;
use App\Http\Controllers\Chart\GovernmentEmployedChartController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\Backup_Auto_Controller;

// Public route (welcome page)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route accessible by all authenticated users (Admin, Manager, Member)
Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

// Admin routes - only Admins can access
Route::middleware(['auth', CheckUserRole::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Add any other routes accessible only by Admin
    Route::get('/admin/manage', function () {
        return 'Admin management area';
    })->name('admin.manage');



});



Route::middleware(['auth', CheckUserRole::class . ':manager'])->group(function () {
    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
    Route::get('employed-chart-detail', [App\Http\Controllers\Chart\EmployedChart_Detail_Controller::class, 'index'])->name('chart.employedChartDetail');
Route::get('employed-chart-data', [App\Http\Controllers\Chart\EmployedChart_Detail_Controller::class, 'getEmployedChartData'])->name('chart.getEmployedChartData');
});

Route::middleware(['auth', CheckUserRole::class . ':member'])->group(function () {
    Route::get('/member/dashboard', function () {
        return view('member.dashboard');
    })->name('member.dashboard');
});



// Profile routes - accessible by all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





// Route for listing users (accessible by all authenticated users)
Route::get('/users', [UserController::class, 'index'])->middleware(['auth'])->name('users.index');

// Route for deleting users (admin check is done in the controller)
Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware(['auth'])->name('users.destroy');

// Route for editing a user's role (only admins can access this)
Route::get('/users/{id}/edit-role', [UserController::class, 'editRole'])->middleware(['auth'])->name('users.editRole');

// Route for updating a user's role (only admins can update this)
Route::patch('/users/{id}/edit-role', [UserController::class, 'updateRole'])->middleware(['auth'])->name('users.updateRole');

// Route::get('/users', [UserController::class, 'index'])->middleware(['auth'])->name('users.index');


// All Admin routes

    // Routes for PersonalInfoEmpController
    // Route::get('/', [DashboardController::class, 'index']);
    Route::get('/personal_info_emp', [PersonalInfoEmpController::class, 'index']);
    Route::get('/personal_info_Empl/GetAllData', [PersonalInfoEmpController::class, 'getAllData']);
    Route::post('/personal_info_Empl/Create', [PersonalInfoEmpController::class, 'addEmployee']);
    Route::delete('/personal_info_Empl/delete/{id}', [PersonalInfoEmpController::class, 'deleteEmployee'])->name('personal_info_Empl.delete');
    Route::get('/personal_info_Empl/GetDataId/{id}', [PersonalInfoEmpController::class, 'getEmployeeById']);
    Route::put('/personal_info_Empl/Update/{id}', [PersonalInfoEmpController::class, 'updateEmployee'])->name('personal_info_Empl.update');
    Route::get('/personal_info_Empl/GetEmployeeDetails/{id}', [PersonalInfoEmpController::class, 'getEmployeeDetails']);

    // Routes for HomeController
    Route::get('/about', [HomeController::class, 'about']);
    Route::get('/contact', [HomeController::class, 'contact']);




    // Routes for ProvinceController
    Route::get('/provinces', [ProvinceController::class, 'show']);
    Route::get('/get_provinces', [ProvinceController::class, 'getProvinces']);
    Route::post('/add_province', [ProvinceController::class, 'addProvince']);
    Route::post('/update_province/{id}', [ProvinceController::class, 'updateProvince']);
    Route::get('/getprovince_byid/{id}', [ProvinceController::class, 'getById']);
    Route::post('/delete_province/{id}', [ProvinceController::class, 'deleteProvince']);

    // Routes for IdentificationController
    Route::get('/identifications', [IdentificationController::class, 'show'])->name('identifications.show');
    Route::get('/identifications/getAllData', [IdentificationController::class, 'getAllData'])->name('identifications.getAllData');
    Route::post('/identifications', [IdentificationController::class, 'create'])->name('identifications.create');
    Route::get('/identifications/{id}', [IdentificationController::class, 'getDataById'])->name('identifications.getDataId');
    Route::post('/identifications/{id}', [IdentificationController::class, 'update'])->name('identifications.update');
    Route::delete('/identifications/{id}', [IdentificationController::class, 'delete'])->name('identifications.delete');
    Route::get('/identifications/getEmployeePhoto/{id}', [IdentificationController::class, 'getEmployeePhoto'])->name('identifications.getEmployeePhoto');
    Route::get('/identifications/getIdentificationDetails/{id}', [IdentificationController::class, 'getIdentificationDetails'])->name('identifications.getIdentificationDetails');

    // Routes for EducationController
    Route::get('/educations', [EducationController::class, 'show'])->name('educations.show');
    Route::get('/EducationS/GetAllData', [EducationController::class, 'getAllData'])->name('educations.getAllData');
    Route::post('/educations', [EducationController::class, 'create'])->name('educations.create');
    Route::get('/educations/{id}', [EducationController::class, 'getDataById'])->name('educations.getDataById');
    Route::put('/educations/{id}', [EducationController::class, 'update'])->name('educations.update');
    Route::delete('/educations/{id}', [EducationController::class, 'delete'])->name('educations.delete');
    Route::get('/educations/getEducationDetails/{id}', [EducationController::class, 'getEducationDetails'])->name('educations.getEducationDetails');
    Route::get('/educations/getEmployeePhoto/{id}', [EducationController::class, 'getEmployeePhoto'])->name('educations.getEmployeePhoto');

    // Routes for PositionController
    Route::get('/positions', [PositionController::class, 'show'])->name('positions.show');
    Route::get('/get_positions', [PositionController::class, 'getPositions']);
    Route::post('/addPosition', [PositionController::class, 'addPosition']);
    Route::get('/positions/{id}', [PositionController::class, 'getById'])->name('positions.getById');
    Route::put('/updatePosition/{id}', [PositionController::class, 'updatePosition']);
    Route::delete('/deletePosition/{id}', [PositionController::class, 'deletePosition']);

    // Routes for BuildingController
    Route::get('/buildings', [BuildingController::class, 'show'])->name('buildings.show');
    Route::get('/getBuildings', [BuildingController::class, 'getBuildings']);
    Route::post('/addBuilding', [BuildingController::class, 'addBuilding']);
    Route::get('/buildings/{id}', [BuildingController::class, 'getById'])->name('buildings.getById');
    Route::put('/updateBuilding/{id}', [BuildingController::class, 'updateBuilding']);
    Route::delete('/deleteBuilding/{id}', [BuildingController::class, 'deleteBuilding']);

    // Routes for CategoryEmployeeController
    Route::get('/category_employees', [CategoryEmployeeController::class, 'show']);
    Route::get('/getCategoryEmployees', [CategoryEmployeeController::class, 'getCategoryEmployees']);
    Route::post('/addCategoryEmployee', [CategoryEmployeeController::class, 'addCategoryEmployee']);
    Route::get('/getById/{id}', [CategoryEmployeeController::class, 'getById']);
    Route::put('/updateCategoryEmployee/{id}', [CategoryEmployeeController::class, 'updateCategoryEmployee']);
    Route::delete('/deleteCategoryEmployee/{id}', [CategoryEmployeeController::class, 'deleteCategoryEmployee']);

    // Routes for DepartmentController
    Route::get('/departments', [DepartmentController::class, 'show'])->name('departments.show');
    Route::get('/get_departments', [DepartmentController::class, 'getDepartments']);
    Route::post('addDepartment', [DepartmentController::class, 'addDepartment'])->name('addDepartment');
    Route::post('updateDepartment/{id}', [DepartmentController::class, 'updateDepartment'])->name('updateDepartment');
    Route::get('/getdepartment_byid/{id}', [DepartmentController::class, 'getById']);
    Route::delete('/delete_department/{id}', [DepartmentController::class, 'deleteDepartment']);

    // Routes for EmploymentStatusController
    Route::get('/employment_statuses', [EmploymentStatusController::class, 'show'])->name('employment_statuses.show');
    Route::get('/getEmploymentStatuses', [EmploymentStatusController::class, 'getEmploymentStatuses']);
    Route::post('/addEmploymentStatus', [EmploymentStatusController::class, 'addEmploymentStatus']);
    Route::get('/getEmploymentStatus/{id}', [EmploymentStatusController::class, 'getById']);
    Route::put('/updateEmploymentStatus/{id}', [EmploymentStatusController::class, 'updateEmploymentStatus']);
    Route::delete('/deleteEmploymentStatus/{id}', [EmploymentStatusController::class, 'deleteEmploymentStatus']);

    // Routes for SkillController
    Route::get('/skills', [SkillController::class, 'show'])->name('skills.show');
    Route::get('/get_skills', [SkillController::class, 'getSkills']);
    Route::post('/addSkill', [SkillController::class, 'addSkill']);
    Route::get('/getSkillById/{id}', [SkillController::class, 'getById']);
    Route::put('/updateSkill/{id}', [SkillController::class, 'updateSkill']);
    Route::delete('/deleteSkill/{id}', [SkillController::class, 'deleteSkill']);

    // Routes for GovernmentEmployedDoctorController
    Route::get('/government_employed_doctors', [GovernmentEmployedDoctorController::class, 'show'])->name('government_employed_doctors.show');
    Route::get('/government_employed_doctors/getAllData', [GovernmentEmployedDoctorController::class, 'getAllData'])->name('government_employed_doctors.getAllData');
    Route::post('/government_employed_doctors', [GovernmentEmployedDoctorController::class, 'create'])->name('government_employed_doctors.create');
    Route::get('/government_employed_doctors/{id}', [GovernmentEmployedDoctorController::class, 'getDataById'])->name('government_employed_doctors.getDataById');
    Route::put('/government_employed_doctors/{id}', [GovernmentEmployedDoctorController::class, 'update'])->name('government_employed_doctors.update');
    Route::delete('/government_employed_doctors/{id}', [GovernmentEmployedDoctorController::class, 'delete'])->name('government_employed_doctors.delete');
    Route::get('/government_employed_doctors/getGovernmentEmployedDoctorDetails/{id}', [GovernmentEmployedDoctorController::class, 'getGovernmentEmployedDoctorDetails'])->name('government_employed_doctors.getGovernmentEmployedDoctorDetails');
    Route::get('/government_employed_doctors/getEmployeePhoto/{id}', [GovernmentEmployedDoctorController::class, 'getEmployeePhoto'])->name('government_employed_doctors.getEmployeePhoto');

    Route::get('/hired_medical_officers', [HiredMedicalOfficerController::class, 'show'])->name('hired_medical_officers.show');
Route::get('/hired_medical_officers/getAllData', [HiredMedicalOfficerController::class, 'getAllData'])->name('hired_medical_officers.getAllData');
Route::post('/hired_medical_officers', [HiredMedicalOfficerController::class, 'create'])->name('hired_medical_officers.create');
Route::get('/hired_medical_officers/{id}', [HiredMedicalOfficerController::class, 'getDataById'])->name('hired_medical_officers.getDataById');
Route::put('/hired_medical_officers/{id}', [HiredMedicalOfficerController::class, 'update'])->name('hired_medical_officers.update');
Route::delete('/hired_medical_officers/{id}', [HiredMedicalOfficerController::class, 'delete'])->name('hired_medical_officers.delete');
Route::get('/hired_medical_officers/getHiredMedicalOfficerDetails/{id}', [HiredMedicalOfficerController::class, 'getHiredMedicalOfficerDetails'])->name('hired_medical_officers.getHiredMedicalOfficerDetails');
Route::get('/hired_medical_officers/getEmployeePhoto/{id}', [HiredMedicalOfficerController::class, 'getEmployeePhoto'])->name('hired_medical_officers.getEmployeePhoto');

Route::get('/hired_not_medical_officers', [HiredNotMedicalOfficerController::class, 'show'])->name('hired_not_medical_officers.show');
Route::get('/hired_not_medical_officers/getAllData', [HiredNotMedicalOfficerController::class, 'getAllData'])->name('hired_not_medical_officers.getAllData');
Route::post('/hired_not_medical_officers', [HiredNotMedicalOfficerController::class, 'create'])->name('hired_not_medical_officers.create');
Route::get('/hired_not_medical_officers/{id}', [HiredNotMedicalOfficerController::class, 'getDataById'])->name('hired_not_medical_officers.getDataById');
Route::put('/hired_not_medical_officers/{id}', [HiredNotMedicalOfficerController::class, 'update'])->name('hired_not_medical_officers.update');
Route::delete('/hired_not_medical_officers/{id}', [HiredNotMedicalOfficerController::class, 'delete'])->name('hired_not_medical_officers.delete');
Route::get('/hired_not_medical_officers/getHiredNotMedicalOfficerDetails/{id}', [HiredNotMedicalOfficerController::class, 'getHiredNotMedicalOfficerDetails'])->name('hired_not_medical_officers.getHiredNotMedicalOfficerDetails');
Route::get('/hired_not_medical_officers/getEmployeePhoto/{id}', [HiredNotMedicalOfficerController::class, 'getEmployeePhoto'])->name('hired_not_medical_officers.getEmployeePhoto');

Route::get('/update-employee-status', function() {
    return view('government_employed_doctors_and_hired_medical_officers_and_hired_not_medical_officers.government_employed_doctors_and_hired_medical_officers_and_hired_not_medical_officer');
})->name('update.status.view');

Route::get('/get-employees', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'getEmployees'])->name('get.employees');
Route::get('/filter-employees', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'filterEmployees'])->name('update.status.filterEmployees');
Route::get('/filter-employees', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'filterEmployees'])->name('filter.employees');

Route::get('/get-statuses', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'getStatuses'])->name('get.statuses');
Route::get('/get-employees', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'getEmployees'])->name('get.employees');
Route::get('/filter-employees', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'filterEmployees'])->name('filter.employees');
Route::get('/get-employee-photo', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'getEmployeePhoto'])->name('get.employee.photo');
Route::post('/update-status', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'updateStatus'])->name('update.status');
Route::get('/filter-employees', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'filterEmployees'])->name('filter.employees');
Route::get('/get-employee-details', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'getEmployeeDetails'])->name('get.employee.details');
Route::get('/get-employee-status', [UpdateStatusForGovernmentEmployedDoctorsAndHiredMedicalOfficersAndHiredNotMedicalOfficers::class, 'getEmployeeStatus'])->name('get.employee.status');
Route::get('/government_employed_doctors/getEmployeePhoto/{id}', [GovernmentEmployedDoctorController::class, 'getEmployeePhoto'])->name('government_employed_doctors.getEmployeePhoto');

// Government Employed Chart by Building
Route::get('/government-employed-chart-by-building', function() {
    return view('Chart.GovernmentEmployedChart_by_Building');
})->name('chart.government_employed_chart_by_building');



// Employed Report Detail Routes
Route::get('/employed-report-detail', [EmployedReport_Detail_Controller::class, 'showEmployedReportByBuilding'])->name('EmployedReport.detail');

Route::get('/employed-report-detail/get', [EmployedReport_Detail_Controller::class, 'getEmployedReport_Detail'])->name('EmployedReport.getEmployedReport_Detail');

Route::get('/employed-report-detail/export', [EmployedReport_Detail_Controller::class, 'exportEmployedReport_Detail'])->name('EmployedReport.exportEmployedReport_Detail');

// Employed Report Detail Second
Route::get('/employed-report-detail-second', [EmployedReport_Detail_secondController::class, 'showEmployedReportByBuilding'])->name('EmployedReport.detail_second');

Route::get('/employed-report-detail-second/get', [EmployedReport_Detail_secondController::class, 'getEmployedReport_Detail_second'])->name('EmployedReport.getEmployedReport_Detail_second');

Route::get('/employed-report-detail-second/export', [EmployedReport_Detail_secondController::class, 'exportEmployedReport_Detail_second'])->name('EmployedReport.exportEmployedReport_Detail_second');

Route::get('/employed-report-detail-second/export-third', [EmployedReport_Detail_secondController::class, 'exportEmployedReport_Detail_second_third'])
    ->name('EmployedReport.exportEmployedReport_Detail_second_third');

// Employed Chart Detail
Route::get('employed-chart-detail', [App\Http\Controllers\Chart\EmployedChart_Detail_Controller::class, 'index'])->name('chart.employedChartDetail');
Route::get('employed-chart-data', [App\Http\Controllers\Chart\EmployedChart_Detail_Controller::class, 'getEmployedChartData'])->name('chart.getEmployedChartData');


Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
Route::middleware(['auth', CheckUserRole::class . ':admin'])->group(function () {

Route::post('/backup/run', [BackupController::class, 'backup'])->name('backup.run');
Route::post('/backup/run_as_sql', [BackupController::class, 'backup_as_sql'])->name('backup.run_as_sql');
Route::post('/backup/run_as_winra', [BackupController::class, 'backup_as_winra'])->name('backup.run_as_winra');

Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
Route::post('/backup/restore_as_sql', [BackupController::class, 'restore_as_sql'])->name('backup.restore_as_sql');
Route::post('/backup/restore_as_winra', [BackupController::class, 'restore_as_winra'])->name('backup.restore_as_winra');

Route::post('/backup/clean', [BackupController::class, 'clean'])->name('backup.clean');

Route::get('/backup/progress', [BackupController::class, 'getBackupProgress'])->name('backup.getBackupProgress');


    Route::post('/queue/start', [BackupController::class, 'startQueueWorker'])->name('queue.start');
    Route::post('/queue/stop', [BackupController::class, 'stopQueueWorker'])->name('queue.stop');
});
Route::get('/backup_Auto', [Backup_Auto_Controller::class, 'index'])->name('backup.index_Auto');
Route::post('/backup/schedule', [Backup_Auto_Controller::class, 'updateSchedule'])->name('backup.updateSchedule');
require __DIR__.'/auth.php';


Route::get('/government-employed-report', function() {
    return view('report.government_employed_report');
})->name('report.government_employed_report');

Route::get('/report/getGovernmentEmployedReport', [ReportController::class, 'getGovernmentEmployedReport'])->name('report.getGovernmentEmployedReport');
Route::get('/report/exportGovernmentEmployedReport', [ReportController::class, 'exportGovernmentEmployedReport'])->name('report.exportGovernmentEmployedReport');

Route::get('/report/exportGovernmentEmployedReport', [ReportController::class, 'exportGovernmentEmployedReport'])->name('report.exportGovernmentEmployedReport');

Route::get('/hired-medical-officer-report', function() {
    return view('report.hired_medical_officer_report');
})->name('report.hired_medical_officer_report');

Route::get('/report/getHiredMedicalOfficerReport', [ReportController::class, 'getHiredMedicalOfficerReport'])->name('report.getHiredMedicalOfficerReport');
Route::get('/report/exportHiredMedicalOfficerReport', [ReportController::class, 'exportHiredMedicalOfficerReport'])->name('report.exportHiredMedicalOfficerReport');

Route::get('/hired-not-medical-officer-report', function() {
    return view('report.hired_not_medical_officer_report');
})->name('report.hired_not_medical_officer_report');

Route::get('/report/getHiredNotMedicalOfficerReport', [ReportController::class, 'getHiredNotMedicalOfficerReport'])->name('report.getHiredNotMedicalOfficerReport');
Route::get('/report/exportHiredNotMedicalOfficerReport', [ReportController::class, 'exportHiredNotMedicalOfficerReport'])->name('report.exportHiredNotMedicalOfficerReport');

Route::get('/government-employed-report-by-building', function() {
    return view('report.GovernmentEmployedReport_by_BuildingName');
})->name('report.government_employed_report_by_building');

Route::get('/report/getGovernmentEmployedReport_by_BuildingName', [ReportController::class, 'getGovernmentEmployedReport_by_BuildingName'])->name('report.getGovernmentEmployedReport_by_BuildingName');

Route::get('/report/exportGovernmentEmployedReport_by_BuildingName', [ReportController::class, 'exportGovernmentEmployedReport_by_BuildingName'])->name('report.exportGovernmentEmployedReport_by_BuildingName');

Route::get('/government-employed-report-by-building', [ReportController::class, 'showGovernmentEmployedReportByBuilding'])->name('report.government_employed_report_by_building');

Route::get('/government-employed-chart-by-building', function() {
    return view('Chart.GovernmentEmployedChart_by_Building');
})->name('chart.government_employed_chart_by_building');