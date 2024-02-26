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
            <div class="col-md-12">
                <h2 class="my-4 text-center">List of Mobiles</h2>
                <button type="button" class="btn btn-primary btn-sm float-end my-2" data-bs-toggle="modal" data-bs-target="#productModal">
                    Add Product
                  </button>
                  <input type="text" name="search" id="search" class="mb-3 form-control" placeholder="Search Here...">
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
                                <a href="" class="btn btn-success update_product_form my-1" data-bs-toggle="modal" data-bs-target="#editProductModal" data-id="{{$product->id}}" data-name="{{$product->name}}" data-price="{{$product->price}}"><i class="las la-edit"></i></a>
                                <a href="" class="btn btn-danger delete_product_form my-1" data-id="{{$product->id}}"><i class="las la-trash"></i></a>
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
        //Add Product Value
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
                        toastrMessage('Product Added Successfully!!!');
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

        //Update Product Data
         $(document).on('click','.edit_product',function(e){
            e.preventDefault();
            let update_id = $('#product_id').val();
            let update_name = $('#product_name').val();
            let update_price = $('#product_price').val();

            $.ajax({
                url:"{{route('product.update')}}",
                method:'POST',
                data:{
                    update_id:update_id,
                    update_name:update_name,
                    update_price:update_price
                },
                success:function(res){
                    if(res.status == 'success'){
                        $('#editProductModal').modal('hide');
                        $('#editProductForm')[0].reset();
                        $('.table').load(location.href+' .table');
                        toastrMessage('Product Updated Successfully!!!');
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

        //Delete Product Data
        $(document).on('click','.delete_product_form',function(e){
            e.preventDefault();
            var product_id = $(this).data('id');    
            if(confirm('Are you sure to delete product ??')){
                $.ajax({
                    url:"{{route('product.delete')}}",
                    method:'POST',
                    data:{
                        product_id: product_id,
                    },
                    success:function(res){
                        if(res.status == 'success'){
                            $('.table').load(location.href+' .table');
                            toastrMessage('Product Deleted Successfully!!!');
                        }
                    }
                });
            }
        });

        //Pagination
        $(document).on('click','.pagination a',function(e){
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            product(page);
        });

        function product(page){
            $.ajax({
                url:'products/paginate-data?page='+page,
                success:function(res){
                    $('.table-data').html(res);
                }
            });
        }

        //Search Product
        $(document).on('keyup',function(e){
            e.preventDefault();
            let search = $('#search').val();
            $.ajax({
                url:"{{route('product.search')}}",
                method:'GET',
                data:{
                    search:search
                },
                success:function(res){
                    $('.table-data').html(res);
                    if(res.status == 'nothing_found'){
                        $('.table-data').html('<span class="text-danger">'+'Nothing Found'+'</span>');
                    }
                }

            })
        });

        //Toastr Message
        function toastrMessage(message){
            Command: toastr["success"](message)
                toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                }

        }
    });
</script>
@endsection