<?php

use App\Models\{HomeSlider, Category, Brand, Product, Variant};
    if(!function_exists('printName')) {
        function printName() {
            $name = 'Jason';
            return $name;
        }
    }

    if(!function_exists('getSizes')) {
        function getColors($variant) {
            $product_id = $variant->product_id;
            $colors = [];
            $variants = Variant::where([
                'product_id' => $product_id,
                'status' => 1,
                'size' => $variant->size
            ])->get();

            foreach($variants as $variant) {
                $colors[] = $variant;
            }

            return $colors;
        }
    }

    if(!function_exists('getRelatedProducts')) {
        function getRelatedProducts($id) {
            $product = Product::find($id);
            $category_id = $product->category_id;
            $related_products = Product::where([
                'category_id' => $category_id,
                'status' => 1
                
                ])->where('id', '!=', $id)->get();
            return $related_products;
        }
    }
?>