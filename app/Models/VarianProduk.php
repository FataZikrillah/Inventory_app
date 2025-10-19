<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarianProduk extends Model
{
    //
    protected $fillable = [
        'produk_id',
        'nomor_sku',
        'nama_varian',
        'harga_varian',
        'stok_varian',
        'gambar_varian',
    ];

    public static function generateNoSku() {
        $maxId = self::max('id');
        $prefix = 'SKU';
        $nomorSku = $prefix . str_pad($maxId + 1, 6, '0', STR_PAD_LEFT);
        return $nomorSku;
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
