<table class="table table-bordered text-center shadow">
    <thead>
      <tr>
        <th scope="col">S.No</th>
        <th scope="col">Name</th>
        <th scope="col">Price</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
    @foreach($products as $key=>$product)
      <tr>
        <td>{{$key+1}}</td>
        <td>{{$product->name}}</td>
        <?php
            $formattedPrice = number_format($product->price,2,'.',',');
        ?>
        <td>{{$formattedPrice}}</td>
        <td>
            <a href="" class="btn btn-success update_product_form my-1" data-bs-toggle="modal" data-bs-target="#editProductModal" data-id="{{$product->id}}" data-name="{{$product->name}}" data-price="{{$product->price}}"><i class="las la-edit"></i></a>
            <a href="" class="btn btn-danger delete_product_form my-1" data-id="{{$product->id}}"><i class="las la-trash"></i></a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {!! $products->links() !!}