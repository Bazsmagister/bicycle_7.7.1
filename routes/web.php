
<?php

use App\Rent;
use App\User;
use App\Helpers;
use App\BicycleToSell;
use App\Events\NewUser;
use App\Events\BicycleUpdated;
use App\Events\aRentHasBeenMade;
use App\Events\aRentHasBeenEnded;
use App\Notifications\rentIsOver;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;
use Illuminate\Filesystem\FilesystemManager;

//use League\Flysystem\Filesystem;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//   DB::listen(function ($query) {
//       var_dump($query->sql, $query->bindings);
//   });

 //auth()->loginUsingId(1);

//Login as an exclusive user:
//Auth::loginUsingId(5);
// auth()->loginUsingId(1);
// auth()->loginUsingId(2);
// auth()->loginUsingId(3);
// auth()->loginUsingId(4);
// auth()->loginUsingId(5);
//auth()->loginUsingId(6);

//when
    $reqtimeinepoch=$_SERVER['REQUEST_TIME'];
    $goodDate= date('r', $reqtimeinepoch);
    $when = fopen(".when", "a+");
    fwrite($when, $goodDate."\n");


Route::get('stor', function () {
    $filePath = "/home/bazs/code/bicycle_7.7.1/public/storage/images/try.txt";
    //$filePath = "/storage/images/try.txt"; // ile_get_contents(/storage/images/try.txt): failed to open stream: No such file or directory


    $contents = file_get_contents($filePath);
    dump($contents);

    Log::debug('contents', ['contents'=>$contents]);
    //[2020-07-27 20:08:50] local.DEBUG: contents {"contents":"kfjasdklfjalskdjflkajsdfa"}

    $publicpath = public_path();
    //var_dump($publicpath); //"/home/bazs/code/bicycle_7.7.1/public"

    $reference ='doggy';
    Storage::put('text.txt', 'hello');
    //Storage::makeDirectory(public_path('upload/release/'.$reference)); //not good! /home/bazs/code/bicycle_7.7.1/public/storage/home/bazs/code/bicycle_7.7.1/public/upload/release/doggy/
    Storage::makeDirectory('uploaded/release/'.$reference);

    $directory = "/images"; //public/storage/IMAGES

    echo dirname($directory) . PHP_EOL;
    print_r(dirname($directory) . PHP_EOL);

    //Storage::dirname doesn't work
    //\Log::info(Storage::dirname($directory));
    //print_r(Storage::dirname($directory));
    //$dirs = Storage::dirname($directory);
    //dd($dirs);

    $files = Storage::files($directory);
    //var_dump($files);
    //dump($files);
    //var_dump('***');

    $filesall = Storage::allFiles($directory);
    //var_dump($filesall);
    //var_dump('***');
    //echo("\n");

    $directories = Storage::directories($directory);
    //var_dump($directories);
    //var_dump('***');

    // Recursive...
    $directoriesall = Storage::allDirectories($directory);
    //var_dump($directoriesall);

    //dump($directoriesall);

    return view('stor', compact('files', 'filesall', 'directories', 'directoriesall'));
});

Route::get('/', function () {
    //phpinfo();

    //echo php_ini_loaded_file();
    //echo "\n";

    //trying a helper function it shows public path:
    //$publicpath = public_path();
    //var_dump($publicpath); //"/home/bazs/code/bicycle_7.7.1/public"

    echo(Inspiring::quote()), "\n";
    // dump(Inspiring::quote());
    // echo(Inspiring::quote());
    // var_dump(Inspiring::quote());
    // print_r(Inspiring::quote());

    //trying python:
    //$result = shell_exec("python " . storage_path() . "/python/python.py 2>&1"); //this works
    //echo($result);

    //$result2 = shell_exec("python " . public_path() . "/storage/python/python.py 2>&1"); //this works too
    //echo($result2);

    //On Linux works,
    //$command ='python C:/Users/Legion/code/bicycle_7.7.1/public/storage/python/python.py'; //need python
    //$command ='python '. public_path() . "/storage/python/python.py"; //need python
    //DD($command);
    //$proc = Process::fromShellCommandline($command, null, [])->mustRun()->getOutput(); //getErrorOutput();
    //echo $proc;

    //On win 10  not works
    /*     $process = new Process(['python ', 'C:/Users/Legion/code/bicycle_7.7.1/public/storage/python/python.py']);
        //dd($process);
        echo $process->mustRun()->getOutput();
        var_dump($process->getOutput()); */
    //echo $process->getOutput();

    return view('welcome');
});


