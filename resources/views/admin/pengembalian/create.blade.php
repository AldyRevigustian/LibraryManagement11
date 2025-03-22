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
                <form class="form" action="{{ route('admin.pengembalian_store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="peminjaman_id" id="peminjaman_id">
                    <div class="row">
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
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                <input type="date"
                                    class="form-control flatpickr-no-config"
                                    id="tanggal_peminjaman" placeholder="Tanggal Peminjaman" name="tanggal_peminjaman" />
                                @error('tanggal_peminjaman')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                                Batas Pengembalian : <strong id="batas-pengembalian">-</strong> <br>
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
            const anggotaMap = {};
            @foreach ($anggotas as $anggota)
                anggotaMap[{{ $anggota->id }}] = {
                    id: {{ $anggota->id }},
                    nim: "{{ $anggota->nim }}",
                    nama: "{{ $anggota->nama }}"
                };
            @endforeach


            const peminjamanByAnggota = {};
            @foreach ($peminjamanByAnggota as $anggotaId => $peminjamans)
                peminjamanByAnggota[{{ $anggotaId }}] = [
                    @foreach ($peminjamans as $peminjaman)
                        {
                            id: {{ $peminjaman->buku->id }},
                            ISBN: "{{ $peminjaman->buku->ISBN }}",
                            judul: "{{ $peminjaman->buku->judul }}",
                            tanggal_peminjaman: "{{ $peminjaman->tanggal_peminjaman }}",
                            peminjaman_id: {{ $peminjaman->id }}
                        },
                    @endforeach
                ];
            @endforeach

            const batasHari = @json(App\Models\Aturan::first()->batas_hari ?? 7);
            const dendaInfo = document.getElementById('info-peminjaman');
            const batasPengembalianText = document.getElementById('batas-pengembalian');
            const jumlahDendaText = document.getElementById('jumlah-peminjaman');

            const isbnElement = document.querySelector('select[name="ISBN_id"]');
            const bukuElement = document.querySelector('select[name="buku_id"]');

            const nimElement = document.querySelector('select[name="anggota_id"]');
            const namaElement = document.querySelector('select[name="nama_id"]');

            const tanggalPeminjamanInput = document.getElementById('tanggal_peminjaman');
            const tanggalPengembalianInput = document.getElementById('tanggal_pengembalian');
            const peminjamanIdInput = document.getElementById('peminjaman_id');

            var today = new Date();

            var pinjamPicker = flatpickr('#tanggal_peminjaman', {
                dateFormat: "Y-m-d",
            });

            var pengembalianPicker = flatpickr('#tanggal_pengembalian', {
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    calculateDenda(dateStr);
                }
            });

            pinjamPicker.set('clickOpens', false);
            pengembalianPicker.set('clickOpens', false);
            tanggalPeminjamanInput.disabled = true;
            tanggalPengembalianInput.disabled = true;

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

            isbnElement.closest('.form-group').classList.add('disabled');
            bukuElement.closest('.form-group').classList.add('disabled');

            function calculateDenda(tanggalPengembalianValue) {
                const selectedBookId = isbnElement.value || bukuElement.value;
                const selectedAnggotaId = nimElement.value || namaElement.value;

                if (!selectedBookId || !selectedAnggotaId || !tanggalPeminjamanInput.value || !tanggalPengembalianValue) {
                    return;
                }

                let borrowDate = new Date(tanggalPeminjamanInput.value);
                let batasDate = new Date(borrowDate);
                batasDate.setDate(batasDate.getDate() + batasHari);

                const batasPengembalianFormatted = batasDate.toISOString().split('T')[0];

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

                        batasPengembalianText.textContent = data.batas_pengembalian;

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

            function updateDateFields(bookId, anggotaId) {
                if (!bookId || !anggotaId) {
                    pinjamPicker.setDate('');
                    pinjamPicker.set('clickOpens', false);
                    tanggalPeminjamanInput.disabled = true;

                    pengembalianPicker.setDate('');
                    pengembalianPicker.set('clickOpens', false);
                    tanggalPengembalianInput.disabled = true;

                    batasPengembalianText.textContent = '-';
                    jumlahDendaText.textContent = '0';
                    dendaInfo.className = 'alert alert-primary';

                    // Clear peminjaman_id when no book is selected
                    peminjamanIdInput.value = '';
                    return;
                }

                const borrowedBooks = peminjamanByAnggota[anggotaId] || [];
                const selectedBook = borrowedBooks.find(book => book.id.toString() === bookId.toString());

                if (selectedBook && selectedBook.tanggal_peminjaman) {
                    // Set the peminjaman_id for the selected book
                    peminjamanIdInput.value = selectedBook.peminjaman_id;

                    pinjamPicker.setDate(selectedBook.tanggal_peminjaman);
                    pinjamPicker.set('clickOpens', false);
                    tanggalPeminjamanInput.disabled = true;

                    pengembalianPicker.set('clickOpens', true);
                    tanggalPengembalianInput.disabled = false;

                    let borrowDate = new Date(selectedBook.tanggal_peminjaman);
                    let returnDate = new Date(borrowDate);
                    returnDate.setDate(returnDate.getDate() + batasHari);


                    const batasPengembalianFormatted = returnDate.toISOString().split('T')[0];
                    batasPengembalianText.textContent = batasPengembalianFormatted;


                    jumlahDendaText.textContent = '0';
                    dendaInfo.className = 'alert alert-primary';

                    pengembalianPicker.set('minDate', borrowDate);


                    if (tanggalPengembalianInput.value) {
                        calculateDenda(tanggalPengembalianInput.value);
                    }
                } else {
                    pinjamPicker.setDate('');
                    pinjamPicker.set('clickOpens', false);
                    tanggalPeminjamanInput.disabled = true;

                    pengembalianPicker.setDate('');
                    pengembalianPicker.set('clickOpens', false);
                    tanggalPengembalianInput.disabled = true;

                    batasPengembalianText.textContent = '-';
                    jumlahDendaText.textContent = '0';
                    dendaInfo.className = 'alert alert-primary';

                    // Clear peminjaman_id when no valid book is selected
                    peminjamanIdInput.value = '';
                }
            }

            function updateBookSelections(anggotaId) {
                isbnChoice.clearStore();
                bukuChoice.clearStore();

                tanggalPeminjamanInput.value = '';
                tanggalPengembalianInput.value = '';

                // Clear peminjaman_id when changing anggota
                peminjamanIdInput.value = '';

                batasPengembalianText.textContent = '-';
                jumlahDendaText.textContent = '0';
                dendaInfo.className = 'alert alert-primary';

                isbnChoice.setChoices([{
                    value: '',
                    label: '--ISBN--',
                    disabled: true,
                    selected: true
                }]);

                bukuChoice.setChoices([{
                    value: '',
                    label: '--Pilih Buku--',
                    disabled: true,
                    selected: true
                }]);

                if (!anggotaId) {
                    isbnElement.closest('.form-group').classList.add('disabled');
                    bukuElement.closest('.form-group').classList.add('disabled');

                    pinjamPicker.setDate('');
                    pinjamPicker.set('clickOpens', false);
                    tanggalPeminjamanInput.disabled = true;

                    pengembalianPicker.setDate('');
                    pengembalianPicker.set('clickOpens', false);
                    tanggalPengembalianInput.disabled = true;

                    return;
                }

                isbnElement.closest('.form-group').classList.remove('disabled');
                bukuElement.closest('.form-group').classList.remove('disabled');

                const borrowedBooks = peminjamanByAnggota[anggotaId] || [];

                if (borrowedBooks.length > 0) {
                    const isbnChoices = borrowedBooks.map(book => ({
                        value: book.id.toString(),
                        label: book.ISBN
                    }));

                    const bukuChoices = borrowedBooks.map(book => ({
                        value: book.id.toString(),
                        label: book.judul
                    }));

                    isbnChoice.setChoices(isbnChoices, 'value', 'label', true);
                    bukuChoice.setChoices(bukuChoices, 'value', 'label', true);
                }
            }

            nimElement.addEventListener('change', function() {
                const selectedId = this.value;
                if (namaElement.value !== selectedId) {
                    namaChoice.setChoiceByValue(selectedId);
                }
                updateBookSelections(selectedId);
            });

            namaElement.addEventListener('change', function() {
                const selectedId = this.value;
                if (nimElement.value !== selectedId) {
                    nimChoice.setChoiceByValue(selectedId);
                }
                updateBookSelections(selectedId);
            });

            isbnElement.addEventListener('change', function() {
                const selectedId = this.value;
                if (selectedId) {
                    if (bukuElement.value !== selectedId) {
                        bukuChoice.setChoiceByValue(selectedId);
                    }
                    updateDateFields(selectedId, nimElement.value || namaElement.value);
                    enableSubmitButton();
                }
            });

            bukuElement.addEventListener('change', function() {
                const selectedId = this.value;
                if (selectedId) {
                    if (isbnElement.value !== selectedId) {
                        isbnChoice.setChoiceByValue(selectedId);
                    }
                    updateDateFields(selectedId, nimElement.value || namaElement.value);
                    enableSubmitButton();
                }
            });

            function enableSubmitButton() {
                const submitButton = document.querySelector('button[type="submit"]');
                if (isbnElement.value && bukuElement.value && (nimElement.value || namaElement.value)) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            }
        </script>
    @endpush
@endsection
