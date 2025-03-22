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
                        <h5 class="mb-0">Peminjaman Baru</h5>
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
                                <label for="batas_pengembalian" class="form-label">Batas Pengembalian</label>
                                <input type="date"
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
                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="nim-column" class="form-label">NIM Peminjam</label>
                                <select name="anggota_id" id="nim-column" class=" form-select">
                                    <option value="" disabled selected>-- Pilih NIM --</option>
                                    @foreach ($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->nim }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="nama-column" class="form-label">Nama Peminjam</label>
                                <select name="nama_id" id="nama-column" class=" form-select">
                                    <option value="" disabled selected>-- Pilih Nama --</option>
                                    @foreach ($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mt-2">
                            <div class="form-group mandatory">
                                <label for="ISBN-column" class="form-label">ISBN</label>
                                <select name="ISBN_id" class="  form-select">
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
                                <select name="buku_id" class="  form-select">
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
                        <div class="col-12 mt-3">
                            <div id="info-peminjaman" class="alert alert-primary d-none">
                                Nama Peminjam : <strong id="nama-peminjam">-</strong> <br>
                                Jumlah Peminjaman Aktif : <strong id="jumlah-peminjaman">0</strong>
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

            const anggotaMap = {};
            @foreach ($anggotas as $anggota)
                anggotaMap[{{ $anggota->id }}] = {
                    id: {{ $anggota->id }},
                    nim: "{{ $anggota->nim }}",
                    nama: "{{ $anggota->nama }}"
                };
            @endforeach


            const peminjamanAktifMap = {};
            @foreach ($anggotas as $anggota)
                peminjamanAktifMap[{{ $anggota->id }}] = {{ $anggota->peminjamans_active->count() }};
            @endforeach

            function updateInfoPeminjaman(selectedId) {
                const infoDiv = document.getElementById('info-peminjaman');
                const jumlahSpan = document.getElementById('jumlah-peminjaman');
                const namaSpan = document.getElementById('nama-peminjam');

                if (selectedId && peminjamanAktifMap[selectedId] !== undefined) {
                    jumlahSpan.textContent = peminjamanAktifMap[selectedId];
                    namaSpan.textContent = anggotaMap[selectedId]?.nama || '-';
                    infoDiv.classList.remove('d-none');
                } else {
                    infoDiv.classList.add('d-none');
                }
            }


            const isbnElement = document.querySelector('select[name="ISBN_id"]');
            const bukuElement = document.querySelector('select[name="buku_id"]');

            const nimElement = document.querySelector('select[name="anggota_id"]');
            const namaElement = document.querySelector('select[name="nama_id"]');


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


            let nimChoice = new Choices(nimElement, {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            let namaChoice = new Choices(namaElement, {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });


            nimElement.addEventListener('change', function() {
                const selectedId = this.value;
                updateInfoPeminjaman(selectedId);
                if (namaElement.value !== selectedId) {
                    namaChoice.setChoiceByValue(selectedId);
                }
            });

            namaElement.addEventListener('change', function() {
                const selectedId = this.value;
                updateInfoPeminjaman(selectedId);
                if (nimElement.value !== selectedId) {
                    nimChoice.setChoiceByValue(selectedId);
                }
            });

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
