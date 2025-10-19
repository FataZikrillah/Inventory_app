<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeKategoriProdukRequest;
use App\Http\Requests\updateKategoriProdukRequest;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class KategoriProdukController extends Controller
{
    public $pageTitle = 'Kategori Produk';
    //index
    public function index() {
        $pageTitle = $this->pageTitle;
        $perPage = request()->query('perPage');
        $search = request()->query('search');
        $query = KategoriProduk::query();
        
        if ($search) {
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        }


        $kategori = $query->paginate($perPage)->appends(request()->query());
        confirmDelete('Hapus Data Kategori Produk Dapat Di Batalakan, Apakah Anda Yakin Ingin Menghapus Data Ini?');

        return view('kategori-produk.index' , compact('pageTitle', 'kategori'));
    }

    // Store
    public function store(storeKategoriProdukRequest $request) {
        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        toast()->success('Berhasil menambahkan kategori produk');
        return redirect()->route('master-data.kategori-produk.index');
    }


    public function update(updateKategoriProdukRequest $request, KategoriProduk $kategoriProduk) {
        $kategoriProduk->nama_kategori = $request->nama_kategori;
        $kategoriProduk->save();
        toast()->success('Berhasil mengupdate kategori produk');
        return redirect()->route('master-data.kategori-produk.index');
    }


    public function destroy(KategoriProduk $kategoriProduk) {
        $kategoriProduk->delete();
        toast()->success('Berhasil menghapus kategori produk');
        return redirect()->route('master-data.kategori-produk.index');
    }


    

}
