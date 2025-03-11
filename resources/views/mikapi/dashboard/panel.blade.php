<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
    <div class="widget widget-one_hybrid widget-followers mb-4">
        <div class="widget-heading mb-0">
            <div class="w-title bs-tooltip" title="Open report"
                onclick="window.location.href = `{{ route('mikapi.report') }}${param_router}`" style="cursor: pointer">
                <div class="w-icon">
                    <i data-feather="dollar-sign"></i>
                </div>
                <div class="">
                    <p class="w-value" id="report_today">Loading...</p>
                    <h5 class="" id="report_month">Loading...</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="widget-four" style="height: 75%">
        <div class="widget-heading">
            <h5 class="">Panel</h5>
        </div>
        <div class="widget-content">
            <div class="d-grid gap-2 col-12 mx-auto">
                <button type="button" id="btn_reboot"
                    class="btn btn-lg btn-warning btn-block mb-3 d-flex align-items-center justify-content-start">
                    <i data-feather="refresh-cw" class="me-3"></i>
                    <span class="btn-text-inner text-weight-bold">REBOOT</span>
                </button>
                <button type="button" id="btn_shutdown"
                    class="btn btn-lg btn-danger btn-block mb-3 d-flex align-items-center justify-content-start">
                    <i data-feather="power" class="me-3"></i>
                    <span class="btn-text-inner text-weight-bold">SHUTDOWN</span>
                </button>
            </div>

        </div>
    </div>
</div>
<form id="form_reboot"
    action="{{ route('api.mikapi.system.panel', 'reboot') }}?router={{ request()->query('router') }}"></form>
<form id="form_shutdown"
    action="{{ route('api.mikapi.system.panel', 'shutdown') }}?router={{ request()->query('router') }}"></form>
