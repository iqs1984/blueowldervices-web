<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BlueOwl</title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Muli:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap"
        rel="stylesheet">
</head>
<body>
<div class="login-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-3"></div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                @if( Session::has( 'error' ))
                <div class="alert alert-danger">{{ Session::get( 'error' ) }}</div>
                @endif
                <form action="<?= route('login_admin') ?>" method="post">
                    @csrf()
                    <h3>Login in</h3>
                    <input class="form-control" type="text" name="email" placeholder="User name or email address">
                    <input class="form-control" id="pass" type="password" name="password" placeholder="Password">
                    <h4><a onclick="showpass();" id="showpass">Show password</a><a onclick="showpass();" style="display:none;" id="hidepass">Hide password</a></h4>
                    <button class="login-button" type="submit"><span>Login in</span></button>
                       Forgot password?
                </form><!-- form end here -->
            </div><!-- col end here -->
        </div><!-- row end here -->
    </div><!-- container end here -->
</div><!-- login-section end here -->

<script>
    function showpass(){
        var x = document.getElementById("pass");
        if (x.type === "password") {
            x.type = "text";
            $("#showpass").hide();
            $("#hidepass").show();
        } else {
            x.type = "password";
            $("#showpass").show();
            $("#hidepass").hide();
        }
    }
</script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
</body>
</html>
