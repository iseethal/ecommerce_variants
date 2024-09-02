@include('template.navbar')

<style>
    .table th {
        width: 25%;
    }
</style>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


<div class="container ">
    <h4>ADD PRODUCT VARIANT OPTIONS</h4>

    <p>Product Details</p>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Product Name</th>
                <td>{{ $product->product_name }}</td>
            </tr>

            <tr>
                <th>Description</th>
                <td>{{ $product->description }} </td>
            </tr>

            <tr>
                <th>Price</th>
                <td>{{ $product->price }} </td>
            </tr>

            <tr>
                <th>Quantity</th>
                <td>{{ $product->quantity }}</td>
            </tr>
        </tbody>
    </table>


    @php
        $product_variants = App\Models\ProductVariant::where('product_id', $product->id)->get();
        $product_variant_options = App\Models\ProductVariantOption::with('variants')
            ->where('product_id', $product->id)
            ->get();
    @endphp

    @if (!$product_variants->isEmpty())
        <p>Product Variants</p>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Variant Name</th>
                    <th>Description</th>
                    <th>Delete</th>

                </tr>
                @foreach ($product_variants as $variants)
                    <tr>
                        <td>{{ $variants->variant_name }}</td>
                        <td>{{ $variants->description }} </td>
                        <td><a href="{{ route('product-variants.delete', $variants->id) }}" class="text-danger"><i
                                    class="fas fa-trash-alt"></i></a> </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endif

    @if (!$product_variant_options->isEmpty())
        <p>Product Variant Option</p>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Product Variant</th>
                    <th>Variant Name</th>
                    <th>Description</th>
                    <th>Delete</th>

                </tr>
                @foreach ($product_variant_options as $variants)
                    <tr>
                        <td>{{ $variants->variants->variant_name }}</td>
                        <td>{{ $variants->variant_option }}</td>
                        <td>{{ $variants->description }} </td>
                        <td><a href="{{ route('product-variant-option.delete', $variants->id) }}"
                                class="text-danger"><i class="fas fa-trash-alt"></i></a> </td>
                    </tr>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endif




    <form action="{{ route('products.save_product_variant_option', $product->id) }}" method="POST">
        @csrf
        <div class="container mt-5">
            <div class="row row-xs align-items-center mg-b-20">
                <div class="col-md-4">
                    <label class="mg-b-0"> <b>Add Product Variant Option </b></label>
                </div>
                <div class="col-md-8 mg-t-5 mg-md-t-0">
                    <button class="btn ripple btn-success" type="button" onclick="addRow()">Add Row</button>
                    <input type="hidden" id="row_cnt" name="row_cnt" value="0">
                </div>
            </div>
            <table id="myTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product variant </th>
                        <th>variant Option </th>
                        <th>description</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <br><br><br>
        <div class="row mt-4">
            <div class="col-md-6 text-start">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('products.index') }}" class="btn btn-danger">Back - Product List</a>
            </div>
        </div>
    </form>

</div>

<br><br><br>

<script>
    function addRow() {
        let rowcnt = document.getElementById("row_cnt").value;
        let row_cnt = Number(rowcnt);

        var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
        var row = table.insertRow();
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);


        let containerHTML = '<div class="d-flex align-items-center">';

        let variantOptions = '<select class="form-control" name="variant_id_' + row_cnt + '" id="variant_id_' +
            row_cnt + '" onchange="updateVariantId(' + row_cnt + ')">';
        variantOptions += '<option value="">Select Variant</option>';
        @foreach ($product_variants as $variant)
            variantOptions += '<option value="{{ $variant->id }}">{{ $variant->variant_name }}</option>';
        @endforeach
        variantOptions += '</select>';

        cell1.innerHTML = variantOptions;


        cell2.innerHTML = "<input class='form-control' name='variant_option_" + row_cnt + "' id='variant_option_" +
            row_cnt +
            "' placeholder=' Variant option' type='text'>";
        cell3.innerHTML = "<input class='form-control' name='description_" + row_cnt + "' id='description_" + row_cnt +
            "' placeholder=' Description' type='text'>";
        containerHTML += '</div>';

        cell4.innerHTML =
            '<button type="button" class="btn ripple btn-danger" onclick="deleteRow(this)">Delete</button>';

        let cnt = 1;
        let new_cnt = row_cnt + cnt;
        document.getElementById("row_cnt").value = new_cnt;
    }

    function deleteRow(button) {
        var row = button.closest('tr');
        row.parentNode.removeChild(row);
    }
</script>
