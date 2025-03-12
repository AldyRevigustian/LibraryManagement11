@extends('layouts.admin')

@include('components.admin')

@push('style')
@endpush

@section('content')
    <section class="section mt-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add Peminjaman</h5>
                    </div>
                    <hr class="mt-4 mb w-100">
                </div>
            </div>

            @include('components.message')
            <div class="card-body">
                <form class="form" action="{{ route('admin.peminjaman_store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                <input type="date"
                                    class="form-control flatpickr-no-config @error('tanggal_peminjaman') is-invalid @enderror"
                                    id="tanggal_peminjaman" placeholder="Tanggal Peminjaman" name="tanggal_peminjaman"
                                    required />
                                @error('tanggal_peminjaman')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="tanggal_pengembalian" class="form-label">Maksimal Tanggal Pengembalian</label>
                                <input type="date"
                                    class="form-control flatpickr-pengembalian @error('tanggal_pengembalian') is-invalid @enderror"
                                    id="tanggal_pengembalian" placeholder="Tanggal Peminjaman" name="tanggal_pengembalian"
                                    required />
                                <p class="mb-0"><small class="text-muted">Maksimal Tanggal Pengembalian Sebelum Di Denda</small></p>
                                @error('tanggal_pengembalian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group mandatory">
                                <label for="peminjam-column" class="form-label">Peminjam</label>
                                <select name="peminjam_id" class="choices form-select">
                                    <option value="" disabled selected>
                                        --Pilih Peminjam--</option>
                                    @foreach ($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->nim . ' | ' . $anggota->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group mandatory">
                                <label for="buku-column" class="form-label">Buku</label>
                                <select name="buku_id" class="choices form-select">
                                    <option value="" disabled selected>
                                        --Pilih Buku--</option>
                                    @foreach ($bukus as $buku)
                                        <option value="{{ $buku->id }}">{{ $buku->ISBN . ' | ' . $buku->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="deskripsi_fisik-column" class="form-label">Deskripsi Fisik</label>
                                <input type="text" id="deskripsi_fisik-column"
                                    class="form-control @error('deskripsi_fisik') is-invalid @enderror"
                                    placeholder="Deskripsi Fisik" name="deskripsi_fisik"
                                    value="{{ old('deskripsi_fisik') }}" required autocomplete="deskripsi_fisik">
                                @error('deskripsi_fisik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary me-1 mb-1">
                                    Submit
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </section>

    @push('script')
    <script>
            var currentDate = new Date();
            var mingdep = new Date();
            mingdep.setDate(currentDate.getDate() + {{ $rule->batas_pengembalian }});

            flatpickr('.flatpickr-no-config', {
                dateFormat: "d/m/Y",
                defaultDate: currentDate
            });

            flatpickr('.flatpickr-pengembalian', {
                dateFormat: "d/m/Y",
                defaultDate: mingdep
            });

            flatpickr('.flatpickr-range', {
                dateFormat: "d/m/Y",
                mode: 'range',
                defaultDate: [yesterday, currentDate]
            });
        </script>
    @endpush
@endsection
