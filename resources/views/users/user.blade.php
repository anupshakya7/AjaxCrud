@extends('layout.base')

{{-- Style --}}
@section('style')
<style>
    .pagination{
        justify-content: center;
    }
</style>
@endsection

{{-- Body --}}
@section('content')
<div class="container">
    @csrf
    @include('users.pagination')
</div>
@endsection

{{-- Script --}}
@section('script')
<script>
    $(document).ready(function(){
        $(document).on('click','.relative',function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page){
            var _token = $('input[name=_token]').val();
            $.ajax({
                url:"{{route('user.fetch')}}",
                method:"POST",
                data:{
                    _token:_token,
                    page:page
                }
                success:function(data){
                    console.log(data);
                    $('#table_data').html(data);
                }
            })
        }
    });
</script>
@endsection