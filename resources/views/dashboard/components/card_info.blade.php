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

    @if ($user->is_admin())
        <div class="row widget-statistic">
            <div class="col-xl-4 col-lg-4 col-md-4 col-12 layout-spacing">
                <div class="widget widget-one_hybrid widget-engagement">
                    <div class="widget-heading mb-0">
                        <div class="w-title bs-tooltip mb-0" title="Total Income" id="filter_income"
                            style="cursor: pointer">
                            <div class="w-icon">
                                <i data-feather="download"></i>
                            </div>
                            <div class="">
                                <p class="w-value" id="data_income">Loading...</p>
                                <h5 class="">Total Income</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12 layout-spacing">
                <div class="widget widget-one_hybrid widget-referral">
                    <div class="widget-heading mb-0">
                        <div class="w-title bs-tooltip mb-0" title="Total Outcome" id="filter_outcome"
                            style="cursor: pointer">
                            <div class="w-icon">
                                <i data-feather="upload"></i>
                            </div>
                            <div class="">
                                <p class="w-value" id="data_outcome">Loading...</p>
                                <h5 class="">Total Outcome</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12 layout-spacing">
                <div class="widget widget-one_hybrid widget-followers">
                    <div class="widget-heading mb-0">
                        <div class="w-title bs-tooltip mb-0" title="Show All Data" id="filter_diff"
                            style="cursor: pointer">
                            <div class="w-icon">
                                <i data-feather="trending-up"></i>
                            </div>
                            <div class="">
                                <p class="w-value" id="data_diff">Loading...</p>
                                <h5 class="">Total Diff</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
