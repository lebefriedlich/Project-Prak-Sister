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
                            <h4 class="card-title">Lokasi Event</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#TambahModal"><i
                                        class="bi bi-plus-circle"></i>
                                    Tambah Data Lokasi Event</button>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped-columns table-hover"
                                    style="min-width: 845px">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">No. </th>
                                            <th class="text-center">Nama Lokasi</th>
                                            <th class="text-center">Gedung</th>
                                            <th class="text-center">Kapasitas</th>
                                            <th class="text-center">Tipe Lokasi</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td class="text-center text-dark">{{ $loop->iteration }}</td>
                                                <td class="text-center text-dark">{{ $data->nama_lokasi }}</td>
                                                <td class="text-center text-dark">{{ $data->gedung }}</td>
                                                <td class="text-center text-dark">{{ $data->kapasitas }}</td>
                                                <td class="text-center text-dark">{{ $data->tipe_lokasi }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-success" data-toggle="modal"
                                                        style="margin-right: 20px"
                                                        data-target="#EditModal{{ $data->id_lokasi }}"><i
                                                            class="bi bi-pencil-square"></i>
                                                        Edit</button>
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#HapusModal{{ $data->id_lokasi }}"><i
                                                            class="bi bi-trash3"></i>
                                                        Hapus</button>
                                                </td>
                                                <div class="modal fade" id="HapusModal{{ $data->id_lokasi }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Data
                                                                    Lokasi Event</h5>
                                                                <button class="close" type="button" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left text-dark">Apakah anda yakin
                                                                menghapus
                                                                data Lokasi Event tersebut?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-warning" type="button"
                                                                    data-dismiss="modal">Tidak</button>
                                                                <form action="{{ route('lokasi-event-delete', $data->id_lokasi) }}"
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
                                                <div class="modal fade" id="EditModal{{ $data->id_lokasi }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Data
                                                                    Lokasi Event
                                                                </h5>
                                                                <button class="close" type="button" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <form
                                                                action="{{ route('lokasi-event-update', $data->id_lokasi) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="nama_lokasi" class="text-dark">Nama
                                                                            Lokasi</label>
                                                                        <input type="text"
                                                                            class="form-control border border-primary"
                                                                            id="nama_lokasi" name="nama_lokasi"
                                                                            value="{{ $data->nama_lokasi }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="gedung"
                                                                            class="text-dark">Gedung</label>
                                                                        <input type="text"
                                                                            class="form-control border border-primary"
                                                                            id="gedung" name="gedung" value="{{ $data->gedung }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="kapasitas"
                                                                            class="text-dark">Kapasitas</label>
                                                                        <input type="number"
                                                                            class="form-control border border-primary"
                                                                            id="kapasitas" name="kapasitas" value="{{ $data->kapasitas }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="tipe_lokasi" class="text-dark">Tipe
                                                                            Lokasi</label>
                                                                        <select class="form-control border border-primary"
                                                                            id="tipe_lokasi" name="tipe_lokasi" required>
                                                                            <option value="">Pilih Tipe Lokasi</option>
                                                                            <option value="Indoor" {{ $data->tipe_lokasi == 'Indoor' ? 'selected' : '' }}>Indoor</option>
                                                                            <option value="Outdoor" {{ $data->tipe_lokasi == 'Outdoor' ? 'selected' : '' }}>Outdoor</option>
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

    <div class="modal fade" id="TambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Lokasi Event</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('lokasi-event-post') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_lokasi" class="text-dark">Nama Lokasi</label>
                            <input type="text" class="form-control border border-primary" id="nama_lokasi"
                                name="nama_lokasi" required>
                        </div>
                        <div class="form-group">
                            <label for="gedung" class="text-dark">Gedung</label>
                            <input type="text" class="form-control border border-primary" id="gedung"
                                name="gedung" required>
                        </div>
                        <div class="form-group">
                            <label for="kapasitas" class="text-dark">Kapasitas</label>
                            <input type="number" class="form-control border border-primary" id="kapasitas"
                                name="kapasitas" required>
                        </div>
                        <div class="form-group">
                            <label for="tipe_lokasi" class="text-dark">Tipe Lokasi</label>
                            <select class="form-control border border-primary" id="tipe_lokasi" name="tipe_lokasi"
                                required>
                                <option value="">Pilih Tipe Lokasi</option>
                                <option value="Indoor">Indoor</option>
                                <option value="Outdoor">Outdoor</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
