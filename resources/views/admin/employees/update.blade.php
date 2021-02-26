@extends('admin.layouts.main')
@section('content')
    <div class="content col-sm-9 col-sm-push-3">
        <h2 style="text-align: center;padding:5px 10px;">edit employee</h2>
        <form action="{{ route('employees.update',$record->id) }}" method="post" class="form-horizontal">
            {{  csrf_field() }}
            {{  method_field('PUT') }}
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">First name</label>
                <div class="col-sm-10">
                    <input type="text" name="First_name" id="First_name" value="{{$record->First_name}}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">last name</label>
                <div class="col-sm-10">
                    <input type="text" name="last_name" id="last_name" value="{{$record->last_name}}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">email</label>
                <div class="col-sm-10">
                    <input type="text" name="email" id="email"  value="{{$record->email}}" class="form-control" >
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">company</label>
                <div class="col-sm-10">
                    <select name="Company" id="Company" class="form-control">
                        @foreach($companies as $item)
                            <option value="{{$item->id}}" @if($item->id == $record->Company) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">phone</label>
                <div class="col-sm-10">
                    <input type="text" name="phone" id="phone" value="{{$record->phone}}" class="form-control">
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