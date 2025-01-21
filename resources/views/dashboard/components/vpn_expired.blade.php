<div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">

    <div class="widget widget-one_hybrid widget-engagement mb-3">
        <div class="widget-heading mb-0">
            <div class="w-title mb-0">
                <div class="w-icon">
                    <i class="fab fa-whatsapp" style="font-size: 50px;"></i>
                </div>
                <div class="">
                    <p class="w-value">Whatsapp Group</p>
                    <h5>Gabung grup informasi layanan kami.</h5>
                </div>
                <div class="ms-auto" style="vertical-align: middle">
                    <a href="https://chat.whatsapp.com/CCGvRqG3Hv40nYb4zbSZbd" class="btn btn-primary"
                        target="_blank"><i class="fas fa-user-plus"></i> Join</a>
                </div>
            </div>
        </div>
        <div class="widget-content">
            <div class="w-chart">
                <div id="hybrid_followers"></div>
            </div>
        </div>
    </div>

    <div class="widget widget-table-three p-3">

        <div class="widget-heading">
            <h5 class="">Latest Vpn Expired</h5>
        </div>

        <div class="widget-content">
            @if (count($new_expired_vpns) > 0)
                <div class="table-responsive">
                    <table class="table table-scroll">
                        <thead>
                            <tr>
                                <th>
                                    <div class="th-content">Server</div>
                                </th>
                                <th>
                                    <div class="th-content th-heading">Username</div>
                                </th>
                                <th>
                                    <div class="th-content th-heading">Expired</div>
                                </th>
                                <th>
                                    <div class="th-content">Trial</div>
                                </th>
                                <th>
                                    <div class="th-content">Active</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new_expired_vpns as $item)
                                <tr>
                                    <td>
                                        <div class="td-content">
                                            {{ $item->server->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">{{ $item->username }}</div>
                                    </td>
                                    <td>
                                        <div class="td-content">{{ $item->expired }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-content">{{ $item->is_trial ? 'Trial' : 'No Trial' }}</div>
                                    </td>
                                    <td>
                                        <div class="td-content">{{ $item->is_active ? 'Active' : 'Nonactive' }}</div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-danger layout-top-spacing" role="alert">
                    No Expired VPN Found!
                </div>
            @endif
        </div>
    </div>
</div>
