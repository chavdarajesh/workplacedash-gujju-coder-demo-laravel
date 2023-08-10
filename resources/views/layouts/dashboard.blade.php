<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <!-- <script src="{{ asset('js/app.js') }}" ></script>     -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/dtsel.css') }}" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2totree.css') }}" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css-fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fastselect.min.css') }}" rel="stylesheet">
    <script type="text/javascript">
      var site_url="{{url('/')}}";
    </script>
    <style type="text/css">

      canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
    </style>
</head>
<body class="loaded gcspdashbordbody">
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"><a href="{{url('dashboard')}}"><img src="{{ asset('images/logo.png') }}"></a></div>

      <div class="list-group list-group-flush">
      <nav id="sidebar">


            <ul class="list-unstyled components left-menu">
                @if($cuser->hasRole('Super Admin') || $cuser->can('Observations'))
                @if($cuser->is_admin!=6)
                <li class="list-group-item list-group-item-action bg-light dashbord-homeicon">
                    <a href="{{route('dashboard')}}"><i class="fa fa-home" aria-hidden="true"></i><p>{{__('Dashboard')}}</p></a>
                </li>
                @endif
                @endif

                <li class="list-group-item list-group-item-action bg-light dashbord-icons">
                    <a href="{{route('observations')}}" ><img src="{{ asset('images/observation.png') }}" alt=""><p>{{__('Near Miss')}}</p></a>
                </li>
                @if($cuser->hasRole('Super Admin') || $cuser->can('Incident'))
                <li class="list-group-item list-group-item-action bg-light dashbord-icons">
                    <a href="{{route('incidents')}}" ><img src="{{ asset('images/incidns.png') }}" alt=""><p> {{__('Incidents')}}</p></a>
                </li>
                @endif
                @if($cuser->hasRole('Super Admin') || $cuser->can('Actions'))
                <li class="list-group-item list-group-item-action bg-light dashbord-icons">
                    <a href="{{route('actions')}}" ><img src="{{ asset('images/action.png') }}" alt=""><p> {{__('Actions')}}</p></a>
                </li>
                @endif
                @if($cuser->hasRole('Super Admin') || $cuser->can('Permit'))
                <li class="list-group-item list-group-item-action bg-light dashbord-icons">
                    <a href="{{route('permits')}}" ><img src="{{ asset('images/permit.png') }}" alt=""><p>{{__('Permits')}}</p></a>
                </li>
                @endif
                @if($cuser->hasRole('Super Admin') || $cuser->can('Audit'))
                <li class="list-group-item list-group-item-action bg-light dashbord-icons">
                    <a href="{{route('audits')}}" ><img src="{{ asset('images/audits.png') }}" alt=""><p>{{__('Audits')}}</p></a>
                </li>
                @endif
                <li class="list-group-item list-group-item-action bg-light dashbord-icons">
                    <a href="{{route('vaccinations')}}" ><img src="{{ asset('images/vacccine-icon.png') }}" alt=""><p>{{__('Vaccination')}}</p></a>
                </li>
                @if($cuser->hasRole('Super Admin') || $cuser->can('Sites') || $cuser->can('Roles') || $cuser->can('User') || $cuser->can('Categories') || $cuser->can('Root Cause') || $cuser->can('Permit Templates') || $cuser->can('Workflows'))
                <li class="list-group-item list-group-item-action bg-light dashbord-homeicon">
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-cog" aria-hidden="true"></i><p>{{__('Settings')}}</p></a>
                    <ul class="collapse list-unstyled gc-dashboard-submenu" id="pageSubmenu">
                      @if($cuser->can('Sites'))
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="{{route('sites')}}" >{{__('Sites')}}</a>
                        </li>
                      @endif
                      @if($cuser->can('Roles'))
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="{{route('roles')}}" >{{__('Roles')}}</a>
                        </li>
                      @endif
                      @if($cuser->can('User'))
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="{{route('users')}}" >{{__('Users')}}</a>
                        </li>
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="{{route('universal-login')}}" >{{__('Universal Login')}}</a>
                        </li>
                      @endif
                      @if($cuser->can('Categories'))
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="{{route('categories')}}" >{{__('Categories')}}</a>
                        </li>
                      @endif
                      @if($cuser->can('Root Cause'))
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="{{route('rootcause')}}" >{{__('Root Cause')}}</a>
                        </li>
                      @endif
                      @if($cuser->can('Audit Template'))
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="{{route('audittemplates')}}" >{{__('Audit Template')}}</a>
                        </li>
                      @endif
                     <?php /* @if($cuser->can('Permit Templates'))
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="javascript:void(0);" >Permit Templates</a>
                        </li>
                      @endif
                      @if($cuser->can('Workflows'))
                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="javascript:void(0);" >Worker Profile</a>
                        </li>


                        <li class="list-group-item list-group-item-action bg-light border-0 p-2">
                            <a href="javascript:void(0);" >Workflows</a>
                        </li>
                      @endif
                      <?php */ ?>
                    </ul>
                </li>
                @endif

            </ul>


        </nav>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <h5>{{__($page_title)}}</h5>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>



        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="navbar-nav ml-auto mt-2 mt-lg-0" id="navbarDropdown">
            @if($cuser->is_admin==6)
            <div class="btn-group gc-newtop-btn">
            <div class="searchaudittopheader d-block m-0">
                <form id="auditsitewisesearch" action="{{route('observations')}}" method="get">
                    <input type="text" value="{{$searchbykeywords}}" required="" name="searchbykeywords" placeholder="NM00000" class="form-control" autocomplete="off">
                    <button type="submit" class="d-none"></button>
                </form>
            </div>
            </div>
            @endif


            <div class="gcsplanguaswit dashboardgcsplanguaswit">
              <?php $setlocale=app()->getLocale();?>
              <a class="@if($setlocale=='en') active @endif" href="{{url('setlocale/en')}}">En</a>
              <a class="@if($setlocale=='es') active @endif" href="{{url('setlocale/es')}}">Es</a>
            </div>

            @if($cuser->is_admin!=6)
             <div class="btn-group gc-newtop-btn">
                <button class="btn btn-secondary gc-new-list  btn-lg dropdown-toggle gc-new-list-click" type="button" id="navbarDropdown">
                 <i id="navbarDropdown" class="fa fa-plus" aria-hidden="true"></i> <span id="navbarDropdown">{{__('New')}}</span>
                </button>

                <div class="dropdown-menu gc-dropdowntop gc-new-list-click-show">
                  <ul>
                    <li><a href="{{route('observations')}}">{{__('Near Miss')}}</a></li>
                    @if($cuser->hasRole('Super Admin') || $cuser->can('Incident Add'))
                    <li><a href="{{route('incidents')}}">{{__('Incidents')}}</a></li>
                    @endif
                    @if($cuser->hasRole('Super Admin') || $cuser->can('Permit Add'))
                    <li><a href="{{route('permitscreate')}}">{{__('Permits')}}</a></li>
                    @endif
                    @if($cuser->hasRole('Super Admin') || $cuser->can('Audit Add'))
                    <li><a href="{{route('audits')}}/#create">{{__('Audits')}}</a></li>
                    @endif
                  </ul>
                </div>
             </div>
            @endif

            @if($cuser->is_admin!=6)
             <li class="btn-group gc-rightbtn">
              <div class="gc-ballicon" type="button" class="btn btn-secondary dropdown-toggle" >
                <i class="fa fa-bell gc-bell" aria-hidden="true"></i>
              </div>
              <!-- <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" type="button">Account Setting</a>
                <a class="dropdown-item" type="button">Sing UP</a>
              </div> -->
            </li>
            @endif


            <li class="nav-item dropdown gc-userlogin-top" id="navbarDropdown">
              <a class="nav-link dropdown-toggle gc-userlogin-top-click hidenav" href="#" id="navbarDropdown" role="button" >
                <i class="fa fa-user-circle gc-userlogin hidenav" id="navbarDropdown" aria-hidden="true"></i>
              </a>

              <div class="dropdown-menu dropdown-menu-right gc-dropdowntop gc-userlogin-top-click-show" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" type="button">{{__('Hi')}} {{$cuser->name}}</a>
                <!-- <a class="dropdown-item" type="button">{{__('Account Setting')}}</a> -->
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
      <div class="container-fluid gcspmainmiddlesection">
        @if ($errors->any())
        <div class="Absolute-Center">
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    </div>
    @endif
                @if(session()->has('error'))
                    <div class="Absolute-Center">
                    <div class="alert alert-danger m-3">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="Absolute-Center">
                    <div class="alert alert-success  m-3">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    </div>
                @endif

        @yield('content')




      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->
