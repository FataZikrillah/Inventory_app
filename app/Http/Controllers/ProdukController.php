<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Requests\storeProdukRequest;
use App\Http\Requests\updateProdukRequest;

class ProdukController extends Controller
{
    //
    public $pageTitle = 'Data Produk';
    public function index()
    {
        // menyimpan dan menampilkan data 
        $pageTitle = $this->pageTitle;
        $query = Produk::query();
        $perPage = request()->query('perPage');
        $search = request()->query('search');
        // untuk relasi ke tabel kategori produk
        $query->with('kategori');


        // if pencarian data
        if ($search) {
            $query->where('nama_produk', 'like', '%' . $search . '%');
        }

        // untuk menampilkan data terbaru
        $produk = $query->orderBy('created_at', 'DESC')->paginate($perPage)->appends(request()->query());

        // confirm delete
        confirmDelete('Hapus Data Produk Dapat Di Batalakan, Apakah Anda Yakin Ingin Menghapus Data Ini?');

        return view('produk.index', compact('pageTitle', 'produk'));
    }


    // method store
    // Untuk Menambahkan produk
    public function store(storeProdukRequest $request)
    {
        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'kategori_produk_id' => $request->kategori_produk_id,
        ]);
        toast()->success('Berhasil Menambahkan Produk Baru');
        return redirect()->route('master-data.produk.show', $produk->id);
    }

    // 
    public function show(Produk $produk) {
        $pageTitle = 'Detail Produk';
        return view('produk.show', compact('produk', 'pageTitle'));
    }

    // Untuk menghapus data produk
    public function destroy(Produk $produk)
    {
        $produk->delete();
        toast()->success('Berhasil menghapus kategori produk');
        return redirect()->route('master-data.produk.index');
    }


    // untuk update data produk
    public function update(updateProdukRequest $request, Produk $produk)
    {
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'kategori_produk_id' => $request->kategori_produk_id,
        ]);

        toast()->success('Berhasil mengupdate data produk');
        return redirect()->route('master-data.produk.index');
    }
}
