<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = ['name','description','price','image', 'category_id','stock','user_id'];

   public function category()
{
    return $this->belongsTo(Category::class);
}

public function images()
{
    return $this->hasMany(ProductImage::class);
}

/**favoritar**/
public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'favorites');
}

//reviews
public function reviews()
{
    return $this->hasMany(Review::class);
}

//rating media
public function averageRating()
{
    return $this->reviews()->avg('rating') ?? 0;
}

public function user()
{
    return $this->belongsTo(User::class);
}


}