// Route::get('/', function () {
//     return view('welcome');
// });

  Route::group(['middleware' => 'auth'], function () {
      // User needs to be authenticated to enter here.
      Route::get('/pamfs', function () {
          Artisan::call('migrate:fresh --seed');

          return 'php artisan migrate:fresh --seed, FINISHED';
          //return redirect('home');
      });

      Route::get('/paclearall', function () {
          Artisan::call('config:clear');
          Artisan::call('cache:clear');
          Artisan::call('view:clear');
          Artisan::call('route:clear');

          return 'clear FINISHED';
      });

      Route::get('/paCacheAll', function () {
          Artisan::call('config:cache');
          Artisan::call('view:cache');

          // Artisan::call('route:cache'); //Unable to prepare route [api/user] for serialization. Uses Closure.
          //The error message is coming from the route:cache command, not sure why clearing the cache calls this automatically.
          //The problem is a route which uses a Closure instead of a controller,
          return 'cache FINISHED';
      });
  });

 Route::get('eventupdate', function () {
     event(new aRentHasBeenEnded('your rent has been ended'));

     //event(new NewUser('A new user has been created'));

     //new rent is made in RentController@store , I cant call it here somewhy.
     //event(new aRentHasBeenMade(new Rent())); //404
     //event(new aRentHasBeenMade());


     //NewUser::dispatch();
     //  NewUser::dispatch('a new user has been created');
     // NewUser::dispatch(User $user);

     //  BicycleUpdated::dispatch();
     //  //same as
     //  event(new BicycleUpdated);
     //  event(new aRentHasBeenEnded());
     //  event(new aRentHasBeenEnded);

     //  aRentHasBeenEnded::dispatch();
     //event(new OrderShipped($order));

     return view('event');

     //check app\storage\logs\laravel.log
 });


    Route::get('/randomnames', function () {
        $names = collect(explode(',', 'michael, esther, peace, elvira'));
        dump($names);
        $names = explode(',', 'michael, esther, peace, elvira');
        $names = collect($names);
        dump($names);
        $rand = $names->random();
        dd($rand);
    });

    Route::get('/carousel', function () {
        $bicycles = BicycleToSell::all();
        return view('carousel', compact('bicycles'));
    });



 Route::get('mapWithKeys', function () {
     $userCollections = User::all();
     //dd($userCollections);
     $userCollectionskey = $userCollections ->mapWithKeys(function ($user) {
         return [$user['name'] => $user['created_at']];
     });

     $userCollectionsmap = $userCollectionskey->all();
     //dd($userCollectionsmap);
     //print_r($userCollections);
     //echo $userCollections;
     //dd($userCollections);
     return view('UserNameDateMapWithKeys', compact('userCollectionsmap'));
 });

 //it gives a view about the mail. For this reason, Laravel allows you to return any mailable directly from a route Closure or controller.
    // Route::get('mailable', function () {
    //     $invoice = App\Invoice::find(1);

    //     return new App\Mail\InvoicePaid($invoice);
    // });

 Route::get('mailservice', function () {
     $service = App\Service::latest()->first();
     dump($service);
     //dd($service);
     return (new App\Notifications\newServiceCreated($service))
                ->toMail($service->user);
 });

 Route::get('mailrent', function () {
     $rent = App\Rent::latest()->first();
     // $rent = App\Rent::find(30);
     dump($rent);
     return (new App\Notifications\newRentIsMade($rent))
                 ->toMail($rent->user);
 });

 Route::get('helper', function () {
     //dd('test');
     myCustomHelper();
 });


  Route::get('maxuser', function () {
      $maxValue = App\User::max('id');
      dump($maxValue);
      echo($maxValue);
      var_dump($maxValue);
      print_r($maxValue);
  });


 Route::get('dates', function () {
     $now= date('Y-m-d');
     $dateStart = date('Y-m-d', strtotime('-5 year'));
     $dateEnd = date('Y-m-d');
     dump($now, $dateStart, $dateEnd);

     echo strtotime("now"), "\n";
     echo strtotime("10 September 2000"), "\n";
     echo strtotime("+1 day"), "\n";
     echo strtotime("+1 week"), "\n";
     echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
     echo strtotime("next Thursday"), "\n";
     echo strtotime("last Monday"), "\n";

     echo date("jS F, Y", strtotime("11.12.10"));
     // outputs 10th December, 2011

     echo date("jS F, Y", strtotime("11/12/10"));
     // outputs 12th November, 2010

     echo date("jS F, Y", strtotime("11-12-10"));
     // outputs 11th December, 2010
 });



