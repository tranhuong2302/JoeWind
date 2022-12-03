<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\Product;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\IProductRepository;
use Illuminate\Support\Facades\DB;

class EloquentProductRepository extends EloquentBaseRepository implements IProductRepository
{

    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    public function getProductAllWithOneImages()
    {
        return DB::table('products')->join('product_images', 'product_images.product_id', '=', 'products.id')->select(DB::raw('products.*, MIN(product_images.image_path) image_path'))->groupBy('products.id')->get();
    }

    public function getCategoryIdsByProductId($productId)
    {
        return DB::table('product_categories')->select('category_id')->where('product_id', $productId)->get();
    }
}
