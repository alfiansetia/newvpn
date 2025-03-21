<div
    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#ffffff;color:#718096;height:100%;line-height:1.4;margin:0;padding:0;width:100%!important">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%">
        <tbody>
            <tr>
                <td align="center"
                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';margin:0;padding:0;width:100%">
                        <tbody>
                            <tr>
                                <td
                                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';padding:25px 0;text-align:center">
                                    <a href="{{ url('/') }}"
                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:19px;font-weight:bold;text-decoration:none;display:inline-block"
                                        target="_blank">
                                        <span class="il">{{ $company->name }}</span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%" cellpadding="0" cellspacing="0"
                                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%">
                                    <table class="m_5686903106685948781inner-body" align="center" width="570"
                                        cellpadding="0" cellspacing="0" role="presentation"
                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:570px">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';max-width:100vw;padding:32px">
                                                    <h1
                                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
                                                        Hello {{ $topup->user->name }},</h1>
                                                    <p
                                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                                        Date time : {{ date('d-M-Y H:i:s') }}</p>
                                                    <p
                                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                                        Hereby we inform you of the details of your Top Up Balance
                                                        Request below:
                                                    </p>
                                                    <p
                                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                                        <b>Detail Transaction</b>
                                                        <br>Number : {{ $topup->number }}
                                                        <br>Datetime : {{ $topup->date }}
                                                        <br>Amount : <b>Rp. {{ hrg($topup->amount) }}</b>
                                                        <br>Cost : <b>Rp. {{ hrg($topup->cost) }}</b>
                                                        <br>Total : <b>Rp. {{ hrg($topup->amount + $topup->cost) }}</b>
                                                        <br>Status : {{ $topup->status }}
                                                        <br>Description : {{ $topup->desc }}
                                                        <br>Payment Type : {{ strtoupper($topup->type) }}
                                                        <br>Payment Expired At : {{ $topup->expired_at }}
                                                    </p>
                                                    @if ($topup->type == 'auto')
                                                        @if ($topup->status == 'pending')
                                                            <p
                                                                style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                                                <br><b>Payment via QRIS</b>
                                                                <br>Log in to your digital wallet application that
                                                                supports
                                                                QRIS,
                                                                <br>Scan the available QR Code,
                                                                <br>Transaction details will appear. Make sure the
                                                                transaction data is correct,
                                                                <br>Complete your payment process,
                                                                <br>Transaction complete. Save your proof of payment
                                                                <br><b>QR QRIS Rp.
                                                                    {{ hrg($topup->amount + $topup->cost) }}</b>
                                                                <br><img src="{{ $topup->qris_image }}"
                                                                    alt="Qris Image">
                                                                <br><b>If the image cannot be loaded, follow this link
                                                                    to
                                                                    make a payment.</b>
                                                                <br><a
                                                                    href="{{ $topup->link }}">{{ $topup->link }}</a>
                                                            </p>
                                                        @endif
                                                    @else
                                                        @if ($topup->bank)
                                                            <p
                                                                style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                                                <br><b>Destination Bank Details</b>
                                                                <br>Bank Name : {{ $topup->bank->name }}
                                                                <br>Bank Account Number :
                                                                <b>{{ $topup->bank->acc_number }}</b>
                                                                <br>Bank Account Name : {{ $topup->bank->acc_name }}
                                                            </p>
                                                        @endif
                                                        @if ($topup->status == 'pending')
                                                            <p
                                                                style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left; ">
                                                                <br>
                                                                <font color="red"><b>
                                                                        Please transfer Rp.
                                                                        {{ hrg($topup->amount + $topup->cost) }}
                                                                        to the account number/bank above, then confirm
                                                                        to our admin.</b>
                                                                </font>
                                                            </p>
                                                        @endif
                                                    @endif
                                                    @if ($topup->status == 'cancel')
                                                        <p
                                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left; ">
                                                            <br>
                                                            <font color="red">
                                                                <b>Your request to cancel your account
                                                                    top-up of Rp.{{ hrg($topup->amount) }} has been
                                                                    successful, refresh your
                                                                    profile page to see the balance update. Please
                                                                    contact the admin if there is an error.
                                                                </b>
                                                            </font>
                                                        </p>
                                                    @endif
                                                    @if ($topup->status == 'done')
                                                        <p
                                                            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left; ">
                                                            <br>
                                                        <h2>We have verified and received your payment. Please go to
                                                            your member area dashboard and refresh the page to see your
                                                            balance update.</h2>
                                                        </p>
                                                    @endif
                                                    <p
                                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                                                        <br>
                                                        <br>Regards,
                                                        <br>
                                                        <span class="il">{{ $company->name }}</span>
                                                        <br><a
                                                            href="https://member.kacangan.net">https://member.kacangan.net</a>
                                                        <br><a href="https://kacangan.net">https://kacangan.net</a>
                                                        <br><a
                                                            href="https://blog.kacangan.net">https://blog.kacangan.net</a>
                                                        <br>Whatsapp : <a
                                                            href="https://api.whatsapp.com/send/?phone=6282324129752&text=Halo">082324129752</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                                    <table class="m_5686903106685948781footer" align="center" width="570"
                                        cellpadding="0" cellspacing="0" role="presentation"
                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';margin:0 auto;padding:0;text-align:center;width:570px">
                                        <tbody>
                                            <tr>
                                                <td align="center"
                                                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';max-width:100vw;padding:32px">
                                                    <p
                                                        style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';line-height:1.5em;margin-top:0;color:#b0adc5;font-size:12px;text-align:center">
                                                        © {{ date('Y') }} <span
                                                            class="il">{{ $company->name }}</span>. All rights
                                                        reserved.</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="yj6qo"></div>
    <div class="adL">
    </div>
</div>