Route::get('file', function () {
    //laravel way works
    //$file = public_path('try.txt');
    //dump($file);

    //on shared hosting:
    $file = realpath('try.txt');
    //dump($file);

    $fp = fopen($file, "r");
    //dump($fp);
    $responsejson = file_get_contents($file);
    dump($responsejson);
    fclose($fp);
    dump($fp); //Closed resource @8

    // File handling example
    // *****************
    // $handle = fopen("/home/bazs/code/bicycle_7.7.1/public/try.txt", "r");
    // dump($handle);
    // $responsejson = file_get_contents("/home/bazs/code/bicycle_7.7.1/public/try.txt");
    // dump($responsejson);
    // fclose($handle);
    // dump($handle); //Closed resource @8
    //*******************
});

Route::get('log ', function () {
    $logfilename = 'cron_'. now()->format('Y_m_d') . '.txt';
    dump($logfilename);
    $fp = fopen($logfilename, "w") or die("Unable to open file!");
    dump($fp);
    $txt = "This need to be written in the file...\n";
    fwrite($fp, $txt);
    $txt='new text';
    fwrite($fp, $txt);

    $responsejson = file_get_contents($logfilename);
    dump($responsejson);
    fclose($fp);
    dump($fp); //Closed resource @8
});

Route::get('notifications', function () {

    // $user = App\User::find(1);
    // dump($user);
    // foreach ($user->notifications as $notification) {
    //     echo $notification->type;
    // }

    $user = auth()->user();

    foreach ($user->unreadNotifications as $notification) {
        echo $notification ->type;
        echo("\n");
        echo $notification ->id;

        echo $notification ->read_at;
        //echo $notification->data;

        dump($notification);
        echo $notification ->created_at;
        echo("\n");

        echo "Expires: ";
        echo $notification->data['expires'];
        echo("\n");

        echo $notification->data['link'];
        echo("\n");

        echo $notification->data['data2'];
    }
});

// Route::get('user/{id}', 'UserController@show');

// When registering routes for single action controllers, you do not need to specify a method:
//Route::get('users/{id}', 'ShowProfile');

//Route::get('/users', 'UserController@index');

// Route::get('/', function () {
//     $user = $request->user(); //getting the current logged in user
//     dd($user->hasRole('admin','editor')); // and so on
// });

//Route::get('service', 'BicycleController@service');

Route::resource('users', 'UserController');

Route::post('users/findId', 'UserController@findId');
Route::post('bicyclesToRent/findId', 'BicycleToRentController@findId');
Route::post('bicyclesToSell/findId', 'BicycleToSellController@findId');


Route::post('bicyclesToRent/showmethebike', 'BicycleToRentController@showmethebike')->name('showmethebike');

Route::post('bicyclesToSell/showmethesellablebike', 'BicycleToSellController@showmethesellablebike')->name('showmethesellablebike');

Route::post('bicyclesToService/showmetheservicebike', 'BicycleToServiceController@showmetheservicebike')->name('showmetheservicebike');


Route::get('indexDeletedAlso', 'UserController@indexDeletedAlso');

 Route::get('OnlyDeletedUsers', 'UserController@onlyDeletedUsers');
 Route::get('OnlyDeletedUsersAPI', 'UserController@onlyDeletedUsersAPI');



// Route::group(['middleware' => ['role:super-admin']], function () {

// });

// Route::group(['middleware' => ['role_or_permission:serviceman|edit bicycles']], function () {
// //
// });

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('myserviceprogress', 'ServiceController@myserviceprogress');
Route::get('myoldservices', 'ServiceController@myoldservices');
Route::get('myworkshop', 'ServiceController@myworkshop');


Route::get('rentabike', 'BicycleToRentController@rent');

// When declaring a resource route, you may specify a subset of actions the controller should handle instead of the full set of default actions
// Route::resource('bicycle', 'BicycleController')->except(['index', 'show']);

Auth::routes();

//Auth::routes(['verify' => true]);

/*named route */
Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/home', function() {
//     $user = Auth::user(); //getting the current logged in user
//      dd($user->name, $user->email, $user->phone) ;
//     // dd($user->name);

//     //it works
//     // dd($user->hasRole('admin', 'editor'));
// });

// Route::get('/roles', 'PermissionController@Permission');


//it works
// Route::get('/roles', function() {
// $user = Auth::user();
// // dd($user->hasRole('developer')); //will return true, if user has role
// // dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null
// dd($user->can('create-tasks')); // will return true, if user has permission
// });


Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/update', 'ProfileController@updateProfile')->name('profile.update');


