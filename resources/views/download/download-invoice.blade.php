<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Parvez IT">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ $siteInfo->site_name . (!empty($invoiceInfo->invoice_no) ? ' | Invoice No #' . $invoiceInfo->invoice_no : '')
        . ' | Ref. Code : ' . (!empty($invoiceInfo->ref_code) ? $invoiceInfo->ref_code : '') }}
    </title>

    <!-- Arimo Font Links Here -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    <!-- Arimo Font Links Here -->

    <style>
        *,
        *::after,
        *::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            /* font-family: "Quintessential", serif;
            font-weight: 400;
            font-style: normal; */
            font-family: "Arimo", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }

        ul,
        ol {
            list-style-type: none;
        }

        img {
            vertical-align: top;
        }

        a,
        a:focus,
        a:visited,
        a:active,
        a:link {
            text-decoration: none;
            display: block !important;
            color: #fff;
        }

        table {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        table,
        table tr,
        table tr th,
        table tr td {
            border-collapse: collapse;
        }

        .main_padding {
            padding: 15px 40px;
        }

        .weight_600 {
            font-family: "Arimo", sans-serif !important;
            font-optical-sizing: auto !important;
            font-weight: bold !important;
            font-style: normal !important;
        }

        .invoice {
            width: 100%;
            height: 100% !important;
            color: #444444;
        }

        .header {
            background: #00005C;
            color: white;
            overflow: hidden;
            font-size: 32px;
            text-transform: uppercase;
            font-family: "Arimo", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: bold !important;
        }

        .footer {
            background: #FF8B4A;
            padding: 12px 40px;
        }

        .footer p {
            color: #fff;
            font-size: 15px;
            text-align: left;
            font-family: "Arimo", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }

        .header::after,
        .header::before,
        .order_info::after,
        .order_info::before,
        .contain_btn::after,
        .contain_btn::before .footer::after,
        .footer::before {
            content: "";
            clear: both;
        }

        .header .logo {
            float: left;
            text-align: left;
            width: 52%;
        }

        .header .logo img {
            height: 50px;
            width: auto;
        }

        .header .title {
            float: left;
            text-align: right;
            width: 46%;
        }

        .order_footer {
            width: 30%;
        }

        .order_footer .sign_underline {
            padding: 0px 15px;
            border-bottom: 2px solid #FF8B4A;
            margin-bottom: 15px;
        }

        .order_footer .contain p {
            padding: 0;
            margin: 0;
            color: #111111;
            font-family: "Arimo", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            text-align: center;
            font-size: 13px;
        }

        .order_info {
            padding: 5px 40px;
        }

        .order_info .left_side .table_info tr td {
            text-align: left !important;
        }

        .order_info .right_side .table_info tr td {
            text-align: right !important;
        }

        .order_info .left_side .table_info,
        .order_info .right_side .table_info {
            font-size: 17px;
        }

        p.site_name {
            font-size: 24px !important;
            font-weight: bold !important;
        }

        .order_info .left_side {
            float: left;
            width: 60%;
        }

        .order_info .right_side {
            float: right;
            width: 39.5%;
        }

        .main_contain {
            padding: 15px 40px;
        }

        .main_contain .main_table thead tr th {
            background: #FF8B4A;
            color: #111;
        }

        .main_contain .main_table thead tr th,
        .main_contain .main_table tbody tr td,
        .main_contain .main_table tfoot tr th {
            font-size: 12px !important;
        }

        table.main_table tr th,
        table.main_table tr td {
            padding: 5px 12px;
        }

        /* table.main_table tr:nth-child(even) {
            background: #E8EAF6;
        } */

        table.main_table,
        table.main_table tr,
        table.main_table tr th,
        table.main_table tr td {
            border: 1px solid #C5CAE9;
        }

        .main_contain .sub_table {
            width: 100% !important;
        }

        .main_contain .sub_table,
        .main_contain .sub_table thead tr th,
        .main_contain .sub_table tbody tr td,
        .main_contain .sub_table tfoot tr th {
            font-size: 12px !important;
        }

        table.table_footer,
        table.table_footer tr,
        table.table_footer tr th,
        table.table_footer tr td {
            border: 1px solid #C5CAE9;
        }

        table.table_footer tr th,
        table.table_footer tr td {
            padding: 10px 15px;
            font-size: 12px;
        }

        table.table_footer tr th.total {
            text-align: right;
            font-size: 18px !important;
        }

        table.table_footer tr th.total_amount {
            text-align: right;
            font-size: 18px !important;
        }

        table.table_footer tr th.payment_status {
            width: 55%;
            text-align: center;
            vertical-align: middle;
            font-size: 22px !important;
            color: #9FA8DA;
        }

        /*
        .main_btn {padding: 15px 0px;}
        .contain_btn tr td.btn_copy {
            cursor: pointer !important;
            border: 1px solid #C5CAE9;
            text-align: center;
            padding: 15px 25px;
            width: 50%;
            transition: 0.4s all ease-in-out;
        }
        .contain_btn tr th.empty {padding: 8px 10px;}
        */
        .btn_send {
            cursor: pointer !important;
            background: green;
            border: 1px solid green;
            line-height: 34px;
            color: #fff;
            font-weight: bold;
        }

        .right_side .table_info tr td.btn_send {
            text-align: center !important;
        }

        .invoice_info {
            width: 80%;
            float: right;
        }

        .invoice_paid {
            background: #1B9E1B;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            width: 50%;
            padding: 5px 16px;
        }

        .invoice_pending {
            background: #ff0000;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            width: 50%;
            padding: 5px 16px;
        }

        .invoice_unpaid {
            background: #FB8C00;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            width: 50%;
            padding: 5px 16px;
        }

        table.table.table_info tr td.due_amount {
            font-size: 18px !important;
            border: 1px solid #C5CAE9;
            text-align: center;
        }

        table.table.table_info tr td img.logo {
            height: 60px;
            width: auto;
        }

        table.table tr td.header_font {
            font-size: 18px;
        }
    </style>

</head>

<body>
    <div class="invoice">
        <div class="order_info">
            <table class="table table_header">
                <tr>
                    <td style="width: 60%; ">
                        <table class="table table_info">
                            <tr>
                                <td class="weight_600 header_font"> Bill From: </td>
                            </tr>

                            <tr>
                                <td>
                                    {{-- @if(!empty($siteInfo->logo))
                                    <img class="logo" src="{{ asset($siteInfo->logo) }}" alt="Logo">
                                    @else
                                    <p>{{ $siteInfo->site_name }}</p>
                                    @endif --}}

                                    <p class="site_name">{{$siteInfo->site_name}}</p>

                                    <p>
                                        <span class="weight_600">Email :</span>
                                        {{ (!empty($siteInfo->email) ? $siteInfo->email : "") }}
                                    </p>

                                    <p>
                                        <strong>USA Office:</strong>
                                        {{ (!empty($siteInfo->us_location) ? $siteInfo->us_location : "") }}
                                    </p>

                                    <p>
                                        <strong>BD Office :</strong>
                                        {{ (!empty($siteInfo->location) ? $siteInfo->location : "") }}
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <h3 class="weight_600">&nbsp;</h3>
                                </td>
                            </tr>

                        </table>
                    </td>

                    <td style="width: 40%; ">
                        <table class="table table_info">

                            {{-- @if($invoiceInfo->status != 'paid')
                            <tr>
                                <td class="btn_send">
                                    <a href="{{ url('paypal/payment', $invoiceInfo->ref_code) }}">Pay Now</a>
                                </td>
                            </tr>
                            @endif --}}

                            <tr class="invoice_status">
                                @if ($invoiceInfo->status == 'paid')
                                <td class="invoice_paid" style="text-align: center;">
                                    Paid
                                </td>
                                @elseif($invoiceInfo->status == 'pending')
                                <td class="invoice_pending" style="text-align: center;">
                                    Pending
                                </td>
                                @else
                                <td class="invoice_unpaid" style="text-align: center;">
                                    Unpaid
                                </td>
                                @endif
                            </tr>

                            <tr>
                                <td style="text-align: right;">
                                    <span class="weight_600">Invoice No :</span>
                                    #{{ (!empty($invoiceInfo->invoice_no) ? $invoiceInfo->invoice_no : "") }}
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align: right;">
                                    <span class="weight_600">Invoice Date :</span>
                                    {{ !empty($invoiceInfo->created) ? date('d F, Y', strtotime($invoiceInfo->created))
                                    : '' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="text-align: right;">
                                    <span class="weight_600">Paid Date :</span>
                                    {{ !empty($invoiceInfo->payment_date) ? date('d F, Y',
                                    strtotime($invoiceInfo->payment_date)) : 'Due' }}
                                </td>
                            </tr>
                            @if($invoiceInfo->status != 'paid')
                            <tr>
                                <td class="due_amount">
                                    Amount Due: <br />
                                    <span class="weight_600">{{sprintf("$%0.2f",$invoiceInfo->grand_total)}}</span>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 15px; border-top: 1px solid #C5CAE9;"> &nbsp; </div>

            <div>
                <table class="table" style="width: 100%;">
                    <tr>
                        <td class="weight_600 header_font"> Bill To: </td>
                    </tr>

                    <tr>
                        <td>
                            <p class="site_name">{{ (!empty($invoiceInfo->customer->company_name) ?
                                strFilter($invoiceInfo->customer->company_name) : '') }}</p>

                            @if(!empty($invoiceInfo->customer->full_name))
                            <p>
                                <span class="weight_600">Name :</span>
                                {{ (!empty($invoiceInfo->customer->full_name) ?
                                strFilter($invoiceInfo->customer->full_name) : '') }}
                            </p>
                            @endif

                            <p>
                                <span class="weight_600">Email :</span>
                                {{ (!empty($invoiceInfo->email) ? $invoiceInfo->email : "") }}
                            </p>

                            @if(!empty($invoiceInfo->customer->phone))
                            <p>
                                <span class="weight_600">Mobile :</span>
                                {{ (!empty($invoiceInfo->customer->phone) ? strFilter($invoiceInfo->customer->phone) :
                                '') }}
                            </p>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        <div class="main_contain">
            @if(!empty($orderList) && $orderList->isNotEmpty())
            <table class="table main_table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 80px;">
                            Order ID
                        </th>
                        <th rowspan="2" style="width: 60px;">
                            Date
                        </th>
                        <th colspan="2">
                            Billing On
                        </th>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Live Link</th>
                        <th style="text-align: right; width: 120px;">Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($orderList as $key => $order )
                    <tr>
                        <td style="text-align: center; white-space: nowrap;">
                            {{ (!empty($order->order_no) ? $order->order_no : "") }}
                        </td>

                        <td style="text-align: center; white-space: nowrap;">
                            {{ !empty($order->created) ? date('d F, Y', strtotime($order->created)) : date('d F, Y') }}
                        </td>

                        <td colspan="2" style="padding: 2px;">
                            <table class="sub_table">
                                <tbody>

                                    <tr>
                                        <td colspan="2">
                                            {{ $order->billType?->name }}
                                            @if(!empty($order->orderItem))
                                            @php($itemQty = count($order->orderItem))
                                            @for ($i = 0; $i < $itemQty; $i++) <?php $mainUrl=parse_url($order->
                                                orderItem[$i]->live_url);
                                                echo $mainUrl['host'];
                                                ?>,
                                                @endfor
                                                @endif
                                        </td>
                                    </tr>
                                    @if(!empty($order->orderItem))
                                    @foreach($order->orderItem as $key => $row)
                                    <tr>
                                        <td>
                                            {{ $row->live_url }}
                                        </td>
                                        <td style="text-align: right; width: 120px;">
                                            {{ sprintf("$%0.2f",$row->total) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    <tr>
                                        <th style="text-align: right;">
                                            Subtotal
                                        </th>

                                        <th style="text-align: right;">
                                            {{ sprintf("$%0.2f",$order->subtotal) }}
                                        </th>
                                    </tr>

                                    <tr>
                                        <th style="text-align: right;">
                                            Service Charge
                                        </th>

                                        <th style="text-align: right;">
                                            {{ sprintf("$%0.2f",$order->service_charge) }}
                                        </th>
                                    </tr>

                                    <tr>
                                        <th style="text-align: right;">
                                            Tax
                                        </th>

                                        <th style="text-align:right;">
                                            {{ sprintf("$%0.2f",$order->tax) }}
                                        </th>
                                    </tr>

                                    <tr>
                                        <th style="text-align: right;">
                                            Discount
                                        </th>

                                        <th style="text-align: right;">
                                            {{ sprintf("$%0.2f",$order->discount) }}
                                        </th>
                                    </tr>

                                    <tr>
                                        <th style="text-align: right;">
                                            Total
                                        </th>

                                        <th style="text-align: right;">
                                            {{ sprintf("$%0.2f",$order->grand_total) }}
                                        </th>
                                    </tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <table class="table table_footer">
                <tbody>
                    <tr>
                        <th rowspan="3" class="payment_status">
                            {{ (!empty($invoiceInfo->status) ? strFilter($invoiceInfo->status) : '') }}
                        </th>

                        <th style="text-align: right;">Subtotal </th>

                        <th style="width: 124px; text-align: right;">
                            {{sprintf("$%0.2f",$invoiceInfo->subtotal)}}
                        </th>
                    </tr>

                    <tr>
                        <th style="text-align: right;">Discount </th>

                        <th style="text-align: right;">
                            {{sprintf("$%0.2f",$invoiceInfo->discount)}}
                        </th>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="total">Grand Total </th>

                        <th class="total_amount">
                            {{sprintf("$%0.2f",$invoiceInfo->grand_total)}}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
