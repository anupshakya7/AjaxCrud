@extends('layout.base')
@section('style')
<style>
    .pagination{
        justify-content: center;
    }
</style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2 class="my-4 text-center">Laravel 9 Ajax Crud</h2>
                <button type="button" class="btn btn-primary btn-sm float-end my-2" data-bs-toggle="modal" data-bs-target="#productModal">
                    Add Product
                  </button>
                <div class="table-data">
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
                                <a href="" class="btn btn-success update_product_form" data-bs-toggle="modal" data-bs-target="#editProductModal" data-id="{{$product->id}}" data-name="{{$product->name}}" data-price="{{$product->price}}"><i class="las la-edit"></i></a>
                                <a href="" class="btn btn-danger"><i class="las la-trash"></i></a>
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                      {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
    @include('products.modal')
    @include('products.editmodal')
@endsection

@section('script')
<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(document).ready(function(){
        $(document).on('click','.add_product',function(e){
            e.preventDefault();
            let name = $('#name').val();
            let price = $('#price').val();

            // console.log(name+price);
            $.ajax({
                url:"{{route('product.store')}}",
                method:'POST',
                data:{
                    name:name,
                    price:price
                },
                success:function(res){
                    if(res.status == 'success'){
                        $('#productModal').modal('hide');
                        $('#addProductForm')[0].reset();
                        $('.table').load(location.href+' .table');
                    }
                },
                error:function(err){
                    let error = err.responseJSON;
                    $.each(error.errors,function(index,value){
                        $('.errorMsgContainer').append('<span class="text-danger">'+value+'</span>'+'<br>');
                    });
                }
            });
        });

        //Show Product Value in Update Form
        $(document).on('click','.update_product_form',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');
            $('#product_id').val(id);
            $('#product_name').val(name);
            $('#product_price').val(price);
        });
    });
</script>
@endsection