//  Route::post('update_picture/{id}', [
//         'uses' => 'UserController@update_picture',
//         'as' => 'update_picture'
//     ]);

Route::put('update_picture/{id}', 'UserController@update_picture')->name('update_picture');

Route::resource('rents', 'RentController');

Route::get('/myPreviousRents', 'UserController@myPreviousRents');
Route::get('/myActiveRents', 'UserController@myActiveRents')->name('myactiverents');


// Route::get('autocomplete', 'UserController@autocomplete')->name('autocomplete');
// Route::get('autocompletebike', 'BicycleController@autocompletebike')->name('autocompletebike');

Route::get('autocompleteUser', 'UserController@autocompleteUser')->name('autocompleteUser');
Route::get('autocompleteBikeToSell', 'BicycleToSellController@autocompleteBikeToSell')->name('autocompleteBikeToSell');
Route::get('autocompleteBikeToRent', 'BicycleToRentController@autocompleteBikeToRent')->name('autocompleteBikeToRent');
Route::get('autocompleteBikeToRentAvailable', 'BicycleToRentController@autocompleteBikeToRentAvailable')->name('autocompleteBikeToRentAvailable');
Route::get('autocompleteBikeToService', 'BicycleToServiceController@autocompleteBikeToService')->name('autocompleteBikeToService');



Route::post('restoreDeletedUser/{id}', 'UserController@restoreDeletedUser')->name('restoreDeletedUser');
// Route::get('restoreDeletedUser/{id}', 'UserController@restoreDeletedUser')->name('restoreDeletedUser');


Route::resource('services', 'ServiceController');

Route::resource('bicyclesToSell', 'BicycleToSellController');
// Route::resource('bicycles_to_sell', 'BicycleToSellController');

Route::resource('bicyclesToRent', 'BicycleToRentController');
//Route::get('indexrentable', 'BicycleToRentController@indexrentable');
Route::get('indexavailabletorent', 'BicycleToRentController@indexavailabletorent');


Route::resource('bicyclesToService', 'BicycleToServiceController');

//If your route only needs to return a view, you may use the Route::view method.
//Like the redirect method, this method provides a simple shortcut so that you do not have to define a full route or controller.
//The view method accepts a URI as its first argument and a view name as its second argument.
//In addition, you may provide an array of data to pass to the view as an optional third argument:
            //v1
            Route::view('serviceguest', 'services.serviceguest');

            //v2
            Route::get('serviceguest', function () {
                return view('services.serviceguest');
            });
            //in view:
            //<a href="{{ url('serviceguest')}}">Service (guest v2)</a>

            //v3 with named route
             Route::get('serviceguest', function () {
                 return view('services.serviceguest');
             })->name('serviceguest');


//it works with (int) before $c:
Route::get('/mkuser/{c}', function ($c) {
    return collect(factory(User::class, (int)$c)->create());
});


Route::get('/sendemail', function () {
    Mail::raw('it works', function ($message) {
        $message->to('info@hogyat.hu')->subject('Hello There');
    });
    return redirect()->back()->with('message', 'Email sent');

    //MAIL_MAILER=log
});

//XHRHTTPrequest
Route::post('users/{user}/togglecategory', 'UserController@toggleCategory')->name('toggleCategory');


Route::get('/loginasauth', function () {
    $user = User::find(5);
    dump($user);
    //Auth::logout();

    Auth::login($user);
    //auth()->loginUsingId(5);

    dump('login');
    dump(auth()->user()->id);

    //it shows view, but it doesn't show anything else. Doesn't work!
    return view('home');

    //Doesn't work:
    //return redirect()->route('myactiverents');
    //return redirect()->back();
});


Route::get('contacts', 'ContactController@getIndex');
// Route::post('contacts', 'ContactController@postStore');  //orig.  this is not good. script is referring to contacts/store
Route::post('contacts/store', 'ContactController@postStore');
Route::get('contacts/data', 'ContactController@getData');
Route::post('contacts/update', 'ContactController@postUpdate');
Route::post('contacts/delete', 'ContactController@postDelete');



Route::get('sessionset', function () {
    return view('sessionset');
});

Route::get('sessionget', function () {
    //print_r($_SESSION);

    //var_dump($_SESSION); //doesn't work
    //Print_r($_SESSION);
    return view('sessionget');
});

Route::get('sessiondestroy', function () {
    return view('sessiondestroy');
});
