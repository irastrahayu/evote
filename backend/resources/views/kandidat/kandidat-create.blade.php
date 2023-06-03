@extends('layout')
@section('title', 'Buat Kandidat')
@section('content')
@if(Session::get('msg'))
<div class="alert alert-danger">
    {{Session::get('msg')}}
</div>
@endif

<div class="container">
    <h3 class="text-success text-center mt-3">
        FORM KANDIDAT
    </h3>
    <form action="{{ route('kandidat.store') }}" method="post" class="row p-3" enctype="multipart/form-data">
        @csrf
        <div class="input-group justify-content-center">
            <input type="text" class="form-control col-6 mb-3" placeholder="Nama Pasangan" name="nama_pasangan" value="{{old('nama_pasangan')}}">
        </div>
        @if($errors->has('nama_pasangan'))
        <small class="text-danger mx-auto">{{$errors->first('nama_pasangan')}}</small>
        @endif
        <div class="input-group justify-content-center">
            <input type="file" class="form-control col-6 mb-3" placeholder="Foto Kandidat" name="photo">
        </div>
        @if($errors->has('photo'))
        <small class="text-danger mx-auto">{{$errors->first('photo')}}</small>
        @endif
        <div class="input-group justify-content-center">
            <select type="text" name="pemilihan_id" class="form-control col-6 mb-3" required id="pemilihan_id">
                <option>Pilih</option>
                @foreach ($pemilihan as $data)
                <option value="{{ $data->id }}">{{ $data->nama_pemilihan }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="">NIS Ketua</label>
                        <input type="text" class="form-control" name="NIS_ketua" value="{{old('NIS_ketua')}}">
                        @if($errors->has('NIS_ketua'))
                        <small class="text-danger">{{$errors->first('NIS_ketua')}}</small>
                        @endif
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Nama Ketua</label>
                        <input type="text" class="form-control" name="nama_ketua" value="{{old('nama_ketua')}}">
                        @if($errors->has('nama_ketua'))
                        <span class="text-danger">{{$errors->first('nama_ketua')}}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Kelas Ketua</label>
                        <input type="text" class="form-control" name="kelas_ketua" value="{{old('kelas_ketua')}}">
                        @if($errors->has('kelas_ketua'))
                        <small class="text-danger">{{$errors->first('kelas_ketua')}}</small>
                        @endif
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Jurusan</label>
                        <select name="jurusan_ketua" class="form-control">
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                            <option value="Bahasa">Bahasa</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-2">
                        <label for="">NIS Wakil Ketua</label>
                        <input type="text" class="form-control" name="NIS_wakil" value="{{old('NIS_wakil')}}">
                        @if($errors->has('NIS_wakil'))
                        <small class="text-danger">{{$errors->first('NIS_wakil')}}</small>
                        @endif
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Nama Wakil Ketua</label>
                        <input type="text" class="form-control" name="nama_wakil" value="{{old('nama_wakil')}}">
                        @if($errors->has('nama_wakil'))
                        <small class="text-danger">{{$errors->first('nama_wakil')}}</small>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Kelas Wakil Ketua</label>
                        <input type="text" class="form-control" name="kelas_wakil" value="{{old('kelas_wakil')}}">
                        @if($errors->has('kelas_wakil'))
                        <small class="text-danger">{{$errors->first('kelas_wakil')}}</small>
                        @endif
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Jurusan</label>
                        <select name="jurusan_wakil" class="form-control">
                            <option value="IPA">IPA</option>
                            <option value="IPS">IPS</option>
                            <option value="Bahasa">Bahasa</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-lg">
            <div class="card-body">
                <div class="form-group">
                    <label for="">Visi</label>
                    <textarea name="visi" class="form-control" cols="30" rows="5">{{old('visi')}}</textarea>
                    @if($errors->has('visi'))
                    <small class="text-danger">{{$errors->first('visi')}}</small>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Misi</label>
                    <textarea name="misi" class="form-control" cols="30" rows="5">{{old('misi')}}</textarea>
                    @if($errors->has('misi'))
                    <small class="text-danger">{{$errors->first('misi')}}</small>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Program Kerja</label>
                    <textarea name="program_kerja" class="form-control" cols="30" rows="5">{{old('program_kerja')}}</textarea>
                    @if($errors->has('program_kerja'))
                    <small class="text-danger">{{$errors->first('program_kerja')}}</small>
                    @endif
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-md btn-success">Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>



@endsection
@include('partials.scripts')