<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\GenerateScriptController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Mikapi\CustomerController;
use App\Http\Controllers\Mikapi\DashboardController;
use App\Http\Controllers\Mikapi\DHCPController;
use App\Http\Controllers\Mikapi\HotspotController;
use App\Http\Controllers\Mikapi\LogController;
use App\Http\Controllers\Mikapi\MapsController;
use App\Http\Controllers\Mikapi\MonitorController;
use App\Http\Controllers\Mikapi\OdpController;
use App\Http\Controllers\Mikapi\PackageController;
use App\Http\Controllers\Mikapi\PPPController;
use App\Http\Controllers\Mikapi\ReportController;
use App\Http\Controllers\Mikapi\SystemController;
use App\Http\Controllers\Mikapi\VoucherTemplateController as MikapiVoucherTemplateController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TemporaryIpController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherTemplateController;
use App\Http\Controllers\VpnController;
use App\Http\Controllers\WhatsappTokenController;
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

Route::get('/logout', [LoginController::class, 'logout']);

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
        Route::get('generate/speed-test', [GenerateScriptController::class, 'speed_test'])->name('generate.speed_test');
        Route::get('generate/isolir', [GenerateScriptController::class, 'isolir'])->name('generate.isolir');

        Route::get('mikapi/report', [ReportController::class, 'index'])->name('mikapi.report');
        Route::get('mikapi/dashboard', [DashboardController::class, 'index'])->name('mikapi.dashboard');

        Route::get('mikapi/system/index', [SystemController::class, 'index'])->name('mikapi.system.index');
        Route::get('mikapi/system/user', [SystemController::class, 'user'])->name('mikapi.system.user');
        Route::get('mikapi/system/group', [SystemController::class, 'group'])->name('mikapi.system.group');
        Route::get('mikapi/system/user_active', [SystemController::class, 'user_active'])->name('mikapi.system.user_active');
        Route::get('mikapi/system/scheduler', [SystemController::class, 'scheduler'])->name('mikapi.system.scheduler');
        Route::get('mikapi/system/package', [SystemController::class, 'package'])->name('mikapi.system.package');
        Route::get('mikapi/system/script', [SystemController::class, 'script'])->name('mikapi.system.script');

        Route::get('mikapi/log-all', [LogController::class, 'index'])->name('mikapi.log.all');
        Route::get('mikapi/log-user', [LogController::class, 'user'])->name('mikapi.log.user');
        Route::get('mikapi/log-hotspot', [LogController::class, 'hotspot'])->name('mikapi.log.hotspot');

        Route::get('mikapi/hotspot/server', [HotspotController::class, 'server'])->name('mikapi.hotspot.server');
        Route::get('mikapi/hotspot/profile', [HotspotController::class, 'profile'])->name('mikapi.hotspot.profile');

        Route::get('mikapi/hotspot/user-generate', [HotspotController::class, 'user_generate'])->name('mikapi.hotspot.user.generate');
        Route::get('mikapi/hotspot/user', [HotspotController::class, 'user'])->name('mikapi.hotspot.user');

        Route::get('mikapi/hotspot/voucher-generate/{template}', [HotspotController::class, 'generate'])->name('mikapi.voucher.generate');
        Route::get('mikapi/hotspot/voucher', [HotspotController::class, 'voucher'])->name('mikapi.voucher.index');

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

        Route::get('mikapi/voucher-template', [MikapiVoucherTemplateController::class, 'index'])->name('mikapi.vouchertemplate.index');
        Route::get('mikapi/voucher-template/{template}', [MikapiVoucherTemplateController::class, 'show'])->name('mikapi.vouchertemplate.show');

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
        Route::get('wa-tokens', [WhatsappTokenController::class, 'index'])->name('wa_tokens.index');

        Route::delete('template', [VoucherTemplateController::class, 'destroyBatch'])->name('template.destroy.batch');
        Route::resource('template', VoucherTemplateController::class)->except(['create']);

        Route::resource('news', NewsController::class);

        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

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

        Route::get('mikapi/odps', [OdpController::class, 'index'])->name('mikapi.odps.index');
        Route::get('mikapi/customers', [CustomerController::class, 'index'])->name('mikapi.customers.index');
        Route::get('mikapi/packages', [PackageController::class, 'index'])->name('mikapi.packages.index');
        Route::get('mikapi/maps', [MapsController::class, 'index'])->name('mikapi.maps.index');
    });
});

// Route::get('tes2', function () {
//     $wa = WhatsappService::message('Tes')->sendToGroup();
//     dd($wa);
// });
