@include('template.navbar')

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


<div class="container">
    <h4>ADD PRODUCT</h4>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <!-- Product Name -->
        <div class="form-group mb-3">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control"
                value="{{ old('product_name') }}" placeholder="product name" required>
            @error('product_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="form-group mb-3">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"
                step="1" placeholder="price" required>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}"
                min="1" placeholder="quantity" required>
            @error('quantity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <br><br>

        <div class="form-group mb-3 text-right">
            <button type="submit" class="btn btn-primary">Next</button>
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
