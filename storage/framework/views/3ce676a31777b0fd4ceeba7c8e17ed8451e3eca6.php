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
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.png')); ?>">  
        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/responsive.css')); ?>" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
           

           


        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height gcsphomepage">

            <?php if(Route::has('login')): ?>
                <div class="top-right links gc-homebtn">
                    <div class="gcsplanguaswit">
                          <?php  $setlocale=app()->getLocale();?>
                          <a class="<?php if($setlocale=='en'): ?> active <?php endif; ?>" href="<?php echo e(url('setlocale/en')); ?>">En</a>
                          <a class="<?php if($setlocale=='es'): ?> active <?php endif; ?>" href="<?php echo e(url('setlocale/es')); ?>">Es</a>
                        </div> 
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>"><?php echo e(__('Home')); ?></a>
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">Logout</a>

                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>

                        <?php if(Route::has('register')): ?>
                            <!-- <a href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a> -->
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <div class="title m-b-md gc-ismhome-logo">
                    <img src="<?php echo e(asset('images/homelogo.png')); ?>" alt="">
                </div>

                
            </div>
        </div>
    </body>
</html><?php /**PATH /opt/lampp/htdocs/Laravel/interview_rajkot/workplacedash-laravel-8/workplacedash/resources/views/welcome.blade.php ENDPATH**/ ?>