<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryRelation extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $table = "CategoryRelation";
    protected $fillable = [
        'categoryId',
        'uploadId',
        'userId',
        'orderShow',
        'status',
    ];
}
