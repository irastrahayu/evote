@extends('layout')
@section('title', 'Edit Pemilihan')
@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Edit Pemilihan</h2>

                    <form action="{{ route('pemilihan.update', $pemilihan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_pemilihan">Nama Pemilihan</label>
                            <input type="text" class="form-control" id="nama_pemilihan" name="nama_pemilihan" value="{{ $pemilihan->nama_pemilihan }}">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $pemilihan->tanggal_mulai }}">
                        </div>

                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ $pemilihan->tanggal_selesai }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Pemilihan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection