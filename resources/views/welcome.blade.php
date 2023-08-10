<!-- <!doctype html>
<title>Site Maintenance</title>
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

<article>
    <h1>We&rsquo;ll be back soon!</h1>
    <div>
        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment.</p>
    </div>
</article> -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">  
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
           

           


        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height gcsphomepage">

            @if (Route::has('login'))
                <div class="top-right links gc-homebtn">
                    <div class="gcsplanguaswit">
                          <?php  $setlocale=app()->getLocale();?>
                          <a class="@if($setlocale=='en') active @endif" href="{{url('setlocale/en')}}">En</a>
                          <a class="@if($setlocale=='es') active @endif" href="{{url('setlocale/es')}}">Es</a>
                        </div> 
                    @auth
                        <a href="{{ url('/dashboard') }}">{{ __('Home') }}</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                    @else
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>

                        @if (Route::has('register'))
                            <!-- <a href="{{ route('register') }}">{{ __('Register') }}</a> -->
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md gc-ismhome-logo">
                    <img src="{{ asset('images/homelogo.png') }}" alt="">
                </div>

                
            </div>
        </div>
    </body>
</html>