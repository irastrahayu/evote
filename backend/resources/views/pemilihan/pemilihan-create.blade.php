@extends('layout')
@section('title', 'Buat Pemilihan')
@section('content')

    <div class="container py-4">
        <form action="{{route('pemilihan.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="">Nama Pemilihan</label>
                <input type="text" name="nama_pemilihan" class="form-control" id="nama_pemilihan">
            </div>
            <div class="mb-3">
                <label for="">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" id="deskripsi">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>


    </div>


    </div>


@endsection
@include('partials.scripts')
