<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['kategori_buku'];

    public function bukus()
    {
        return $this->hasMany(buku::class, 'kategori_buku');
    }

    public $timestamps = false;
}
