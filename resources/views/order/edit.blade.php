@extends('layouts.app')

@section('content')

<div ng-app="myApp" ng-controller="OrderController">

    {{-- Preloader Div Html Code Here --}}
    <div ng-show="isLoading"
        class="fixed top-0 left-0 h-screen w-screen flex items-center justify-center bg-white/50 z-[9999999]">
        <div class=" w-20 h-20 animate-[spin_2s_linear_infinite] rounded-full border-8 border-dotted border-sky-600">
        </div>
    </div>

    <!-- Pages Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Update Order</h3>
        <a href="{{ route('admin.order') }}" class="button text-sm">
            <i class="fas fa-list"></i>
            All Order

        </a>
    </div>

    <!-- Order Table -->
    <div class="relative shadow-md rounded p-5">
        <form action="{{ route('admin.order.update') }}" class="grid gap-6" method="POST">
            @csrf

            <input type="hidden" name="id" value="{{ $orderInfo->id }}" class="inputField" />

            <div class="panelHeader bg-darkblue text-white">
                <h3 class="panelHeaderTitle lg:text-xl">Add Link Information</h3>
            </div>

            <div class="grid lg:grid-cols-3 gap-5 items-start">
                <div class="lg:col-span-1 grid gap-4">
                    {{-- Delivary date --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="delivary_date" class="inputLabel">Delivary Date</label>
                        <input id="delivary_date" type="date" value="{{ $orderInfo->delivery_date }}"
                            name="delivery_date" placeholder="Delivery Date" class="datepicker inputField" />
                    </div>

                    {{-- Name --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="name" class="inputLabel">Name</label>
                        <input id="name" type="text" name="first_name" ng-value="customerName"
                            placeholder="Your Full Name" class="inputField" />
                    </div>

                    {{-- Email --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="email" class="inputLabel">Email <span class="required">(*)</span></label>
                        <input id="email" type="email" name="email" ng-init="email='{{ $orderInfo->email }}'"
                            ng-model="email" placeholder="Your Email" class="inputField"
                            ng-model-options="{ debounce: 450 }" required />
                    </div>

                    {{-- Billing Type --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="billing_type" class="inputLabel">Billing Type <span
                                class="required">(*)</span></label>
                        <select id="billing_type" ng-init="billing_type='{{ $orderInfo->billing_type }}'"
                            ng-model="billing_type" name="billing_type" class="inputField" required>
                            <option value="">Select Billing Type</option>
                            @if (!empty($billingType))
                            @foreach ($billingType as $row => $billing)
                            <option value="{{ $billing->id }}">{{ strFilter($billing->name) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="lg:col-span-2 flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5 w-full">
                        <label for="site_url" class="inputLabel">Site URL</label>
                        <input id="site_url" list="allUrl" ng-model="siteUrl" placeholder="Site url" class="inputField"
                            readonly>
                        <datalist id="allUrl">
                            <option ng-repeat="site in siteList" value=""></option>
                        </datalist>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        {{-- Custom entity --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="custom_entity" class="inputLabel">Custom Entity</label>
                            <input id="custom_entity" type="text" name="entity_name" ng-model="entityName"
                                placeholder="Custom Entity Name" class="inputField" />
                        </div>

                        {{-- Link Price --}}
                        <div class="flex flex-col gap-1.5">
                            <label for="link_price" class="inputLabel">Link Price</label>
                            <input id="link_price" type="text" name="url_price" ng-model="price"
                                placeholder="Link Price" class="inputField" step="any">
                            <input type="hidden" ng-model="otherPrice" class="inputField">
                            <input type="hidden" ng-model="item_id" class="inputField">
                        </div>
                    </div>

                    <div ng-show="billing_type==1">
                        <div id="linkInsertionOn" class="grid gap-5">
                            <div ng-repeat="item in anchorCart" class="grid gap-5">
                                <div class="flex gap-5 items-end">
                                    <div class="space-y-2 flex-1">
                                        <label for="anchor_text" class="inputLabel">Anchor Text</label>
                                        <input id="anchor_text" type="text" ng-model="item.anchor_text"
                                            placeholder="Anchor Text" class="inputField" />
                                    </div>
                                    <div class="space-y-2 flex-1">
                                        <label for="URL" class="inputLabel">URL</label>
                                        <input id="URL" type="text" ng-model="item.link" placeholder="URL"
                                            class="inputField" />
                                    </div>
                                    <button type="button" ng-show="$index!=0" ng-click="removeAnchorCartItemFn($index)"
                                        class="times size-[50px] shrink-0 flex items-center justify-center rounded bg-red-600 cursor-pointer text-white">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <button type="button" ng-click="addNewAnchorItem()"
                                    class="ml-auto button button--secondary">
                                    Add <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div ng-show="billing_type==3">
                        <div id="articleWritingOn">
                            <div class="mb-3">
                                <label for="articleAmount" class="inputLabel">Article Writing and Publishing
                                    Price</label>
                                <input type="number" ng-model="articleWriting" placeholder="0" class="inputField" />
                            </div>
                        </div>
                    </div>

                    {{-- Live link --}}
                    <div class=" space-y-2">
                        <label for="live_link" class="inputLabel">Live Link</label>
                        <input id="live_link" type="text" ng-init="liveLink=''" ng-model="liveLink"
                            ng-model-options="{ allowInvalid: true, debounce: 500 }" placeholder="Live Link"
                            class="inputField" step="any">

                        <p class="text-red-600" ng-if="validation">Your link does not match our records.</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4 items-end">
                        <div class="grid gap-1.5">
                            <label for="linkInsert" class="cursor-pointer">
                                <input type="checkbox" ng-model="linkInsert" id="linkInsert">
                                Is allowed link insert ?
                            </label>
                            <label for="otherPriceCheckbox" class="cursor-pointer">
                                <input type="checkbox" ng-click="getItemTotalPriceFn()" ng-model="otherPriceCheckbox"
                                    id="otherPriceCheckbox">
                                Other Post Link Price ?
                            </label>
                        </div>

                        <div class="grid gap-1.5">
                            <label for="TotalPrice" class="inputLabel">Total</label>
                            <input type="text" id="TotalPrice" ng-value="getItemTotalPriceFn()"
                                placeholder="Total Price" class="inputField" readonly>
                        </div>

                        <div>
                            <button type="button" class="button button--secondary h-[46px]" ng-click="addToCart()">
                                Add To Cart
                            </button>
                        </div>

                    </div>
                </div>
            </div>



            <div class="panelHeader bg-darkblue text-white">
                <h3 class="panelHeaderTitle lg:text-xl">Order Information</h3>
            </div>

            <div class="custom-table !p-0" ng-init="orderId='{{ $orderInfo->id }}'">
                <table>
                    <thead>
                        <tr>
                            <th>Site URL</th>

                            <th>Entity Name</th>

                            <th>Live Link</th>

                            <th>Link Insertions</th>

                            <th>Is allowed link insert?</th>

                            <th class="w-[120px]">Price</th>

                            <th class="w-[120px]">Other Price</th>

                            <th class="w-[120px]">Article Writing</th>

                            <th class="w-[160px]">Total</th>

                            <th class="w-[80px]">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr ng-repeat="row in orderItems">

                            <input type="hidden" name="item_id[]" value="@{{ row.item_id }}" class="inputField" />
                            <input type="hidden" name="url[]" value="@{{ row.url }}" class="inputField" />
                            <input type="hidden" name="anchor[]" value="@{{ row.anchor }}" class="inputField" />
                            <input type="hidden" name="entity_name[]" value="@{{ row.entity }}" class="inputField" />
                            <input type="hidden" name="live_link[]" value="@{{ row.liveLink }}" class="inputField" />
                            <input type="hidden" name="link_insert[]" value="yes" ng-if="row.insert"
                                class="inputField" />
                            <input type="hidden" name="link_insert[]" value="no" ng-if="!row.insert"
                                class="inputField" />
                            <input type="hidden" name="other_link_price[]" value="yes" ng-if="row.otherPriceCheckbox"
                                class="inputField" />
                            <input type="hidden" name="other_link_price[]" value="no" ng-if="!row.otherPriceCheckbox"
                                class="inputField" />
                            <input type="hidden" name="url_price[]" value="@{{ row.price }}" class="inputField" />
                            <input type="hidden" name="other_price[]" value="@{{ row.otherPrice }}"
                                class="inputField" />
                            <input type="hidden" name="total[]" value="@{{ row.totalPrice }}" class="inputField" />
                            <input type="hidden" name="article_amount[]" value="@{{ row.articleWriting }}"
                                class="inputField" />

                            <td>
                                @{{ row.url }}
                            </td>

                            <td>
                                @{{ row.entity }}
                            </td>

                            <td>
                                @{{ row.liveLink }}
                            </td>

                            <td class="whitespace-nowrap">
                                <span ng-if="row.anchor.length > 0" ng-repeat="tabs in row.anchor">
                                    <span style="font-weight: bold;">Anchor Text :</span> @{{ tabs.anchor_text }}
                                    <br />
                                    <span style="font-weight: bold;">Link :</span> @{{ tabs.link }}
                                </span>
                                <span ng-if="row.anchor.length == 0">
                                    No anchors available
                                </span>
                            </td>

                            <td>
                                @{{ row.insert ? 'Yes' : 'No' }}
                            </td>

                            <td>
                                @{{ row.price }}
                            </td>

                            <td>
                                @{{ row.otherPrice }}
                            </td>

                            <td>
                                @{{ row.articleWriting }}
                            </td>

                            <td>
                                @{{ row.totalPrice }}
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
                            <th rowspan="7" colspan="6"></th>
                            <th colspan="2" class="border-l border-dashed">Subtotal</th>
                            <td colspan="2">
                                <input type="text" name="subtotal" ng-value="getSubtotalFn()" readonly
                                    class="inputField">
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2" class="border-l border-dashed">Service Charge</th>
                            <td colspan="2">
                                <input type="number" name="service_charge" ng-model="serviceCharge"
                                    ng-init="serviceCharge={{ $orderInfo->service_charge }}" class="inputField">
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2" class="border-l border-dashed">Tax</th>
                            <td colspan="2">
                                <input type="number" name="tax" ng-model="tax" ng-init="tax={{ $orderInfo->tax }}"
                                    class="inputField">
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2" class="border-l border-dashed">Discount</th>
                            <td colspan="2">
                                <input type="number" name="discount" ng-model="discount"
                                    ng-init="discount={{ $orderInfo->discount }}" class="inputField">
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2" class="border-l border-dashed">Grand Total</th>
                            <td colspan="2">
                                <input type="text" name="grand_total" ng-value="calculateGrandTotal()"
                                    class="inputField" readonly>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2" class="border-l border-dashed text-right">Order From</th>
                            <td colspan="2">
                                <select ng-model="orderFrom" ng-init="orderFrom='{{ $orderInfo->email_from_id }}'"
                                    name="email_from_id" class="inputField" required>
                                    @if (!empty($emailList))
                                    @foreach ($emailList as $row => $email)
                                    <option value="{{ $email->id }}">{{ strFilter($email->name) }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2" class="border-l border-dashed text-right">Is PrePayment ?</th>
                            <td colspan="2">
                                <input type="checkbox" name="prepayment" ng-model="prePayment">
                            </td>
                        </tr>

                    </tbody>
                </table>

                <div class="w-full flex justify-end mt-4" ng-show="orderItems.length > 0">
                    <button type="submit" class="button text-center">
                        <i class="fas fa-save"></i>
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('headerPartial')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .required {
        color: red !important;
    }

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

    #linkInsertionOn {
        margin-bottom: 15px;
    }

    fieldset {
        border-radius: 0.25rem;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #bcec00;
        border: 1px solid #bcec00;
        color: #333;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        background-color: #031f42;
        border: 1px solid #031f42;
        color: #fff;
        font-size: 0.75em;
        padding: 2px 4px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        background-color: #c81e1e;
        border: 1px solid #c81e1e;
        color: #fff;
    }

    .select2-container--default .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container--default .select2-selection--multiple {
        height: 50px !important;
        display: flex !important;
        align-items: center !important;
        border-color: #e4e4e4 !important;
    }

    .select2-container--default .select2-selection--single[aria-expanded="true"],
    .select2-container--default.select2-container--focus .select2-selection--multiple[aria-expanded="true"],
    .select2-container--default .select2-selection--multiple[aria-expanded="true"] {
        border-color: #3A9CFD !important
    }

    .select2-selection__arrow {
        height: auto !important;
        top: 50% !important;
        transform: translateY(-50%) !important
    }
</style>
@endpush

@push('footerPartial')
<!-- AngulerJS cdn -->
<script src="{{ asset('public/js/angular.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
            $('#nicheMultiple').select2();
        });

        const app = angular.module("myApp", []);

        app.controller('OrderController', function($scope, $http) {
            // Initialize a variable to track loading state
            $scope.isLoading = false;
            $scope.linkInsert = true;
            $scope.prePayment = false;
            $scope.validation = false;

            @if (!empty($orderInfo->prepaid_status))
                $scope.prePayment = true;
            @endif

            // Initialize variables on the $scope object
            $scope.siteLinks = [];
            $scope.orderItems = [];
            $scope.siteUrl = '';
            $scope.price = 0;
            $scope.otherPrice = 0;

            // Initialize variables
            $scope.subtotal = 0;
            $scope.serviceCharge = 0;
            $scope.tax = 0;
            $scope.discount = 0;
            $scope.grandTotal = 0;

            // Watch the 'liveLink' variable for changes
            $scope.$watch('liveLink', function(liveLink) {

                $scope.price = 0;
                $scope.otherPrice = 0;
                $scope.validation = false;

                if (typeof liveLink !== 'undefined' && liveLink != '') {

                    // Show preloader
                    $scope.isLoading = true;

                    $http({
                        method: 'post',
                        url: "{{ route('admin.order.site_info') }}",
                        data: {
                            check_url: liveLink,
                            _token: '{{ csrf_token() }}'
                        }
                    }).then(function(response) {
                        if (response.data) {
                            $scope.siteUrl = response.data.url;
                            $scope.price = response.data.general_price;
                            $scope.otherPrice = response.data.other_price;
                        } else {
                            $scope.validation = true;
                        }
                    }).finally(function() {
                        // Hide preloader after data is loaded or request is completed
                        $scope.isLoading = false;
                    });
                }

            });

            // Function to add otherPrice to totalPrice
            $scope.totalPrice = 0;

            $scope.otherPriceCheckbox = false;
            $scope.getItemTotalPriceFn = function() {

                let price = !isNaN(parseFloat($scope.price)) ? parseFloat($scope.price) : 0;
                let otherPrice = !isNaN(parseFloat($scope.otherPrice)) ? parseFloat($scope.otherPrice) : 0;
                let articleWriting = !isNaN(parseFloat($scope.articleWriting)) ? parseFloat($scope
                    .articleWriting) : 0;

                let totalPrice = 0;
                if ($scope.otherPriceCheckbox) {
                    totalPrice = (price + otherPrice + articleWriting);
                } else {
                    totalPrice = (price + articleWriting);
                }
                $scope.totalPrice = parseFloat(totalPrice);

                return $scope.totalPrice;
            }

            $scope.$watch('orderId', function(orderId) {
                $http({
                    method: 'post',
                    url: "{{ route('admin.order.itemInfo') }}", // Update the URL to the correct endpoint
                    data: {
                        order_id: orderId,
                        _token: "{{ csrf_token() }}"
                    }
                }).then(function(response) {
                    angular.forEach(response.data, function(row) {
                        var item = {
                            item_id: row.id,
                            url: row.url,
                            entity: row.entity_name,
                            liveLink: row.live_url,
                            insert: row.link_insert,
                            otherPriceCheckbox: row.is_other_price,
                            price: parseFloat(row.url_price),
                            otherPrice: parseFloat(row.other_price),
                            totalPrice: parseFloat(row.total),
                            articleWriting: parseFloat(row.artical),
                            anchor: JSON.parse(row.anchor),
                        };
                        $scope.orderItems.push(item);
                    });
                });
            });

            $scope.addToCart = function() {
                if ($scope.billing_type != '' && $scope.liveLink != '') {
                    // Retrieve values from input fields or other sources
                    var url = $scope.siteUrl;
                    var entity = $scope.entityName;
                    var liveLink = $scope.liveLink;
                    var insert = $scope.linkInsert;
                    var insert = $scope.articleWriting;

                    var anchor = $scope.anchorCart;

                    var otherPriceCheckbox = $scope.otherPriceCheckbox;

                    let price = !isNaN(parseFloat($scope.price)) ? parseFloat($scope.price) : 0;
                    let otherPrice = !isNaN(parseFloat($scope.otherPrice)) ? parseFloat($scope.otherPrice) : 0;
                    let articleWriting = !isNaN(parseFloat($scope.articleWriting)) ? parseFloat($scope
                        .articleWriting) : 0;

                    let subtotalPrice = 0;
                    if ($scope.otherPriceCheckbox) {
                        subtotalPrice = (price + otherPrice + articleWriting);
                    } else {
                        subtotalPrice = (price + articleWriting);
                    }
                    // Calculate total price
                    var total = parseFloat(subtotalPrice.toFixed(3));

                    // Create new order item
                    var newItem = {
                        item_id: '',
                        url: url,
                        entity: entity,
                        liveLink: liveLink,
                        insert: insert,
                        otherPriceCheckbox: otherPriceCheckbox,
                        price: price,
                        otherPrice: otherPrice,
                        totalPrice: total,
                        articleWriting: articleWriting,
                        anchor: anchor,
                    };

                    // Add the new item to the orderItems array
                    $scope.orderItems.push(newItem);

                    // Clear input fields after adding item
                    $scope.clearFields();
                }
            };

            $scope.subtotal = 0;
            $scope.getSubtotalFn = function() {
                let totalAmount = 0;
                angular.forEach($scope.orderItems, function(row) {
                    totalAmount += parseFloat(row.totalPrice);
                });

                $scope.subtotal = parseFloat(totalAmount.toFixed(3));

                return $scope.subtotal;
            }

            // Function to calculate grand total
            $scope.calculateGrandTotal = function() {

                let serviceCharge = !isNaN(parseFloat($scope.serviceCharge)) ? parseFloat($scope
                    .serviceCharge) : 0;
                let tax = !isNaN(parseFloat($scope.tax)) ? parseFloat($scope.tax) : 0;
                let discount = !isNaN(parseFloat($scope.discount)) ? parseFloat($scope.discount) : 0;

                let totalAmount = ($scope.subtotal + serviceCharge + tax) - discount;

                return parseFloat(totalAmount.toFixed(3));
            };

            $scope.removeItem = function(index) {
                $scope.orderItems.splice(index, 1);
            };


            $scope.clearFields = function() {
                // Clear input fields after adding item
                $scope.siteUrl = '';
                $scope.entityName = '';
                $scope.liveLink = '';
                $scope.linkInsert = false;
                $scope.price = '';
                $scope.otherPriceCheckbox = false;
                $scope.otherPrice = '';
                $scope.totalPrice = '';
                $scope.articleWriting = '';

                $scope.anchorCart = [{
                    anchor_text: '',
                    link: ''
                }];
            };

            $scope.anchorCart = [{
                anchor_text: '',
                link: ''
            }];

            $scope.addNewAnchorItem = function() {
                let item = {
                    anchor_text: '',
                    link: ''
                };

                $scope.anchorCart.push(item);
            };

            $scope.removeAnchorCartItemFn = function(index) {
                $scope.anchorCart.splice(index, 1);
            }

            $scope.customerName = '';
            $scope.$watch('email', function(email) {
                if (typeof email !== 'undefined' && email != '') {
                    $http({
                        method: 'post',
                        url: "{{ route('admin.invoice.customerInfo') }}",
                        data: {
                            email: email,
                            _token: "{{ csrf_token() }}"
                        }
                    }).then(function(response) {
                        if (response.data) {
                            $scope.customerName = response.data.full_name;
                        }
                    });
                }
            });
        });
</script>
@endpush