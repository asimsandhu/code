@extends('layouts.master')

@section('content')

        <!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Lato', sans-serif
        }

        label {
            color: #333
        }

        .btn-success {
            background-color: green;
        }

        .help-block.with-errors {
            color: #ff5050;
            margin-top: 5px
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">CREATE</button>
    <div class="panel-header panel-header-sm">
    </div>
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">AGENT PORTAL</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class=" text-primary">
                    <th>
                        cellno
                    </th>
                    <th>
                        sub_name
                    </th>
                    <th>
                        gender
                    </th>
                    <th>
                        first_call_dt
                    </th>
                    <th>
                        last_call_dt
                    </th>
                    <th>
                        province
                    </th>
                    <th>
                        city
                    </th>
                    <th>
                        village
                    </th>
                    <th>district</th>


                    <th>
                        location
                    </th>
                    <th>
                        age
                    </th>
                    <th>
                        occupation
                    </th>
                    <th>
                        feedback
                    </th> <th>
                       action
                    </th>

                    </thead>
                    <tbody>
                    @foreach($sub as $subs)
                   <tr>
                       <td>{{$subs->cellno}}
                       </td>
                       <td>
                           {{$subs->sub_name}}
                        </td><td>
                           {{$subs->gender}}
                       </td><td>{{$subs->first_call_dt}}
                       </td><td>{{$subs->last_call_dt}}

                       </td><td>{{$subs->province}}

                       </td><td>{{$subs->city}}

                       </td><td>{{$subs->village}}

                       </td><td>{{$subs->district}}

                       </td><td>{{$subs->location}}

                       </td><td>{{$subs->age}}

                       </td>
                       <td>{{$subs->occupation}}</td>
                       <td>{{$subs->feedback}}</td>
                       <td><span id="edit" data-toggle="modal" data-target=".bd-example-modal-lg"
                                 onclick="showEditModal({{ $subs->cell_no }})"><img class="cls_ponter" src="{{asset('assets/images/edit.png')}}" alt="" style="width:30px;"></span></td>
                       <td><a href="/delete_sub">DELTE</a></td>
                       <td></td>
                   </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <form id="contact-form" role="form" method="post" action="create_subscriber">
                        {{ csrf_field() }}

                        <div class="controls">
                            <div class="row">
                                <!--CELL NO-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cellno">Cell no *</label>
                                        <input id="cell" type="number" class="form-control" placeholder="Enter your Cell no." name="cellno">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="NAME">Subscriber name</label>
                                        <input id="name" type="name" class="form-control" placeholder="Enter Subscriber name." name="sub_name">
                                    </div>
                                </div>
                                <!--GENDER-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender *</label>
                                        <select id="gender" class="form-control" name="gender">
                                            <option value="" selected disabled>--Select Your Gender--</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>


                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!--PROVINCE-->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province">Please specify your province *</label>
                                        <select id="province" class="form-control" name="province">
                                            <option value="" selected disabled>--Select Your Province--</option>
                                            <option value="punjab">Punjab</option>
                                            <option value="sindh">Sindh</option>
                                            <option value="Baluchustan">Balochistan</option>
                                            <option value="KPK">Khyber Pakhtunkhwa</option>
                                            <option value="FATA">federally-administered Islamabad Capital Territory.</option>

                                        </select> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label for="city">Please specify your City *</label>
                                        <select id="city" class="form-control"  name="city">
                                            <option value="" selected disabled>--Select Your City--</option>
                                            <option value="peshawar" >Peshawar</option>
                                            <option>Islamabad</option>
                                            <option>Quetta	</option>
                                            <option>Sargodha</option>
                                            <option>Sialkot	</option>
                                            <option>Bahawalpur</option>
                                            <option>Sukkur	</option>
                                            <option>Kandhkot	</option>
                                            <option>Sheikhupura</option>
                                            <option>Mardan	</option>
                                            <option>Gujrat	</option>
                                            <option>Larkana	</option>
                                            <option>Kasur	</option>
                                            <option>Rahim Yar Khan	</option>
                                            <option>Sahiwal	</option>
                                            <option>Okara	</option>
                                            <option>Wah Cantonment	</option>
                                            <option>Dera Ghazi Khan	</option>
                                            <option>Mingora	</option>
                                            <option>Mirpur Khas</option>
                                            <option>Chiniot	</option>
                                            <option>Nawabshah	</option>
                                            <option>Kamoke	</option>
                                            <option>Jhelum	</option>
                                            <option>Sadiqabad	</option>
                                            <option>Khanewal	</option>
                                            <option>Hafizabad	</option>
                                            <option>Kohat	</option>
                                            <option>Jacobabad	</option>
                                            <option>Shikarpur	</option>
                                            <option>Muzaffargarh	</option>
                                            <option>Khanpur	</option>
                                            <option>Gojra	</option>
                                            <option>Bahawalnagar</option>
                                            <option>Abbottabad	</option>
                                            <option>Muridke	</option>
                                            <option>Pakpattan	</option>
                                            <option>Khuzdar	</option>
                                            <option>Jaranwala</option>
                                            <option>Chishtian	</option>
                                            <option>Daska	</option>
                                            <option>Mandi Bahauddin	</option>
                                            <option>Ahmadpur East</option>
                                            <option>Kamalia</option>
                                            <option>Tando Adam	</option>
                                            <option>Khairpur	</option>
                                            <option>Dera Ismail Khan	</option>
                                            <option>Vehari	</option>
                                            <option>Nowshera</option>
                                            <option>Dadu	</option>
                                            <option>Wazirabad	</option>
                                            <option>Khushab	</option>
                                            <option>Charsada	</option>
                                            <option>Swabi	</option>
                                            <option>Chakwal	</option>
                                            <option>Mianwali	</option>
                                            <option>Tando Allahyar</option>
                                            <option>Kot Adu	</option>
                                            <option>Farooka	</option>
                                            <option>Chichawatni	</option>
                                            <option>Vehari</option>
                                            <option>Mansehra</option>
                                        </select> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="village">Village *</label>
                                        <input id="village" type="text" class="form-control" placeholder="Enter  Village" name="village" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district">District *</label>
                                        <input id="district" type="text" class="form-control" placeholder="Enter  District"  name="district">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Category"> Category *</label>
                                        <input id="category" type="text" class="form-control" placeholder="Enter category" name="category" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Location">Location <span Style="color:red;"><b>*</b></span></label>
                                        <input id="location" type="text" class="form-control" placeholder="Enter your location" name="location">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Age "> Age *</label>
                                        <input id="Age " type="number" class="form-control" placeholder="Enter your Age " name="age">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Srvc_id">Srvc_id*</label>
                                        <input id="Srvc_id" type="numbers" class="form-control" placeholder="Enter your Srvc_id" name="srvc_id">
                                    <input type="hidden"  value="1" name="updated_by">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="occupation">Occupation *</label>
                                        <textarea id="occupation" class="form-control" placeholder="Write your Occupation here." rows="4" name="occupation"></textarea> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> <label for="form_message">Feedback *</label> <textarea id="form_message" name="feedback" class="form-control" placeholder="Write your message here." rows="4" ></textarea>                                            </div>
                                </div>
                                <div class="col-md-12"> <input type="submit" class="btn btn-success  btn-block " value="Submit"> </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
<script>
</script>

</html>
    @endsection
<script>
    function showEditModal ( id) {
        var e=document.getElementById('edit').value;
        console.log(e);
        
    }
</script>