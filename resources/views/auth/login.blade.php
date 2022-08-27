<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SBS Inventory System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./public/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  
  <link href="./public/adminlte/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./public/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./public/adminlte/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./public/adminlte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="./public/adminlte/dist/css/skins/_all-skins.min.css">
  
  <!-- jQuery 3 -->
  <script src="./public/adminlte/bower_components/jquery/dist/jquery.min.js"></script>

  <script src="./public/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <script src="./public/adminlte/dist/js/adminlte.min.js"></script>

  <script src="./public/adminlte/dist/js/demo.js"></script>

  {{-- dataTables --}}
  <script src="./public/adminlte/dataTables/js/jquery.dataTables.min.js"></script>
  <script src="./public/adminlte/dataTables/js/dataTables.bootstrap.min.js"></script>

    {{-- Validator --}}
  <script src="./public/adminlte/validator/validator.min.js"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>     
  <!-- <body style="background-color:orange;background-image:url('laravel/public/images/cover.jpg');background-repeat: no-repeat;background-size: cover;"> -->
  <body style="background-color: #000">

        <div class="container">
            <div style="margin-top: 80px"></div>
            <div class="row">
                <center><p><span style="font-size: 50px;color:#00a65a"><u>SBS Inventory</u></span><span style="font-size: 50px;color:#fff"><u>System</u></span></p></center>

                <div class="col-md-6 col-md-offset-3" style="text-align: center">
                    <div class="panel panel-info">
                        <div class="panel-heading">Login System</div>

                        <div class="panel-body" style="color:#fff;background-image: url('laravel/public/images/cover.jpg');background-size: cover;">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}" style="text-align: left; display: inline-block;">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                    <label for="role" class="col-md-4 control-label">Role</label>

                                    <div class="col-md-6">
                                        <select name="role" id="role" class="form-control" required>
                                            <option value="Kepala">Kepala</option>
                                            <option value="Admin Produksi">Admin Produksi</option>
                                            <option value="Admin Bahan Baku">Admin Bahan Baku</option>
                                        </select>

                                        @if ($errors->has('role'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('role') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
