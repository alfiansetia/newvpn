<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BalanceHistoryController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\DatabaseBackupController;
use App\Http\Controllers\Api\Mikapi\CustomerController;
use App\Http\Controllers\Api\Mikapi\DashboardController;
use App\Http\Controllers\Api\Mikapi\DHCP\LeasesController as DHCPLeasesController;
use App\Http\Controllers\Api\Mikapi\Hotspot\ActiveController as HotspotActiveController;
use App\Http\Controllers\Api\Mikapi\Hotspot\BindingController as HotspotBindingController;
use App\Http\Controllers\Api\Mikapi\Hotspot\CookieController as HotspotCookieController;
use App\Http\Controllers\Api\Mikapi\Hotspot\HostController as HotspotHostController;
use App\Http\Controllers\Api\Mikapi\Hotspot\ProfileController as HotspotProfileController;
use App\Http\Controllers\Api\Mikapi\Hotspot\ServerController as HotspotServerController;
use App\Http\Controllers\Api\Mikapi\Hotspot\ServerProfileController as HotspotServerProfileController;
use App\Http\Controllers\Api\Mikapi\Hotspot\UserController as HotspotUserController;
use App\Http\Controllers\Api\Mikapi\InterfaceController;
use App\Http\Controllers\Api\Mikapi\LogController;
use App\Http\Controllers\Api\Mikapi\MapsController;
use App\Http\Controllers\Api\Mikapi\OdpController;
use App\Http\Controllers\Api\Mikapi\PackageController as MikapiPackageController;
use App\Http\Controllers\Api\Mikapi\PoolController;
use App\Http\Controllers\Api\Mikapi\PPP\ActiveController as PPPActiveController;
use App\Http\Controllers\Api\Mikapi\PPP\L2tpSecretController as PPPL2tpSecretController;
use App\Http\Controllers\Api\Mikapi\PPP\ProfileController as PPPProfileController;
use App\Http\Controllers\Api\Mikapi\PPP\SecretController as PPPSecretController;
use App\Http\Controllers\Api\Mikapi\QueueController;
use App\Http\Controllers\Api\Mikapi\ReportController;
use App\Http\Controllers\Api\Mikapi\System\GroupController;
use App\Http\Controllers\Api\Mikapi\System\PackageController;
use App\Http\Controllers\Api\Mikapi\System\SchedulerController;
use App\Http\Controllers\Api\Mikapi\System\ScriptController;
use App\Http\Controllers\Api\Mikapi\System\SystemController;
use App\Http\Controllers\Api\Mikapi\System\UserActiveController;
use App\Http\Controllers\Api\Mikapi\System\UserController as SystemUserController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\OnetapController;
use App\Http\Controllers\Api\PortController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RouterController;
use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\Api\TemporaryIpController;
use App\Http\Controllers\Api\TopupController;
use App\Http\Controllers\Api\TopupUserController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TripayController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VoucherTemplateController;
use App\Http\Controllers\Api\VpnController;
use App\Http\Controllers\Api\VpnUserController;
use App\Http\Controllers\Api\WhatsappTokenController;
use App\Services\TripayServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/auth/onetap', [OnetapController::class, 'login'])->name('api.auth.onetap.login');



Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('profile', [ProfileController::class, 'profile']);
    // Route::put('profile', [ProfileController::class, 'profileUpdate']);
    // Route::put('password', [ProfileController::class, 'passwordUpdate']);

    Route::group(['middleware' => ['verified']], function () {
        Route::post('profile/general', [ProfileController::class, 'general'])->name('api.profile.update.general');
        Route::post('profile/social', [ProfileController::class, 'social'])->name('api.profile.update.social');
        Route::post('profile/password', [ProfileController::class, 'password'])->name('api.profile.update.password');

        Route::delete('template', [VoucherTemplateController::class, 'destroyBatch'])->name('api.template.destroy.batch');
        Route::apiResource('template', VoucherTemplateController::class)->names('api.template');

        Route::get('balance_history', [BalanceHistoryController::class, 'index'])->name('api.balance.index');

        Route::get('user-paginate', [UserController::class, 'paginate'])->name('api.users.paginate');
        Route::delete('users', [UserController::class, 'destroyBatch'])->name('api.users.destroy.batch');
        Route::apiResource('users', UserController::class)->names('api.users');

        Route::get('bank-paginate', [BankController::class, 'paginate'])->name('api.banks.paginate');
        Route::delete('banks', [BankController::class, 'destroyBatch'])->name('api.banks.destroy.batch');
        Route::apiResource('banks', BankController::class)->names('api.banks');

        Route::get('transaction-summary', [TransactionController::class, 'summary'])->name('api.transactions.summary');
        Route::delete('transactions', [TransactionController::class, 'destroyBatch'])->name('api.transactions.destroy.batch');
        Route::apiResource('transactions', TransactionController::class)->names('api.transactions');

        Route::delete('news', [NewsController::class, 'destroyBatch'])->name('api.news.destroy.batch');
        Route::apiResource('news', NewsController::class)->names('api.news');

        Route::delete('temporaryips', [TemporaryIpController::class, 'destroyBatch'])->name('api.temporaryips.destroy.batch');
        Route::apiResource('temporaryips', TemporaryIpController::class)->names('api.temporaryips');

        Route::get('server-paginate', [ServerController::class, 'paginate'])->name('api.servers.paginate');
        Route::get('servers/{server}/ping', [ServerController::class, 'ping'])->name('api.servers.ping');
        Route::delete('servers', [ServerController::class, 'destroyBatch'])->name('api.servers.destroy.batch');
        Route::apiResource('servers', ServerController::class)->names('api.servers');

        Route::get('router-paginate', [RouterController::class, 'paginate'])->name('api.routers.paginate');
        Route::get('routers/{router}/ping', [RouterController::class, 'ping'])->name('api.routers.ping');
        Route::delete('routers', [RouterController::class, 'destroyBatch'])->name('api.routers.destroy.batch');
        Route::apiResource('routers', RouterController::class)->names('api.routers');

        Route::get('port-paginate-user', [PortController::class, 'paginateUser'])->name('api.ports.paginate.user');
        Route::get('port-paginate', [PortController::class, 'paginate'])->name('api.ports.paginate');
        Route::delete('ports', [PortController::class, 'destroyBatch'])->name('api.ports.destroy.batch');
        Route::apiResource('ports', PortController::class)->names('api.ports');

        Route::get('vpn-user-paginate', [VpnUserController::class, 'paginate'])->name('api.vpns.user.paginate');
        Route::apiResource('vpn-user', VpnUserController::class)->names('api.vpns.user')->only(['index', 'show', 'store', 'update']);

        Route::get('vpn-paginate', [VpnController::class, 'paginate'])->name('api.vpns.paginate');
        Route::post('vpns/{vpn}/send-email', [VpnController::class, 'sendEmail'])->name('api.vpns.send.email');
        Route::post('vpns/{vpn}/temporary', [VpnController::class, 'temporary'])->name('api.vpns.temporary');
        Route::delete('vpns', [VpnController::class, 'destroyBatch'])->name('api.vpns.destroy.batch');
        Route::apiResource('vpns', VpnController::class)->names('api.vpns');

        Route::apiResource('topups', TopupController::class)->names('api.topups');
        Route::apiResource('topup-user', TopupUserController::class)->names('api.topups.user')->only(['index', 'show', 'store', 'destroy']);

        Route::get('router-paginate', [WhatsappTokenController::class, 'paginate'])->name('api.wa_tokens.paginate');
        Route::post('wa-tokens-sync', [WhatsappTokenController::class, 'sync'])->name('api.wa_tokens.sync');
        Route::post('wa-tokens-test/{id}', [WhatsappTokenController::class, 'test'])->name('api.wa_tokens.test');
        Route::delete('wa-tokens', [WhatsappTokenController::class, 'destroyBatch'])->name('api.wa_tokens.destroy.batch');
        Route::apiResource('wa-tokens', WhatsappTokenController::class)->names('api.wa_tokens');


        Route::delete('setting/databases', [DatabaseBackupController::class, 'destroyBatch'])->name('api.setting.databases.destroy.batch');
        Route::apiResource('setting/databases', DatabaseBackupController::class)->names('api.setting.databases')->except(['update']);


        Route::get('mikapi/dashboard/get-data', [DashboardController::class, 'get'])->name('api.mikapi.dashboard.get');

        Route::get('mikapi/report-summary', [ReportController::class, 'summary'])->name('api.mikapi.report.summary');
        Route::apiResource('mikapi/reports', ReportController::class)
            ->only(['index', 'show', 'destroy'])
            ->names('api.mikapi.reports');
        Route::delete('mikapi/reports', [ReportController::class, 'destroy_batch'])
            ->name('api.mikapi.reports.destroy.batch');

        Route::apiResource('mikapi/hotspot/profiles', HotspotProfileController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('api.mikapi.hotspot.profiles');
        Route::delete('mikapi/hotspot/profiles', [HotspotProfileController::class, 'destroy_batch'])
            ->name('api.mikapi.hotspot.profiles.destroy.batch');

        Route::delete('mikapi/hotspot/users', [HotspotUserController::class, 'destroy_batch'])
            ->name('api.mikapi.hotspot.users.destroy.batch');
        Route::delete('mikapi/hotspot/user-comment', [HotspotUserController::class, 'destroy_comment'])
            ->name('api.mikapi.hotspot.users.destroy.comment');
        Route::post('mikapi/hotspot/user-generate', [HotspotUserController::class, 'generate'])
            ->name('api.mikapi.hotspot.users.generate');
        Route::get('mikapi/hotspot/user-comment', [HotspotUserController::class, 'comment'])
            ->name('api.mikapi.hotspot.users.comment');
        Route::get('mikapi/hotspot/user-refresh', [HotspotUserController::class, 'refresh'])
            ->name('api.mikapi.hotspot.users.refresh');
        Route::apiResource('mikapi/hotspot/users', HotspotUserController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('api.mikapi.hotspot.users');

        Route::apiResource('mikapi/hotspot/actives', HotspotActiveController::class)
            ->only(['index', 'show', 'destroy'])
            ->names('api.mikapi.hotspot.actives');
        Route::delete('mikapi/hotspot/actives', [HotspotActiveController::class, 'destroy_batch'])
            ->name('api.mikapi.hotspot.actives.destroy.batch');

        Route::apiResource('mikapi/hotspot/hosts', HotspotHostController::class)
            ->only(['index', 'show', 'destroy'])
            ->names('api.mikapi.hotspot.hosts');
        Route::delete('mikapi/hotspot/hosts', [HotspotHostController::class, 'destroy_batch'])
            ->name('api.mikapi.hotspot.hosts.destroy.batch');

        Route::apiResource('mikapi/hotspot/bindings', HotspotBindingController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('api.mikapi.hotspot.bindings');
        Route::delete('mikapi/hotspot/bindings', [HotspotBindingController::class, 'destroy_batch'])
            ->name('api.mikapi.hotspot.bindings.destroy.batch');

        Route::apiResource('mikapi/hotspot/cookies', HotspotCookieController::class)
            ->only(['index', 'show', 'destroy'])
            ->names('api.mikapi.hotspot.cookies');
        Route::delete('mikapi/hotspot/cookies', [HotspotCookieController::class, 'destroy_batch'])
            ->name('api.mikapi.hotspot.cookies.destroy.batch');

        Route::apiResource('mikapi/hotspot/servers', HotspotServerController::class)
            ->only(['index', 'show', 'update'])
            ->names('api.mikapi.hotspot.servers');

        Route::apiResource('mikapi/hotspot/serverprofiles', HotspotServerProfileController::class)
            ->only(['index', 'show', 'update'])
            ->names('api.mikapi.hotspot.serverprofiles');

        Route::apiResource('api/mikapi/queues', QueueController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('api.mikapi.queues');

        Route::apiResource('api/mikapi/pools', PoolController::class)
            ->only(['index', 'show'])
            ->names('api.mikapi.pools');

        Route::apiResource('mikapi/ppp/profiles', PPPProfileController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('api.mikapi.ppp.profiles');
        Route::delete('mikapi/ppp/profiles', [PPPProfileController::class, 'destroy_batch'])
            ->name('api.mikapi.ppp.profiles.destroy.batch');

        Route::apiResource('mikapi/ppp/secrets', PPPSecretController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('api.mikapi.ppp.secrets');
        Route::delete('mikapi/ppp/secrets', [PPPSecretController::class, 'destroy_batch'])
            ->name('api.mikapi.ppp.secrets.destroy.batch');

        Route::apiResource('mikapi/ppp/actives', PPPActiveController::class)
            ->only(['index', 'show', 'destroy'])
            ->names('api.mikapi.ppp.actives');
        Route::delete('mikapi/ppp/actives', [PPPActiveController::class, 'destroy_batch'])
            ->name('api.mikapi.ppp.actives.destroy.batch');

        Route::apiResource('mikapi/ppp/l2tp_secrets', PPPL2tpSecretController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('api.mikapi.ppp.l2tp_secrets');
        Route::delete('mikapi/ppp/l2tp_secrets', [PPPL2tpSecretController::class, 'destroy_batch'])
            ->name('api.mikapi.ppp.l2tp_secrets.destroy.batch');

        Route::apiResource('mikapi/dhcp/leases', DHCPLeasesController::class)
            ->only(['index', 'show', 'destroy'])
            ->names('api.mikapi.dhcp.leases');
        Route::delete('mikapi/dhcp/leases', [DHCPLeasesController::class, 'destroy_batch'])
            ->name('api.mikapi.dhcp.leases.destroy.batch');

        Route::get('mikapi/system/routerboards', [SystemController::class, 'routerboard'])
            ->name('api.mikapi.system.routerboards.index');
        Route::get('mikapi/system/routerboards-settings', [SystemController::class, 'setting'])
            ->name('api.mikapi.system.routerboards.settings');
        Route::get('mikapi/system/resources', [SystemController::class, 'resource'])
            ->name('api.mikapi.system.resources.index');

        Route::get('mikapi/interfaces/{id}/monitor', [InterfaceController::class, 'monitor'])
            ->name('api.mikapi.interfaces.monitor');
        Route::apiResource('mikapi/interfaces', InterfaceController::class)
            ->only(['index', 'show'])
            ->names('api.mikapi.interfaces');

        Route::apiResource('mikapi/system/packages', PackageController::class)->only(['index', 'show']);

        Route::apiResource('mikapi/system/users', SystemUserController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])->names('api.mikapi.system.users');
        Route::delete('mikapi/system/users', [SystemUserController::class, 'destroy_batch'])
            ->name('api.mikapi.system.users.destroy.batch');

        Route::apiResource('mikapi/system/groups', GroupController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('api.mikapi.system.groups');
        Route::delete('mikapi/system/groups', [GroupController::class, 'destroy_batch'])
            ->name('api.mikapi.system.groups.destroy.batch');

        Route::apiResource('mikapi/system/user_actives', UserActiveController::class)
            ->only(['index', 'show'])
            ->names('api.mikapi.system.user_actives');

        Route::delete('mikapi/system/schedulers', [SchedulerController::class, 'destroy_batch'])
            ->name('api.mikapi.system.schedulers.destroy.batch');
        Route::apiResource('mikapi/system/schedulers', SchedulerController::class)
            ->only(['index', 'show', 'destroy'])->names('api.mikapi.system.schedulers');

        Route::apiResource('mikapi/system/packages', PackageController::class)
            ->only(['index', 'show'])->names('api.mikapi.system.packages');

        Route::post('mikapi/system/panel/{action}', [SystemController::class, 'panel'])
            ->name('api.mikapi.system.panel');

        Route::delete('mikapi/system/scripts', [ScriptController::class, 'destroy_batch'])
            ->name('api.mikapi.system.scripts.destroy.batch');
        Route::apiResource('mikapi/system/scripts', ScriptController::class)
            ->only(['index', 'show', 'destroy'])->names('api.mikapi.system.scripts');


        Route::delete('mikapi/logs', [LogController::class, 'destroy'])->name('api.mikapi.logs.destroy');
        Route::apiResource('mikapi/logs', LogController::class)->only(['index', 'show'])->names('api.mikapi.logs');


        Route::delete('mikapi/odps', [OdpController::class, 'destroy'])->name('api.mikapi.odps.destroy');
        Route::apiResource('mikapi/odps', OdpController::class)->names('api.mikapi.odps');

        Route::delete('mikapi/packages', [MikapiPackageController::class, 'destroy'])->name('api.mikapi.packages.destroy');
        Route::apiResource('mikapi/packages', MikapiPackageController::class)->names('api.mikapi.packages');

        Route::delete('mikapi/customers', [CustomerController::class, 'destroy'])->name('api.mikapi.customers.destroy');
        Route::apiResource('mikapi/customers', CustomerController::class)->names('api.mikapi.customers');
        Route::apiResource('mikapi/maps', MapsController::class)->names('api.mikapi.maps');
    });
});

Route::post('callback-payment',  [TripayController::class, 'callback']);
Route::get('callback-payment',  function () {
    return response()->json([]);
});
