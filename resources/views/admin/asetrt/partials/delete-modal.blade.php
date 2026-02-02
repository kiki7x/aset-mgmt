 <div class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
     aria-hidden="true" id="deleteModal">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Konfirmasi Penghapusan!</h5>
                 <button type="button" id="btnHeaderCloseModal" class="close" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <form id="formDeleteAsetRT">
                 @csrf
                 <div class="modal-body">
                     Apakah Anda yakin ingin menghapus aset <strong id="assetName"></strong>?
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" id="btnCloseModal">Batal</button>
                     <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 @push('script-foot')
     {{-- SubmitScript --}}
     <script>
         $(document).ready(function() {
             let id;

             $('#deleteModal').on('show.bs.modal', function(event) {
                 const button = $(event.relatedTarget);
                 id = button.data('id');
             });

             $('#formDeleteAsetRT').on('submit', function(e) {
                 e.preventDefault();
                 let form = $(this);

                 $.ajax({
                     url: `{{ route('admin.asetrt.destroy', ['id' => '__ID__', 'classification' => '__CLASS__']) }}`
                         .replace('__ID__', id)
                         .replace('__CLASS__', 'rt'),
                     method: "DELETE",
                     data: form.serialize(),
                     success: function(response) {
                         $('#deleteModal').modal('hide');

                         Swal.fire({
                             icon: 'success',
                             title: 'Berhasil!',
                             text: 'Aset berhasil dihapus!',
                         })

                         $('#tableAsetrt').DataTable().ajax.reload();
                     },
                     error: function() {
                         window.dispatchEvent(new CustomEvent('alert', {
                             detail: {
                                 type: 'error',
                                 message: 'Aset gagal dihapus'
                             }
                         }));
                     }
                 });

             });
         });
     </script>

     {{-- ModalManagement --}}
     <script>
         $('#btnCloseModal, #btnHeaderCloseModal').on('click', function() {
             $('#deleteModal').modal('hide');
         });
     </script>
 @endpush
