<?php

namespace App\Http\Controllers;

use App\BicycleToService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BicycleToServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bicycles = DB::table('bicycles')->paginate(15);


        return view('bicyclesToService.index', compact('bicycles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bicyclesToService.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         =>  'string',
            'description'  => 'string',
            'price' => 'numeric',

        ]);

        $bicycle=  BicycleToService::create([
        'name' => request('name'),
        'description' => request('description'),
        'price' => request('price'),


        ]);



        // dd($bicycle);

        // $request->session()->put('key', 'myvalue');
        // $answer= $request->session()->get('key', 'default');
        // dump($answer);

        $imageName = 'hello'.time().'.'.request()->image->getClientOriginalExtension();
        //dd($imageName);
        //die;
        //$path = request()->image->move(public_path('images'), $imageName);
        //$path =request()->image->move(storage_path('images'), $imageName);

        // $path =  $request->file('image')->storeAs('/public/storage/images', $imageName);
        $path =  $request->file('image')->storeAs('images', $imageName);

        //$bicycle->image = $request->file('image');


        //dd($path);
        //$bicycle['image']= $path;
        $bicycle->image = $path;

        $bicycle->save();
        //dd($bicycle);

        //$img = request()->image;
        //$img = request('image');
        //dd($img);

        // $request->flash();
        // $request->flashOnly(['username', 'email']);
        // $request->flashExcept('password');

        Session::flash('message', 'Bicycle has written in DB');

        return redirect('bicycle')->with('message', 'A new bic is uploaded to DB');

        // $input = $request->all();
        // $name = $request->input('name');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BicycleToService  $bicycleToService
     * @return \Illuminate\Http\Response
     */
    public function show(BicycleToService $bicycleToService)
    {
        return view('bicyclesToService.show', compact('$bicycleToService'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BicycleToService  $bicycleToService
     * @return \Illuminate\Http\Response
     */
    public function edit(BicycleToService $bicycleToService)
    {
        return view('bicyclesToService.edit', compact('bicycleToService'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BicycleToService  $bicycleToService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BicycleToService $bicycleToService)
    {
        $data= $request->all();
        // echo "<pre>";
        // print_r($data);
        //die;

        // Form validation
        $request->validate([
            'name'              =>  'string',
            'description'  => 'string',
            'price' => 'numeric',
            'image'     =>  'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get current bike
        //$bicycle = Bicycle::findOrFail($bicycle);
        // Set bike name
        $bicycleToService->name = $request->input('name');
        $bicycleToService->description = $request->input('description');
        $bicycleToService->price = $request->input('price');



        //dd($bicycle);


        // Check if a profile image has been uploaded
        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')).'_'.time();
            // Define folder path
            $folder = 'images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $bicycleToService->image = $filePath;
        }
        // Persist user record to database
        $bicycleToService->save();
        //dd($bicycle);


        // Return user back and show a flash message
        return redirect('bicycles')->with(['message' => 'Bicycle updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BicycleToService  $bicycleToService
     * @return \Illuminate\Http\Response
     */
    public function destroy(BicycleToService $bicycleToService)
    {
        //$bicycle = Bicycle::findOrFail($bicycle);
        $bicycleToService->delete();
        return redirect()->route('bicycles.index')
            ->with(
                'message',
                'Bike successfully deleted'
            )->with('alert-class', 'alert-danger');
    }

    public function service()
    {
        // $bicycles_in_service = DB::select('select * from bicycles where is_serviceable = ?', [1]);
        // return view('bicycleservice', compact('bicycles_in_service'));

        $user_id = auth()->user()->id;
        //echo($user_id);

        // $myBicycleServiceProgress = DB::select('select * from services where user_id = ?', [$user_id]);
        // print_r($myBicycleServiceProgress);

        // $myBicycleServiceProgress = DB::whereRaw('select * from services, user_id = $user_id');
        // print_r($myBicycleServiceProgress);

        // $myBicycleServiceProgress = DB::table('users')->leftJoin('services', 'users.id', '=', 'services.user_id')->get();
        // print_r($myBicycleServiceProgress);
        // dd($myBicycleServiceProgress);

        $myBicycleServiceProgress = DB::table('services')
                                    ->where('user_id', [$user_id])
                                    ->where('isActive', '1')
                                    ->get();

        //print_r($myBicycleServiceProgress);
        //dd($myBicycleServiceProgress);

        // return view('bicycleservice', compact('bicycles_in_service'));
        return view('bicycleservice', compact('myBicycleServiceProgress'));
    }
}
