<?php

namespace App\Http\Controllers;

use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\storeVarianProdukRequest;
use App\Http\Requests\updateVarianProdukRequest;
use App\Models\KartuStok;
use Illuminate\Support\Facades\Auth;

class VarianProdukController extends Controller
{
    //
    public function store(storeVarianProdukRequest $request)
    {
        $fileName = time() . '.' . $request->file('gambar_varian')->getClientOriginalExtension();
        // store the uploaded file into the public disk under varian-produk with the desired filename
        Storage::disk('public')->putFileAs('varian-produk', $request->file('gambar_varian'), $fileName);
        // alternatively: $request->file('gambar_varian')->storeAs('varian-produk', $fileName, 'public');
        VarianProduk::create([
            'produk_id' => $request->produk_id,
            'nomor_sku' => VarianProduk::generateNoSku(),
            'nama_varian' => $request->nama_varian,
            'harga_varian' => $request->harga_varian,
            'stok_varian' => $request->stok_varian,
            'gambar_varian' => $fileName,
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan varian produk'
        ]);

        // toast()->success('Berhasil menambahkan varian produk');
        // return redirect()->route('master-data.produk.show', $request->produk_id);
    }

    public function update(updateVarianProdukRequest $request, $varian_produk) {

        $isAdjusment = false;
        $varian = VarianProduk::findOrFail($varian_produk);
        
        if ($request->stok_varian != $varian->stok_varian) {
            $isAdjusment = true;
        }
        
        $fileName = $varian->gambar_varian;

        // 
        if ($request->file('gambar_varian')) {
            Storage::disk('public')->delete('varian-produk/' . $fileName);
            $fileName = time() . '.' . $request->file('gambar_varian')->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('varian-produk', $request->file('gambar_varian'), $fileName);
            // $request->file('gambar_varian')->storeAs('varian-produk', $fileName, 'public');
        }

        $varian->update([
            'nama_varian' => $request->nama_varian,
            'harga_varian' => $request->harga_varian,
            'stok_varian' => $request->stok_varian,
            'gambar_varian' => $fileName,
        ]);

        if ($isAdjusment) {
            KartuStok::create([
                'jenis_transaksi' => 'adjustment',
                'nomor_sku' => $varian->nomor_sku,
                'stok_akhir' => $varian->stok_varian,
                'petugas' => Auth::user()->name,
            ]);
        }

        return response()->json([
            'message' => 'Berhasil mengupdate varian produk'
        ]);
    }

    public function destroy($varian_produk) {
        $varian = VarianProduk::findOrFail($varian_produk);
        Storage::disk('public')->delete('varian-produk/' . $varian->gambar_varian);
        $varian->delete();
        toast()->success('Berhasil menghapus varian produk');
        return redirect()->route('master-data.produk.show', $varian->produk_id);
    }
}
