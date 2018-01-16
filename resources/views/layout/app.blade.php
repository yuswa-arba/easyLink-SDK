<!DOCTYPE html>
<html lang="en">
<head>
    <title>Client Easylink SDK</title>
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
    <link href="{{ url('css/simple-sidebar.css') }}" rel="stylesheet">
    <link type="image/gif" href="{{ url('images/favicon.gif') }}" rel="icon">
</head>
<body>
<div id="wrapper">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand"><a href="user">EasyLink SDK</a></li>
            <li><a href="user">Data User</a></li>
            <li><a href="scanlog">Data Scanlog</a></li>
            <li><a href="info">Info</a></li>
            <li><a href="setting">Settings</a></li>
        </ul>
    </div>

    @yield('content')
</div>
<script src="{{ url('http://localhost:6005/socket.io/socket.io.js') }}"></script>
<script src="{{ url('js/app.js') }}"></script>
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
@yield('script')
</body>
</html>