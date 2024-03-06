<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\DirectoryTaxonomyController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\KiddAitkenController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WlmKanbanController;
use App\Http\Controllers\WorkloadManagementController;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login/azure', [LoginController::class, 'redirecToProvider']);
Route::get('/login/azure/callback', [LoginController::class, 'handleProviderCallback']);

Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('under-construction', [App\Http\Controllers\HomeController::class, 'getUnderConstructionView'])->name('under-construction');

Route::get('test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');
Route::post('save-all', [App\Http\Controllers\HomeController::class, 'saveAll'])->name('save-all');
Route::post('time-zone-register', [UserController::class, 'timeZoneRegister'])->name('time-zone-register');



Route::group(['middleware' => ['permission.verifier']], function () {
    /**@REMOVE: This code has been removed. code was not used and was cousing torubles */
    //Route::post('search', [KiddAitkenController::class, 'search'])->name('search');
    Route::get('my-profile/{view?}/', [UserController::class, 'myProfile'])->name('my-profile');
    Route::post('update-profile', [UserController::class, 'updateProfile'])->name('update-profile');
    Route::post('delete-user-picture', [UserController::class, 'deleteUserPicture'])->name('delete-user-picture');

    Route::get('/impersonate-user/{id}', [App\Http\Controllers\ImpersonateController::class, 'impersonate'])->name('impersonate-user');
    Route::get('/impersonate/leave', [App\Http\Controllers\ImpersonateController::class, 'leave'])->name('leave');
    Route::post('search-users', [KiddAitkenController::class, 'searchUsers'])->name('search-users');

    Route::get('projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('project/create', [ProjectController::class, 'create'])->name('create-project');
    Route::post('save-project', [ProjectController::class, 'save'])->name('save-project');
    Route::get('project/{view}/{id}', [ProjectController::class, 'read'])->name('edit-project');
    Route::get('project/edit/{view}/{id}/{ids_extern?}', [ProjectController::class, 'read'])->name('read-project');
    Route::get('project/view/{view}/{id}', [ProjectController::class, 'view'])->name('view-project');
    Route::post('save-update-submissions', [ProjectController::class, 'saveUpdateSubmissions'])->name('save-update-submissions');
    Route::post('get-submission', [ProjectController::class, 'getSubmission'])->name('get-submission');
    Route::post('get-guides', [ProjectController::class, 'getGuidesFromTaxonomy'])->name('get-guides-from-taxonomy');
    Route::post('get-locations', [ProjectController::class, 'getLocationsFromTaxonomy'])->name('get-locations-from-taxonomy');
    Route::post('get-practices', [ProjectController::class, 'getPracticesFromTaxonomy'])->name('get-practices-from-taxonomy');
    Route::post('delete-project', [ProjectController::class, 'deleteProject'])->name('delete-project');
    Route::post('get-catalog-taxonomies', [ProjectController::class, 'getCatalogTaxonomies'])->name('get-catalog-taxonomies');
    Route::post('get-directories', [ProjectController::class, 'getDirectoriesFromTaxonomy'])->name('get-directories-from-taxonomy');
    Route::post('save-contact', [ProjectController::class, 'saveContact'])->name('save-contact');
    Route::post('edit-contact', [ProjectController::class, 'editContact'])->name('edit-contact');
    Route::post('delete-contact', [ProjectController::class, 'deleteContact'])->name('delete-contact');
    Route::post('get-dealine-directory', [ProjectController::class, 'getDealineDirectory'])->name('get-dealine-directory');
    Route::post('delete-contact-rel', [ProjectController::class, 'deleteContactRel'])->name('delete-contact-rel');

    Route::get('clients', [ClientController::class, 'index'])->name('clients');
    Route::get('client/create', [ClientController::class, 'create'])->name('create-client');
    Route::post('get-client', [ClientController::class, 'getClient'])->name('get-client');
    Route::get('client/read/{view}/{id}', [ClientController::class, 'read'])->name('read-client');
    Route::get('client/view/{view}/{id}', [ClientController::class, 'view'])->name('view-client');
    Route::post('save-client', [ClientController::class, 'save'])->name('save-client');
    Route::post('delete-client', [ClientController::class, 'delete'])->name('delete-client');
    Route::post('delete-client-picture', [ClientController::class, 'deletePicture'])->name('delete-client-picture');

    Route::get('allocation', [AllocationController::class, 'index'])->name('allocation');
    Route::post('update-submissions', [AllocationController::class, 'updateSubmissions'])->name('update-submissions');
    Route::get('submissions', [SubmissionController::class, 'index'])->name('submissions');

    Route::get('get-tasks-from-allocation', [AllocationController::class, 'getTasks'])->name('get-tasks-from-allocation');

    /**WLM LIST*/
    Route::get('wlm', [WorkloadManagementController::class, 'index'])->name('wlm');
    Route::post('update-status-c', [WorkloadManagementController::class, 'updateStatusC'])->name('update-status-c');
    Route::post('wlm', [WorkloadManagementController::class, 'filterTasks'])->name('filter-tasks');
    Route::post('search-tasks', [WorkloadManagementController::class, 'searchTasks'])->name('search-tasks');
    Route::get('/export', [WorkloadManagementController::class, 'export'])->name('export-tasks-wlm');
    /**WLM KANBAN*/
    Route::get('wlm-kanban', [WlmKanbanController::class, 'index'])->name('wlm-kanban');
    Route::post('update-status-kanban', [WlmKanbanController::class, 'updateStatusKanban'])->name('update-status-kanban');
    Route::post('search-kanban-tasks', [WlmKanbanController::class, 'searchKanbanTasks'])->name('search-kanban-tasks');

    Route::get('submission/view/{id}', [WlmKanbanController::class, 'viewSubmission'])->name('view-submission');

    Route::get('deadlines', [DeadlineController::class, 'index'])->name('deadlines');
    Route::get('deadline/create', [DeadlineController::class, 'create'])->name('create-deadline');
    Route::post('save-deadline-header', [DeadlineController::class, 'save'])->name('save-deadline-header');
    Route::get('deadline/{view}/{id}', [DeadlineController::class, 'read'])->name('read-deadlineheader');
    Route::post('save-deadline', [DeadlineController::class, 'saveDeadline'])->name('save-deadline');
    Route::post('delete-deadline', [DeadlineController::class, 'deleteDeadline'])->name('delete-deadline');
    Route::post('import-file-deadline', [DeadlineController::class, 'fileUploadDeadline'])->name('import-file-deadline');
    Route::post('get-deadlines-by-header', [DeadlineController::class, 'getDeadlinesByHeader'])->name('get-deadlines-by-header');
    Route::post('update-deadline-submission', [DeadlineController::class, 'updateDeadlineSubmission'])->name('update-deadline-submission');
    Route::post('update-deadline-submission-today', [DeadlineController::class, 'todayUpdateDeadlineSubmission'])->name('update-deadline-submission-today');
    //Catalogs Module
    Route::group(['prefix' => 'catalogs'], function () {

        Route::group(['prefix' => 'directory-taxonomy'], function () {
            Route::get('/{ids_extern?}', [DirectoryTaxonomyController::class, 'index'])->name('directory-taxonomy');
            Route::post('save-directory', [DirectoryTaxonomyController::class, 'saveDirectory'])->name('save-directory');
            Route::post('get-directory', [DirectoryTaxonomyController::class, 'getDirectory'])->name('get-directory');
            Route::post('delete-directory', [DirectoryTaxonomyController::class, 'deleteDirectory'])->name('delete-directory');

            Route::post('save-guide', [DirectoryTaxonomyController::class, 'saveGuide'])->name('save-guide');
            Route::post('get-guide', [DirectoryTaxonomyController::class, 'getGuide'])->name('get-guide');
            Route::post('get-guides-by-directory', [DirectoryTaxonomyController::class, 'getGuidesByDirectory'])->name('get-guides-by-directory');
            Route::post('get-practices-by-directory', [DirectoryTaxonomyController::class, 'getPracticesByDirectory'])->name('get-practices-by-directory');
            Route::post('delete-guide', [DirectoryTaxonomyController::class, 'deleteGuide'])->name('delete-guide');

            Route::post('save-location', [DirectoryTaxonomyController::class, 'saveLocation'])->name('save-location');
            Route::post('get-location', [DirectoryTaxonomyController::class, 'getLocation'])->name('get-location');
            Route::post('delete-location', [DirectoryTaxonomyController::class, 'deleteLocation'])->name('delete-location');

            Route::post('save-practice', [DirectoryTaxonomyController::class, 'savePractice'])->name('save-practice');
            Route::post('get-practice', [DirectoryTaxonomyController::class, 'getPractice'])->name('get-practice');
            Route::post('delete-practice', [DirectoryTaxonomyController::class, 'deletePractice'])->name('delete-practice');

            Route::post('save-all-directory-taxonomy', [DirectoryTaxonomyController::class, 'saveAllDirectoryTaxonomy'])->name('save-all-directory-taxonomy');
            Route::post('get-central-practice', [DirectoryTaxonomyController::class, 'getCentralPractice'])->name('get-central-practice');
        });

    });
    //Security Module
    Route::group(['prefix' => 'security'], function () {

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users');
            Route::get('create', [UserController::class, 'create'])->name('create-user');
            Route::get('read/{id}', [UserController::class, 'read'])->name('read-user');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit-user');
            Route::post('update', [UserController::class, 'save'])->name('save-user');
            Route::post('deactivate', [UserController::class, 'deactivate'])->name('deactivate-user');
        });

        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles');
            Route::get('read/{id}', [RoleController::class, 'read'])->name('read-role');
            Route::get('edit/{id}', [RoleController::class, 'edit'])->name('edit-role');
            Route::post('update', [RoleController::class, 'save'])->name('save-role');
            Route::post('deactivate', [RoleController::class, 'deactivate'])->name('deactivate-role');
            Route::post('delete-user-role', [RoleController::class, 'deleteUserRole'])->name('delete-user-role');
            Route::post('save-user-role', [RoleController::class, 'saveUserRole'])->name('save-user-role');
        });

        Route::group(['prefix' => 'actions'], function () {
            Route::get('/', [ActionController::class, 'index'])->name('actions');
            Route::post('read', [ActionController::class, 'read'])->name('read-action');
            Route::post('save', [ActionController::class, 'save'])->name('save-action');
            Route::post('deactivate', [ActionController::class, 'deactivate'])->name('deactivate-action');
        });

        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'index'])->name('permissions');
            Route::post('read', [PermissionController::class, 'read'])->name('read-permission');
            Route::post('save', [PermissionController::class, 'save'])->name('save-permission');
            Route::post('delete-permission', [PermissionController::class, 'delete'])->name('delete-permission');
        });

        Route::group(['prefix' => 'menuitems'], function () {
            Route::get('/', [MenuItemController::class, 'index'])->name('menuitems');
            Route::post('read', [MenuItemController::class, 'read'])->name('read-menuitem');
            Route::post('save', [MenuItemController::class, 'save'])->name('save-menuitem');
            Route::post('deactivate-menuitem', [MenuItemController::class, 'deactivate'])->name('deactivate-menuitem');
        });

        Route::group(['prefix' => 'groups'], function () {
            Route::get('/', [GroupController::class, 'index'])->name('groups');
            Route::get('group/create', [GroupController::class, 'create'])->name('create-group');
            Route::get('read', [GroupController::class, 'read'])->name('read-group');
            Route::post('save-group', [GroupController::class, 'save'])->name('save-group');
            Route::post('save-user-group', [GroupController::class, 'saveUserGroup'])->name('save-user-group');
            Route::post('get-group-detail', [GroupController::class, 'getGroupDetail'])->name('get-group-detail');
            Route::get('edit/group', [GroupController::class, 'edit'])->name('edit-group');
            Route::post('deactivate-group', [GroupController::class, 'deactivate'])->name('deactivate-group');
            Route::post('deactivate-groupdetail', [GroupController::class, 'deactivateGroupDetail'])->name('deactivate-groupdetail');
        });
    });
});
