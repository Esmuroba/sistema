<!-- Request Conditions Modal -->
<div class="modal fade" id="import-excel" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary" id="modalToggleLabel">Importar Pagos Masivos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <div class="row">
                    <div class="col-lg">
                        <form action="{{ route('admin.importExcel') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Pagos Masivos</label>
                                <input class="form-control{{--  @error('import_file') is-invalid @enderror --}} import" name="import_file"
                                    type="file" id="importFile" accept=".xls, .xlsx">
                            </div>
                            <button type="submit" class="btn btn-primary" id="importButton" disabled>
                                Importar
                                <i class='bx bx-check-circle'></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let file = $('#importFile');
        let importBtn = $('#importButton');

        $('.import').on('input', function() {
            if (file.val().length > 0) {
                importBtn.attr('disabled', false);

            } else {
                importBtn.attr('disabled', true);

            }
        });
    });
</script>
