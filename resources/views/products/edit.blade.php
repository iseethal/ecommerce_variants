@include('template.navbar')

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


<div class="container">
    <h4>EDIT PRODUCT</h4>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Product Name -->
        <div class="form-group mb-3">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control"
                value="{{ $product->product_name }}" placeholder="product name" required>
            @error('product_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="description">{{ $product->description }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="form-group mb-3">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}"
                step="1" placeholder="price" required>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $product->quantity }}"
                min="1" placeholder="quantity" required>
            @error('quantity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <hr>

        @if (!$product_variants->isEmpty())
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p><b>Product Variants</b></p>
                <a href="{{ route('products.add_product_variant', ['id' => $product['id']]) }}"
                    class="btn btn-success">Add Variant</a>
            </div>

            <table class="table table-bordered mt-3">
                <tbody>
                    <tr>
                        <th>Variant Name</th>
                        <th>Description</th>
                    </tr>
                    @foreach ($product_variants as $variants)
                        <tr>
                            <td>{{ $variants->variant_name }}</td>
                            <td>{{ $variants->description }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>

        @endif


        @if (!$variant_options->isEmpty())

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <p><b>Product Variant Option</b></p>
                <a href="{{ route('products.add_product_variant_option', ['id' => $product['id']]) }}"
                    class="btn btn-success">Add Variant Option</a>
            </div>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Product Variant</th>
                        <th>Variant Name</th>
                        <th>Description</th>
                    </tr>
                    @foreach ($variant_options as $variants)
                        <tr>
                            <td>{{ $variants->variants->variant_name }}</td>
                            <td>{{ $variants->variant_option }}</td>
                            <td>{{ $variants->description }} </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @endif

        <br><br>

        <div class="row mt-4">
            <div class="col-md-6 text-start">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

            @if ($product_variants->isEmpty())
                <div class="col-md-6 text-end">
                    <a href=" {{ route('products.add_product_variant', ['id' => $product['id']]) }}"
                        class="btn btn-danger">Next - Add Variants</a>
                </div>
            @endif

            @if (!$product_variants->isEmpty())
                <div class="col-md-6 text-end">
                    <a href=" {{ route('products.add_product_variant_option', ['id' => $product['id']]) }}"
                        class="btn btn-danger">Next - Add Variant Options</a>
                </div>
            @endif

            <br><br> <br><br>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select2').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
    });
</script>
