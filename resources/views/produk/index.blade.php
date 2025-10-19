@extends('layouts.kai')
@section('title', $pageTitle)

@section('content')
    <div class="card">
        <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
        <div class="card-body py-5">
            <div class="row align-items-center">
                {{-- filter --}}
                <div class="row col-10 align-items-center justify-content-between">
                    <div class="col-2">
                        <x-per-page-option />
                    </div>
                    <div class="col-8">
                        <x-filter-by-field term="search" placeholder="Cari Produk..."/>
                    </div>
                    <div class="col-2">
                        <x-button-reset-filter route="master-data.produk.index"/>
                    </div>
                </div>
                {{-- filter --}}

                {{-- form --}}
                <div class="col-2 d-flex justify-content-end">
                    <x-produk.form-produk />
                </div>
                {{-- form --}}

            </div>

            <table class="table mt-2">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15px">No</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>deskripsi</th>
                        <th class="text-center" style="width: 100px">opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><a href="{{ route('master-data.produk.show', $item->id) }}" class="text-decoration-none">{{ $item->nama_produk }}</a></td>
                            <td>{{ $item->kategori->nama_kategori }}</td>
                            <td>{{ $item->deskripsi_produk }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <x-produk.form-produk id="{{ $item->id }}" />
                                    <x-confirm-delete id="{{ $item->id }}" route="master-data.produk.destroy" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="4">Data Produk Belum Ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $produk->links() }}
        </div>
    </div>
@endsection