<section class="Footerwaaper">
        <div class="col-sm-12 col-xs-12">
          <div class="inlinefooter"><span>©{{date('Y')}} {{env('APP_NAME')}}.</span></div>
        </div>
      </section>
  <!-- Bootstrap core JavaScript -->
<script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>



<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/fastselect.standalone.js') }}"></script>
<script src="{{ asset('js/spcustom.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.min.js') }}"></script>


  <!-- Menu Toggle Script -->
<script>

jQuery('.gcspdaterangepicker').daterangepicker({
    "showDropdowns": true,
    "autoApply": true,
    //"autoUpdateInput": false,
    ranges: {
        '{{__("Today")}}': [moment(), moment()],
        '{{__("Yesterday")}}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '{{__("This week")}}': [moment().startOf('week'), moment().endOf('week')],
        '{{__("Last week")}}': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
        '{{__("Last 7 days")}}': [moment().subtract(7, 'days'), moment()],
        '{{__("Last 30 days")}}': [moment().subtract(30, 'days'), moment()],
        '{{__("This month")}}': [moment().startOf('month'), moment().endOf('month')],
        '{{__("Last month")}}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        '{{__("This year")}}': [moment().startOf('year'), moment().endOf('year')],
        '{{__("Last year")}}': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
    },
    "locale": {
        "format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "{{__('Apply')}}",
        "cancelLabel": "{{__('Cancel')}}",
        "fromLabel": "{{__('From')}}",
        "toLabel": "{{__('To')}}",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "firstDay": 1
    },
    "showCustomRangeLabel": false,
    "alwaysShowCalendars": true,
    "opens": "center",
});
@if(!Request::is('audits') && !Request::is('audits/*'))
jQuery('.gcspdaterangepicker').on('apply.daterangepicker', function(ev, picker) {
    jQuery(this).closest("form").submit();
});
@endif


