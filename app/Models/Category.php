<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function tree()
    {
        $allCategories = Category::all();

        $rootCategories = $allCategories->where('parent_id', 0);

        self::formatTree($rootCategories, $allCategories);

        return $rootCategories;
    }

    private static function formatTree($rootCategories, $allCategories)
    {
        foreach ($rootCategories as $category) {

            $category->children = $allCategories->where('parent_id', $category->id)->values();

            if ($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allCategories);
            }
        }
    }

    public function getProductsByCategory(){
        return $this->belongsToMany(Product::class, 'product_categories', 'product_id' );
    }
}
