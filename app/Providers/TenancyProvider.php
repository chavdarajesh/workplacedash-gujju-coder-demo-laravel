<?php

namespace App\Providers;

use App\Tenant;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\User;
use Crypt;
use Redirect;

class TenancyProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRequests();
        if(isset($_POST['companyname'])) {

        }
        else{
            $this->configureQueue();
        }
    }

    /**
     *
     */
    public function configureRequests()
    {
       Tenant::where('database_name',env('DB_SINGLE_DB'))->firstOrFail()->configure()->use();
       /*if(!isset($_COOKIE['asarcotenent'])) {

            if(isset($_POST['rpcompanyname'])) {
                Tenant::where('database_name',env('LANDLORD_DB_DATABASE'))->firstOrFail()->configure()->use();
                 $companywxites=User::where('companyname',$_POST['rpcompanyname'])->first();
                if(empty($companywxites)){
                    return Redirect::back()->withInput()->with('error', 'Company name does not exits.');
                }
                Tenant::where('database_name',$companywxites->database_name)->firstOrFail()->configure()->use();
            }else{
                Tenant::where('database_name',env('LANDLORD_DB_DATABASE'))->firstOrFail()->configure()->use();
            }

       }else{
            $dbname= Crypt::decryptString(Cookie::get('asarcotenent'));
            $dbname=explode('|', $dbname);
            if(array_key_exists(1, $dbname)){
                Tenant::where('database_name',$dbname[1])->firstOrFail()->configure()->use();
            }else{
                Tenant::where('database_name',env('LANDLORD_DB_DATABASE'))->firstOrFail()->configure()->use();
            }
       }*/


    }

    /**
     *
     */
    public function configureQueue()
    {
        $this->app['queue']->createPayloadUsing(function () {
            return $this->app['tenant'] ? ['tenant_id' => $this->app['tenant']->id] : [];
        });

        $this->app['events']->listen(JobProcessing::class, function ($event) {
            if (isset($event->job->payload()['tenant_id'])) {
                Tenant::find($event->job->payload()['tenant_id'])->configure()->use();
            }
        });
    }
}
