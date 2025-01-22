<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\HomeController;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route::get('/tes', function (Request $request) {
//     return response()->json([
//         'headers' => $request->headers->all(),
//         'cf_connecting_ip' => $request->header('cf-connecting-ip'), // Huruf kecil
//         'CF_Connecting_IP' => $request->header('CF-Connecting-IP') // Huruf besar
//     ]);
// });


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

    // Profile
    Route::get('setting/profile', [ProfileController::class, 'profile'])->name('setting.profile');
    Route::get('setting/profile/edit', [ProfileController::class, 'profileEdit'])->name('setting.profile.edit');

    Route::group(['middleware' => ['active']], function () {


        Route::get('page/contact', [PageController::class, 'contact'])->name('page.contact');

        Route::get('mikapi/dashboard', [DashboardController::class, 'index'])->name('mikapi.dashboard');

        Route::get('mikapi/system/index', [SystemController::class, 'index'])->name('mikapi.system.index');
        Route::get('mikapi/system/user', [SystemController::class, 'user'])->name('mikapi.system.user');
        Route::get('mikapi/system/group', [SystemController::class, 'group'])->name('mikapi.system.group');
        Route::get('mikapi/system/user_active', [SystemController::class, 'user_active'])->name('mikapi.system.user_active');
        Route::get('mikapi/system/scheduler', [SystemController::class, 'scheduler'])->name('mikapi.system.scheduler');
        Route::get('mikapi/system/package', [SystemController::class, 'package'])->name('mikapi.system.package');
        Route::get('mikapi/system/script', [SystemController::class, 'script'])->name('mikapi.system.script');

        Route::get('mikapi/log', [LogController::class, 'index'])->name('mikapi.log.index');
        Route::get('mikapi/hotspot/server', [HotspotController::class, 'server'])->name('mikapi.hotspot.server');
        Route::get('mikapi/hotspot/profile', [HotspotController::class, 'profile'])->name('mikapi.hotspot.profile');

        Route::get('mikapi/hotspot/user', [HotspotController::class, 'user'])->name('mikapi.hotspot.user');
        Route::get('mikapi/hotspot/user/voucher/{template}', [HotspotController::class, 'voucher'])->name('mikapi.hotspot.voucher');

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

        // Route::group(['middleware' => ['role:admin']], function () {

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('banks', [BankController::class, 'index'])->name('banks.index');
        Route::get('temporaryip', [TemporaryIpController::class, 'index'])->name('temporaryip.index');
        Route::get('servers', [ServerController::class, 'index'])->name('servers.index');
        Route::get('ports', [PortController::class, 'index'])->name('ports.index');

        Route::get('vpns/create', [VpnController::class, 'create'])->name('vpns.create');
        Route::get('vpns', [VpnController::class, 'index'])->name('vpns.index');
        Route::get('routers', [RouterController::class, 'index'])->name('routers.index');

        Route::get('topups', [TopupController::class, 'index'])->name('topups.index');

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

        Route::get('database', [DatabaseBackupController::class, 'index'])->name('setting.database.index');

        Route::get('tools/phpinfo', [ToolController::class, 'php_info'])->name('tool.phpinfo');
        // });
    });
});

// Route::get('tes2', function () {
//     $wa = WhatsappService::message('Tes')->sendToGroup();
//     dd($wa);
// });
