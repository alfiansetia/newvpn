<div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="row widget-statistic">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
            <div class="widget widget-one_hybrid widget-followers">
                <div class="widget-heading mb-0">
                    <div class="w-title mb-0">
                        <div class="w-icon">
                            <i data-feather="dollar-sign"></i>
                        </div>
                        <div class="">
                            <p class="w-value"> {{ hrg($user->balance) }}</p>
                            <h5 class="">Your Balance</h5>
                        </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="w-chart">
                        <div id="hybrid_followers"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
            <div class="widget widget-one_hybrid widget-engagement">
                <div class="widget-heading mb-0">
                    <div class="w-title mb-0">
                        <div class="w-icon">
                            <i data-feather="cloud"></i>
                        </div>
                        <div class="">
                            <p class="w-value"> {{ hrg($router_count) }} /
                                {{ hrg($user->router_limit) }}</p>
                            <h5 class="">Your Router</h5>
                        </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="w-chart">
                        <div id="hybrid_followers"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
            <div class="widget widget-one_hybrid widget-referral">
                <div class="widget-heading mb-0">
                    <div class="w-title mb-0">
                        <div class="w-icon">
                            <i data-feather="shopping-cart"></i>
                        </div>
                        <div class="">
                            <p class="w-value"> {{ hrg($billing_pending) }}</p>
                            <h5 class="">Pending Payment</h5>
                        </div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="w-chart">
                        <div id="hybrid_followers"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
