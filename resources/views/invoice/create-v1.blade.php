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
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Create Invoice</h3>
        <a href="{{ route('admin.invoice') }}" class="primary-btn text-sm">
            All Invoice
            <i class="fa-solid fa-list-check"></i>
        </a>
    </div>

    <!-- Order Table -->
    <div class="shadow-md rounded p-5">
        <form action="{{ route('admin.invoice.store') }}" method="POST">
            @csrf

            <div class="grid lg:grid-cols-2 mt-2 gap-5">
                <fieldset class="border border-solid border-gray-300 p-3 mb-4 grid">
                    <legend class="font-medium text-gray-900">
                        <p class="text-[20px]">Customer Info</p>
                    </legend>

                    <div class="grid lg:grid-cols-1 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="firstName">First Name</label>
                            <input type="text" name="first_name" id="firstName" ng-value="customerInfo.first_name"
                                class="w-full block inputField" placeholder="First Name">
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-1 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="lastName">Last Name</label>
                            <input type="text" name="last_name" id="lastName" ng-value="customerInfo.last_name"
                                class="w-full block inputField" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-1 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="businessName">Business Name</label>
                            <input type="text" name="business_name" id="businessName"
                                ng-value="customerInfo.business_name" class="w-full block inputField"
                                placeholder="Business Name">
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-1 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="emailAddress">Email Address <span class="required">(*)</span></label>
                            <select id="emailAddress" ng-init="orderEmail=''" ng-model="orderEmail"
                                ng-change="getOrderInfoFn(orderEmail)" class="w-full block inputField select2" required>
                                <option value="">Select Email</option>
                                @if (!empty($orderList))
                                @foreach ($orderList as $key => $row)
                                <option value="{{ $row->email }}">{{ $row->email }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="countryCode">Country Code</label>
                            <select name="code" id="countryCode" class="w-full block inputField select2">
                                <option value="">Select Code</option>
                                @foreach($countryList as $key => $country)
                                <option value="{{ $country->phonecode }}">{{ $country->name }} (+{{ $country->phonecode
                                    }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" name="phone" id="phoneNumber" ng-value="customerInfo.phone"
                                class="w-full block inputField" placeholder="Phone Number">
                        </div>

                    </div>

                </fieldset>

                <fieldset class="border border-solid border-gray-300 p-3 mb-4 grid">
                    <legend class="font-medium text-gray-900">
                        <p class="text-[20px]">Billing Info</p>
                    </legend>

                    <div class="grid lg:grid-cols-1 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="countryId">Country</label>
                            <select name="country_id" id="countryId" class="w-full block inputField select2">
                                <option value="">Select Country</option>
                                @foreach($countryList as $key => $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-1 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="streetName">Street Name and House Number</label>
                            <input type="text" name="street_name" id="streetName" ng-value="customerInfo.street_name"
                                class="w-full block inputField" placeholder="Street Name and House Number">
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-1 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" ng-value="customerInfo.address"
                                class="w-full block inputField" placeholder="Address">
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-1 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="city">City</label>
                            <input type="text" name="city" id="city" ng-value="customerInfo.city"
                                class="w-full block inputField" placeholder="City">
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 mt-2 gap-7">
                        <div class="flex flex-col gap-2">
                            <label for="postalCode">Postal Code</label>
                            <input type="text" name="postal_code" id="postalCode" ng-value="customerInfo.postal_code"
                                class="w-full block inputField" placeholder="Postal Code">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="taxCode">Tax Code</label>
                            <input type="text" name="tax_code" id="taxCode" ng-value="customerInfo.tax_code"
                                class="w-full block inputField" placeholder="Tax Code">
                        </div>
                    </div>

                </fieldset>
            </div>

            <fieldset class="border border-solid border-gray-300 p-3 mb-4 grid">
                <legend class="font-medium text-gray-900">
                    <p class="text-[20px]">Add Order No</p>
                </legend>

                <div class="custom-table">
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

            </fieldset>

            <fieldset class="border border-solid border-gray-300 p-3 mb-4 w-full grid">
                <legend class="font-medium text-gray-900">
                    <p class="text-[20px]">Invoice Information</p>
                </legend>

                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Billing On</th>
                                <th>Live Link</th>
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
                                    <input type="number" name="discount" ng-model="discount" class="inputField">
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
                                        @if (!empty($method))
                                        @foreach ($method as $name)
                                        <option value="{{ $name->id }}">{{ strFilter($name->name) }}</option>
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

                    <div ng-show="cartItems.length > 0">
                        <div class="w-full flex justify-end mt-4">
                            <button type="submit" class="primary-btn text-center">
                                Save
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </fieldset>
        </form>
    </div>

</div>
@endsection


@push('headerPartial')
<style>
    .primary-btn {
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
            $scope.isLoading    = false;
            $scope.cartItems    = [];
            $scope.orderItems   = [];
            $scope.customerInfo = [];
            $scope.countryCode  = '';
            $scope.countryId    = '';
            $scope.getOrderInfoFn = function(orderEmail) {

                $scope.cartItems = [];
                $scope.orderItems = [];
                $scope.customerInfo = [];

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
                            $('#countryCode option[value="'+  response.data.code +'"]').attr("selected", "selected");
                            $('#countryId option[value="'+  response.data.country +'"]').attr("selected", "selected");
                            $('.select2').select2();
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
                                    id            : row.id,
                                    created       : row.created,
                                    order_no      : row.order_no,
                                    billing_type  : row.billing_type,
                                    name          : row.name,
                                    email         : row.email,
                                    live_links    : row.live_links,
                                    prepaid_status: row.prepaid_status,
                                    subtotal      : parseFloat(row.subtotal),
                                    publish_price : parseFloat(row.publish_price),
                                    discount      : parseFloat(row.discount),
                                    total         : parseFloat(row.grand_total),
                                    checked       : false
                                };
                                $scope.orderItems.push(item);
                            });
                        }
                    }).finally(function() {
                        // Hide preloader after data is loaded or request is completed
                        $scope.isLoading = false;
                    });
                }
            }

            $scope.addCartItemFn = function(index, checked) {

                let data = $scope.orderItems[index];

                data.checked = (checked == false ? true : false);

                if (typeof data !== 'undefined' && data.checked == true) {

                    var item = {
                        order_id    : data.id,
                        created     : data.created,
                        order_no    : data.order_no,
                        billing_type: data.billing_type,
                        name        : data.name,
                        email       : data.email,
                        live_links  : data.live_links,
                        total       : data.total,
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