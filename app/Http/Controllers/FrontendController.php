<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{HomeSlider, Category, Brand, Product, Variant};

class FrontendController extends Controller
{
    public function index()
    {
        return view('index', [
            'sliders' => HomeSlider::all(),
        ]);
    }

    public function shop()
    {
        return view('shop');
    }

    public function shop_detail($slug)
    {
        $this->data['product'] = Product::with('variants')->where('slug', $slug)->first();
        return view('shop_detail', $this->data);
    }

    public function change_color($id)
    {
        $variant = Variant::find($id);
        return getColors($variant);
    }

    public function change_image($id)
    {
        $variant = Variant::find($id);
        return $variant;
    }

    public function cart()
    {
        return view('cart');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function contact()
    {
        return view('contact');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
}
