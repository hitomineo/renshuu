<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\BookController;

class Book extends Model
{
    use HasFactory;
    
    protected $books = [
    'user_id',
    'item_name',
    'item_number',
    'item_amount',
    'published',
];

}
