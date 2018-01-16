@extends('layout.app')
@section('content')

    <!-- START USER -->
    <!-- Untuk mengambil info dari mesin -->
    <form method="post" action="#">
        <input type="hidden" name="url_user" id="url_user" value="">
        <div class="row">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" id="b_GetUser">
                    Get All User
                </button>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" id="b_DelUser">
                    Delete All User
                </button>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" id="b_SetAllUser">
                    Set All User
                </button>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" id="b_delUserDB">
                    Clear User in Database
                </button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <div class="col-xs-6">
                    <input type="text" class="form-control" placeholder="PIN" id="i_setUser" name="i_setUser"
                           style="width:120px">
                </div>
                <div class="col-xs-6">
                    <button type="button" class="btn btn-primary btn-block" id="b_SetUser" style="width:133px">
                        Set User
                    </button>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-xs-6">
                    <input type="text" class="form-control" placeholder="PIN" id="i_delUser" name="i_delUser"
                           style="width:120px">
                </div>
                <div class="col-xs-6">
                    <button type="button" class="btn btn-primary btn-block" id="b_delUserPIN" style="width:160px">
                        Delete User Pin Mesin
                    </button>
                </div>
            </div>
        </div>
        <br>
        <table class="table table-hover">
                <tr>
                    <th>PIN</th>
                    <th>Nama</th>
                    <th>Password</th>
                    <th>RFID</th>
                    <th>Privilege</th>
                </tr>
            <tbody id="result_body_user"></tbody>
        </table>
    </form>
    <!-- END USER -->

@endsection


@section('script')

    <script src="{{ url('script/user/user.js') }}"></script>

@endsection