jQuery('.multipleSelect').fastselect();

jQuery(document).ready(function ($) {
  if(jQuery('#dashboardcalender').length){
    jQuery("#dashboardcalender").datepicker({
      numberOfMonths: 3
    });
  }

  if(jQuery('.gcspdatepickerstart').length){
      jQuery(".gcspdatepickerstart").datepicker({
      dateFormat: 'yy-mm-dd',
      onSelect: function(date){
          var selectedDate = new Date(date);
          var msecsInADay = 86400000;
          var endDate = new Date(selectedDate.getTime() + msecsInADay);
          jQuery(".gcspdatepickerend").datepicker( "option", "minDate", endDate );
      }
      });
  }

  if(jQuery('.gcspdatepickerend').length){
    jQuery(".gcspdatepickerend").datepicker({dateFormat: 'yy-mm-dd'});
  }

  if(jQuery('.gcspdatepicker').length){
    jQuery(".gcspdatepicker").datepicker({
        dateFormat: 'dd-mm-yy',
    });
  }

});
</script>



  <script src="{{ asset('js/select2.min.js') }}"></script>
  <script src="{{ asset('js/select2totree.js') }}"></script>
  <script>
    jQuery(".oc_id").select2ToTree();
    jQuery(".oc_id1").select2ToTree();
    jQuery(".oc_id2").select2ToTree();
    jQuery(".oc_id3").select2ToTree();
    jQuery(".site_id").select2ToTree({
    // options
    placeholder: '{{__("All Sites")}}'
});
    jQuery(".site_id1").select2ToTree();
    jQuery(".site_id2").select2ToTree();
    jQuery(".site_id3").select2ToTree();
    jQuery(".site_id4").select2ToTree();

    jQuery(".vaccine_type").select2ToTree();

    if(jQuery('.site_id_audit').length){
        jQuery(".site_id_audit").each(function() {
          var selectid=jQuery(this).attr('id');
          jQuery("#"+selectid).select2ToTree();
        });
    }

