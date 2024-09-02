@include('template.navbar')

<style>
    .table th {
        width: 25%;
    }
</style>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


<div class="container ">
    <h4>ADD PRODUCT VARIANT</h4>

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

    <form action="{{ route('products.save_product_variants', $product->id) }}" method="POST">
        @csrf
        <div class="container mt-5">
            <div class="row row-xs align-items-center mg-b-20">
                <div class="col-md-4">
                    <label class="mg-b-0"> <b>Add Product Variants </b></label>
                </div>
                <div class="col-md-8 mg-t-5 mg-md-t-0">
                    <button class="btn ripple btn-success" type="button" onclick="addRow()">Add Row</button>
                    <input type="hidden" id="row_cnt" name="row_cnt" value="0">
                </div>
            </div>
            <table id="myTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th> variant_name </th>
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

            @if (!$product_variants->isEmpty())
                <div class="col-md-6 text-end">
                    <div class="col-md-6 text-end">
                        <a href="{{ route('products.add_product_variant_option', ['id' => $product['id']]) }}"
                            class="btn btn-danger">Next - Add Variant Options</a>
                    </div>
                </div>
            @endif
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

        let containerHTML = '<div class="d-flex align-items-center">';


        cell1.innerHTML = "<input class='form-control' name='variant_name_" + row_cnt + "' id='variant_name_" +
            row_cnt +
            "' placeholder=' Variant name' type='text'>";
        cell2.innerHTML = "<input class='form-control' name='description_" + row_cnt + "' id='description_" + row_cnt +
            "' placeholder=' Description' type='text'>";
        containerHTML += '</div>';

        cell3.innerHTML =
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
