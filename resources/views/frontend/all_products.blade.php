@include('frontend.template.navbar')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4> All Products</h4>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Description</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th>Add Quantity</th>
                <th>Total Price</th>
                <th scope="col">Variants </th>
                <th scope="col">Variant Options </th>
                <th scope="col">Add to cart </th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($products as $product)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td> {{ $product->product->product_name }} </td>
                    <td> {{ $product->product->description }} </td>
                    <td> {{ $product->product->quantity }} </td>

                    <td>
                        <span id="price-{{ $product['id'] }}" class="discounted-price">₹
                            {{ $product->product['price'] }}</span>
                    </td>
                    <td>
                        <div class="mx-0 pt-0">
                            <input class="form-input" name="product_qty" id="product_qty_{{ $product['id'] }}"
                                type="number" min="1" max="100" step="1" value="1"
                                style="width: 80px; height: 50px; text-align: center;"
                                onchange="calculateAmount({{ $product['id'] }})">
                            <input id="product_price_{{ $product['id'] }}" hidden type="text"
                                value="{{ $product->product['price'] }}">
                            <input name="product_id" id="product_id_{{ $product['id'] }}" hidden type="text"
                                value="{{ $product['id'] }}">
                        </div>
                    </td>
                    <td> <span id="price-new-{{ $product['id'] }}" class="discounted-price"></span></td>
                    <td> {{ $product->variants->variant_name }} : {{ $product->variants->description }} </td>
                    <td> {{ $product->variant_option }} : {{ $product->description }} </td>
                    <input id="variant_option_id_{{ $product['id'] }}" hidden
                        type="text"value="{{ $product['id'] }}">

                    <input id="variant_id_{{ $product['id'] }}" hidden
                        type="text"value="{{ $product['product_variant_id'] }}">
                    <td>
                        <button class="btn btn-primary" onclick="addToCart({{ $product['id'] }})">Add To Cart
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script type="text/javascript">
    function calculateAmount(productId) {
        var quantity = document.getElementById('product_qty_' + productId).value;
        var price = document.getElementById('product_price_' + productId).value;

        var calculatedAmount = quantity * price;

        document.getElementById('price-new-' + productId).innerHTML = '₹ ' + calculatedAmount;
    }
</script>
<script>
    function addToCart(productId) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var variant_option_id = document.getElementById('variant_option_id_' + productId).value;
        var variant_id = document.getElementById('variant_id_' + productId).value;
        var quantity = document.getElementById('product_qty_' + productId).value;
        var price = document.getElementById('product_price_' + productId).value;
        var totalPrice = quantity * price;

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        formData.append('price', price);
        formData.append('totalPrice', totalPrice);
        formData.append('variant_option_id', variant_option_id);
        formData.append('variant_id', variant_id);


        $.ajax({
            type: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            url: "{{ route('frontend.add-to-cart') }}",
            data: formData,
            success: function(response) {
                alert('Product added to cart successfully!');
            },
            error: function(xhr) {
                alert('Failed to add product to cart.');
            }
        });

        function updateCartCount() {
            fetch('{{ route('cart.count') }}')
                .then(response => response.json())
                .then(data => {
                    var newCartItem = document.getElementById('cart-item');
                    var oldCartItem = document.getElementById('cart-item1');
                    var cartCountElement = document.getElementById('cart-count');

                    if (data.count > 0) {
                        newCartItem.style.display = 'block';
                        oldCartItem.style.display = 'none';
                        cartCountElement.innerText = data.count;
                    } else {
                        newCartItem.style.display = 'none';
                        oldCartItem.style.display = 'block';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            setInterval(updateCartCount, 10000);
        });

    }
</script>