</script>
<script src="{{ asset('js/dtsel.js') }}"></script>
<script type="text/javascript">
  jQuery(document).on('click focus','.gcspdatetimepicker',function(){
      if(jQuery(this).val()==''){
          var d = new Date($.now());
          var month = d.getMonth()+1;
          var day = d.getDate();
          var hour = d.getHours();
          var minite = d.getMinutes();
          //alert(d.getDate()+"-"+(d.getMonth()+1)+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds());
          var output = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day+'/' +d.getFullYear()+', '+(hour<10 ? '0' : '') + hour+':'+(minite<10 ? '0' : '') + minite;

          $(this).val(output);

          instance = new dtsel.DTS('.gcspdatetimepicker',  {
            direction: 'BOTTOM',
            dateFormat: "mm/dd/yyyy",
            showTime: true,
            timeFormat: "HH:MM A"
        });

      }
  });

  jQuery(document).on('click focus','.gcspdatetimepicker2',function(){
      if(jQuery(this).val()==''){
          var d = new Date($.now());
          var month = d.getMonth()+1;
          var day = d.getDate();
          var hour = d.getHours();
          var minite = d.getMinutes();
          //alert(d.getDate()+"-"+(d.getMonth()+1)+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds());
          var output = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day+'/' +d.getFullYear()+', '+(hour<10 ? '0' : '') + hour+':'+(minite<10 ? '0' : '') + minite;

          $(this).val(output);

          instance = new dtsel.DTS('.gcspdatetimepicker2',  {
            direction: 'BOTTOM',
            dateFormat: "mm/dd/yyyy",
            showTime: true,
            timeFormat: "HH:MM A"
        });

      }
  });



jQuery( document ).ajaxComplete(function() {
  if(jQuery('.gcspdatetimepicker').length){
    instance = new dtsel.DTS('.gcspdatetimepicker',  {
      direction: 'BOTTOM',
      dateFormat: "mm/dd/yyyy",
      showTime: true,
      timeFormat: "HH:MM A"
    });
  }
  if(jQuery('.gcspdatetimepicker2').length){
    instance = new dtsel.DTS('.gcspdatetimepicker2',  {
      direction: 'BOTTOM',
      dateFormat: "mm/dd/yyyy",
      showTime: true,
      timeFormat: "HH:MM A"
    });
  }
});
</script>

@if(Request::is('near-miss') || Request::is('near-miss/*'))
<script src="{{ asset('js/observations.js') }}"></script>
@endif
@if(Request::is('actions') || Request::is('actions/*'))
<script src="{{ asset('js/actions.js') }}"></script>
@endif
@if(Request::is('incidents') || Request::is('incidents/*'))
<script src="{{ asset('js/incidents.js') }}"></script>
@endif
@if(Request::is('vaccinations') || Request::is('vaccinations/*'))
<script src="{{ asset('js/vaccinations.js') }}"></script>
@endif
@if(Request::is('audits') || Request::is('audits/*'))
<link href="{{ asset('css/cmxform.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('js/additional-methods.js') }}"></script>
<script src="{{ asset('js/audits.js') }}"></script>
@endif
@if(Request::is('audit-templates') || Request::is('audit-templates/*'))
<script src="{{ asset('js/audit-templates.js') }}"></script>
@endif

@if(Request::is('dashboard'))
<script src="{{ asset('js/highcharts.js') }}"></script>
<script type="text/javascript">
    // Create the chart
if($('#ObservationsbyCategories').length){
Highcharts.chart('ObservationsbyCategories', {
    chart: {type: 'column'},
    title: {text: ''},
    subtitle: {text: ''},
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title:false
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{y}'
            }
        }
    },
    tooltip: false,
    series: [
        {
            name: "Near Miss ",
            colorByPoint: false,
            data: <?php echo json_encode($ObservationbyRatingArrFinal); ?>
        }
    ],
}, function(chart) { // on complete
    @if(empty($ObservationbyRatingArrFinal))
        chart.renderer.text('{{__("No Data Available")}}', 35, 85).css({color: '#000000', fontSize: '16px'}) .add();
    @endif
});
}

if($('#IncidentsbyCategories').length){

Highcharts.chart('IncidentsbyCategories', {
    chart: {type: 'column'},
    title: {text: ''},
    subtitle: {text: ''},
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title:false
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{y}'
            }
        }
    },
    tooltip: false,
    series: [
        {
            name: "Incident ",
            colorByPoint: false,
            data: <?php echo json_encode($IncidentsbyCategoriesArr); ?>
        }
    ],
}, function(chart) { // on complete
    @if(empty($IncidentsbyCategoriesArr))
        chart.renderer.text('{{__("No Data Available")}}', 35, 85).css({color: '#000000', fontSize: '16px'}) .add();
    @endif
});

}

