@extends('layouts.app')

@section('content')

<div ng-app="myApp" ng-controller="InvoiceController" ng-cloak>
    {{-- Preloader Div Html Code Here --}}
    <div ng-show="isLoading"
        class="fixed top-0 left-0 h-screen w-screen flex items-center justify-center bg-white/50 z-[9999999]">
        <div class=" w-20 h-20 animate-[spin_2s_linear_infinite] rounded-full border-8 border-dotted border-sky-600">
        </div>
    </div>

    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class=" panelHeaderTitle">Create Invoice</h3>
        <a href="{{ route('admin.invoice') }}" class="panelHeaderBtn">
            <i class="fa-solid fa-list-check"></i>
            All Invoice
        </a>
    </div>

    <!-- Order Table -->
    <div class="shadow-md rounded p-5">
        <form action="{{ route('admin.invoice.store') }}" method="POST">
            @csrf
            <div class="grid  gap-4">
                <div class="panelHeader bg-darkblue text-white">
                    <h3 class="panelHeaderTitle lg:text-xl">Customer Info</h3>
                </div>

                <div class="grid gap-1.5">
                    <label for="firstName" class="inputLabel">Name <span class="required">(*)</span></label>
                    <input type="text" name="full_name" id="firstName" ng-model="customerName" ng-init="customerName=''"
                        class="w-full block inputField" placeholder="Your Full Name" required>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="grid gap-1.5">
                        <label for="emailAddress" class="inputLabel">Email Address <span
                                class="required">(*)</span></label>
                        @php($email = app('request')->email)
                        <select id="emailAddress" ng-model="orderEmail" ng-init="orderEmail='{{ $email }}'"
                            ng-model-options="{ debounce: 450 }" class="w-full block inputField select2" required>
                            <option value="">Select Email</option>
                            @if (!empty($orderList))
                            @foreach ($orderList as $key => $row)
                            <option value="{{ $row->email }}" {{ app('request')->input('email') == $row->email ?
                                'selected' : '' }}>
                                {{ $row->email }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="grid gap-1.5">
                        <label for="phoneNumber" class="inputLabel">Phone Number</label>
                        <input type="text" name="phone" id="phoneNumber" ng-value="customerInfo.phone"
                            class="w-full block inputField" placeholder="Phone Number">
                    </div>
                </div>

                <div class="grid gap-1.5">
                    <label for="address" class="inputLabel">Address</label>
                    <textarea name="address" id="address" class="inputField" ng-model="customerInfo.address" rows="3"
                        placeholder="Add Your Address"></textarea>
                </div>

                <div class="panelHeader bg-darkblue text-white">
                    <h3 class="panelHeaderTitle lg:text-xl">Add Order No</h3>
                </div>

                <div class="custom-table !p-0">
                    <table>
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Email</th>
                                <th>Live Links</th>
                                <th>Is Prepaid?</th>
                                <th>Amount</th>
                                <th>Publishable Amount</th>
                                <th>Discount</th>
                                <th>Total Amount</th>
                                <th class="w-[80px]">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr ng-repeat="row in orderItems">
                                <td>
                                    @{{ row.order_no }}
                                </td>

                                <td>
                                    @{{ row.email }}
                                </td>

                                <td width="250" ng-bind="row.live_links"></td>

                                <td>
                                    <span ng-if="row.prepaid_status" class="badge badge-primary mb-2">
                                        @{{ row.prepaid_status }}
                                    </span>
                                </td>

                                <td>
                                    @{{ row.subtotal }}
                                </td>

                                <td>
                                    @{{ row.publish_price }}
                                </td>

                                <td>
                                    @{{ row.discount }}
                                </td>

                                <td>
                                    @{{ row.total }}
                                </td>

                                <td class="text-center">
                                    <input type="checkbox" ng-checked="row.checked"
                                        ng-click="addCartItemFn($index, row.checked)">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="panelHeader bg-darkblue text-white">
                    <h3 class="panelHeaderTitle lg:text-xl">Invoice Information</h3>
                </div>

                <div class="custom-table !p-0">
                    <table>
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Billing On</th>
                                <th class="w-[250px]">Live Link</th>
                                <th class="w-[200px]">Total</th>
                                <th class="w-[80px]">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr ng-repeat="row in cartItems">
                                <input type="hidden" name="order_id[]" value="@{{ row.order_id }}" />
                                <input type="hidden" name="email" value="@{{ row.email }}" />

                                <td>
                                    @{{ row.order_no }}
                                </td>

                                <td>
                                    @{{ row.billing_type }}
                                </td>

                                <td>
                                    @{{ row.live_links }}
                                </td>

                                <td>
                                    @{{ row.total }}
                                </td>

                                <td class="text-center">
                                    <span
                                        class="w-[35px] p-2 flex items-center justify-center bg-red-700 cursor-pointer rounded text-white text-sm"
                                        ng-click="removeItem($index)">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </td>
                            </tr>

                            <tr class="hover:!bg-transparent">
                                <td rowspan="3" colspan="2">
                                    <textarea name="description" class="inputField" rows="7"
                                        placeholder="Add Your Description"></textarea>
                                </td>
                                <th class="border-l border-dashed text-right">Subtotal</th>
                                <td colspan="2">
                                    <input type="text" name="subtotal" ng-value="getSubtotalFn()" class="inputField"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <th class="border-l border-dashed text-right">Discount</th>
                                <td colspan="2">
                                    <input type="number" name="discount" ng-model="discount" placeholder="0"
                                        class="inputField">
                                </td>
                            </tr>
                            <tr>
                                <th class="border-l border-dashed text-right">Grand Total</th>
                                <td colspan="2">
                                    <input type="text" name="grand_total" ng-value="calculateGrandTotal()"
                                        class="inputField" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2" rowspan="2" class="text-right"></th>
                                <th class="border-l border-dashed text-right">
                                    <label>Method <span class="required">(*)</span></label>
                                </th>
                                <td colspan="2">
                                    <select name="method_id" class="inputField" required>
                                        <option value="">Select Method </option>
                                        @if (!empty($methods))
                                        @foreach ($methods as $key => $row)
                                        <option value="{{ $row->id }}" @if ($key==0) selected @endif>
                                            {{ strFilter($row->name) }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th class="border-l border-dashed text-right">
                                    <label for="sendMail">Send Mail ?</label>
                                </th>
                                <td colspan="2">
                                    <input type="checkbox" name="send_mail" id="sendMail" checked>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div ng-show="cartItems.length > 0 && customerName.trim().length > 0">
                        <div class="w-full flex justify-end mt-4">
                            <button type="submit" class="button text-center">
                                Save
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

</div>
@endsection


@push('headerPartial')
<style>
    .button {
        justify-content: center;
    }

    #default-modal .inputField,
    #TotalPrice,
    table.table tr th .inputField,
    table.table tr td .inputField {
        margin-bottom: 0px;
    }

    table.table tfoot tr th {
        text-align: right;
    }

    .none {
        display: none;
    }

    .block {
        display: block;
    }

    fieldset {
        border-radius: 0.25rem;
    }

    .required {
        color: red;
    }
</style>
@endpush

@push('headerPartial')
<script src="{{ asset('public/js/angular.min.js') }}"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('footerPartial')
<script>
    $(document).ready(function() {
            $('.select2').select2();
        });

        const app = angular.module("myApp", []);

        app.controller('InvoiceController', function($scope, $http) {

            // Initialize a variable to track loading state
            $scope.isLoading = false;
            $scope.cartItems = [];
            $scope.orderItems = [];
            $scope.customerInfo = [];
            $scope.countryCode = '';
            $scope.countryId = '';

            $scope.$watch('orderEmail', function(orderEmail) {

                $scope.cartItems = [];
                $scope.orderItems = [];
                $scope.customerInfo = [];
                $scope.customerName = '';

                if (typeof orderEmail !== 'undefined' && orderEmail != '') {
                    // Show preloader
                    $scope.isLoading = true;

                    $http({
                        method: 'post',
                        url: "{{ route('admin.invoice.customerInfo') }}",
                        data: {
                            email: orderEmail,
                            _token: "{{ csrf_token() }}"
                        }
                    }).then(function(response) {
                        if (response.data) {
                            $scope.customerInfo = response.data;
                            $scope.customerName = response.data.full_name;
                        }
                    }).finally(function() {
                        // Hide preloader after data is loaded or request is completed
                        $scope.isLoading = false;
                    });

                    $http({
                        method: 'post',
                        url: "{{ route('admin.invoice.orderInfo') }}",
                        data: {
                            email: orderEmail,
                            _token: "{{ csrf_token() }}"
                        }
                    }).then(function(response) {
                        if (response.data) {
                            angular.forEach(response.data, function(row) {
                                var item = {
                                    id: row.id,
                                    created: row.created,
                                    order_no: row.order_no,
                                    billing_type: row.billing_type,
                                    name: row.name,
                                    email: row.email,
                                    live_links: row.live_links,
                                    prepaid_status: row.prepaid_status,
                                    subtotal: parseFloat(row.subtotal),
                                    publish_price: parseFloat(row.publish_price),
                                    discount: parseFloat(row.discount),
                                    total: parseFloat(row.grand_total),
                                    checked: false
                                };
                                $scope.orderItems.push(item);
                            });
                        }
                    }).finally(function() {
                        // Hide preloader after data is loaded or request is completed
                        $scope.isLoading = false;
                    });
                }
            });

            $scope.addCartItemFn = function(index, checked) {

                let data = $scope.orderItems[index];

                data.checked = (checked == false ? true : false);

                if (typeof data !== 'undefined' && data.checked == true) {

                    var item = {
                        order_id: data.id,
                        created: data.created,
                        order_no: data.order_no,
                        billing_type: data.billing_type,
                        name: data.name,
                        email: data.email,
                        live_links: data.live_links,
                        total: data.total,
                    };

                    $scope.cartItems.push(item);

                } else {

                    angular.forEach($scope.cartItems, function(row, key) {
                        if (row.order_id == data.id) {
                            $scope.cartItems.splice(key, 1);
                        }
                    });
                }
            }

            $scope.subtotal = 0;
            $scope.getSubtotalFn = function() {

                let totalAmount = 0;
                angular.forEach($scope.cartItems, function(row) {
                    totalAmount += parseFloat(row.total);
                });

                $scope.subtotal = parseFloat(totalAmount.toFixed(3));

                return $scope.subtotal;
            };

            // Function to calculate grand total
            $scope.calculateGrandTotal = function() {
                let subtotal = !isNaN(parseFloat($scope.subtotal)) ? parseFloat($scope.subtotal) : 0;
                let discount = !isNaN(parseFloat($scope.discount)) ? parseFloat($scope.discount) : 0;

                let totalAmount = subtotal - discount;

                return parseFloat(totalAmount.toFixed(3));
            };

            $scope.removeItem = function(index) {

                let alert = confirm('Do you want to remove this item?');
                if (alert) {

                    let data = $scope.cartItems[index];

                    angular.forEach($scope.orderItems, function(row, key) {
                        if (row.id == data.order_id) {
                            $scope.orderItems[key].checked = false;
                        }
                    });

                    $scope.cartItems.splice(index, 1);
                }
            };

        });
</script>
@endpush
