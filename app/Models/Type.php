<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    // Definisikan relasi dengan transaksi
    public function category()
    {
        return $this->hasMany(Category::class);
    }
}
