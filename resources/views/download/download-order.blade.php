<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Parvez IT">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ $siteInfo->site_name . (!empty($orderInfo->order_no) ? ' | #' . $orderInfo->order_no : '') }}
    </title>

    <style>
        *, *::after, *::before {box-sizing: border-box; margin: 0; padding: 0;}
        h1, h2, h3, h4, h5, h6 {margin: 0; padding: 0;}
        html, body {margin: 0; padding: 0; font-family: 'Roboto', sans-serif;}
        ul, ol {list-style-type: none;}
        img {width: 100%; vertical-align: top;}
        a, a:focus, a:visited, a:active, a:link {text-decoration: none; display: block !important; color: #fff;}
        table {width: 100%;margin: 0; padding: 0;}
        table, table tr, table tr th, table tr td {border-collapse: collapse;}
        .main_padding {padding: 30px 72px;}
        .weight_600 {font-weight: bold !important;}
        
        .invoice {width: 100%; height: 1123px !important; color: #444444;}
        .header {
            background: #00005C;
            color: #fff;
            overflow: hidden;
            font-size: 32px;
            text-transform: uppercase;
            font-family: 'Roboto', sans-serif;
            font-style: normal;
        }
        .footer {
           background: #00005C;
           padding: 12px 72px;
        }
        .footer p {
            color: #fff; 
            font-size: 15px;
            text-align: left; 
            font-family: 'Roboto', sans-serif; 
            font-style: normal;
        }
        
        .header::after, .header::before,
        .order_info::after, .order_info::before,
        .contain_btn::after, .contain_btn::before
        .footer::after, .footer::before {
            content: "";
            clear: both;
        }
        .header .logo {float: left; text-align: left; width: 38%;}
        .header .title {float: left; text-align: right;width: 60%;}
        .order_footer {width: 30%;font-family: 'Roboto', sans-serif !important;}
        .order_footer .sign_underline {padding: 0px 15px;border-bottom: 2px solid #00005C;margin-bottom: 15px;}
        .order_footer .contain p {
            padding: 0;
            margin: 0;
            color: #111111;
            font-family: 'Roboto', sans-serif;
            font-style: normal;
            text-align: center;
            font-size: 13px;
        }
        .order_info {padding: 15px 72px;}
        .order_info .left_side .table_info tr td {text-align: left !important;}
         .order_info .right_side .table_info tr td {text-align: right !important;}
        .order_info .left_side .table_info, .order_info .right_side .table_info {font-size: 17px;}
        .order_info .left_side .table_info tr td span, .order_info .right_side .table_info tr td span {}
        .order_info .left_side {float: left;width: 60%;}
        .order_info .right_side {float: left;width: 39%;}
        .main_contain {padding: 15px 72px;}
        .main_contain .main_table thead tr {background: #00005C;}
        .main_contain .main_table thead tr th {color: #fff;}
        .main_contain .main_table thead tr th, .main_contain .main_table tbody tr td, .main_contain .main_table tfoot tr th {font-size: 15px !important;}
        table.main_table tr th, table.main_table tr td {padding: 10px;}
        table.main_table tr:nth-child(even) {background: #E8EAF6;}
        table.main_table, table.main_table tr, table.main_table tr th, table.main_table tr td {border: 1px solid #C5CAE9;}
        .main_contain .main_table tr th.total {text-align: right;font-size: 22px !important;}
        .main_contain .main_table tr th.total_amount {text-align: center;font-size: 22px !important;}
        .payment_status {
            vertical-align: middle;
            text-align: center;
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
            width: 40%;
            margin: 5px 0px;
            height: auto;
            background: green;
            border: 1px solid green;
            line-height: 34px;
            text-align: center;
            /* float: right; */
        }
        .btn_send a {color: #fff;font-weight: bold;}
        
    </style>
    
</head>

<body>
    <div class="invoice">
            <div class="order_info main_padding">
    
                <div class="left_side">
                    <table class="table table_info">
                        <tr>
                            <td>
                                @if(!empty($siteInfo->logo))
                                <img src="{{ asset($siteInfo->logo) }}" alt="Logo" height="34">
                                @endif
                            </td>
                        </tr>
    
                        <tr>
                            <td>
                                <h3 class="weight_600">{{ (!empty($orderInfo->name) ? strFilter($orderInfo->name) : $orderInfo->company) }}</h3>
                            </td>
                        </tr>
    
    
                        <tr>
                            <td>
                                <span class="weight_600">Address :</span>
                                {{ (!empty($orderInfo->address) ? $orderInfo->address : $siteInfo->location) }}
                            </td>
                        </tr>
    
                        <tr>
                            <td>
                                <span class="weight_600">Email :</span>
                                {{ (!empty($orderInfo->email) ? $orderInfo->email : "") }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="right_side">
                    <table class="table table_info">
    
                        <tr>
                            <td>
                                <span class="weight_600">Order No :</span>
                                #{{ (!empty($orderInfo->order_no) ? $orderInfo->order_no : "") }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="weight_600">Date :</span>
                                {{ !empty($orderInfo->delivery_date) ? date('d F, Y', strtotime($orderInfo->delivery_date)) : date('d F, Y') }}
                            </td>
                        </tr>
    
                        <tr>
                            <td>
                                <span class="weight_600">Mobile :</span>
                                {{ (!empty($orderInfo->mobile) ? $orderInfo->mobile : "") }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <td>
                                {{ strFilter($orderInfo->company) }}
                            </td>
                        </tr> --}}
                    </table>
                </div>
            </div>
        
        <div class="main_contain">
            <table class="table main_table">
                <thead>
                    <tr>
                        <th>Live URL</th>
                        <th style="width: 60px;">Price</th>
                        <th style="width: 110px; white-space: nowrap; ">Other Price</th>
                        <th style="width: 120px; white-space: nowrap; ">Article Writing</th>
                        <th style="width: 100px;">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($orderInfo->orderItem))
                        @foreach($orderInfo->orderItem as $key => $row)
                        <tr >
                            <td>{{ $row->live_url }}</td>
                            <td style="text-align: center;">${{ round($row->url_price, 3) }}</td>
                            <td style="text-align: center;">${{ round($row->other_price, 3) }}</td>
                            <td style="text-align: center;">${{ round($row->artical, 3) }}</td>
                            <td style="text-align: center;">$<span>{{ round($row->total, 3) }}</span></td>
                        </tr>
                        @endforeach
                    @endif

                    <tr>
                        <th class="payment_status" rowspan="4" colspan="2">
                            @if(!empty($orderInfo->status))
                            <span style="rotate: 90; width: 300px; height: 300px;">
                                {{ strFilter($orderInfo->status) }}
                            </span>
                            @endif
                        </th>
                        <th colspan="2" style="text-align: right;">Subtotal </th>
                        <th style="text-align: center;">${{ round($orderInfo->subtotal, 3) }}</th>
                    </tr>

                    <tr>
                        <th colspan="2" style="text-align: right;">Service Charge </th>
                        <th style="text-align: center;">${{ round($orderInfo->service_charge, 3) }}</th>
                    </tr>

                    <tr>
                        <th colspan="2" style="text-align: right;">Tax </th>
                        <th style="text-align: center;">${{ round($orderInfo->tax, 3) }}</th>
                    </tr>

                    <tr>
                        <th colspan="2" style="text-align: right;">Discount </th>
                        <th style="text-align: center;">${{ round($orderInfo->discount, 3) }}</th>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="total">Total </th>
                        <th class="total_amount">${{ round($orderInfo->grand_total, 3) }}</th>
                    </tr>
                </tfoot>
            </table>
            
        </div>

    </div>
</body>
</html>
