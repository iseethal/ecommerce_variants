<?php
use Illuminate\Support\Facades\Session;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

@php
    if (session::has('cart')) {
        $cartcount = count(Session::get('cart', []));
    }
@endphp

<body>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Frontend</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('frontend.all-products') }}">Products <span
                                class="sr-only"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('frontend.cart') }}">Cart</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">


                    <li class="nav-item" id="cart-item" style="display: none;">
                        <a class="nav-link" href="#"> Cart Count: <span id="cart-count">0</span></a>
                    </li>

                    <li class="nav-item" id="cart-item1">
                        <a class="nav-link" href="#"> Cart Count: <span
                                id="cart-count1">{{ $cartcount }}</span></a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="/products"><b>Go To Backend</b></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</body>

</html>
