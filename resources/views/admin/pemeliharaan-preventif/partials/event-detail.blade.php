<!-- Modal Detail Event -->
<div class="modal fade" id="event-detail" tabindex="-1" role="dialog" aria-labelledby="event-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event-title">Detail Pemeliharaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless table-sm">
                    <tbody>
                        <tr>
                            <td style="font-weight: bold; width: 30%;">Judul</td>
                            <td>:</td>
                            <td><span id="eventTitle"></span></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Aset</td>
                            <td>:</td>
                            <td><a href="#" target="_blank" id="eventAsset"></a></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Waktu</td>
                            <td>:</td>
                            <td><span id="eventTime"></span></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Bukti Dukung</td>
                            <td>:</td>
                            <td><a href="{{ url('') }}" target="_blank" id="eventAttachment"></a></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Biaya</td>
                            <td>:</td>
                            <td><span id="eventCost"></span></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Status</td>
                            <td>:</td>
                            <td><span id="eventStatus"></span></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Catatan</td>
                            <td>:</td>
                            <td><span id="eventNotes"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModalEventDetail(historyData) {
        $('#event-title').text("Detail Pemeliharaan");
        // Isi konten modal secara dinamis
        $('#eventTitle').text(historyData.title);
        $('#eventAsset').text(historyData.description || 'Tidak ada aset'); // Tampilkan aset jika ada, atau teks default jika tidak ada
        $('#eventAsset').attr('href', historyData.id_asset ? historyData.classification + '/' + historyData.id_asset + '/overview/' : '#'); // Set link aset jika ada, atau link default jika tidak ada
        $('#eventTime').text(moment(historyData.start).format('DD MMM YYYY')); // Format waktu menggunakan moment.js
        $('#eventStatus').text(historyData.status || 'Tidak ada status'); // Tampilkan status jika ada, atau teks default jika tidak ada
        $('#eventNotes').text(historyData.notes || 'Tidak ada catatan'); // Tampilkan catatan jika ada, atau teks default jika tidak ada
        $('#eventAttachment').text(historyData.attachment_link ? 'Lihat Bukti Dukung' : 'Tidak ada bukti dukung'); // Tampilkan teks link jika ada, atau teks default jika tidak ada
        $('#eventAttachment').attr('href', historyData.attachment_link || '#'); // Set link bukti dukung jika ada, atau link default jika tidak ada
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }
        $('#eventCost').text(historyData.cost ? formatRupiah(historyData.cost) : 'Tidak ada biaya'); // Tampilkan biaya jika ada, atau teks default jika tidak ada

        // Tampilkan modal event-detail
        $('#event-detail').modal('show');
    }
</script>
