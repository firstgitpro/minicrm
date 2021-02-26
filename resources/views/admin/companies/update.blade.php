@extends('admin.layouts.main')
@section('content')
    <div class="content col-sm-9 col-sm-push-3">
        <h2 style="text-align: center;padding:5px 10px;">edit company</h2>
        <form action="{{ route('companies.update',$item->id) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">company name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="name" value="{{$item->name}}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">email</label>
                <div class="col-sm-10">
                    <input type="text" name="email" value="{{$item->email}}" id="email" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">logo</label>
                <div class="col-sm-10">
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">save</button>
                </div>
            </div>
        </form>
    </div>
@stop