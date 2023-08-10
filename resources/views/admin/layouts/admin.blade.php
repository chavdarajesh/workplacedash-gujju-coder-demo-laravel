<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css-fontawesome.min.css') }}" rel="stylesheet">

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"><img src="{{ asset('images/logo.png') }}"></div>
     
      <div class="list-group list-group-flush">
      <nav id="sidebar">
            

            <ul class="list-unstyled components left-menu">                
                <li class="list-group-item list-group-item-action bg-light">
                    <a href="{{route('admin')}}">Dashboard</a>
                </li>
                <li class="list-group-item list-group-item-action bg-light">
                    <a href="#" >Users</a>
                </li>                
                
            </ul>
           
            
        </nav>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <h5>{{$page_title}}</h5>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>



        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">  
            
           <!--   <div class="btn-group gc-newtop-btn">
                <button class="btn btn-secondary gc-new-list btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="fa fa-plus" aria-hidden="true"></i> <span>New</span>
                </button>

                <div class="dropdown-menu gc-dropdowntop">
                  <ul>
                    <li><a href="{{route('observationscreate')}}">Near Miss</a></li>
                    <li><a href="{{route('incidentscreate')}}">Incidents</a></li>
                    <li><a href="{{route('actionscreate')}}">Actions</a></li>
                    <li><a href="{{route('permitscreate')}}">Permits</a></li>
                  </ul>  
                </div>
             </div> -->

          <!--   <div class="gc-topdetail">
              <a href="#"><i class="fa fa-bell gc-bell" aria-hidden="true"></i></a>
              <a href="#"><i class="fa fa-user-circle gc-userlogin" aria-hidden="true"></i></a> 
            </div> -->

                         
             <li class="btn-group gc-rightbtn">
              <div class="gc-ballicon" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell gc-bell" aria-hidden="true"></i>
              </div>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" type="button">Account Setting</a>
                <a class="dropdown-item" type="button">Sing UP</a>
              </div>
            </li> 


              
            <li class="nav-item dropdown gc-userlogin-top">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-circle gc-userlogin" aria-hidden="true"></i>
                
              </a>
              
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                {{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </div>
            </li>

         
             
          </ul>

        </div>
      </nav>
      <div class="container-fluid pt-5">
        @yield('content')
      </div>  
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->

  

  <!-- Menu Toggle Script -->
  

</body>

</html>
