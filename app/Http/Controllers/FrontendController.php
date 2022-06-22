<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QueryRequest;
use App\Models\{HomeSlider, Category, Brand, Product, Variant, Contact, Query};

class FrontendController extends Controller
{
    public function index()
    {
        return view('index', [
            'sliders' => HomeSlider::all(),
        ]);
    }

    public function shop($category_id = null)
    {
        if($category_id == null){
            $variants = Variant::where('status', 1)->get();
            $products = Product::where('status', 1)->get();
        }
        else{
            $variants = Variant::where('status', 1)
            ->whereIn('product_id', function($query) use ($category_id) {
                $query->select('id')
                ->from('products')
                ->where('category_id', $category_id);
            })
            ->get();
            $products = Product::where('status', 1)->where('category_id', $category_id)->get();
        }
        return view('shop', [
            'products' => $products,
            'colors' => $variants->groupBy('color'),
            'sizes' => $variants->groupBy('size'),
        ]);
    }

    public function sort_products(request $request)
    {
        $ids = $request->ids;
        $sort = $request->sort;
        if($sort === 'latest'){
            $products = Product::with('variants')->whereIn('id', $ids)->orderBy('id', 'desc')->get();
        }elseif($sort === 'pricel2h'){
            $products = Product::with('variants')->whereIn('id', $ids)->get()->sortBy(function($product) {
                return $product->variants->min('sale_price');
            });
        }elseif($sort === 'priceh2l'){
            $products = Product::with('variants')->whereIn('id', $ids)->get()->sortByDesc(function($product) {
                return $product->variants->max('sale_price');
            });
        }else{
            $products = Product::with('variants')->whereIn('id', $ids)->orderBy('id', 'asc')->get();
        }

        $html = '';
        foreach ($products as $product){
            $price = '';
            if ( $product->variants->count() > 1 ) {
                $price .= '<h6>$ '.$product->variants->min('sale_price').' - $ '.$product->variants->max('sale_price').'</h6>';
            } else {
                $price .= '<h6>$ '.$product->variants->max('sale_price').'</h6><h6 class="text-muted ml-2"><del>$ '.$product->variants->max('price').'</del></h6>';
            }   
            $html .= '
                <a class="col-lg-4 col-md-6 col-sm-12 pb-1 product-item" id="'.$product->id.'" href="/shop_detail/'.$product->slug.'">
                    <div class="card border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="'. asset('uploads/product/'.$product->image).'" alt="'.$product->name.'">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">'.$product->name.'</h6>
                            <div class="d-flex justify-content-center">
                               '.$price.'
                            </div>
                        </div>
                    </div>
                </a>';
        }

        return response()->json(['html' => $html]);
    }

    public function filter_products(Request $request)
    {
        $request->ids = preg_split ("/\,/", $request->ids);

        $ids = $request->ids;
        $colors = [];
        $sizes = [];
        $allColors = Variant::where('status', 1)->get()->groupBy('color');
        $allSizes = Variant::where('status', 1)->get()->groupBy('size');
        foreach($allColors as $color => $variants) {
            array_push($colors, $color);
        }
        foreach($allSizes as $size => $variants) {
            array_push($sizes, $size);
        }
        if(isset($request->colors)) {
            $colors = $request->colors;
        }
        if(isset($request->sizes)) {
            $sizes = $request->sizes;
        }
        $products = Product::with('variants')
        ->whereIn('id', $ids)
        ->whereIn('id', function($query) use ($sizes) {
            $query->select('product_id')
            ->from('variants')
            ->whereIn('size', $sizes);
        })
        ->whereIn('id', function($query) use ($colors) {
            $query->select('product_id')
            ->from('variants')
            ->whereIn('color', $colors);
        })
        ->whereIn('id', function($query) use ($request) {
            $query->select('product_id')
            ->from('variants')
            ->whereBetween('sale_price', [$request->minPrice, $request->maxPrice]);
        })
        ->get();

        $html = '';
        foreach($products as $product){
            $price = '';
            if ( $product->variants->count() > 1 ) {
                $price .= '<h6>$ '.$product->variants->min('sale_price').' - $ '.$product->variants->max('sale_price').'</h6>';
            } else {
                $price .= '<h6>$ '.$product->variants->max('sale_price').'</h6><h6 class="text-muted ml-2"><del>$ '.$product->variants->max('price').'</del></h6>';
            }
            $html .= '<a class="col-lg-4 col-md-6 col-sm-12 pb-1 product-item" id="'.$product->id.'" href="'.route('shop_detail', $product->slug).'">
                <div class="card border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="'.asset('uploads/product/'.$product->image).'" alt="'.$product->name.'">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">'.$product->name.'</h6>
                        <div class="d-flex justify-content-center">
                            '.$price.'
                        </div>
                    </div>
                </div>
            </a>';
        }

        return response()->json([
            'html' => $html
        ]);    
    }

    public function shop_detail($slug)
    {
        $this->data['product'] = Product::with('variants')->where('slug', $slug)->first();
        return view('shop_detail', $this->data);
    }

    public function add_to_cart(Request $request)
    {
        dd($request->all());
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

    public function checkout()
    {
        return view('checkout');
    }

    public function contact()
    {
        $this->data = Contact::all()->first();
        return view('contact', [
            'contact' => $this->data
        ]);
    }

    public function query_form(QueryRequest $request)
    {
        $validated = $request->validated();
        $query = Query::create($validated);
        return redirect('/contact')->with('success', 'Your query has been sent successfully.');   
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
