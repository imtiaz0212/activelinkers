@extends('layouts.app')

@section('content')
<div>
    <!-- Link List Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Site Information</h3>
        <a href="{{ route('admin.link_list') }}" class="primary-btn text-sm">
            All Sites
            <i class="fa-solid fa-list-check"></i>
        </a>
    </div>
    <!-- Link List Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-5">
        <table class="table">
            <tr>
                <th style="width: 18%;">Website URL :</th>
                <td style="width: 27%;">{{ $info->url }}</td>

                <th style="width: 18%;">Site Owner Name :</th>
                <td style="width: 27%;">{{ $info->publisher->name }}</td>

                <td rowspan="4" style="width: 10%;">
                    <img src="{{ $info->images ? asset($info->images) : asset('/images/placeholder.webp') }}"
                        width="150px" height="150px" alt="{{ $info->title }}">
                </td>
            </tr>

            <tr>
                <th>Title :</th>
                <td colspan="3">{{ $info->title }}</td>
            </tr>

            <tr>
                <th>Link Type :</th>
                <td>{{ strFilter($info->link_type) }}</td>

                <th>Link Validity :</th>
                <td>
                    @php($newValidity = date('d-m-Y', strtotime($info->link_validity, strtotime($info->created))))
                    {{ $info->link_validity }} - {{ $newValidity }}
                </td>
            </tr>

            <tr>
                <th>Niche List :</th>
                <td>
                    @php($nicheItems = json_decode($info->niche))
                    @foreach ($nicheItems as $niche)
                    {{ $nicheList->where('id', $niche)->first()->name . ', ' }}
                    @endforeach
                </td>

                <th></th>
                <td></td>
            </tr>

            <tr>
                <th>Description :</th>
                <td colspan="4">{!! strLimit($info->description, 70) !!}</td>
            </tr>

            <tr>
                <td colspan="5">
                    <table class="table subtable">
                        <tr>
                            <th style="width: 18%">Regular Price :</th>
                            <td style="width: 17%;">${{ $info->linkPrice->regular_price }}</td>
                            <th style="width: 12%">Sale Price :</th>
                            <td style="width: 20%;">${{ $info->linkPrice->sale_price }}</td>
                            <th style="width: 13%">Site Owner Price :</th>
                            <td style="width: 20%;">${{ $info->linkPrice->owner_price }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <table class="table subtable">
                        <tr>
                            <th colspan="2" style="text-align: center;">Merchant Price</th>
                            <th colspan="2" style="text-align: center;">Site Owner Price</th>
                            <th colspan="2" style="text-align: center;">Merchant Price</th>
                            <th colspan="2" style="text-align: center;">Site Owner Price</th>
                        </tr>
                        <tr>
                            <th style="width: 10%;">CBD :</th>
                            <td style="width: 15%;">${{ $info->linkPrice->merchant_cbd_price }}</td>

                            <th style="width: 10%;">CBD :</th>
                            <td style="width: 15%;">${{ $info->linkPrice->owner_cbd_price }}</td>

                            <th style="width: 10%;">Crypto :</th>
                            <td style="width: 15%;">${{ $info->linkPrice->merchant_crypto_price }}</td>

                            <th style="width: 10%;">Crypto :</th>
                            <td style="width: 15%;">${{ $info->linkPrice->owner_crypto_price }}</td>
                        </tr>

                        <tr>
                            <th>Casino :</th>
                            <td>${{ $info->linkPrice->merchant_casino_price }}</td>
                            <th>Casino :</th>
                            <td>${{ $info->linkPrice->owner_casino_price }}</td>
                            <th>Homepage Link :</th>
                            <td>${{ $info->linkPrice->merchant_homepage_price }}</td>
                            <th>Homepage Link :</th>
                            <td>${{ $info->linkPrice->owner_homepage_price }}</td>
                        </tr>

                        <tr>
                            <th>Sidebar Link :</th>
                            <td>${{ $info->linkPrice->merchant_sidebar_price }}</td>
                            <th>Sidebar Link :</th>
                            <td>${{ $info->linkPrice->owner_sidebar_price }}</td>
                            <th>Footer Link :</th>
                            <td>${{ $info->linkPrice->merchant_footer_price }}</td>
                            <th>Footer Link :</th>
                            <td>${{ $info->linkPrice->owner_footer_price }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <table class="table subtable">
                        <tr>
                            <th style="width: 10%;">DA (%):</th>
                            <td style="width: 15%;">{{ $info->da }}%</td>

                            <th style="width: 10%;">PA (%):</th>
                            <td style="width: 15%;">{{ $info->pa }}%</td>

                            <th style="width: 10%;">DR (%):</th>
                            <td style="width: 15%;">{{ $info->dr }}%</td>

                            <th style="width: 10%;">A href Rank :</th>
                            <td style="width: 15%;">{{ $info->ahref_rank }}</td>
                        </tr>
                        <tr>
                            <th>Traffic :</th>
                            <td>{{ $info->traffic }}</td>

                            <th>Keywords :</th>
                            <td>{{ $info->organic_keyword }}</td>

                            <th>CF (%):</th>
                            <td>{{ $info->cf }}%</td>

                            <th>TF (%):</th>
                            <td>{{ $info->tf }}%</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <table class="table subtable">
                        <tr>
                            <th style="width: 15%">Direct (%) :</th>
                            <td style="width: 20%;">{{ $info->direct }}%</td>
                            <th style="width: 12%">Organic Search (%) :</th>
                            <td style="width: 20%;">{{ $info->organic_search }}%</td>
                            <th style="width: 13%">Social (%) :</th>
                            <td style="width: 20%;">{{ $info->social }}%</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="5">
                    <table class="table subtable">
                        <tr>
                            <th style="width: 20%">Homepage Link Allowed ? :</th>
                            <td style="width: 13%;">{{ strFilter($info->homepage_link) }}</td>
                            <th style="width: 20%">Sidebar Link Allowed ? :</th>
                            <td style="width: 13%;">{{ strFilter($info->sidebar_link) }}</td>
                            <th style="width: 20%">Footer Link Allowed ? :</th>
                            <td style="width: 13%;">{{ strFilter($info->footer_link) }}</td>
                        </tr>
                        <tr>
                            <th>CBD Allowed ? :</th>
                            <td>{{ strFilter($info->cbd) }}</td>
                            <th>Crypto Allowed ? :</th>
                            <td>{{ strFilter($info->crypto) }}</td>
                            <th>Casino Allowed ? :</th>
                            <td>{{ strFilter($info->casino) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="table2">
            @foreach ($country_percent as $key => $row)
            <tr>
                <th style="width: 30%">Country {{ $key + 1 }} :</th>
                <td style="width: 70%;">{{ strFilter($row->country_name) }} - {{ $row->percent }}%</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection

@push('headerPartial')
<style>
    table.table {
        width: 100%;
    }

    table.table tr th,
    table.table2 tr th {
        text-align: right;
    }

    table.table tr td,
    table.table tr th,
    table.table2 tr td,
    table.table2 tr th {
        padding: 5px;
    }

    table.table,
    table.table tr,
    table.table tr td,
    table.table tr th,
    table.table2,
    table.table2 tr,
    table.table2 tr td,
    table.table2 tr th {
        border-collapse: collapse;
        border: 1px solid transparent;
    }

    table.table2 {
        width: 50%;
    }

    table.table.subtable,
    table.table.subtable tr,
    table.table.subtable tr td,
    table.table.subtable tr th {
        border: 1px solid #ddd;
    }
</style>
@endpush