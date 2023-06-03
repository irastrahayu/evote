@extends('layout')
@section('title', 'Dashboard')
@section('content')

    <div class="container py-5">
        <h3>Selamat datang di E-Voting</h3>
        @if (Auth::user()->role == 'Admin')
            <div class="row py-5">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pemilihan</h5>
                            <h1>{{ $jp }} </h1> Agenda Pemilihan
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pasangan</h5>
                            <h1>{{ $kandidat }} </h1>
                            Kandidat
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User</h5>
                            <h1>{{ $user }}</h1>
                            Jumlah User aktif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-3">
            <a href="{{ route('pemilihan') }}" class="btn btn-block btn-primary">Menuju ke pemilihan</a>

        </div>

    </div>

    @include('partials.scripts')
    <script>
        // Mempersiapkan data yang akan ditampilkan di chart
        var pemilihanLabels = [];
        var kandidatData = [];

        @foreach ($pemilihans as $pemilihan)

            var kandidatJumlahSuara = [];

            pemilihanLabels.push('{{ $pemilihan->nama_pasangan }}');
            kandidatJumlahSuara.push({{ $pemilihan->jumlah_suara ?? 0 }});

            kandidatData.push(kandidatJumlahSuara);
        @endforeach

        // Membuat chart menggunakan Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');

        var datasets = [];
        @foreach ($pemilihans as $index => $pemilihan)
            datasets.push({
                label: '{{ $pemilihan->nama_pemilihan }}',
                data: kandidatData[{{ $index }}],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            });
        @endforeach

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: pemilihanLabels,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        });
    </script>
@endsection
