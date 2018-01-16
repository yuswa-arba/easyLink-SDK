@extends('layout.app')
@section('content')

    <!-- START INFO -->
    <!-- Untuk mengambil info dari mesin -->
    <form method="post" action="#">
        <div class="col-sm-4">
            <h3>Device Info</h3>
            <button type="button" class="btn btn-primary btn-block" value="" id="b_infoDev">Device Info</button>
        </div>
    </form>

    <div class="col-sm-12">
        <br><textarea id="result_success_info" class="form-control" placeholder="Result" readonly="readonly"></textarea>
    </div>
    <!-- END INFO -->

@endsection


@section('script')

    <script src="{{ url('script/info/info.js') }}"></script>

@endsection