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
                <p><strong>Judul:</strong> <span id="eventTitle"></span></p>
                <p><strong>Aset:</strong> <span id="eventAsset"></span></p>
                <p><strong>Waktu:</strong> <span id="eventTime"></span></p>
                <p><strong>Bukti Dukung:</strong> <a href="{{ url('') }}" target="_blank" id="eventAttachment"></a></p>
                <p><strong>Biaya:</strong> <span id="eventCost"></span></p>
                <p><strong>Status:</strong> <span id="eventStatus"></span></p>
                <p><strong>Catatan:</strong> <span id="eventNotes"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModalEventDetail(historyData) {
        // Isi konten modal secara dinamis
        $('#eventTitle').text(historyData.title);
        $('#eventAsset').text(historyData.description || 'Tidak ada aset'); // Tampilkan aset jika ada, atau teks default jika tidak ada
        $('#eventTime').text(moment(historyData.start).format('DD MMM YYYY')); // Format waktu menggunakan moment.js
        $('#eventStatus').text(historyData.status || 'Tidak ada status'); // Tampilkan status jika ada, atau teks default jika tidak ada
        $('#eventNotes').text(historyData.notes || 'Tidak ada catatan'); // Tampilkan catatan jika ada, atau teks default jika tidak ada
        $('#eventAttachment').text(historyData.attachment_link ? 'Lihat Bukti Dukung' : 'Tidak ada bukti dukung'); // Tampilkan teks link jika ada, atau teks default jika tidak ada
        $('#eventAttachment').attr('href', historyData.attachment_link || '#'); // Set link bukti dukung jika ada, atau link default jika tidak ada
        $('#eventCost').text(historyData.cost ? 'Rp ' + historyData.cost : 'Tidak ada biaya'); // Tampilkan biaya jika ada, atau teks default jika tidak ada

        // Tampilkan modal event-detail
        $('#event-detail').modal('show');
    }
</script>
