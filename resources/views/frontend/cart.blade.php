@include('frontend.template.navbar')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container mt-4">

    @if (session('cart'))
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4> Cart Details</h4>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Variant</th>
                    <th scope="col">Variant Option</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th>Add Quantity</th>
                    <th>Total Price</th>
                    <th>Update</th>
                    <th scope="col">Delete </th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp

                @foreach (session('cart') as $id => $cart_items)
                    @php
                        if (!empty($cart_items['variant_id'])) {
                            $variant = App\Models\ProductVariant::where('id', $cart_items['variant_id'])
                                ->pluck('variant_name')
                                ->first();
                        } else {
                            $variant = '';
                        }
                        if (!empty($cart_items['variant_option_id'])) {
                            $variant_option = App\Models\ProductVariantOption::where(
                                'id',
                                $cart_items['variant_option_id'],
                            )
                                ->pluck('variant_option')
                                ->first();
                        } else {
                            $variant_option = '';
                        }
                    @endphp
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td> {{ $cart_items['product_name'] }}</td>
                        <td> {{ $variant }}</td>
                        <td> {{ $variant_option }}</td>
                        <td> {{ $cart_items['quantity'] }} </td>
                        <td>
                            <span id="price-{{ $cart_items['id'] }}" class="discounted-price">₹
                                {{ $cart_items['price'] }}</span>
                        </td>
                        <td>
                            <div class="mx-0 pt-0">
                                <input class="form-input" name="product_qty" id="product_qty_{{ $cart_items['id'] }}"
                                    type="number" min="1" max="100" step="1"
                                    value="{{ $cart_items['quantity'] }}"
                                    style="width: 80px; height: 50px; text-align: center;"
                                    onchange="calculateAmount({{ $cart_items['id'] }})">
                                <input id="product_price_{{ $cart_items['id'] }}" hidden type="text"
                                    value="{{ $cart_items['price'] }}">
                                <input name="product_id" id="product_id_{{ $cart_items['id'] }}" hidden type="text"
                                    value="{{ $cart_items['id'] }}">
                            </div>
                        </td>
                        <td> <span id="price-new-{{ $cart_items['id'] }}" class="discounted-price">
                                {{ $cart_items['total_price'] }} </span></td>

                        <td><button class="btn btn-primary" onclick="updateCart({{ $id }})">Update</td>

                        <td>
                            <a href="{{ route('cart.delete', $id) }}" class="text-danger"><i
                                    class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach

                @php
                    $subtotal = 0;

                    foreach (session('cart') as $id => $cart_items) {
                        $subtotal += $cart_items['total_price'];
                    }

                @endphp

                <tr>
                    <td colspan="7" class="text-end"><strong>Subtotal:</strong></td>
                    <td><span id="cart-subtotal" class="discounted-price">₹ {{ $subtotal }}</span>
                    </td>
                    <td></td>
                </tr>

            </tbody>
        </table>
    @else
        <p style="padding-top: 50px;text-align:center;font-size:25px">Your cart is empty</p>
    @endif
</div>

<script type="text/javascript">
    function calculateAmount(productId) {
        var quantity = document.getElementById('product_qty_' + productId).value;
        var price = document.getElementById('product_price_' + productId).value;

        var calculatedAmount = quantity * price;

        document.getElementById('price-new-' + productId).innerHTML = '₹ ' + calculatedAmount;
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function updateCart(productId) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var quantity = document.getElementById('product_qty_' + productId).value;
        var price = document.getElementById('product_price_' + productId).value;
        var totalPrice = quantity * price;

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        formData.append('price', price);
        formData.append('totalPrice', totalPrice);

        $.ajax({

            type: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            url: "{{ route('frontend.update-cart') }}",
            data: formData,
            success: function(response) {
                alert('cart updated successfully!');
                window.location.reload();

            },
            error: function(xhr) {
                alert('Failed to update cart.');
            }

        });
    }
</script>
