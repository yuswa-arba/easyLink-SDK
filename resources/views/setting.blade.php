@extends('layout.app')
@section('content')

    <!-- START SETTING -->
    <!-- Untuk mengambil info dari mesin -->
    <div id="page-content-wrapper">
        <div class="container-fluid">

            <form method="get" action="#">
                <h3>Device Settings</h3>
                <div class="col-sm-4">
                    <input type="hidden" id="url_finger" name="url_finger" value="test">
                    <button type="button" class="btn btn-primary btn-block" id="b_syncDT">Sync Date Time</button>
                    <button type="button" class="btn btn-primary btn-block" id="b_delAdm">Delete Admin</button>
                    <button type="button" class="btn btn-primary btn-block" id="b_delLog">Delete Device Log</button>
                    <button type="button" class="btn btn-primary btn-block" id="b_init">Initialization</button>
                </div>
            </form>

            <div class="col-sm-8"></div>

            <div class="col-sm-12">
                <br><textarea id="responses_success" class="form-control" placeholder="Result"
                          readonly="readonly"></textarea>
            </div>

            <div class="col-sm-8"></div>

            <div class="col-sm-12"><br>
                <div class="alert alert-danger hide" id="responses_error"></div>
            </div>

        </div>
    </div>
    <!-- END SETTING -->

@endsection


@section('script')

    <script src="{{ url('script/setting/setting.js') }}"></script>

@endsection