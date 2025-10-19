<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\VarianProduk;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    //
    public $pageTitle = "Stok Barang";
    public function index()
    {
        // menyimpan dan menampilkan data
        $pageTitle = $this->pageTitle;
        $kategori = KategoriProduk::all();
        $perPage = request()->get('perPage');
        $search = request()->get('search');
        $rKategori = request()->get('kategori');

        // filter data stok barang
        $query = VarianProduk::query();
        $query->with('produk', 'produk.kategori');

        // jika ada kata kunci pencarian maka filter akan mencari berdasarkan nama varian, nomor sku, atau nama produk
        if ($search) {
            $query->where('nama_varian', 'like', '%' . $search . '%')
                ->orWhere('nomor_sku', 'like', '%' . $search . '%')
                ->orWhereHas('produk', function ($query) use ($search) {
                    $query->where('nama_produk', 'like', '%' . $search . '%');
                });
        }

        // jika ada kategori yang dipilih maka filter akan mencairi berdasarkan kategori tersebut
        if ($rKategori) {
            $query->whereHas('produk.kategori', function ($query) use ($rKategori) {
                $query->where('id', $rKategori);
            });
        }

        // menampilkan data dengan pagination
        $paginator = $query->paginate($perPage ?? 10)->appends(request()->query());
        $produk = $paginator->getCollection()->map(function ($q) {
            return [
                'varian_id' => $q->id,
                'nomor_sku' => $q->nomor_sku,
                'kategori' => $q->produk->kategori->nama_kategori,
                'produk' => $q->produk->nama_produk . " - " . $q->nama_varian,
                'stok' => $q->stok_varian,
                'harga' => $q->harga_varian,
            ];
        });

        // untuk menampilkan data terbaru di halaman pertama
        $paginator->setCollection($produk);
        $produk = $paginator;


        return view('stok-barang.index', compact('pageTitle', 'produk', 'kategori'));
    }
}
