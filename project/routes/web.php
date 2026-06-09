<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ProcurementReportController as AdminProcurementReportController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Candidate\ApplicationController as CandidateApplicationController;
use App\Http\Controllers\Candidate\DashboardController as CandidateDashboardController;
use App\Http\Controllers\Candidate\DocumentController as CandidateDocumentController;
use App\Http\Controllers\Candidate\JobController as CandidateJobController;
use App\Http\Controllers\Candidate\ProfileController as CandidateProfileController;
use App\Http\Controllers\Candidate\VerificationController as CandidateVerificationController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ProcurementReportController as ClientProcurementReportController;
use App\Http\Controllers\Client\ProcurementRecordController as ClientProcurementRecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Procurement\DashboardController as ProcurementDashboardController;
use App\Http\Controllers\Procurement\DirectorController as ProcurementDirectorController;
use App\Http\Controllers\Procurement\DirectorReportController as ProcurementDirectorReportController;
use App\Http\Controllers\Procurement\DirectorVerificationController as ProcurementDirectorVerificationController;
use App\Http\Controllers\Procurement\DocumentController as ProcurementDocumentController;
use App\Http\Controllers\Procurement\EnterpriseController as ProcurementEnterpriseController;
use App\Http\Controllers\Procurement\EnterpriseReportController as ProcurementEnterpriseReportController;
use App\Http\Controllers\Procurement\EnterpriseVerificationController as ProcurementEnterpriseVerificationController;
use App\Http\Controllers\Procurement\ProfileController as ProcurementProfileController;
use App\Http\Controllers\Procurement\VerificationController as ProcurementVerificationController;
use App\Http\Controllers\Procurement\VerificationHistoryController as ProcurementVerificationHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recruitment\ApplicationController as RecruitmentApplicationController;
use App\Http\Controllers\Recruitment\ApplicationDocumentController as RecruitmentApplicationDocumentController;
use App\Http\Controllers\Recruitment\CandidateController as RecruitmentCandidateController;
use App\Http\Controllers\Recruitment\DashboardController as RecruitmentDashboardController;
use App\Http\Controllers\Recruitment\JobController as RecruitmentJobController;
use App\Http\Controllers\Recruitment\ProfileController as RecruitmentProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)
        ->middleware('can:dashboard.view')
        ->name('dashboard');

    Route::get('/account/profile', [ProfileController::class, 'edit'])
        ->middleware('can:profile.view')
        ->name('profile.edit');
    Route::put('/account/profile', [ProfileController::class, 'update'])
        ->middleware(['can:profile.update', 'identity.verified'])
        ->name('profile.update');
    Route::get('/account/profile/{profile}/avatar', [ProfileController::class, 'showAvatar'])
        ->name('profile.avatar.show');
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->middleware('identity.verified')
        ->name('notifications.index');
    Route::put('/notifications/{notification}', [NotificationController::class, 'update'])
        ->middleware('identity.verified')
        ->name('notifications.update');

    Route::middleware(['role:superadmin', 'can:dashboard.view'])->group(function () {
        Route::get('/admin/dashboard', AdminDashboardController::class)->name('admin.dashboard');
        Route::get('/admin/users', [AdminUserController::class, 'index'])
            ->middleware('can:users.manage')
            ->name('admin.users.index');
        Route::get('/admin/users/create', [AdminUserController::class, 'create'])
            ->middleware('can:users.manage')
            ->name('admin.users.create');
        Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->middleware('can:users.manage')
            ->name('admin.users.edit');
        Route::post('/admin/users', [AdminUserController::class, 'store'])
            ->middleware('can:users.manage')
            ->name('admin.users.store');
        Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])
            ->middleware('can:users.manage')
            ->name('admin.users.update');
        Route::get('/admin/clients', [AdminClientController::class, 'index'])
            ->middleware('can:clients.manage')
            ->name('admin.clients.index');
        Route::get('/admin/clients/create', [AdminClientController::class, 'create'])
            ->middleware('can:clients.manage')
            ->name('admin.clients.create');
        Route::post('/admin/clients', [AdminClientController::class, 'store'])
            ->middleware('can:clients.manage')
            ->name('admin.clients.store');
        Route::get('/admin/verifications', [AdminVerificationController::class, 'index'])
            ->middleware('can:reports.view')
            ->name('admin.verifications.index');
        Route::get('/admin/verifications/{verificationRecord}', [AdminVerificationController::class, 'show'])
            ->middleware('can:reports.view')
            ->name('admin.verifications.show');
        Route::get('/admin/procurement-reports/{procurementUser}', [AdminProcurementReportController::class, 'show'])
            ->middleware('can:reports.view')
            ->name('admin.procurement-reports.show');
        Route::get('/admin/reports', AdminReportController::class)
            ->middleware('can:reports.view')
            ->name('admin.reports.index');
        Route::get('/admin/settings', [AdminSettingController::class, 'edit'])
            ->middleware('can:settings.manage')
            ->name('admin.settings.edit');
        Route::put('/admin/settings', [AdminSettingController::class, 'update'])
            ->middleware('can:settings.manage')
            ->name('admin.settings.update');
    });

    Route::middleware(['role:candidate'])->group(function () {
        Route::get('/candidate/identity-verification', [CandidateVerificationController::class, 'show'])->name('candidate.identity-verification.show');
        Route::post('/candidate/identity-verification', [CandidateVerificationController::class, 'store'])->name('candidate.identity-verification.store');
    });

    Route::middleware(['role:candidate', 'can:dashboard.view', 'identity.verified'])->group(function () {
        Route::get('/candidate/dashboard', CandidateDashboardController::class)->name('candidate.dashboard');
        Route::get('/candidate/profile', [CandidateProfileController::class, 'edit'])->name('candidate.profile.edit');
        Route::put('/candidate/profile', [CandidateProfileController::class, 'update'])->name('candidate.profile.update');
        Route::get('/candidate/documents', [CandidateDocumentController::class, 'index'])->name('candidate.documents.index');
        Route::post('/candidate/documents', [CandidateDocumentController::class, 'store'])->name('candidate.documents.store');
        Route::get('/candidate/documents/{document}', [CandidateDocumentController::class, 'show'])->name('candidate.documents.show');
        Route::get('/candidate/jobs', [CandidateJobController::class, 'index'])->name('candidate.jobs.index');
        Route::get('/candidate/jobs/{job}', [CandidateJobController::class, 'show'])->name('candidate.jobs.show');
        Route::get('/candidate/applications', [CandidateApplicationController::class, 'index'])->name('candidate.applications.index');
        Route::post('/candidate/jobs/{job}/apply', [CandidateApplicationController::class, 'store'])->name('candidate.applications.store');
    });

    Route::middleware(['role:recruitment', 'can:dashboard.view'])->group(function () {
        Route::get('/recruitment/dashboard', RecruitmentDashboardController::class)->name('recruitment.dashboard');
        Route::get('/recruitment/profile', [RecruitmentProfileController::class, 'edit'])->name('recruitment.profile.edit');
        Route::put('/recruitment/profile', [RecruitmentProfileController::class, 'update'])->name('recruitment.profile.update');
        Route::get('/recruitment/jobs', [RecruitmentJobController::class, 'index'])->name('recruitment.jobs.index');
        Route::get('/recruitment/jobs/create', [RecruitmentJobController::class, 'create'])->name('recruitment.jobs.create');
        Route::post('/recruitment/jobs', [RecruitmentJobController::class, 'store'])->name('recruitment.jobs.store');
        Route::get('/recruitment/candidates', [RecruitmentCandidateController::class, 'index'])->name('recruitment.candidates.index');
        Route::get('/recruitment/applications', [RecruitmentApplicationController::class, 'index'])->name('recruitment.applications.index');
        Route::get('/recruitment/applications/{application}', [RecruitmentApplicationController::class, 'show'])->name('recruitment.applications.show');
        Route::get('/recruitment/applications/{application}/documents/{document}', [RecruitmentApplicationDocumentController::class, 'show'])->name('recruitment.applications.documents.show');
        Route::get('/recruitment/applications/{application}/candidate-documents/{document}', [RecruitmentApplicationDocumentController::class, 'showCandidateDocument'])->name('recruitment.applications.candidate-documents.show');
        Route::put('/recruitment/applications/{application}', [RecruitmentApplicationController::class, 'update'])->name('recruitment.applications.update');
        Route::post('/recruitment/applications/{application}/notify', [RecruitmentApplicationController::class, 'notify'])->name('recruitment.applications.notify');
    });

    Route::middleware(['role:procurement'])->group(function () {
        Route::get('/procurement/identity-verification', [ProcurementVerificationController::class, 'identity'])->name('procurement.identity-verification.show');
        Route::post('/procurement/identity-verification', [ProcurementVerificationController::class, 'storeIdentity'])->name('procurement.identity-verification.store');
    });

    Route::middleware(['role:procurement', 'can:dashboard.view', 'identity.verified'])->group(function () {
        Route::get('/procurement/dashboard', ProcurementDashboardController::class)->name('procurement.dashboard');
        Route::get('/procurement/profile', [ProcurementProfileController::class, 'edit'])->name('procurement.profile.edit');
        Route::put('/procurement/profile', [ProcurementProfileController::class, 'update'])->name('procurement.profile.update');
        Route::get('/procurement/enterprise', [ProcurementEnterpriseController::class, 'edit'])->name('procurement.enterprise.edit');
        Route::get('/procurement/enterprise/report', [ProcurementEnterpriseReportController::class, 'show'])->name('procurement.enterprise.report');
        Route::put('/procurement/enterprise', [ProcurementEnterpriseController::class, 'update'])->name('procurement.enterprise.update');
        Route::post('/procurement/enterprise/verify', [ProcurementEnterpriseVerificationController::class, 'store'])->name('procurement.enterprise.verify');
        Route::get('/procurement/directors', [ProcurementDirectorController::class, 'index'])->name('procurement.directors.index');
        Route::get('/procurement/directors/{director}', [ProcurementDirectorController::class, 'show'])->name('procurement.directors.show');
        Route::get('/procurement/directors/{director}/report', [ProcurementDirectorReportController::class, 'show'])->name('procurement.directors.report');
        Route::post('/procurement/directors', [ProcurementDirectorController::class, 'store'])->name('procurement.directors.store');
        Route::post('/procurement/directors/{director}/verify', [ProcurementDirectorVerificationController::class, 'store'])->name('procurement.directors.verify');
        Route::get('/procurement/documents/proof-of-address', [ProcurementDocumentController::class, 'proofOfAddress'])->name('procurement.documents.proof-of-address');
        Route::post('/procurement/documents/proof-of-address', [ProcurementDocumentController::class, 'storeProofOfAddress'])->name('procurement.documents.proof-of-address.store');
        Route::get('/procurement/verifications/driver-licence', [ProcurementVerificationController::class, 'driverLicence'])->name('procurement.verifications.driver-licence');
        Route::post('/procurement/verifications/driver-licence', [ProcurementVerificationController::class, 'storeDriverLicence'])->name('procurement.verifications.driver-licence.store');
        Route::get('/procurement/verifications/bank-account', [ProcurementVerificationController::class, 'bankAccount'])->name('procurement.verifications.bank-account');
        Route::post('/procurement/verifications/bank-account', [ProcurementVerificationController::class, 'storeBankAccount'])->name('procurement.verifications.bank-account.store');
        Route::get('/procurement/verifications/history', [ProcurementVerificationHistoryController::class, 'index'])->name('procurement.verifications.history');
        Route::get('/procurement/verifications/history/{verificationRecord}', [ProcurementVerificationHistoryController::class, 'show'])->name('procurement.verifications.show');
        Route::post('/procurement/verifications/history/{verificationRecord}/retry', [ProcurementVerificationHistoryController::class, 'retry'])->name('procurement.verifications.retry');
    });

    Route::middleware(['role:client', 'can:dashboard.view'])->group(function () {
        Route::get('/client/dashboard', ClientDashboardController::class)->name('client.dashboard');
        Route::get('/client/procurement-records', [ClientProcurementRecordController::class, 'index'])->name('client.procurement-records.index');
        Route::get('/client/procurement-records/{procurementUser}', [ClientProcurementRecordController::class, 'show'])->name('client.procurement-records.show');
        Route::post('/client/procurement-records/{procurementUser}/notify', [ClientProcurementRecordController::class, 'notify'])->name('client.procurement-records.notify');
        Route::get('/client/procurement-records/{procurementUser}/report', [ClientProcurementReportController::class, 'show'])->name('client.procurement-records.report');
    });
});
