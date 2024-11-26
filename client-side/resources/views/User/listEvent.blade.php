@extends('User.partials.master')

@section('content')
    @if (session('error'))
        <div class="position-fixed" style="top: 100px; right: 100px; z-index: 1050;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @if (is_array(session('error')))
                    <ul>
                        @foreach (session('error') as $error)
                            <li><strong>{{ $error }}</strong></li>
                        @endforeach
                    </ul>
                @else
                    <strong>{{ session('error') }}</strong>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="position-fixed" style="top: 100px; right: 100px; z-index: 1050;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <section id="about" class="about section light-background py-5">
        <!-- Section Title -->
        <div class="container section-title text-center mb-4" data-aos="fade-up">
            <h2 class="fw-bold text-primary">Acara Saya</h2>
            <p class="text-muted">
                <span>List Acara yang</span>
                <span class="description-title d-block fs-5">Sudah Saya Daftar</span>
            </p>
        </div>
        <div class="ticket-list">
            {{-- @php
                dd($datas);
            @endphp --}}
            @foreach ($datas as $data)
                <div class="ticket-item card shadow-sm mb-4 p-3">
                    <div class="d-flex align-items-center">
                        <div class="ticket-info flex-grow-1">
                            <h5 class="ticket-title mb-1">{{ $data->event->nama_event }}</h5>
                            <p class="text-muted mb-1">{{ $data->event->deskripsi }}</p>
                            <p class="text-muted mb-1">
                                Tanggal:
                                {{ \Carbon\Carbon::parse($data->event->tanggal_event)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm me-3" data-bs-toggle="modal"
                                data-bs-target="#FormFeedback{{ $data->id_pendaftaran }}">
                                <i class="bi bi-chat-text"></i>
                                Beri Feedback
                            </button>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#Feedback{{ $data->id_pendaftaran }}">
                                <i class="bi bi-eye"></i>
                                Lihat Feedback
                            </button>

                            <div class="modal fade" id="FormFeedback{{ $data->id_pendaftaran }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                Feedback {{ $data->event->nama_event }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        @if ($data->status_kehadiran == 'Tidak Hadir')
                                            <div class="modal-body">
                                                Belum bisa memberikan feedback, karena anda tidak hadir di Event tersebut
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        @elseif ($data->status_kehadiran == 'Hadir')
                                            <form action="{{ route('create-feedback') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_pendaftaran"
                                                    value="{{ $data->id_pendaftaran }}">
                                                <div class="modal-body">
                                                    <label for="">Rating Acara
                                                        {{ $data->event->nama_event }}</label>
                                                    <div class="rating">
                                                        <input type="radio" name="rating" id="star5"
                                                            value="5"><label for="star5"></label>
                                                        <input type="radio" name="rating" id="star4"
                                                            value="4"><label for="star4"></label>
                                                        <input type="radio" name="rating" id="star3"
                                                            value="3"><label for="star3"></label>
                                                        <input type="radio" name="rating" id="star2"
                                                            value="2"><label for="star2"></label>
                                                        <input type="radio" name="rating" id="star1"
                                                            value="1"><label for="star1"></label>
                                                    </div>
                                                    <label for="komentar">Komentar</label>
                                                    <textarea name="komentar" id="komentar" cols="30" rows="5" class="form-control"></textarea>
                                                    <label for="jenis_feedback" class="mt-2">Jenis Feedback</label>
                                                    <select class="form-control border border-primary" id="jenis_feedback"
                                                        name="jenis_feedback" required>
                                                        <option value="">Pilih Salah Satu Jenis</option>
                                                        <option value="Kritik">Kritik</option>
                                                        <option value="Saran">Saran</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="Feedback{{ $data->id_pendaftaran }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                Feedback {{ $data->event->nama_event }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if (empty($data->all_feedbacks) || count($data->all_feedbacks) == 0)
                                                <p class="text-center text-muted">Belum ada feedback untuk acara ini.
                                                </p>
                                            @else
                                                @foreach ($data->all_feedbacks as $feedback)
                                                    <div class="card feedback-card">
                                                        <div class="card-body">
                                                            <div class="feedback-header">
                                                                <span
                                                                    class="feedback-name">{{ $feedback->pendaftaran->user->name }}</span>
                                                                <div class="feedback-rating">
                                                                    <!-- Loop untuk menampilkan rating bintang -->
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <span class="star"
                                                                            style="color: {{ $i <= $feedback->rating ? '#ffcc00' : '#ccc' }};">&#9733;</span>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div class="feedback-type">
                                                                <small class="text-muted">Jenis Feedback:
                                                                    {{ $feedback->jenis_feedback }}</small>
                                                            </div>
                                                            <div class="feedback-comment">
                                                                <p>{{ $feedback->komentar }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

<style>
    .ticket-list {
        max-width: 800px;
        margin: auto;
    }

    .ticket-item {
        border-left: 5px solid #007bff;
        border-radius: 5px;
        padding: 15px 20px;
    }

    .ticket-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .ticket-info {
        padding-right: 20px;
    }

    .modal-body {
        text-align: left;
        /* Memastikan semua teks di modal-body berada di kiri */
    }

    .modal-body label {
        display: block;
        text-align: left;
        /* Pastikan label berada di kiri */
    }

    .rating {
        direction: rtl;
        display: inline-flex;
        /* Menjaga bintang dalam satu baris */
        justify-content: flex-start;
        /* Meratakan bintang ke kiri */
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 2em;
        color: gray;
        cursor: pointer;
    }

    .rating label::before {
        content: '★';
        /* Menampilkan simbol bintang */
    }

    .rating input:checked~label {
        color: gold;
        /* Warna bintang setelah dipilih */
    }

    /* Efek hover: Bintang akan berubah jadi emas ketika di-hover */
    .rating label:hover,
    .rating label:hover~label {
        color: gold;
    }

    .feedback-container {
        max-width: 800px;
        padding: 10px;
    }

    .feedback-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 20px;
        background-color: #fff;
    }

    .card-body {
        padding: 15px;
    }

    .feedback-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .feedback-name {
        font-weight: bold;
        font-size: 16px;
        color: #333;
    }

    .feedback-rating {
        font-size: 18px;
    }

    .star {
        font-size: 20px;
    }

    .feedback-comment {
        font-size: 14px;
        color: #555;
    }

    .feedback-comment p {
        margin: 0;
    }

    .feedback-type {
        margin-top: 5px;
        font-style: italic;
    }
</style>
