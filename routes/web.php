<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Mikapi\DashboardController;
use App\Http\Controllers\Mikapi\DHCPController;
use App\Http\Controllers\Mikapi\HotspotController;
use App\Http\Controllers\Mikapi\LogController;
use App\Http\Controllers\Mikapi\MonitorController;
use App\Http\Controllers\Mikapi\PPPController;
use App\Http\Controllers\Mikapi\SystemController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TemporaryIpController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherTemplateController;
use App\Http\Controllers\VpnController;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/tes', function () {
    return view('tes');
});


Auth::routes([
    'verify' => true,
    'register' => true,
]);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])->name('auth.socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('auth.socialite.callback');


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => ['active']], function () {

        Route::resource('topup', TopupController::class);

        Route::get('page/contact', [PageController::class, 'contact'])->name('page.contact');

        Route::get('mikapi/dashboard', [DashboardController::class, 'index'])->name('mikapi.dashboard');

        Route::get('mikapi/system/routerboard', [SystemController::class, 'routerboard'])->name('mikapi.system.routerboard');
        Route::get('mikapi/system/resource', [SystemController::class, 'resource'])->name('mikapi.system.resource');
        Route::get('mikapi/system/user', [SystemController::class, 'user'])->name('mikapi.system.user');
        Route::get('mikapi/system/group', [SystemController::class, 'group'])->name('mikapi.system.group');
        Route::get('mikapi/system/user_active', [SystemController::class, 'user_active'])->name('mikapi.system.user_active');

        Route::get('mikapi/log', [LogController::class, 'index'])->name('mikapi.log.index');
        Route::get('mikapi/hotspot/server', [HotspotController::class, 'server'])->name('mikapi.hotspot.server');
        Route::get('mikapi/hotspot/profile', [HotspotController::class, 'profile'])->name('mikapi.hotspot.profile');
        Route::get('mikapi/hotspot/user', [HotspotController::class, 'user'])->name('mikapi.hotspot.user');
        Route::get('mikapi/hotspot/active', [HotspotController::class, 'active'])->name('mikapi.hotspot.active');
        Route::get('mikapi/hotspot/host', [HotspotController::class, 'host'])->name('mikapi.hotspot.host');
        Route::get('mikapi/hotspot/binding', [HotspotController::class, 'binding'])->name('mikapi.hotspot.binding');
        Route::get('mikapi/hotspot/cookie', [HotspotController::class, 'cookie'])->name('mikapi.hotspot.cookie');

        Route::get('mikapi/ppp/profile', [PPPController::class, 'profile'])->name('mikapi.ppp.profile');
        Route::get('mikapi/ppp/secret', [PPPController::class, 'secret'])->name('mikapi.ppp.secret');
        Route::get('mikapi/ppp/active', [PPPController::class, 'active'])->name('mikapi.ppp.active');
        Route::get('mikapi/ppp/l2tp_secret', [PPPController::class, 'l2tp_secret'])->name('mikapi.ppp.l2tp_secret');

        Route::get('mikapi/dhcp/lease', [DHCPController::class, 'lease'])->name('mikapi.dhcp.lease');

        Route::get('mikapi/monitor/interface', [MonitorController::class, 'interface'])->name('mikapi.monitor.interface');

        // Profile
        Route::get('setting/profile', [ProfileController::class, 'profile'])->name('setting.profile');
        Route::get('setting/profile/general', [ProfileController::class, 'profileEdit'])->name('setting.profile.edit');
        Route::post('setting/profile/general', [ProfileController::class, 'profileUpdate'])->name('setting.profile.update');

        Route::get('setting/profile/social/', [ProfileController::class, 'social'])->name('setting.profile.social');
        Route::post('setting/profile/social/', [ProfileController::class, 'socialUpdate'])->name('setting.profile.social.update');

        Route::get('setting/profile/password', [ProfileController::class, 'password'])->name('setting.profile.password');
        Route::post('setting/profile/password', [ProfileController::class, 'passwordUpdate'])->name('setting.profile.password.update');


        Route::get('routers', [RouterController::class, 'index'])->name('routers.index');



        // Route::post('vpn/{vpn}/extend', [VpnController::class, 'extend'])->name('vpn.extend');
        // Route::get('vpn/{vpn}/download', [VpnController::class, 'download'])->name('vpn.download');
        // Route::post('vpn-autocreate', [VpnController::class, 'autoCreate'])->name('vpn.autocreate');
        // Route::get('port-getbyuser', [PortController::class, 'getByUser'])->name('port.getbyuser');
        // Route::resource('vpn', VpnController::class)->only(['create', 'index', 'show']);

        Route::resource('invoice', InvoiceController::class)->only(['index', 'show']);

        Route::get('bank-paginate', [BankController::class, 'paginate'])->name('bank.paginate');

        // Route::group(['middleware' => ['role:admin']], function () {

        Route::resource('invoice', InvoiceController::class)->only(['store', 'update', 'destroy',]);

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('banks', [BankController::class, 'index'])->name('banks.index');
        Route::get('temporaryip', [TemporaryIpController::class, 'index'])->name('temporaryip.index');
        Route::get('servers', [ServerController::class, 'index'])->name('servers.index');
        Route::get('ports', [PortController::class, 'index'])->name('ports.index');

        Route::get('vpns-create', [VpnController::class, 'create'])->name('vpns.create');
        Route::get('vpns', [VpnController::class, 'index'])->name('vpns.index');




        Route::get('vpn-paginate', [VpnController::class, 'paginate'])->name('vpn.paginate');
        Route::post('vpn/{vpn}/temporary', [VpnController::class, 'temporary'])->name('vpn.temporary');
        Route::get('vpn/{vpn}/analyze', [VpnController::class, 'analyze'])->name('vpn.analyze');
        Route::post('vpn/{vpn}/send-email', [VpnController::class, 'sendEmail'])->name('vpn.send.email');
        Route::delete('vpn-batch', [VpnController::class, 'destroyBatch'])->name('vpn.destroy.batch');
        Route::resource('vpn', VpnController::class)->only(['store', 'update', 'destroy']);

        Route::delete('template', [VoucherTemplateController::class, 'destroyBatch'])->name('template.destroy.batch');
        Route::resource('template', VoucherTemplateController::class)->except(['create']);

        // Company
        Route::get('setting/company/general', [CompanyController::class, 'general'])->name('setting.company.general');
        Route::post('setting/company/general', [CompanyController::class, 'generalUpdate'])->name('setting.company.general.update');

        Route::get('setting/company/image', [CompanyController::class, 'image'])->name('setting.company.image');
        Route::post('setting/company/image', [CompanyController::class, 'imageUpdate'])->name('setting.company.image.update');

        Route::get('setting/company/social', [CompanyController::class, 'social'])->name('setting.company.social');
        Route::post('setting/company/social', [CompanyController::class, 'socialUpdate'])->name('setting.company.social.update');

        Route::get('setting/company/telegram', [SettingController::class, 'telegram'])->name('setting.company.telegram');
        Route::post('setting/company/telegram', [SettingController::class, 'telegramUpdate'])->name('setting.company.telegram.update');
        Route::put('setting/company/telegram', [SettingController::class, 'telegramSet'])->name('setting.company.telegram.set');

        Route::get('setting/company/backup', [SettingController::class, 'backup'])->name('setting.company.backup');

        Route::delete('database-batch', [DatabaseBackupController::class, 'destroyBatch'])->name('database.destroy.batch');
        Route::get('database-detail/{file}', [DatabaseBackupController::class, 'download'])->name('database.download');
        Route::get('database', [DatabaseBackupController::class, 'index'])->name('database.index');
        Route::post('database', [DatabaseBackupController::class, 'store'])->name('database.store');
        Route::delete('database/{file}', [DatabaseBackupController::class, 'destroy'])->name('database.destroy');

        Route::get('tools/phpinfo', [ToolController::class, 'php_info'])->name('tool.phpinfo');
        // });
    });
});

// Route::get('tes2', function () {
//     $wa = WhatsappService::message('Tes')->sendToGroup();
//     dd($wa);
// });
