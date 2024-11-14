@extends('Admin.partials.master')
@section('title', 'Lokasi Event')
@section('css')
    <style>
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
@endsection

@section('content')
    @if (session('error'))
        <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
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
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="position-fixed" style="top: 100px; right: 20px; z-index: 1050;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Event</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#TambahModal"><i
                                        class="bi bi-plus-circle"></i>
                                    Tambah Data Event</button>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped-columns table-hover"
                                    style="min-width: 845px">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">No. </th>
                                            <th class="text-center">Nama Event</th>
                                            <th class="text-center">Tanggal Event</th>
                                            <th class="text-center">Lokasi</th>
                                            <th class="text-center">Deskripsi</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Peserta</th>
                                            <th class="text-center">Feedback Acara</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center text-dark">{{ $loop->iteration }}</td>
                                                <td class="text-center text-dark">{{ $data->nama_event }}</td>
                                                <td class="text-center text-dark">
                                                    {{ \Carbon\Carbon::parse($data->tanggal_event)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}
                                                </td>
                                                <td class="text-center text-dark">{{ $data->lokasi->nama_lokasi }}</td>
                                                <td class="text-center text-dark">{{ $data->deskripsi }}</td>
                                                <td class="text-center text-dark">{{ $data->status }}</td>
                                                <td class="text-center text-dark">
                                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                                        data-target="#Peserta{{ $data->id_event }}">
                                                        <i class="bi bi-people-fill"></i>
                                                        Peserta
                                                    </button>
                                                </td>
                                                <td class="text-center text-dark">
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#Feedback{{ $data->id_event }}">
                                                        <i class="bi bi-chat-text"></i>
                                                        Feedback
                                                    </button>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-success" data-toggle="modal"
                                                        style="margin-right: 20px"
                                                        data-target="#EditModal{{ $data->id_event }}"><i
                                                            class="bi bi-pencil-square"></i>
                                                        Edit</button>
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#HapusModal{{ $data->id_event }}"><i
                                                            class="bi bi-trash3"></i>
                                                        Hapus</button>
                                                </td>

                                                {{-- Modal Hapus --}}
                                                <div class="modal fade" id="HapusModal{{ $data->id_event }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Data
                                                                    Event</h5>
                                                                <button class="close" type="button" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left text-dark">Apakah anda yakin
                                                                menghapus
                                                                data Event tersebut?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-warning" type="button"
                                                                    data-dismiss="modal">Tidak</button>
                                                                <form action="{{ route('event-delete', $data->id_event) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">
                                                                        Iya
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Modal Edit --}}
                                                <div class="modal fade" id="EditModal{{ $data->id_event }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Data
                                                                    Event
                                                                </h5>
                                                                <button class="close" type="button"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('event-update', $data->id_event) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="nama_event" class="text-dark">Nama
                                                                            Event</label>
                                                                        <input type="text"
                                                                            class="form-control border border-primary"
                                                                            id="nama_event" name="nama_event"
                                                                            value="{{ $data->nama_event }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="tanggal_event"
                                                                            class="text-dark">Tanggal Event</label>
                                                                        <input type="date"
                                                                            class="form-control border border-primary"
                                                                            id="tanggal_event" name="tanggal_event"
                                                                            value="{{ $data->tanggal_event }}"
                                                                            min="{{ date('Y-m-d') }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="id_lokasi"
                                                                            class="text-dark">Lokasi</label>
                                                                        <select class="form-control border border-primary"
                                                                            id="lokasi" name="id_lokasi" required>
                                                                            <option value="">Pilih Lokasi</option>
                                                                            @foreach ($lokasi as $lok)
                                                                                <option value="{{ $lok->id_lokasi }}"
                                                                                    {{ $lok->id_lokasi == $data->id_lokasi ? 'selected' : '' }}>
                                                                                    {{ $lok->nama_lokasi }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="deskripsi"
                                                                            class="text-dark">Deskripsi</label>
                                                                        <textarea class="form-control border border-primary" id="deskripsi" name="deskripsi" required>{{ $data->deskripsi }}</textarea>

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="status"
                                                                            class="text-dark">Status</label>
                                                                        <select class="form-control border border-primary"
                                                                            id="status" name="status" required>
                                                                            <option value="">Pilih Status</option>
                                                                            <option value="Dibuka"
                                                                                {{ $data->status == 'Dibuka' ? 'selected' : '' }}>
                                                                                Dibuka</option>
                                                                            <option value="Ditutup"
                                                                                {{ $data->status == 'Ditutup' ? 'selected' : '' }}>
                                                                                Ditutup</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-danger" type="button"
                                                                            data-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Edit</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($datas as $data)
        <div class="modal fade" id="Peserta{{ $data->id_event }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Peserta Event</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (empty($data->pendaftaran) || count($data->pendaftaran) == 0)
                            <p class="text-center text-muted">Belum ada Peserta yang daftar untuk acara ini.
                            </p>
                        @else
                            <form action="{{ route('set-kehadiran') }}" method="POST">
                                @csrf
                                <table class="table table-striped table-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No.</th>
                                            <th scope="col" class="text-center">Nama Peserta</th>
                                            <th scope="col" class="text-center">Email</th>
                                            <th scope="col" class="text-center">No. Telepon</th>
                                            <th scope="col" class="text-center">Hadir?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->pendaftaran as $peserta)
                                            <tr>
                                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                                <td class="text-center">{{ $peserta->user->name }}</td>
                                                <td class="text-center">{{ $peserta->user->email }}</td>
                                                <td class="text-center">{{ $peserta->user->no_hp }}</td>
                                                <td class="text-center">
                                                    <input type="hidden" name="id_event" value="{{ $data->id_event }}">
                                                    <input type="hidden" name="id_user[]"
                                                        value="{{ $peserta->id_user }}">

                                                    <input type="hidden"
                                                        name="status_kehadiran[{{ $peserta->id_user }}]"
                                                        value="Tidak Hadir">

                                                    <input type="checkbox"
                                                        name="status_kehadiran[{{ $peserta->id_user }}]" value="Hadir"
                                                        {{ $peserta->status_kehadiran == 'Hadir' ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
                                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="Feedback{{ $data->id_event }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Feedback
                            Event
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" style="overflow-x: auto;">
                        @if (empty($data->feedback) || count($data->feedback) == 0)
                            <p class="text-center text-muted">Belum ada Feedback untuk acara ini.
                            </p>
                        @else
                            <form action="{{ route('delete-feedback') }}" method="POST">
                                @csrf
                                <table class="table table-striped table-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No.</th>
                                            <th scope="col" class="text-center">Nama Peserta</th>
                                            <th scope="col" class="text-center">Rating</th>
                                            <th scope="col" class="text-center">Komentar</th>
                                            <th scope="col" class="text-center">Hapus?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->feedback as $feedback)
                                            <tr>
                                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                                <td class="text-center">{{ $feedback->user->name }}</td>
                                                <td class="text-center">{{ $feedback->rating }}</td>
                                                <td class="text-center">{{ $feedback->komentar }}</td>
                                                <td class="text-center">
                                                    <input type="checkbox"
                                                        name="id_feedback[]" value={{ $feedback->id_feedback }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
                                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <div class="modal fade" id="TambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Event</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('event-post') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_event" class="text-dark">Nama Event</label>
                            <input type="text" class="form-control border border-primary" id="nama_event"
                                name="nama_event" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_event" class="text-dark">Tanggal Event</label>
                            <input type="date" class="form-control border border-primary" id="tanggal_event"
                                name="tanggal_event" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="id_lokasi" class="text-dark">Lokasi</label>
                            <select class="form-control border border-primary" id="lokasi" name="id_lokasi" required>
                                <option value="">Pilih Lokasi</option>
                                @foreach ($lokasi as $data)
                                    <option value="{{ $data->id_lokasi }}">{{ $data->nama_lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="text-dark">Deskripsi</label>
                            <textarea class="form-control border border-primary" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status" class="text-dark">Status</label>
                            <select class="form-control border border-primary" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Dibuka">Dibuka</option>
                                <option value="Ditutup">Ditutup</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
