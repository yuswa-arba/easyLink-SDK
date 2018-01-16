@extends('layout.app')
@section('content')

    <!-- START SCAN LOG -->
    <!-- Untuk mengambil info dari mesin -->
    <form method="post" action="#">

        <div class="row">
            <input type="hidden" id="url_scan" value="">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" id="b_allScan">Get All Scanlog</button>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" id="b_delScan">Delete Scanlog</button>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" id="b_delScanDB">Clear Scanlog in Database
                </button>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-block" id="b_getNewScan">Get New Scanlog</button>
            </div>
        </div>

        <br>

        <table class="table table-hover">
            <tr>
                <th>Serial Number</th>
                <th>Scan Date</th>
                <th>PIN</th>
                <th>Verify Mode</th>
                <th>IO Mode</th>
                <th>Work Code</th>
            </tr>

            <tbody id="result_body_scan">

            @foreach($get_scans as $data)
                <tr>
                    <td>{{ $data->sn }}</td>
                    <td>{{ $data->scan_date }}</td>
                    <td>{{ $data->pin }}</td>
                    <td>{{ $data->verifymode }}</td>
                    <td>{{ $data->iomode }}</td>
                    <td>{{ $data->workcode }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </form>
    <!-- END SCAN LOG -->

@endsection


@section('script')

    <script src="{{ url('script/scanLog/scanlog.js') }}"></script>

    <script src="{{ url('script/scanLog/scan-echo.js') }}"></script>

@endsection