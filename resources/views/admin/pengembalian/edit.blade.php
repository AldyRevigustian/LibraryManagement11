@extends('layouts.admin')

@include('components.admin')

@push('style')
    <style>
        .disabled .choices,
        .disabled .choices__inner,
        .disabled .choices__list,
        .disabled .choices__list--single,
        .disabled .choices__list--dropdown {
            background-color: #e9ecef !important;
            pointer-events: none;
            cursor: not-allowed;
        }

        .disabled .choices__item,
        .disabled .choices__button,
        .disabled .choices__input {
            pointer-events: none;
            cursor: not-allowed;
        }

        .disabled .choices__list--single .choices__item {
            color: #6c757d;
        }

        .disabled .choices__input {
            background-color: #e9ecef !important;
        }

        .disabled .choices__list--dropdown {
            background-color: #e9ecef !important;
        }

        /* Styling for disabled date inputs */
        input[type="date"]:disabled,
        .flatpickr-input[disabled] {
            background-color: #e9ecef !important;
            opacity: 0.65;
            pointer-events: none;
            cursor: not-allowed;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
    <section class="section mt-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pengembalian Buku</h5>
                    </div>
                    <hr class="mt-4 mb w-100">
                </div>
            </div>

            @include('components.message')
            <div class="card-body">
                <form class="form" action="{{ route('admin.pengembalian_update', $peminjaman->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="peminjaman_id" id="peminjaman_id">
                    <div class="row">
                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="nim-column" class="form-label">NIM Peminjam</label>
                                <input type="text" class="form-control" id="nim-column" placeholder="NIM Peminjam"
                                    value="{{ $peminjaman->anggota->nim }}" disabled />
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="nama-column" class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control" id="nama-column" placeholder="Nama Peminjam"
                                    value="{{ $peminjaman->anggota->nama }}" disabled />
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="ISBN-column" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="isbn-column" placeholder="ISBN"
                                    value="{{ $peminjaman->buku->ISBN }}" disabled />
                            </div>
                        </div>

                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="buku-column" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" id="judul-column" placeholder="Judul Buku"
                                    value="{{ $peminjaman->buku->judul }}" disabled />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                <input type="text" class="form-control" id="tanggal_peminjaman"
                                    placeholder="Tanggal Peminjaman" value="{{ $tanggal_peminjaman }}" disabled />
                                <input type="text" class="form-control d-none" id="batas_pengembalian"
                                    placeholder="Tanggal Peminjaman" value="{{ $batas_pengembalian }}" disabled />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                                <input type="date"
                                    class="form-control flatpickr-pengembalian @error('tanggal_pengembalian') is-invalid @enderror"
                                    id="tanggal_pengembalian" placeholder="Tanggal Pengembalian" name="tanggal_pengembalian"
                                    required />
                                <p class="mb-0"><small class="text-muted">Maksimal Pengembalian Sebelum Di Denda</small>
                                </p>
                                @error('tanggal_pengembalian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div id="info-peminjaman" class="alert alert-primary">
                                Batas Pengembalian : <strong>{{ $batas_pengembalian }}</strong> <br>
                                Denda : <strong id="jumlah-peminjaman"> - </strong>
                            </div>
                        </div>
                        <div class="row mt-2">
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
            document.addEventListener('DOMContentLoaded', function() {
                calculateDenda(preselectedTanggalPeminjaman);
            });

            const batasHari = @json(App\Models\Aturan::first()->batas_hari ?? 7);
            const dendaInfo = document.getElementById('info-peminjaman');
            const jumlahDendaText = document.getElementById('jumlah-peminjaman');

            const tanggalPeminjamanInput = document.getElementById('tanggal_peminjaman');
            const batasPengembalian = document.getElementById('batas_pengembalian');

            const preselectedTanggalPeminjaman =
                "{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('Y-m-d') }}";

            var pengembalianPicker = flatpickr('#tanggal_pengembalian', {
                dateFormat: "Y-m-d",
                defaultDate: preselectedTanggalPeminjaman,
                onChange: function(selectedDates, dateStr, instance) {
                    calculateDenda(dateStr);
                }
            });

            function calculateDenda(tanggalPengembalianValue) {
                let borrowDate = new Date(tanggalPeminjamanInput.value);
                let batasDate = new Date(batasPengembalian.value);

                const batasPengembalianFormatted = batasDate.toISOString().split('T')[0];
                console.log(batasPengembalianFormatted);

                fetch('/calculate-denda', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            batas_pengembalian: batasPengembalianFormatted,
                            tanggal_pengembalian: tanggalPengembalianValue
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.isLate) {
                            dendaInfo.className = 'alert alert-danger';
                            jumlahDendaText.textContent =
                                `Rp. ${data.denda.toLocaleString('id-ID')} (Terlambat ${data.hariTerlambat} hari)`;
                        } else {
                            dendaInfo.className = 'alert alert-success';
                            jumlahDendaText.textContent = `Rp. 0 (Tepat Waktu)`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        dendaInfo.className = 'alert alert-warning';
                        jumlahDendaText.textContent = 'Terjadi kesalahan saat menghitung denda';
                    });
            }
        </script>
    @endpush
@endsection
