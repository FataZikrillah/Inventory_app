<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // apa saja yang boleh diisi
    protected $fillable = ['nama_produk', 'deskripsi_produk', 'kategori_produk_id'];


    //relasi ke tabel kategori produk --> jadi 1 produk itu punya 1 kategori 
    public function kategori() {
         return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }


    // relasi ke tabel varian produk --> jadi 1 produk itu punya banyak varian
    public function varian() {
        return $this->hasMany(VarianProduk::class, 'produk_id');
    }
}
