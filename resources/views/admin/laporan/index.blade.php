@extends('layouts.admin')

@include('components.admin')

@push('style')
@endpush

@section('content')
    <section class="section mt-3">
        <div class="row g-3"> {{-- Gunakan g-3 untuk memberi jarak antar kolom tanpa turun --}}
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Laporan Per Tanggal</h5>
                            </div>
                            <hr class="mt-4 mb-0 w-100">
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('admin.export_tanggal') }}" method="POST"
                            style="display: flex; flex-direction: column;">
                            @csrf
                            <label for="kategori-column" class="form-label">Tanggal</label>
                            <input type="date" class="form-control mb-3 flatpickr-no-config"
                                placeholder="Select date.." name="tanggal"/>
                            <button type="submit" class="btn btn-primary">
                                Export
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Laporan Range Tanggal</h5>
                            </div>
                            <hr class="mt-4 mb-0 w-100">
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('admin.export_range') }}" method="POST"
                            style="display: flex; flex-direction: column;">
                            @csrf
                            <label for="kategori-column" class="form-label">Range Tanggal</label>
                            <input type="date" class="form-control flatpickr-range mb-3" placeholder="Select date.." name="tanggal" />
                            <button type="submit" class="btn btn-primary">
                                Export
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')
        <script>
            var currentDate = new Date();
            var yesterday = new Date();
            yesterday.setDate(currentDate.getDate() - 7);

            flatpickr('.flatpickr-no-config', {
                dateFormat: "d/m/Y",
                defaultDate: currentDate
            });

            flatpickr('.flatpickr-range', {
                dateFormat: "d/m/Y",
                mode: 'range',
                defaultDate: [yesterday, currentDate]
            });
        </script>
    @endpush
@endsection
