@extends('layouts.pegawai')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .card {
            width: 100%;
            max-width: 80%;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 10px;
            height: auto;
        }

        .card-image {
            width: 100%;
            height: auto;
        }

        .card-content {
            padding: 20px;
            text-align: center;
        }

        @media screen and (max-width: 768px) {
            .card {
                max-width: 80%;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row" style="margin-left: 9%; margin-top: 3%">
        <h5 class="text-primary">Absen</h5>
    </div>
    <div class="row mt-2" style="justify-content: center">
        <div class="card border-primary mb-3">
            <div class="card-body text-primary">
                <div class="container">
                    <center>
                        <h1>Formulir Absen</h1>
                        @if (\Session::has('msg_success'))
                            <div class="alert alert-success">
                                {{ \Session::get('msg_success') }}
                            </div>
                        @endif
                        @if (\Session::has('msg_error'))
                            <div class="alert alert-danger">
                                {{ \Session::get('msg_error') }}
                            </div>
                        @endif
                    </center>
                    <br>
                    <br>
                    <center>
                        <form method="post" action="{{ route('pegawai.addAbsen') }}" enctype="multipart/form-data"
                            oid="absenForm" onsubmit="return handleSubmit(event)">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="hidden" id="latitude" name="latitude">
                                <input type="hidden" id="longitude" name="longitude">
                                @if ($datang)
                                    <input type="hidden" name="status" value="Pulang">
                                @else
                                    <input type="hidden" name="status" value="Datang">
                                @endif
                            </div>
                            @if (empty($pulang))
                                <button type="submit" class="btn btn-primary">Absen</button>
                            @endif
                        </form>
                    </center>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <center>
                                <p class="text-primary">Absen Masuk :
                                    @if (!empty($datang))
                                        {{ date('d F Y H:i:s', strtotime(@$datang->created_at)) }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </center>
                        </div>
                        <div class="col-sm-6">
                            <center>
                                <p class="text-primary">Absen Pulang :
                                    @if (!empty($pulang))
                                        {{ date('d F Y H:i:s', strtotime(@$datang->created_at)) }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        new DataTable('#shipment', {
            responsive: true,
            lengthMenu: [5, 10, 25, 50],
        });
    </script>
    <script>
        function getLocation(callback) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        callback(position.coords.latitude, position.coords.longitude);
                    },
                    (error) => {
                        alert("Tidak dapat mendapatkan lokasi Anda: " + error.message);
                        callback(null, null); // Jika gagal, tetap memanggil callback tanpa nilai
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
                callback(null, null); // Jika tidak didukung, tetap memanggil callback tanpa nilai
            }
        }

        function handleSubmit(event) {
            event.preventDefault();

            getLocation((latitude, longitude) => {
                if (latitude !== null && longitude !== null) {
                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;

                    // Jika sudah dapat lokasi, submit form
                    event.target.submit();
                } else {
                    alert("Gagal mendapatkan lokasi, tidak bisa submit data.");
                }
            });
        }
    </script>
@endsection
