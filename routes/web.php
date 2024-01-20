<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectItemController;
use App\Http\Controllers\ExpensesCategoryController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ExpensesReportController;
use App\Http\Controllers\ProjectExpensesReportController;

use App\Http\Controllers\BkashTokenizePaymentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;

Route::get('/clear', function () {
    // Reoptimize class loader
    Artisan::call('optimize');

    // Clear Cache facade value
    Artisan::call('cache:clear');

    // Clear Route cache
    Artisan::call('route:clear');

    // Clear View cache
    Artisan::call('view:clear');

    // Clear Config cache
    Artisan::call('config:clear');

    // Redirect back to the dashboard with a success message
    // return "Cache cleared successfully";
    // usleep(3000000);
    return redirect('/dashboard');
});


Route::group(['middleware' => 'api'], function ($router) {
    Route::get('/registration', [RegistrationController::class, 'showRegisterFrom']);
    Route::get('/countries', [CountryController::class, 'getCountry'])->name('country');
    Route::get('/terms', [RegistrationController::class, 'getTerms']);
    //    Route::post('/register',[RegistrationController::class,'register']);
    //    Route::get('/verify',[RegistrationController::class,'verifyEmail']);

    Route::get('/', [RegistrationController::class, 'loginForm']);
    //    Route::post('/loginCheck',[RegistrationController::class,'login'])->name('logincheck');
    Route::post('/logout', [RegistrationController::class, 'logout'])->name('user_logout');

    //      Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index']);

    //      Sidebar route
    Route::get('get/sidebar/{role}', [ModuleController::class, 'sidebar'])->name('get.sidebar');

    //      Navigation route
    Route::get('/navigation', [ModuleController::class, 'viewNavigation'])->name('view.navigation');
    Route::get('/parent', [ModuleController::class, 'parentNav'])->name('parent');
    Route::post('/add-navigation', [ModuleController::class, 'addNavigation'])->name('add.navigation');
    Route::get('/show-navigation', [ModuleController::class, 'allNavigation'])->name('all.navigation');
    Route::get('/navigation-edit/{id}', [ModuleController::class, 'editNavigation']);
    Route::delete('/navigation-delete/{id}', [ModuleController::class, 'deleteNavigation']);

    //      User route
    Route::get('/users', [UserController::class, 'userIndex'])->name('view.user');
    Route::get('/all-users', [UserController::class, 'userData'])->name('view.alluser');
    Route::get('/role', [UserController::class, 'getRole'])->name('role');
    Route::post('/add-user', [UserController::class, 'userStore'])->name('user.store');
    Route::get('/user-edit/{id}', [UserController::class, 'editUser']);
    Route::delete('/user-delete/{id}', [UserController::class, 'deleteUser']);

    //      Role route
    Route::get('/roles', [UserController::class, 'roleIndex'])->name('view.role');
    Route::get('/all-roles', [UserController::class, 'roleData'])->name('all.role');
    Route::post('/add-role', [UserController::class, 'roleStore'])->name('role.store');
    Route::get('/role-edit/{id}', [UserController::class, 'editRole']);
    Route::delete('/role-delete/{id}', [UserController::class, 'deleteRole']);

    // Workgroup route
    Route::get('/workgroup', [ModuleController::class, 'workgroupIndex'])->name('view.workgroup');
    Route::post('/add-workgroup', [ModuleController::class, 'addWorkgroup'])->name('add.workgroup');
    Route::get('/show-workgroup', [ModuleController::class, 'allWorkgroup'])->name('all.workgroup');
    Route::get('/show-workgroup-parent', [ModuleController::class, 'getParent'])->name('workgroup.parent');
    Route::get('/workgroup-edit/{id}', [ModuleController::class, 'editWorkgroup']);
    Route::delete('/workgroup-delete/{id}', [ModuleController::class, 'deleteWorkgroup']);

    // User Workgroup route
    Route::get('/user-workgroup', [ModuleController::class, 'userGroupIndex'])->name('view.usergroup');
    Route::post('/add-user-workgroup', [ModuleController::class, 'addUserWorkgroup'])->name('add.user.workgroup');
    Route::get('/show-user-workgroup-data', [ModuleController::class, 'allUserWorkgroup'])->name('all.user.workgroup');
    Route::get('/show-all-workgroups', [ModuleController::class, 'allWorkgroupData'])->name('workgroup.all.id');
    Route::get('/show-workgroup-all-users', [ModuleController::class, 'getAllUser'])->name('workgroup.user');
    Route::get('/user-workgroup-edit/{id}', [ModuleController::class, 'editUserWorkgroup']);
    Route::delete('/user-workgroup-delete/{id}', [ModuleController::class, 'deleteUserWorkgroup']);

    // lookup route
    Route::get('/lookup', [ModuleController::class, 'lookupIndex'])->name('view.lookup');
    Route::post('/add-lookup', [ModuleController::class, 'addLookup'])->name('add.lookup');
    Route::get('/show-lookup', [ModuleController::class, 'allLookup'])->name('all.lookup');
    Route::get('/show-lookup-parent', [ModuleController::class, 'getLookupParent'])->name('lookup.parent');
    Route::get('/lookup-edit/{id}', [ModuleController::class, 'editLookup']);
    Route::delete('/lookup-delete/{id}', [ModuleController::class, 'deleteLookup']);

    // Profile route
    Route::get('/user/profile', [UserController::class, 'getProfile'])->name('user.profile');
    Route::get('/user/edit/profile', [UserController::class, 'getEditProfile'])->name('user.editProfile');
    Route::post('/user/profile/change/password', [UserController::class, 'getChangePassword'])->name('change.password');
    Route::post('/user/profile/change/data', [UserController::class, 'getChangeProfileData'])->name('change.user.data');
    Route::post('/user/profile/image/change', [UserController::class, 'getChangeProfileImage'])->name('change.profile.image');
    Route::post('/user/profile/nid/change', [UserController::class, 'getChangeNID'])->name('change.profile.nid');
    Route::get('/user/profile/nid/show/{id}', [UserController::class, 'getNIDdata'])->name('show.nid');

    // dashboard route
    Route::get('/show/dashboard/data', [ModuleController::class, 'allUserRequest'])->name('all.dashboard.data');
    Route::get('/user/profile/info/{id}', [ModuleController::class, 'showUserProfile'])->name('user.profile.page');
    Route::get('/individual-users-profile/{id}', [ModuleController::class, 'individualProfile'])->name('ind.profile.data');
    Route::get('/user/accept/data/{id}', [ModuleController::class, 'userAcceptFn'])->name('user.profile.accept');
    Route::post('/user/reject/data/', [ModuleController::class, 'userRejectFn'])->name('user.rejection.data');
    Route::get('/user/pos/dashboard/list/{role}', [ModuleController::class, 'posDashboardInfo'])->name('user.pos.dashboard');
    Route::get('/user/pos/complete/payment/{userid}', [ModuleController::class, 'posCompletePayment'])->name('user.pos.complete.list');


    // Admin privilege route
    Route::get('/privilege', [ModuleController::class, 'privilegeIndex'])->name('view.privilege');
    Route::get('show/privilege', [ModuleController::class, 'showPrivilegeData'])->name('show.privilege');
    Route::get('update/privilege', [ModuleController::class, 'updatePrivilegeData'])->name('privilege.update');


    // Setting route
    Route::get('/setting', [SettingController::class, 'settingIndex'])->name('view.setting');
    Route::post('/setting-store', [SettingController::class, 'Store'])->name('store.setting');
    Route::get('/show-setting', [SettingController::class, 'settingShow'])->name('show.setting');
    Route::post('/setting-update', [SettingController::class, 'settingUpdate'])->name('Update.setting');
    // Route::get('/setting-edit/{id}',[SettingController::class,'editsetting']);

    // Project route
    Route::get('/project', [ProjectController::class, 'projectIndex'])->name('view.project');
    Route::post('/project-store', [ProjectController::class, 'Store'])->name('store.project');
    Route::get('/show-project', [ProjectController::class, 'projectShow'])->name('show.project');
    Route::delete('/project-delete/{id}', [ProjectController::class, 'deleteProject']);
    Route::get('/project-edit/{id}', [ProjectController::class, 'editProject']);
    Route::get('/show-lookup-child', [ProjectController::class, 'getLookupChild'])->name('lookup.chlid.project');

    // Project-item route
    Route::get('/project-item', [ProjectItemController::class, 'projectItemIndex'])->name('view.project-item');
    Route::post('/project-item-store', [ProjectItemController::class, 'Store'])->name('store.project-item');
    Route::get('/show-project-item', [ProjectItemController::class, 'projectItemShow'])->name('show.project-item');
    Route::delete('/project-item-delete/{id}', [ProjectItemController::class, 'deleteProjectItem']);
    Route::get('/project-item-edit/{id}', [ProjectItemController::class, 'editProjectItem']);
    Route::get('/all-project', [ProjectItemController::class, 'projectData'])->name('all.project');
    Route::get('/item-lookup-child', [ProjectItemController::class, 'getLookupChild'])->name('lookup.chlid.project-item');

    // expenses_category
    Route::get('/expenses-category', [ExpensesCategoryController::class, 'ExpensesCategoryIndex'])->name('view.ExpensesCategory');
    Route::post('/add-expenses-category', [ExpensesCategoryController::class, 'addExpensesCategory'])->name('add.ExpensesCategory');
    Route::get('/show-expenses-category', [ExpensesCategoryController::class, 'allExpensesCategory'])->name('all.ExpensesCategory');
    Route::get('/show-expenses-category-parent', [ExpensesCategoryController::class, 'getLookupParent'])->name('lookup.parent.ExpensesCategory');
    Route::get('/expenses-category-edit/{id}', [ExpensesCategoryController::class, 'editExpensesCategory']);
    Route::delete('/expenses-category-delete/{id}', [ExpensesCategoryController::class, 'deleteExpensesCategory']);

    // expenses route
    Route::get('/expenses', [ExpensesController::class, 'ExpensesIndex'])->name('view.Expenses');
    Route::post('/add-expenses', [ExpensesController::class, 'addExpenses'])->name('add.Expenses');
    Route::get('/show-expenses', [ExpensesController::class, 'allExpenses'])->name('all.Expenses');
    Route::get('/show-expenses-parent', [ExpensesController::class, 'getLookupParent'])->name('lookup.parent.Expenses');
    Route::get('/expenses-edit/{id}', [ExpensesController::class, 'editExpenses']);
    Route::delete('/expenses-delete/{id}', [ExpensesController::class, 'deleteExpenses']);
    Route::get('/all-expenses', [ExpensesController::class, 'ExpensesCategory'])->name('all.Expenses.category');
    Route::get('/get-project', [ExpensesController::class, 'getProject'])->name('getProject');
    Route::get('/get-item/{project}', [ExpensesController::class, 'getItem'])->name('getItem');


    // expenses report
    Route::get('/expenses-report', [ExpensesReportController::class, 'ExpensesReportIndex'])->name('view.ExpensesReport');
    Route::get('/filter-expenses', [ExpensesReportController::class, 'FilterExpenses'])->name('filterExpenses');
    Route::get('/filter-date', [ExpensesReportController::class, 'FilterDate'])->name('FilterDate');
    Route::get('/all-report-expenses', [ExpensesReportController::class, 'ReportExpensesCategory'])->name('Report.Expenses.category');

    // project expenses report
    Route::get('/project-expense', [ProjectExpensesReportController::class, 'ProjectExpensesReportIndex'])->name('view.ProjectExpensesReport');
      Route::get('/filter-project-expenses', [ProjectExpensesReportController::class, 'FilterProjectExpenses'])->name('filterProjectExpenses');
    Route::get('/project-report', [ProjectExpensesReportController::class, 'ProjectName'])->name('project.Name');
    Route::get('/project-item-report', [ProjectExpensesReportController::class, 'ProjectItemName'])->name('project.item.Name');




    // Route::post('/add-workgroup',[SettingController::class,'addWorkgroup'])->name('add.workgroup');
    // Route::get('/show-workgroup',[SettingController::class,'allWorkgroup'])->name('all.workgroup');
    // Route::get('/show-workgroup-parent',[SettingController::class,'getParent'])->name('workgroup.parent');
    // Route::get('/workgroup-edit/{id}',[SettingController::class,'editWorkgroup']);
    // Route::delete('/workgroup-delete/{id}',[SettingController::class,'deleteWorkgroup']);

    // Payment Routes for bKash
    //    Route::get('/bkash/payment', [BkashTokenizePaymentController::class,'index']);
    //    Route::get('/bkash/create-payment', [BkashTokenizePaymentController::class,'createPayment'])->name('bkash-create-payment');
    //    Route::get('/bkash/callback', [BkashTokenizePaymentController::class,'callBack'])->name('bkash-callBack');
});
