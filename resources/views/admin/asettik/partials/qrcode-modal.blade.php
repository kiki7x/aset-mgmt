<div class="modal fade" data-backdrop="static" tabindex="-1" id="qrCodeModal" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="qrCodeModalLabel">QR Code Aset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="qrCodeContainer">
                <div id="qrCodeName" class="d-flex justify-content-center mb-2"></div>
                <div id="qrcode" class="d-flex justify-content-center"></div>
                <p class="mt-2" id="qrTagLabel"></p>
                <p><u>sapa.ppl.ac.id</u></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnPrintQrCode" class="btn btn-primary">Print</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('script-foot')
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            function showQrCodeModal(tag, name) {
                let qrCodeInstance;
                $('#qrCodeModal').modal('show');
                document.getElementById('qrCodeName').innerText = name;
                document.getElementById('qrTagLabel').innerText = tag;

                // Reset qrcode div
                document.getElementById('qrcode').innerHTML = '';

                // Generate QR code
                qrCodeInstance = new QRCode(document.getElementById('qrcode'), {
                    text: tag,
                    width: 200,
                    height: 200,
                });
            }

            function printQrCode() {
                const qrCodeName = document.getElementById('qrCodeName').innerHTML;
                const qrcode = document.getElementById('qrcode').innerHTML;
                const qrTagLabel = document.getElementById('qrTagLabel').innerHTML;

                const printWindow = window.open('', '', 'width=800,height=800');
                printWindow.document.write(
                    `<html>
                    <head>
                        <title>Cetak QR Aset</title>
                        <style>
                            body {
                            display: flex; /* Menggunakan flexbox untuk tata letak */
                            flex-direction: column;
                            justify-content: center; /* Pusatkan vertikal */
                            align-items: center; /* Pusatkan horizontal */
                            min-height: 100vh; /* Pastikan body setinggi viewport */
                            margin: 0; /* Hilangkan margin default body */
                            }
                            .asset-name {
                                max-width: 250px;
                                word-wrap: break-word;
                                text-align: center;
                            }
                            .homelink {
                                text-decoration: underline;
                                margin-top: 5px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="asset-name">${qrCodeName}</div>
                        <br>
                        ${qrcode}
                        <br>
                        ${qrTagLabel}
                        <br>
                        <div class="homelink">sapa.ppl.ac.id</div>
                    </body>
                    </html>`
                );
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }

            $(document).on('click', '[data-toggle="modal"][data-target="#qrCodeModal"]', function() {
                const tag = $(this).data('tag');
                const name = $(this).data('name');
                showQrCodeModal(tag, name);
            });

            $("#btnPrintQrCode").on('click', function() {
                printQrCode();
            })
        })
    </script>
@endpush
