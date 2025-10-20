@extends('layouts.kai')

@section('title', $pageTitle)

@section('content')
    <div class="card">
        <!-- The only way to do great work is to love what you do. - Steve Jobs -->
        <div class="card-body">
            <form action="" id="form-add-produk" class="row col-12 justify-content-between">
                <div id="alert-danger" class="alert alert-danger"></div>
                <div class="row">
                    <div class="form-group w-25">
                        <label for="pengirim" class="form-label">Pengirim</label>
                        <input type="text" class="form-control" name="pengirim" id="pengirim">
                    </div>
                    <div class="form-group w-25">
                        <label for="kontak" class="form-label">kontak</label>
                        <input type="text" class="form-control" name="kontak" id="kontak">
                    </div>
                    <div class="form-group w-25">
                        <label for="keterangan" class="form-label">keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-4">
                        <select id="select-produk" class="form-control border py-3"></select>
                    </div>
                    <div class="col-2">
                        <input type="text" name="nomor_batch" id="nomor_batch" class="form-control"
                            placeholder="Nomor Batch">
                    </div>
                    <div class="col-2">
                        <input type="number" name="qty" id="qty" class="form-control" placeholder="Qty">
                    </div>
                    <div class="col-2">
                        <input type="number" name="harga" id="harga" class="form-control" placeholder="Harga">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-dark btn-round w-100" id="btn-add">Tambahkan</button>
                    </div>
                </div>
            </form>
            <table id="table-produk" class="table mt-5">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15px">NO</th>
                        <th>Produk</th>
                        <th>Batch</th>
                        <th>Qty</th>
                        <th>harga</th>
                        <th>Sub Total</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" class=" text-end">Grand Total</th>
                        <th id="grand-total">0</th>
                    </tr>
                    <tr>
                        <th class="text-end" colspan="7">
                            <form action="" id="form-transaksi">
                                <button type="submit" class="btn btn-primary btn-round">Simpan Transaksi</button>
                            </form>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            //sembunyikan alert
            $('#alert-danger').hide();

            //
            const numberFormat = new Intl.NumberFormat('id-ID');
            // currently selected option from select2
            let selectedOption = null;
            let selectedProduk = [];

            //
            $('#select-produk').select2({
                placeholder: 'Pilih Produk',
                delay: 250,
                allowClear: true,
                theme: 'bootstrap-5',
                ajax: {
                    url: '{{ route('get-data.varian-produk') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        let query = {
                            search: params.term,
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: data.map((item) => {
                                return {
                                    id: item.id,
                                    text: item.text,
                                    nomor_sku: item.nomor_sku,
                                }
                            })
                        }
                    }
                }
            })


            //
            $("#select-produk").on('select2:select', function(e) {
                // console.log(e.params.data);
                let data = e.params.data;
                selectedOption = data;
            });




            //
            $("#form-add-produk").on("submit", function(e) {
                e.preventDefault();

                //
                let qty = parseInt($("#qty").val());
                let harga = parseInt($("#harga").val());
                let nomor_batch = $("#nomor_batch").val();

                if (!selectedOption || !selectedOption.id || isNaN(qty) || isNaN(harga) || !nomor_batch) {
                    swal({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Input Data Belum Lengkap',
                        timer: 3000,
                        buttons: false,
                    })
                    return;
                }


                //
                if (qty < 1 || harga < 1) {
                    swal({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Qty Dan Harga Tidak Boleh Kurang Dari 1',
                        timer: 3000,
                        buttons: false,
                    })
                    return;
                }


                //
                let subTotal = qty * harga;

                //
                let existingItem = selectedProduk.find(item => item.nomor_sku === selectedOption.nomor_sku);
                if (existingItem) {
                    existingItem.qty = parseInt(existingItem.qty) + parseInt(qty);
                    existingItem.harga = parseInt(harga);
                    existingItem.subTotal = existingItem.qty * existingItem.harga;
                } else {
                    selectedProduk.push({
                        text: selectedOption.text,
                        nomor_sku: selectedOption.nomor_sku,
                        qty: qty,
                        harga: harga,
                        nomor_batch: nomor_batch,
                        subTotal: subTotal,
                    })
                }

                $('#select-produk').val(null).trigger('change');
                $('#qty').val('');
                $('#harga').val('');
                $('#nomor_batch').val('');
                renderTable();
            });

            //
            function renderTable() {
                let tableBody = $('#table-produk tbody');
                tableBody.empty();

                selectedProduk.forEach((item, index) => {
                    let row = `<tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${item.text} <br> <small class="text-muted">${item.nomor_sku}</small></td>
                        <td>${item.nomor_batch}</td>
                        <td>${item.qty}</td>
                        <td>Rp ${numberFormat.format(item.harga)}</td>
                        <td>Rp ${numberFormat.format(item.subTotal)}</td>
                        <td>
                            <button class="btn btn-sm btn-danger btn-round btn-icon btn-hapus" data-nomor-sku="${item.nomor_sku}" type="button" value=""><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                    tableBody.append(row);
                })

                //
                // delete handler is attached outside renderTable to avoid multiple bindings
                // (handler moved below)

                //
                if (selectedProduk.length === 0) {
                    tableBody.append(`
                        <tr>
                            <td colspan="7" class="text-center">Belum ada produk yang ditambahkan</td>
                        </tr>
                    `);
                }


                //
                let grandTotal = selectedProduk.reduce((total, item) => total + item.subTotal, 0);
                $('#grand-total').text('Rp ' + numberFormat.format(grandTotal));

            }

            // attach delete handler once (use $(this) inside handler)
            $(document).on("click", ".btn-hapus", function () {
                let nomorSku = $(this).data('nomor-sku');
                selectedProduk = selectedProduk.filter(item => item.nomor_sku !== nomorSku);
                renderTable();
            });

            // initial render
            renderTable();


        });
    </script>
@endpush
