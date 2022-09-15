@extends('layouts.app2')
@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h3>Selamat, Registrasi berhasil</h3>
        <p class="lead">Hay <b>{{ $data['name'] }}</b>, terima kasih telah mendaftar. Silahkan screenshot nomor registrasi
            anda
            sebagai tiket masuk pada hari H</p>
        <h1>{{ $data['uuid'] }}</h1>
    </div>
@endsection
