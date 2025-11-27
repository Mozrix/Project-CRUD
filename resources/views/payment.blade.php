<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>
<body>
    <div class="container my-5 py-5">
        <div class="detail row my-centered-block mx-auto text-center">
            <div class="my-centered-block mx-auto verif">
                <img class="logo" src="{{ asset('image/verify.png') }}" alt="">
            </div>
            <p class="my-3 prod-name">Booking Berhasil!</p>
            <div class="my-centered-block mx-auto verif">
                <img class="qris py-3" src="{{ asset('image/qris.png') }}" alt="">
            </div>
            <p class="my-3 prod-name">Bayar DP 50% sesuai dengan harga yang telah anda booking!</p>
            <button class="btn btn-primary">Konfirmasi Pembayaran</button>
        </div>
    </div>
</body>
<script src="{{ asset('js/payment.js') }}"></script>
</html>