<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link href="https://cdn.bootcss.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="https://cdn.bootcdn.net/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" rel="stylesheet">
    <script src="https://cdn.bootcdn.net/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.min.js"></script>
</head>
<style>
    .sidebar{
        background:#0d3625;
        padding:5px 10px;
        position:absolute;
        left:0;
        bottom:0;
        top:60px;
    }
    .content{
        background:#fff;
        padding:5px 10px;
        position:absolute;
        top:60px;
        bottom:0;
    }
    .content .table-bordered{

    }
    .topheader{
        height: 60px;
        background:pink;
        padding:5px 10px;
        margin:0;
        text-align: center;
    }
    .container{
        width:100%;
        padding:0;
        magin:0;
        padding-bottom:1px;
        height: 100%;
    }
    body,html{
        padding:0;
        magin:0;
    }
    .text-pull-right{
        text-align: right;
    }
</style>
<body>
<div class="container">
    <h2 class="topheader"><em class="pull-left"></em>admin dashboard<a class="pull-right" href="/admin/logout">logout</a></h2>
    <div class="col-sm-3 sidebar">
        <p><a href="/admin/companies" class="btn btn-info btn-block">company list</a></p>
        <p><a href="/admin/employees" class="btn btn-info btn-block">employee list</a></p>
    </div>
    @yield('content')
</div>
</body>
@include('flash::message');
<script>
    $('#flash-overlay-modal').modal();
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    })
</script>
</html>