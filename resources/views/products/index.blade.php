@include('template.navbar')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4> PRODUCT LIST</h4>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Variants & Variant Options</th>
                <th scope="col">Action </th>

            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($products as $product)
                @php
                    $product = App\Models\Product::find($product->id);
                    $variantOptions = $product->variantOptions;
                    $variants = app\Models\ProductVariant::where('product_id', $product->id)->get();

                @endphp
                <tr>
                    <td scope="row">{{ $i++ }}</td>
                    <td> {{ $product->product_name }} </td>
                    <td> {{ $product->description }} </td>
                    <td> {{ $product->price }} </td>
                    <td> {{ $product->quantity }} </td>

                    <td>
                        {{-- check the variants are available and the variant options are not available --}}

                        @if (!$variants->isEmpty() && $variantOptions->isEmpty())
                            @foreach ($variants as $variant)
                                <b>{{ $variant->variant_name }}</b> - {{ $variant->description }} <br>
                            @endforeach

                            {{-- check the variant options  are available or not --}}
                        @elseif ($variantOptions->isEmpty())
                            <b>No variants or variant options are available</b>
                        @else
                            @foreach ($variantOptions as $options)
                                @php
                                    $variant = $options->variants;
                                @endphp
                                <b>{{ $variant->variant_name }}</b> - {{ $variant->description }} ,
                                &nbsp;&nbsp;&nbsp;<b>{{ $options->variant_option }}</b> -
                                {{ $options->description }}
                                <br>
                            @endforeach
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="text-primary me-2"><i
                                class="fas fa-edit"></i></a>

                        <a href="{{ route('project.destroy', $product->id) }}" class="text-danger"><i
                                class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
</div>
