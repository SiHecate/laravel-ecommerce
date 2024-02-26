<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
</head>
<body class="antialiased">
<div style="display: flex; gap: 3rem;">
    @foreach($basket['product_datas'] as $product)
        <div class="flex: 1">
            <h5>{{ $product['title'] }}</h5>
            <p>${{ $product['price'] }}</p>
        </div>
    @endforeach
</div>
<p>
<form action="{{ route('checkout') }}" method="POST">
    @csrf
    <button>Checkout</button>
</form>
</p>
</body>
</html>
