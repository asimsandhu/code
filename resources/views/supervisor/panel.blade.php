    @extends('layouts.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

@endsection
    @section('content')
        <div class="main-panel" id="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="#pablo">Table List</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <form>
                            <div class="input-group no-border">
                                <input type="text" value="" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="now-ui-icons ui-1_zoom-bold"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <i class="now-ui-icons media-2_sound-wave"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Stats</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="now-ui-icons location_world"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Some Actions</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <i class="now-ui-icons users_single-02"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Account</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="panel-header panel-header-sm">
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> AGENT MANAGMENT</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead class=" text-primary">
                            <th>
                                Name
                            </th>
                            <th>
                               Email
                            </th>
                            <th>
                                Contact
                            </th>
                            <th>
                                Designation
                            </th>
                            <th>
                               Assigned Role
                            </th>
                            <th>
                                Role
                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                            <th>

                            </th>
                            </thead>
                           <tbody>

                           @foreach($user as $agent)
                           <tr>
                           <td>{{$agent->name}}</td>
                           <td>{{$agent->email}}</td>
                           <td>{{$agent->contact_no}}</td>
                           <td>{{$agent->designation}}</td>
                           <td>{{$agent->roles->pluck('name') }} <a href="remove">revoke</a></td>
                           <td>
                               <form action="assign_role" method="post">
                                   @csrf
                                   <select class="form-control" id="role_id" name="role">
                                   @foreach($roles as $role)

                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                   @endforeach

                                   </select>
                                   <input type="hidden" value="{{$agent->id}}" name="user_id">
                                   <input type="submit"  value=">">
                               </form>
                         </td>
                           <td><td><span id="edit" data-toggle="modal" data-target=".bd-example-modal-lg"
                                         onclick="showEditModal({{$agent->contact_no}})"><img class="cls_ponter" src="{{asset('assets/images/edit.png')}}" alt="" style="width:30px;"></span></td></td>
                           <td><button>delete</button></td>
                           </tr>
                           @endforeach

                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class=" container-fluid ">
                    <nav>

                        <ul>
                            <li>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">CREATE AGENT</button>

                            </li>

                            <li>
                                <button href="http://presentation.creative-tim.com">

                                </button>
                            </li>

                        </ul>
                    </nav>
                    <div class="copyright" id="copyright">
                        &copy; <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by <a href="https://www.creative-tim.com" target="_blank">INDUSTRUS</a>.
                    </div>
                </div>
            </footer>
        </div>
        </div>
        {{-----------Modal to assign role to user----------}}
        <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form" method="post" action="create_agent" >
                    </form>
                </div>
            </div>
        </div>
      {{-----------Modal to add agent----------}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form" method="post" action="create_agent" >

                        {{ csrf_field() }}

                        <div class="form-group row" >
                            <label for="inputPassword" class="col-md-3 col-form-label offset-md-1">Name</label>
                            <div class="col-sm-5 pull-left">
                                <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label offset-md-1">Email Address</label>
                            <div class="col-sm-5 pull-left">
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label offset-md-1">Contact number</label>
                            <div class="col-sm-5 pull-left">
                                <input type="number" class="form-control" id="inputPassword" name="contact_no">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label offset-md-1">Designation</label>
                            <div class="col-sm-5 pull-left">
                                <input type="text" class="form-control" id="inputPassword" name="designation">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label offset-md-1">Department</label>
                            <div class="col-sm-5 pull-left">
                                <input type="text" class="form-control" id="inputPassword" name="department">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-md-3 col-form-label offset-md-1">Role</label>
                            <div class="col-sm-5 pull-left">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label offset-md-1">password</label>
                            <div class="col-sm-5 pull-left">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-md-3 col-form-label offset-md-1">Confirm Password</label>
                            <div class="col-sm-5 pull-left">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label for="inputPassword" class="col-md-3 col-form-label offset-md-1"></label>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"  >Submit</button>
                            </div>

                        </div>
                    </form>

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