@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

@endsection

@section('content')
    <div class="main-panel" id="main-panel">
            <div class="panel-header panel-header-sm">
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Working Hours</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead class=" text-primary">
                            <th>
                                Name
                            </th>
                            <th>
                                login
                            </th>
                            <th>
                                logout
                            </th>
                            <th>
                                total time
                            </th>
                            </thead>
                            <tbody>

            @foreach($detail as  $agent)
                                <tr>

                                    <td>{{$agent->name}}</td>
                                    <td>{{$agent->login_dt}}</td>
                                    <td>{{$agent->logout_dt}}</td>
                                    <td>{{$agent->total_time}}</td>

                                </tr>

            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

@endsection
@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>


        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>

@endsection
