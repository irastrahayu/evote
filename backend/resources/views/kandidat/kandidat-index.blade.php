@extends('layout')
@section('title', 'Kandidat')
@section('content')
    <div class="container py-4">
        <a href="{{ route('kandidat.create') }}" class="btn btn-primary mb-3"> <i class="fa fa-plus ms-0"
                aria-hidden="true"></i> Tambah kandidat</a>
        <div class="row">
            @forelse ($kandidat as $data)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body pb-0">
                            <h3 class="card-title">{{ $data->nama_pasangan }}</h3>
                            <h4 class="btn btn-dark py-1">{{ $data->pemilihan->nama_pemilihan }}</h4>
                            <table>
                                <tr>
                                    <td>Nama Ketua</td>
                                    <td class="px-3">:</td>
                                    <td>{{ $data->nama_ketua }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Wakil</td>
                                    <td class="px-3">:</td>
                                    <td>{{ $data->nama_wakil }}</td>
                                </tr>
                                <tr>
                                    <td>Visi</td>
                                    <td class="px-3">:</td>
                                    <td>{{ $data->visi }}</td>
                                </tr>
                                <tr>
                                    <td>Misi</td>
                                    <td class="px-3">:</td>
                                    <td>{{ $data->misi }}</td>
                                </tr>
                            </table>

                            <hr>
                            <h4>Program Kerja : </h4>
                            <p>{{$data->program_kerja}}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('kandidat.edit', $data->id) }}" class="btn btn-sm btn-warning">Edit
                                Kandidat</a>
                            <a href="{{ route('kandidat.delete', $data->id) }}" class="btn btn-sm btn-danger">Hapus
                                Kandidat</a>

                        </div>
                    </div>
                </div>

            @empty
                <div class="col-lg-12">
                    <h3 class="text-center">Tidak ada data kandidat</h3>
                </div>
            @endforelse
        </div>

    </div>


    </div>


@endsection
@include('partials.scripts')