if($('#IncidentsbyRating').length){
Highcharts.chart('IncidentsbyRating', {
    chart: {type: 'column'},
    title: {text: ''},
    subtitle: {text: ''},
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title:false
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{y}'
            }
        }
    },
    tooltip: false,
    series: [
        {
            name: "Incident Rating",
            colorByPoint: false,
            data: <?php echo json_encode($IncidentsbyRatingArrFinal); ?>
        }
    ],
}, function(chart) { // on complete
    @if(empty($IncidentsbyRatingArrFinal))
        chart.renderer.text('No Data Available', 35, 85).css({color: '#000000', fontSize: '16px'}) .add();
    @endif
});
}


if($('#ActionsByStatus').length){
Highcharts.chart('ActionsByStatus', {
    chart: {type: 'column'},
    title: {text: ''},
    subtitle: {text: ''},
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title:false
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{y}'
            }
        }
    },
    tooltip: false,
    series: [
        {
            name: "Actions By Status",
            colorByPoint: false,
            data: <?php echo json_encode($ActionsByStatusArrFinal); ?>
        }
    ],
}, function(chart) { // on complete
    @if(empty($ActionsByStatusArrFinal))
        chart.renderer.text('{{__("No Data Available")}}', 35, 85).css({color: '#000000', fontSize: '16px'}) .add();
    @endif
});
}

</script>


<link href="{{ asset('css/fullcalendar.min.css') }}" rel='stylesheet' />
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
<script type="text/javascript">
  jQuery(document).ready(function () {

    var all_events = <?php echo json_encode($FinalDayEvent); ?>

    var cal1 = jQuery('#calendar1');
    var cal2 = jQuery('#calendar2');
    var cal3 = jQuery('#calendar3');

    cal1.fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: ''
        },
        dayNamesShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        defaultDate: '{{date("Y-m-d", strtotime("-1 month"))}}',
        events: all_events,
        eventRender: function(event, element) {
        if(event.icon){
          element.find(".fc-title").prepend("<i class='fa fa-"+event.icon+"'></i>");
        }
        },
      dayClick: function() {
        jQuery('#modal-view-event-add').modal();
      },
      eventClick: function(event, jsEvent, view) {
              jQuery('.event-icon').html("<i class='fa fa-"+event.icon+"'></i>");
          jQuery('.event-title').html(event.title);
          jQuery('.event-body').html(event.description);
          jQuery('.eventUrl').attr('href',event.url);
          jQuery('#modal-view-event').modal();
      },
    });

    cal2.fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: ''
        },
        dayNamesShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        defaultDate: '{{date("Y-m-d", time())}}',
        events: all_events,
        eventClick: function(event, jsEvent, view) {
          jQuery('.event-icon').html("<i class='fa fa-"+event.icon+"'></i>");
          jQuery('.event-title').html(event.title);
          jQuery('.event-body').html(event.description);
          jQuery('.eventUrl').attr('href',event.url);
          jQuery('#modal-view-event').modal();
        },

    });

    cal3.fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: ''
        },
        dayNamesShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        defaultDate: '{{date("Y-m-d", strtotime("+1 month"))}}',
        events: all_events,
        eventClick: function(event, jsEvent, view) {
          jQuery('.event-icon').html("<i class='fa fa-"+event.icon+"'></i>");
          jQuery('.event-title').html(event.title);
          jQuery('.event-body').html(event.description);
          jQuery('.eventUrl').attr('href',event.url);
          jQuery('#modal-view-event').modal();
        },

    });

    jQuery(document).on('click','.gcspcalnext',function(){
        var month = jQuery("#calendar1").fullCalendar("getView").intervalStart;
        d1 = moment(month).add('months', 3);
        d2 = moment(month).add('months', 4);
        d3 = moment(month).add('months', 5);
        cal1.fullCalendar('gotoDate', d1);
        cal2.fullCalendar('gotoDate', d2);
        cal3.fullCalendar('gotoDate', d3);
    });

    jQuery(document).on('click','.gcspcalprev',function(){
        var month = jQuery("#calendar1").fullCalendar("getView").intervalStart;
        d1 = moment(month).subtract('months', 3);
        d2 = moment(month).subtract('months', 2);
        d3 = moment(month).subtract('months', 1);
        cal1.fullCalendar('gotoDate', d1);
        cal2.fullCalendar('gotoDate', d2);
        cal3.fullCalendar('gotoDate', d3);
    });
});
</script>
<script src="{{ asset('js/dashboard.js') }}"></script>
@endif



</body>
</html>
