<div class="card">
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <div class="card-body">
        <img src="{{ asset('storage/varian-produk/' . $varian->gambar_varian) }}" alt="{{ $varian->gambar_varian }}"
            class="img-fluid mb-2" style="max-height: 300px; object-fit: cover; width: 100%; height: 100%;">
        <h5 class="card-title">
            {{ $varian->nama_varian }}
        </h5>
        <x-meta-item label="Nomor Sku" value="{{ $varian->nomor_sku }}" />
        <x-meta-item label="Harga" value="Rp. {{ number_format($varian->harga_varian) }}" />
        <x-meta-item label="Stok" value="{{ number_format($varian->stok_varian) }} pcs" />
    </div>
    <div class="card-footer d-flex justify-content-between aligm-items-center gap-1">
        <div class="w-100">
            <button type="button" class="btn btn-outline-dark btn-sm btnEditVarian" data-id="{{ $varian->id }}" data-nama-varian="{{ $varian->nama_varian }}" data-harga-varian="{{ $varian->harga_varian }}" data-stok-varian="{{ $varian->stok_varian }}" data-action="{{ route('master-data.varian-produk.update', $varian->id) }}">
                Edit
            </button>
        </div>
        <form action="{{ route('master-data.varian-produk.destroy', $varian->id) }}" method="POST" class="formDeleteVarian">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
        </form>
    </div>
</div>
