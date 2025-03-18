@extends('layouts.guest')
@push('style')
    <link rel="stylesheet" href="/assets/extensions/choices.js/public/assets/styles/choices.css" />
    <link rel="stylesheet" href="/assets/extensions/flatpickr/flatpickr.min.css" />
    <style>
        .choices__inner {
            background-color: white;
            min-height: 0px;
            padding: 4px !important;
            border: 1px solid #dce7f1 !important;
        }

        .form-control:read-only {
            background-color: #e9ecef;
            pointer-events: none;
        }
    </style>
@endpush
@section('content')
    @php
        $user = Auth::guard('anggota')->user();
        $count = count($user->peminjamans_active);
    @endphp
    <section class="section mt-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pinjam Buku</h5>
                    </div>
                    <hr class="mt-4 mb w-100">
                </div>
            </div>

            @include('components.message')
            <div class="card-body">
                <form class="form" action="{{ route('anggota.peminjaman_store') }}" method="POST"
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
                                <label for="batas_pengembalian" class="form-label">Batas Pengembalian</label>
                                <input type="date" readonly
                                    class="form-control flatpickr-pengembalian @error('batas_pengembalian') is-invalid @enderror"
                                    id="batas_pengembalian" placeholder="Batas Pengembalian" name="batas_pengembalian"
                                    required />
                                <p class="mb-0"><small class="text-muted">Maksimal Pengembalian Sebelum Di Denda</small>
                                </p>
                                @error('batas_pengembalian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="nim-column" class="form-label">NIM Peminjam</label>
                                <input type="number" id="nim-column" disabled
                                    class="form-control @error('nim') is-invalid @enderror" placeholder="NIM Peminjam"
                                    name="nim" value="{{ $user->nim }}" required autocomplete="nim">
                                @error('nim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="nama-column" class="form-label">Nama Peminjam</label>
                                <input type="text" id="nama-column" disabled
                                    class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Peminjam"
                                    name="nama" value="{{ $user->nama }}" required autocomplete="nama">
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="ISBN-column" class="form-label">ISBN</label>
                                <select name="ISBN_id" class="form-select">
                                    <option value="" disabled selected>
                                        --ISBN--</option>
                                    @foreach ($bukus as $buku)
                                        <option value="{{ $buku->id }}">
                                            {{ $buku->ISBN }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="buku-column" class="form-label">Judul Buku</label>
                                <select name="buku_id" class="form-select">
                                    <option value="" disabled selected>
                                        --Pilih Buku--</option>
                                    @foreach ($bukus as $buku)
                                        <option value="{{ $buku->id }}">
                                            {{ $buku->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end">
                                @if ($count >= $rule->max_pinjam)
                                    <button class="btn btn-primary me-1 mb-1" disabled>
                                        Submit
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary me-1 mb-1" id="btn_submit" disabled>
                                        Submit
                                    </button>
                                @endif
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </section>

    @push('script')
        <script src="/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
        <script src="/assets/extensions/apexcharts/apexcharts.js"></script>
        <script src="/assets/extensions/flatpickr/flatpickr.min.js"></script>
        <script>
            const preselectedBukuId = {{ $buku_id ?? 'null' }};
            console.log(preselectedBukuId);
            var today = new Date();
            var batasHari = {{ $rule->batas_pengembalian }} || 7;

            var pinjamPicker = flatpickr('#tanggal_peminjaman', {
                dateFormat: "d/m/Y",
                defaultDate: today,
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        let selectedDate = new Date(selectedDates[0]);
                        let pengembalianDate = new Date(selectedDate);
                        pengembalianDate.setDate(pengembalianDate.getDate() + batasHari);
                        pengembalianPicker.setDate(pengembalianDate);
                    }
                }
            });

            var pengembalianPicker = flatpickr('#batas_pengembalian', {
                dateFormat: "d/m/Y",
                defaultDate: new Date(today.getTime() + batasHari * 24 * 60 * 60 * 1000),
            });

            const bukuMap = {};
            @foreach ($bukus as $buku)
                bukuMap[{{ $buku->id }}] = {
                    id: {{ $buku->id }},
                    isbn: "{{ $buku->ISBN }}",
                    judul: "{{ $buku->judul }}"
                };
            @endforeach

            const isbnElement = document.querySelector('select[name="ISBN_id"]');
            const bukuElement = document.querySelector('select[name="buku_id"]');

            let isbnChoice = new Choices(isbnElement, {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            let bukuChoice = new Choices(bukuElement, {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            if (preselectedBukuId) {
                isbnChoice.setChoiceByValue(preselectedBukuId.toString());
                bukuChoice.setChoiceByValue(preselectedBukuId.toString());
                enableSubmitButton();
            }

            isbnElement.addEventListener('change', function() {
                const selectedId = this.value;
                if (selectedId) {
                    if (bukuElement.value !== selectedId) {
                        bukuChoice.setChoiceByValue(selectedId);
                    }
                    enableSubmitButton();
                }
            });

            bukuElement.addEventListener('change', function() {
                const selectedId = this.value;
                if (selectedId) {
                    if (isbnElement.value !== selectedId) {
                        isbnChoice.setChoiceByValue(selectedId);
                    }
                    enableSubmitButton();
                }
            });

            function enableSubmitButton() {
                const submitButton = document.querySelector('#btn_submit');
                const tanggalPeminjaman = document.getElementById('tanggal_peminjaman').value;

                if (isbnElement.value && bukuElement.value && tanggalPeminjaman) {
                    submitButton.disabled = false;
                }
            }
        </script>
    @endpush
@endsection
