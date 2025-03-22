@if ($restore)
    <form method="POST" action="{{ $action }}" class="d-inline">
        @csrf

        <button type="button" class="btn btn-success" data-bs-toggle="modal"
            data-bs-target="#confirmModal-{{ $id }}-2">
            <i class="bi bi-arrow-counterclockwise"></i>
        </button>

        <div class="modal fade" id="confirmModal-{{ $id }}-2" tabindex="-1"
            aria-labelledby="confirmModalLabel-{{ $id }}-2" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-sm rounded-3">
                    <div class="modal-header bg-success rounded-top-3">
                        <h5 class="modal-title text-light mb-2" id="confirmModalLabel-{{ $id }}-2">
                            {{ $title ?? 'Konfirmasi Hapus' }}</h5>
                    </div>
                    <div class="modal-body text-center">
                        <i class="bi bi-exclamation-triangle-fill warning-icon text-warning display-4"></i>
                        <p class="mt-3 mb-0">Apakah Anda yakin ingin merestore item ini?<br> Tindakan ini tidak dapat
                            dibatalkan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Restore
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@else
    <form method="POST" action="{{ $action }}" class="d-inline">
        @csrf
        @method('DELETE')

        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
            data-bs-target="#confirmModal-{{ $id }}">
            <i class="bi bi-trash-fill"></i>
        </button>

        <div class="modal fade" id="confirmModal-{{ $id }}" tabindex="-1"
            aria-labelledby="confirmModalLabel-{{ $id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-sm rounded-3">
                    <div class="modal-header bg-danger rounded-top-3">
                        <h5 class="modal-title text-light mb-2" id="confirmModalLabel-{{ $id }}">
                            {{ $title ?? 'Konfirmasi Hapus' }}</h5>
                    </div>
                    <div class="modal-body text-center">
                        <i class="bi bi-exclamation-triangle-fill warning-icon text-warning display-4"></i>
                        <p class="mt-3 mb-0">Apakah Anda yakin ingin menghapus item ini?<br> Tindakan ini tidak dapat
                            dibatalkan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash-fill me-2"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
