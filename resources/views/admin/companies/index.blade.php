@extends('admin.layouts.main')
@section('content')
<div class="content col-sm-9 col-sm-push-3">
    <a href="{{ route('companies.create') }}">add company</a>
    <a href="{{ route('companies.export') }}" target="_blank" class="btn btn-info pull-right">export as excel</a>

    <h2>company list</h2>
    <table class="table table-bordered table-responsive">
        <tr>
            <th>company name</th>
            <th>email</th>
            <th>logo</th>
            <th>action</th>
        </tr>
        @foreach($companies as $item)
            <tr>
                <td>{{$item->name}}</td>
                <td>{{$item->email}}</td>
                <td><img width=60 src="/storage/{{$item->logo}}"></td>
                <td>
                    <a href="{{ route('companies.edit', $item->id) }}" class="btn btn-info">edit</a>
                    <a href="javascript:;" onclick="del({{$item->id}})" class="btn btn-danger">delete</a>
                </td>
            </tr>
        @endforeach
        <tr class="text-pull-right">{{ $companies->links() }}</tr>
    </table>
</div>
    <script>
        function del(id) {
            BootstrapDialog.confirm({
                title : 'confirm',
                message : "confirm to delete?",
                type : BootstrapDialog.TYPE_WARNING,
                closable : true,
                draggable : true,
                btnCancelLabel : 'cancel',
                btnOKLabel : 'confirm',
                btnOKClass : 'btn-warning',
                size : BootstrapDialog.SIZE_SMALL,
                onhide : function () {

                },
                callback : function(result) {
                    if (result) {
                        $.ajax({
                            url: "/admin/companies/" + id,
                            method: 'DELETE',
                            success: function(response){
                                BootstrapDialog.show({'message':response.message})
                            }
                        })
                    }
                }
            });
        }
    </script>
@stop