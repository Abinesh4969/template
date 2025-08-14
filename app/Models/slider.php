<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class slider extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $table = 'sliders';

    protected $fillable = [
        // 'title',
        // 'color',
        // 'background_image',
        // 'description',
        'category_id',
        'active',
        'created_at',
        'created_by',
        'updated_by',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    

}
