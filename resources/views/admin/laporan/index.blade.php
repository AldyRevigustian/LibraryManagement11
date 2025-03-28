@extends('layouts.admin')

@include('components.admin')

@push('style')
@endpush

@section('content')
    <section class="section mt-3">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                    <div class="d-flex flex-column w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Export All</h5>
                        </div>
                        <hr class="mt-4 mb-0 w-100">
                    </div>
                </div>
                <div class="card-body mt-3">
                    <form action="{{ route('admin.export_all') }}" method="POST"
                        style="display: flex; flex-direction: column;">
                        @csrf
                        <label for="kategori-column" class="form-label">Tanggal Peminjaman & Pengembalian</label>
                        <input type="date" class="form-control flatpickr-range mb-3" placeholder="Select date.."
                            name="tanggal" />
                        <button type="submit" class="btn btn-primary">
                            Export
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Laporan Peminjaman</h5>
                            </div>
                            <hr class="mt-4 mb-0 w-100">
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('admin.export_peminjaman') }}" method="POST"
                            style="display: flex; flex-direction: column;">
                            @csrf
                            <label for="kategori-column" class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control flatpickr-range mb-3" placeholder="Select date.."
                                name="tanggal" />
                            <button type="submit" class="btn btn-primary">
                                Export
                            </button>
                        </form>
                        <hr>
                        <small class="text-muted d-block text-start mb-0 pb-0">* Hanya mengekspor peminjaman yang belum
                            dikembalikan.</small>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Laporan Pengembalian</h5>
                            </div>
                            <hr class="mt-4 mb-0 w-100">
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('admin.export_pengembalian') }}" method="POST"
                            style="display: flex; flex-direction: column;">
                            @csrf
                            <label for="kategori-column" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control flatpickr-range mb-3" placeholder="Select date.."
                                name="tanggal" />
                            <button type="submit" class="btn btn-primary">
                                Export
                            </button>
                        </form>
                        <hr>
                        <small class="text-muted d-block text-start mb-0 pb-0">* Hanya mengekspor peminjaman yang sudah
                            dikembalikan.</small>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @push('script')
        <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

        <script>
            var currentDate = new Date();
            var yesterday = new Date();
            yesterday.setDate(currentDate.getDate() - 7);

            flatpickr('.flatpickr-range', {
                dateFormat: "d F Y",
                mode: 'range',
                defaultDate: [yesterday, currentDate],
                locale: "id",
                rangeSeparator: " - "
            });
        </script>
    @endpush
@endsection
