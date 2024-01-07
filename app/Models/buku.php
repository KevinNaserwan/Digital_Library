<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    use HasFactory;
    protected $table = 'buku';

    protected $fillable = ['id', 'judul_buku', 'kategori_buku', 'jumlah', 'deskripsi', 'file_buku', 'cover_buku', 'uploaded_by'];

    public $timestamps = false;
}
