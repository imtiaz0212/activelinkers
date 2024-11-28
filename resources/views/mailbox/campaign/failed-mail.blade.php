@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Failed Mail</h3>
        <!-- Modal toggle -->
        <a href="{{ route('admin.email.campaign') }}" class="button">
            <i class="fa-solid fa-plus"></i>
            My Campaigns
        </a>
    </div>


    <div class="mb-4 px-4">
        <div class="relative shadow-sm border rounded mt-5 p-5">
            <div class="grid sm:grid-cols-2 gap-8">
                <a href="{{route('admin.email.pending')}}"
                    class="p-8 bg-[#1EAAE7] text-white flex flex-col gap-1 rounded overflow-hidden relative after:absolute after:right-0 after:top-0 after:translate-x-1/2 after:-translate-y-1/2 after:size-24 after:rounded-full after:bg-[#108BE3]">
                    <span class="text-lg font-medium firstLetter">Pending Mail</span>
                    <span class="text-3xl font-bold [letter-spacing:2px]">{{$pendingMail}}</span>
                </a>

                <a href="{{route('admin.email.failed')}}"
                    class="p-8 bg-[#FF7932] text-white flex flex-col gap1  rounded overflow-hidden relative after:absolute after:right-0 after:top-0 after:translate-x-1/2 after:-translate-y-1/2 after:size-24 after:rounded-full after:bg-[#db6425]">
                    <span class="text-lg font-medium firstLetter">Failed Mail</span>
                    <span class="text-3xl font-bold [letter-spacing:2px]">{{$failedMail}}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th width="20">
                        SL
                    </th>

                    <th>
                        Date
                    </th>

                    <th>
                        Queue
                    </th>

                    <th>
                        Email
                    </th>
                    <th width="100">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>

                @if (!empty($results) && $results->isNotEmpty())
                @foreach ($results as $key => $row)
                <?php
                        $data = json_decode($row->payload);
                        $data = unserialize($data->data->command);
                        ?>
                <tr>
                    <th>
                        {{ $key+ $results->firstItem() }}
                    </th>

                    <td>
                        {{ dateFormat($row->failed_at, 'M d, Y') }}
                    </td>

                    <td>
                        {{ strFilter($row->queue) }}
                    </td>

                    <td>
                        {{ $data->data->email }}
                    </td>
                    <td>
                        <a href="{{ route('admin.email.retry', $row->uuid) }}" style="font-weight: bold; color: green;">
                            Resend
                        </a> |

                        <a href="{{ route('admin.email.failed.destroy', $row->id) }}"
                            style="font-weight: bold; color: red;"
                            onclick="return confirm('Do you want to delete this data?')">
                            Delete
                        </a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <!-- Display pagination links -->
        {{ $results->links() }}
    </div>
</div>
@endsection

@push('headerPartial')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
<link rel="stylesheet" href="{{ asset('public/css/custom-data-table.css') }}">
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
@endpush

@push('footerPartial')
<script>
    const actionUrl = "{{route('admin.email.retry-all')}}";
        new DataTable('#dataTable', {
            info: false,
            paging: false,
            scrollX: true,
            layout: {
                topStart: {
                    buttons: [
                        {
                            text: 'Resend All',
                            attr: {class: 'button text-white', style: "background: green;padding: 5px 10px;float: left; margin-right: 10px" },
                            action: function (e, dt, node, config) {
                                window.location = actionUrl;
                            }
                        },

                        {
                            text: 'Delete All',
                            attr: {class: 'button text-white', style: "background: red; padding: 5px 10px" },
                            action: function (e, dt, node, config) {
                                window.location = actionUrl;
                            }
                        }
                    ]
                }
            }
        });
</script>
@endpush
