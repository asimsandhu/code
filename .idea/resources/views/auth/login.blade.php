<!DOCTYPE html>
<html>

<head>
    <title>Login </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <style>

    </style>
</head>

<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <img src="../assets/images/industrus logo official-01.png " alt="logo" width="50" height="60">



</nav>
<svg width="380px" height="500px" viewBox="0 0 837 1045" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
        <path d="M353,9 L626.664028,170 L626.664028,487 L353,642 L79.3359724,487 L79.3359724,170 L353,9 Z"      id="Polygon-1" stroke="#4DAA46" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M78.5,529 L147,569.186414 L147,648.311216 L78.5,687 L10,648.311216 L10,569.186414 L78.5,529 Z" id="Polygon-2" stroke="#ADFE2F" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M773,186 L827,217.538705 L827,279.636651 L773,310 L719,279.636651 L719,217.538705 L773,186 Z" id="Polygon-3" stroke="#ffff" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M639,529 L773,607.846761 L773,763.091627 L639,839 L505,763.091627 L505,607.846761 L639,529 Z" id="Polygon-4" stroke="#FFD400" stroke-width="6" sketch:type="MSShapeGroup"></path>
        <path d="M281,801 L383,861.025276 L383,979.21169 L281,1037 L179,979.21169 L179,861.025276 L281,801 Z" id="Polygon-5" stroke="#c9c3c1" stroke-width="6" sketch:type="MSShapeGroup"></path>

    </g>
</svg>
<div class="message-box">
    <h1>Welcome!</h1>
    <p>Welcome! Login to your account first.</p>
    <div class="buttons-con">
        <div class="action-link-wrap">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Login</button>
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">

                            <h4 class="modal-title"> Login </h4>
                        </div>
                        <div class="modal-body">
                            <form action="login_user" method="post" class="login100-form validate-form" >
                                @csrf
                                <img src="../assets/images/industrus logo official-01.png " alt="logo" width="50" height="60">
                                <img src="../assets/images/IBIT logo official png.png" class="ibit" alt="logo" width="60" height="60">
                                <span class="login100-form-title p-b-33">

                                </span>

                                <div class="wrap-input100 validate-input">
                                    <input class="input100" type="text" name="email" placeholder="email">

                                    <span class="focus-input100-1"></span>
                                    <span class="focus-input100-2"></span>
                                </div>

                                <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
                                    <input class="input100" type="password" name="password" placeholder="Password">
                                    <span class="focus-input100-1"></span>
                                    <span class="focus-input100-2"></span>
                                </div>

                                <div class="container-login100-form-btn m-t-20">
                                    <button class="login100-form-btn">
                                        Login
                                    </button>
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

    </div>

</div>


</body>
<script>

</script>

</html>