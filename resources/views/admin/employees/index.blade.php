@extends('admin.layouts.main')
    @section('content')
    <div class="content col-sm-9 col-sm-push-3">
        <a href="{{ route('employees.create') }}">add employee</a>
        <a href="{{ route('employees.export') }}" target="_blank" class="btn btn-info pull-right">export as pdf</a>
        <h2>employee list</h2>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>First name</th>
                <th>last name</th>
                <th>email</th>
                <th>phone</th>
                <th>Company</th>
                <th>action</th>
            </tr>
            @foreach($employees as $item)
                <tr>
                    <td>{{$item->First_name}}</td>
                    <td>{{$item->last_name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->phone}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                        <a href="{{ route('employees.edit',$item->id) }}" class="btn btn-info">edit</a>
                        <a href="javascript:;" onclick="del({{$item->id}})" class="btn btn-danger">delete</a>
                    </td>
                </tr>
            @endforeach
            <tr>{{ $employees->links() }}</tr>
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
                                url: "/admin/employees/" + id,
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
