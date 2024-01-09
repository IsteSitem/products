<?php

namespace IsteSitem\Products\Http\Controllers;

use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use IsteSitem\Products\Product;

class ProductController extends VoyagerBaseController
{
    protected $viewPath = 'istesitem-products';

    /**
     * Route: Gets all products and passes data to a view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProducts()
    {
        $products = Product::published()->latest()->paginate(12);

        return view("{$this->viewPath}::modules/products/products", [
            'products' => $products,
        ]);
    }

    /**
     * Route: Gets a single product and passes data to a view
     *
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProduct(Product $slug)
    {
        $product = Product::where('slug', $slug)->published()->firstOrFail();
        $relatedProducts = Product::where('id', '!=', $product->id)->published()->limit(6)->latest()->get();

        return view("{$this->viewPath}::modules/products/product", [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
