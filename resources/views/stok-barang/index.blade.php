@extends('layouts.kai')

@section('title', $pageTitle)

@section('content')

    <div class="card">
        <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
        <div class="card-body py-5">
            <div class="row align-items-center">
                <div class="row col-9 justify-content-between" >
                    <div class="col-2">
                        <x-per-page-option/>
                    </div>
                    <div class="col-7">
                        <x-filter-by-field term="search" placeholder="Cari berdasarkan SKU, Produk, Kategori" />
                    </div>
                    <div class="col-3">
                        <x-filter-by-options term="kategori" :options="$kategori" field="nama_kategori"  defaultValue="Kategori"/>
                    </div>
                </div>
                <div class="col-2">
                    
                </div>
                <div class="col-1">
                    <x-button-reset-filter route="master-data.stok-barang.index"/>
                </div>
            </div>
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15px">No</th>
                        <th>SKU</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Kartu Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item['nomor_sku'] }}</td>
                            <td>{{ $item['produk'] }}</td>
                            <td>{{ $item['kategori'] }}</td>
                            <td>{{ number_format($item['stok']) }}</td>
                            <td>Rp. {{ number_format($item['harga']) }}</td>
                            <td>
                                <x-kartu-stok nomor_sku="{{ $item['nomor_sku'] }}"/>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
