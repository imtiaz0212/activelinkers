@extends('layouts.app')

@section('content')

<div>
    <!-- Link List Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Link Information</h3>
        <a href="{{route('publisher.link_list')}}" class="primary-btn text-sm">
            All Link Placement
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
                    @php($newValidity = date("d-m-Y", strtotime($info->link_validity, strtotime($info->created))))
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
                            <th style="width: 18%">Site Price :</th>
                            <td style="width: 17%;">${{ $info->linkPrice->owner_price }}</td>

                            <th style="width: 20%;">CBD Price :</th>
                            <td style="width: 12%;">${{ $info->linkPrice->owner_cbd_price }}</td>

                            <th style="width: 20%;">Crypto Price :</th>
                            <td style="width: 13%;">${{ $info->linkPrice->owner_crypto_price }}</td>
                        </tr>

                        <tr>
                            <th>Casino Price :</th>
                            <td>${{ $info->linkPrice->owner_casino_price }}</td>

                            <th>Homepage Link Price :</th>
                            <td>${{ $info->linkPrice->owner_homepage_price }}</td>

                            <th>Sidebar Link Price :</th>
                            <td>${{ $info->linkPrice->owner_sidebar_price }}</td>
                        </tr>

                        <tr>
                            <th>Footer Link Price :</th>
                            <td>${{ $info->linkPrice->owner_footer_price }}</td>

                            <th>DA (%):</th>
                            <td>{{ $info->da }}%</td>

                            <th>PA (%):</th>
                            <td>{{ $info->pa }}%</td>

                        </tr>

                        <tr>

                            <th>DR (%):</th>
                            <td>{{ $info->dr }}%</td>

                            <th>CF (%):</th>
                            <td>{{ $info->cf }}%</td>

                            <th>TF (%):</th>
                            <td>{{ $info->tf }}%</td>
                        </tr>

                        <tr>
                            <th>A href Rank :</th>
                            <td>{{ $info->ahref_rank }}</td>

                            <th>Traffic :</th>
                            <td>{{ $info->traffic }}</td>

                            <th>Keywords :</th>
                            <td>{{ $info->organic_keyword }}</td>

                        </tr>

                        <tr>
                            <th>Direct (%) :</th>
                            <td>{{ $info->direct }}%</td>
                            <th>Organic Search (%) :</th>
                            <td>{{ $info->organic_search }}%</td>
                            <th>Social (%) :</th>
                            <td>{{ $info->social }}%</td>
                        </tr>

                        <tr>
                            <th>Homepage Link Allowed ? :</th>
                            <td>{{ strFilter($info->homepage_link) }}</td>
                            <th>Sidebar Link Allowed ? :</th>
                            <td>{{ strFilter($info->sidebar_link) }}</td>
                            <th>Footer Link Allowed ? :</th>
                            <td>{{ strFilter($info->footer_link) }}</td>
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

        @if(!empty($country_percent) && $country_percent->isNotEmpty())
        <table class="table2">
            @foreach ($country_percent as $key => $row )
            <tr>
                <th style="width: 30%">Country {{ $key+1 }} :</th>
                <td style="width: 70%;">{{ strFilter($row->country_name) }} - {{ $row->percent }}%</td>
            </tr>
            @endforeach
        </table>
        @endif

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