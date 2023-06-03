@extends('layout')
@section('title', 'Pemilihan')
@section('content')

<style>
    .img-thumbnail {
        object-fit: contain;
        height: 50vh;
        max-width: 100vh;
    }
</style>
<div class="container py-4">
    <div class="py-5 bg-white">
        <canvas id="myChart"></canvas>
    </div>
    <div class="row">
        @forelse ($pemilihans->Kandidat as $data)
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <img class="img-thumbnail" src="{{ asset('Foto Kandidat/' . $data->foto_kandidat) }}" alt="">
                    </div>
                    <h2 class="card-title text-center mt-5">{{ $data->nama_pasangan }}</h2>
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
                <div class="d-block px-2">
                    @if (Auth::user()->vote()->exists())
                    <h1>Anda sudah melakukan voting</h1>
                    @else
                    <form action="{{ route('pemilihan.vote', ['id_pemilihan' => $pemilihans->id, 'id_kandidat' => $data->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-block btn-primary">Vote pasangan ini</button>
                    </form>
                    @endif


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


@include('partials.scripts')
<script>
    // Mempersiapkan data yang akan ditampilkan di chart
    var pemilihanLabels = [];
    var kandidatData = [];

    @foreach ($pemilihans->Kandidat as $pemilihans)

    var kandidatJumlahSuara = [];

    pemilihanLabels.push('{{ $pemilihans->nama_pasangan }}');
    kandidatJumlahSuara.push({
        {
            $pemilihans - > jumlah_suara
        }
    });

    kandidatData.push(kandidatJumlahSuara);
    @endforeach

    // Membuat chart menggunakan Chart.js
    var ctx = document.getElementById('myChart').getContext('2d');

    var datasets = [];
    datasets.push({
        label: '{{ $pemilihans->nama_pemilihan }}',
        data: kandidatData,
        backgroundColor: [
            'rgba(15, 82, 192, 0.9)',
            'rgba(255, 0, 0, 0.5)',
            'rgba(90, 250, -25, 0.9)'

        ],
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    });

    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: pemilihanLabels,
            datasets: datasets
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom'
            },
        }
    });
</script>
@endsection