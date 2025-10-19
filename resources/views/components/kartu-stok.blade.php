@props(['nomor_sku'])

<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-default btn-kartu-stok text-primary" data-bs-toggle="modal"
        data-bs-target="#kartuStokModal" data-nomor-sku="{{ $nomor_sku }}">
        Kartu Stok
    </button>

    <!-- Modal -->
    <div class="modal fade" id="kartuStokModal" tabindex="-1" aria-labelledby="kartuStokModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="kartuStokModalLabel">Kartu Stok</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="table-kartu-stok" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nomor Transaksi</th>
                                <th>Note</th>
                                <th>Jumlah Keluar</th>
                                <th>Jumlah Masuk</th>
                                <th>Stok Akhir</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi di sini melalui JavaScript -->
                        </tbody>
                    </table>
                    <div id="pagination-kartu-stok" class="mt-3">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {

            let currentNomorSku = null;

            function transaksiColor(value) {
                switch (value) {
                    case 'in':
                        return 'bg-success';
                    case 'out':
                        return 'bg-danger';
                    case 'adjustment':
                        return 'bg-secondary';
                    default:
                        return 'bg-warning';
                }
            }

            //#kartuStokModal
            function loadKartuStok(nomorSku) {
                const url = (typeof pageUrl !== 'undefined' && pageUrl) ? pageUrl : `/kartu-stok/${nomorSku}`;
                const $tbody = $('#table-kartu-stok tbody');
                const $pagination = $('#pagination-kartu-stok');

                $tbody.html('<tr><td colspan="8" class="text-center">Loading...</td></tr>');

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        $tbody.empty();
                        console.log(response);
                        const logger = Array.isArray(response.data) ? response.data : [];

                        if (logger.length === 0) {
                            $tbody.html(
                                '<tr><td colspan="8" class="text-center">Data log Kosong</td></tr>');
                            return;
                        }

                        logger.forEach((item, index) => {
                            const note = item.note ?? item.jenis_transaksi ?? '-';
                            const stokAkhir = item.stok_akhir ?? '-';
                            $tbody.append(`
                            <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.tanggal}</td>
                                    <td>${item.nomor_transaksi ?? '-'}</td>
                                    <td>
                                        <span class="badge rounded-pill ${transaksiColor(item.jenis_transaksi)} fw-bold text-uppercase">
                                            ${item.jenis_transaksi}
                                        </span>
                                    </td>
                                    <td>${item.jumlah_keluar ?? '-'}</td>
                                    <td>${item.jumlah_masuk ?? '-'}</td>
                                    <td>${item.stok_akhir ?? ''}</td>
                                    <td>${item.petugas ?? ''}</td>
                                </tr>
                            `);
                        });


                        // Pagination
                        if (response.meta.total > response.meta.per_page) {
                            const meta = response.meta;

                            let paginationHtml =
                                '<nav>< class="pagination justify-content-center gap-1">'
                            meta.links.forEach(link => {
                                const isNumber = /^\d+$/.test(link.label);
                                if (!isNumber) return; // skip non-numeric links

                                paginationHtml += `
                                    <li class="page-item">
                                        <a class="page-link ${link.active ? 'bg-dark text-white' : ''}" href="${link.url}">${link.label}"></a>
                                    </li>
                                    `
                            })
                            paginationHtml += '</ul></nav>';
                            $pagination.html(paginationHtml);
                        }
                    }
                });
            }


            // handler button nya
            $(document).on('click', '.btn-kartu-stok', function() {
                currentNomorSku = $(this).data('nomor-sku');
                // load kartu stok for the selected SKU when button clicked
                loadKartuStok(currentNomorSku);

            });

            // handle pagination click
            $(document).on('click', '#pagination-kartu-stok a.page-link', function(e) {
                e.preventDefault();


                const pageUrl = $(this).attr('href');
                if (pageUrl && currentNomorSku) {
                    loadKartuStok(currentNomorSku, pageUrl);
                }
            });



        });
    </script>
@endpush
