<table class="table table-bordered mt-3" id="table_data">
    <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    @foreach($user as $users)
    <tr>
        <td>{{$users->id}}</td>
        <td>{{$users->name}}</td>
        <td>{{$users->email}}</td>
    </tr>
    @endforeach
</table>

{!! $user->onEachSide(1)->links() !!}