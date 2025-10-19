<div>
    <!-- Modal -->
    <div class="modal fade" id="modalFormVarian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalFormVarianLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk_id ?? ''}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalFormVarianLabel">Form Varian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_varian" class="form-label">Nama Varian</label>
                            <input type="text" class="form-control" name="nama_varian" id="nama_varian" value="{{ old('nama_varian', $nama_varian ?? '') }}">
                            <small class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="harga_varian" class="form-label">Harga Varian</label>
                            <input type="number" class="form-control" name="harga_varian" id="harga_varian" value="{{ old('harga_varian', $harga_varian ?? '') }}">
                            <small class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="stok_varian" class="form-label">Stok Varian</label>
                            <input type="number" class="form-control" name="stok_varian" id="stok_varian" value="{{ old('stok_varian', $stok_varian ?? '') }}">
                            <small class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="gambar_varian" class="form-label">Uplaod Gambar Varian</label>
                            <input type="file" class="form-control" name="gambar_varian" id="gambar_varian">
                            <small class="text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
