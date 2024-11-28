<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Service;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Information;
use App\Models\Blog;
use App\Models\Coupon;
use App\Models\SiteList;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->data['headerServiceList'] = Service::with('serviceCategory')->limit(5)->get();
        $this->data['userInfo']          = Admin::get();
        $this->data['brandInfo']         = Brand::get();
        $this->data['whyUs']             = Information::where('type', 'why-us')->get();
        $this->data['faq']               = Information::where('type', 'faq')->get();
        $this->data['recentBlog']        = Blog::with('userList')->orderBy('created', 'desc')->limit(3)->get();
        $this->data['aboutUs']           = AboutUs::first();
    }

    // View Cart
    public function index()
    {
        $this->data['menu']       = '';
        $this->data['siteTitle']  = 'Cart';
        $this->data['breadcrumb'] = ['cart' => 'Cart'];

        $cart = session('cart', []);
        if (empty($cart)) {
            $this->removeCartSession();
            return redirect('/websites');
        }
        $this->data["cart"]        = (object)$cart;
        $this->data["coupon"]      = (object)session('cart_coupon', []);
        $this->data["subtotal"]    = $this->getSubtotal();
        $this->data["discount"]    = $this->getDiscountedTotal();
        $this->data["totalAmount"] = $this->getTotal();

        return view('cart', $this->data);
    }

    // View Checkout Page
    public function checkout()
    {
        $this->data['menu']       = '';
        $this->data['siteTitle']  = 'Checkout';
        $this->data['breadcrumb'] = ['checkout' => 'Checkout'];

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            $this->removeCartSession();
            return redirect('/websites');
        }

        $this->data["cart"]        = (object)$cart;
        $this->data["coupon"]      = (object)session('cart_coupon');
        $this->data["subtotal"]    = $this->getSubtotal();
        $this->data["discount"]    = $this->getDiscountedTotal();
        $this->data["totalAmount"] = $this->getTotal();
        $this->data["countryList"] = Country::select('id', 'name')->orderBy('name')->get();

        $this->updateCartTotal();

        return view('checkout', $this->data);
    }

    // Add Item To Cart
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id'   => 'required|exists:site_lists,id',
                'billing_type' => 'required|string',
                'niche'        => 'required|string',
            ]);

            $info = SiteList::find($request->product_id);
            $cart = session()->get('cart', []);

            // If item is already in the cart, update the quantity
            if (isset($cart[$info->id])) {
                $cart[$info->id]['quantity'] += $request->quantity;
            } else {
                // Otherwise, add the item to the cart
                $price = ($request->niche == "others" ? ($info->general_price + $info->other_price) : $info->general_price);

                $cart[$info->id] = [
                    'billing_type'  => $request->billing_type,
                    'niche'         => $request->niche,
                    'title'         => $info->title,
                    'quantity'      => 1,
                    'price'         => $price,
                    'general_price' => $info->general_price,
                    'other_price'   => $info->other_price,
                ];
            }

            session()->put('cart', $cart);
            $this->updateCartTotal();

            session()->flash('success', 'Product added to cart successfully');
            return response()->json(['message' => 'Product added to cart', 'success' => true], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'success' => false], 500);
        }
    }

    // Remove Item From Cart
    public function removeFromCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:site_lists,id',
            ]);

            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                unset($cart[$request->product_id]);
                session()->put('cart', $cart);
            }

            $this->updateCartTotal();

            session()->flash('success', 'Item removed from cart successfully');
            return response()->json(['message' => 'Item removed from cart successfully', 'success' => true], 200);

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'success' => false], 400);
        }
    }

    // update cart
    public function updateCart(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:site_lists,id']);
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {

            // get site info
            $info = SiteList::find($request->product_id);

            if ($request->billing_type) {
                $cart[$request->product_id]['billing_type'] = $request->billing_type;
            }

            // update niche price
            if ($request->niche) {

                $price = ($request->niche == "others" ? ($info->general_price + $info->other_price) : $info->general_price);

                $cart[$request->product_id]['niche']         = $request->niche;
                $cart[$request->product_id]['price']         = $price;
                $cart[$request->product_id]['general_price'] = $info->general_price;
                $cart[$request->product_id]['other_price']   = $info->other_price;
            }
        }

        session()->put('cart', $cart);
        $this->updateCartTotal();

        return response()->json(['cart' => $cart, 'subtotal' => $this->getSubtotal(), 'discount' => $this->getDiscountedTotal(), 'total' => $this->getTotal()]);
    }

    // increase quantity
    public function increaseQuantity(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:site_lists,id']);
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += 1;
        }

        session()->put('cart', $cart);
        $this->updateCartTotal();

        return response()->json(['cart' => $cart, 'subtotal' => $this->getSubtotal(), 'discount' => $this->getDiscountedTotal(), 'total' => $this->getTotal()]);
    }

    // decrease quantity
    public function decreaseQuantity(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:site_lists,id']);
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id]) && $cart[$request->product_id]['quantity'] > 1) {
            $cart[$request->product_id]['quantity'] -= 1;
        } elseif (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
        }

        session()->put('cart', $cart);
        $this->updateCartTotal();

        return response()->json(['cart' => $cart, 'subtotal' => $this->getSubtotal(), 'discount' => $this->getDiscountedTotal(), 'total' => $this->getTotal()]);
    }

    // apply coupon
    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);
        $coupon = Coupon::where('code', $request->coupon_code)->where('status', 'enable')->first();
        if (!$coupon) {
            return response()->json(['message' => 'Invalid coupon code.', 'success' => false], 400);
        }

        session()->put('cart_coupon', ['code' => $coupon->code, 'type' => $coupon->type, 'discount' => $coupon->discount]);
        $this->updateCartTotal();

        return response()->json([
            'message'  => 'Coupon applied successfully.',
            'success'  => true,
            'subtotal' => $this->getSubtotal(),
            'discount' => $this->getDiscountedTotal(),
            'total'    => $this->getTotal(),
            'coupon'   => session('cart_coupon')
        ]);
    }

    // Remove coupon
    public function removeCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        session()->forget('cart_coupon');
        $this->updateCartTotal();

        return response()->json([
            'message'  => 'Coupon removed successfully.',
            'success'  => true,
            'subtotal' => $this->getSubtotal(),
            'discount' => $this->getDiscountedTotal(),
            'total'    => $this->getTotal(),
        ]);
    }

    // calculate cart total
    private function calculateCartTotal($cart)
    {
        return array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));
    }

    // get subtotal
    private function getSubtotal()
    {
        return $this->calculateCartTotal(session()->get('cart', []));
    }

    // get discount
    private function getDiscountedTotal()
    {
        $subtotal = $this->getSubtotal();
        $coupon   = session('cart_coupon');

        if (!$coupon)
            return 0;

        if ($coupon['type'] === 'percentage') {
            return round(($subtotal * ($coupon['discount'] / 100)), 2);
        } elseif ($coupon['type'] === 'fixed') {
            return round($coupon['discount'], 2);
        }
    }

    // get total
    private function getTotal()
    {
        return $this->getSubtotal() - $this->getDiscountedTotal();
    }

    // update cart total
    private function updateCartTotal()
    {
        session()->put([
            'cart_subtotal' => $this->getSubtotal(),
            'cart_discount' => $this->getDiscountedTotal(),
            'cart_total'    => $this->getTotal(),
        ]);
    }

    // remove cart session
    private function removeCartSession()
    {
        session()->forget(['cart', 'cart_coupon', 'cart_subtotal', 'cart_discount', 'cart_total']);
    }
}
