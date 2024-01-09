<?php

namespace IsteSitem\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Traits\Translatable;
use IsteSitem\Products\Product;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use Translatable;

    protected $table = 'product_categories';
    protected $guarded = [];
    protected $translatable = ['title', 'slug', 'content', 'meta_description', 'meta_keywords'];

    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->author_id && Auth::user()) {
            $this->author_id = Auth::user()->id;
        }

        if (!$this->slug) {
            $this->slug = Str::slug($this->title);
        }

        parent::save();
    }

    public function products()
    {
        return $this->hasMany(Product::class)->published()->latest();
    }

    public function parentId()
    {
        return $this->belongsTo(self::class);
    }
}
