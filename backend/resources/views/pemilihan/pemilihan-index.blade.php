@extends('layout')
@section('title', 'Pemilihan')
@section('content')

    <div class="container py-4">
        @if (Auth::user()->role == 'Admin')
            <a href="{{ route('pemilihan.create') }}" class="btn btn-primary mb-3"> <i class="fa fa-plus ms-0"
                    aria-hidden="true"></i> Tambah pemilihan</a>
        @endif
        <div class="row">
            @forelse ($pemilihan as $data)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body pb-0">
                            <h3 class="card-title">{{ $data->nama_pemilihan }}</h4>
                                <p>{{ $data->deskripsi }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('pemilihan.show', $data->id) }}" class="btn btn-sm btn-warning">Lihat
                                agenda</a>

                            @if (Auth::user()->role == 'Admin')
                                <a href="{{ route('pemilihan.delete', $data->id) }}" class="btn btn-sm btn-danger">Hapus
                                    agenda</a>
                            @endif


                        </div>
                    </div>
                </div>

            @empty
                <div class="d-flex justify-content-center">
                    <p class="text-center">Tidak ada data pemilihan</p>
                </div>
            @endforelse
        </div>

    </div>


    </div>


@endsection
@include('partials.scripts')
