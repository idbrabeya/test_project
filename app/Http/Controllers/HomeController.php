<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Apiproject;

use Illuminate\Auth\Events\validated;
use Response;
use Spatie\FlareClient\Api;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    
    {
      
        return view('home');
    }

    public function info_create(Request $request){
        
        $request->validate([
              'name'=>'regex:/^\D.*$/',
              'phone'=>'min:11','numeric','max:11',
            //   'images'=>'required|mimes:png,jpeg,gif',
        ]);
         $test_data_insert = new Test;
         $test_data_insert->name= $request->name;
         $test_data_insert->email= $request->email;
         $test_data_insert->phone= $request->phone;
         $test_data_insert->marital_status= $request->marital_status;
     
         $test_data_insert->save();

         if ($request->hasFile('images')) {
            $imagePaths = [];
            $imagedata =[];
            foreach ($request->file('images') as $photo) {
                $image = new Image;
                $image_path = time() . '-' . uniqid() .'.'. $photo->getClientOriginalExtension();
                $photo_store = public_path('uploads');
                $photo->move($photo_store, $image_path);
                $image->images = $image_path;
                $imagedata[] =['images'=>$image_path];
                $imagePaths[] = $image_path; 
            }
            $test_data_insert->imagess()->createMany($imagedata);
        }
         return back();
        //  return response()->json(['status' => 'success']);   
    }
    public function info_data_show(){
        $datashows = Test::with('imagess')->get();
        return view('data_show',compact('datashows'));
    }
    public function info_edit($id){
    $info_edit=  Test::with('imagess')->findOrfail($id);
    return view('info_edit',compact('info_edit'));     
    }

    public function info_update(Request $request, $id){
        $info_update = Test::with('imagess')->findOrfail($id);
        $info_update->name = $request->name;
        $info_update->email = $request->email;
        $info_update->marital_status= $request->marital_status;
        $info_update->phone = $request->phone;
        $info_update->save();
        if(!$info_update){
            return back()->with('errors','image not found!');
        }
        if ($request->hasFile('new_image')){
            foreach ($request->file('new_image') as $new_photo) {
                $new_photo_update =new Image();
                $photo_path = time() .'_'. uniqid() .'.'. $new_photo->getClientOriginalExtension();
                $photo_store = public_path('uploads');
                $new_photo->move($photo_store,$photo_path);
                $new_photo_update->images=$photo_path;
                $new_photo_update->testre()->associate($info_update);
                $new_photo_update->save();
            }
          }
        return redirect()->route('info.data.show');
    }

    public function status_change(Request $request){
           $status_change =Test::findOrFail($request->id);
           if ($status_change->status== 1) {
            $status_change->status = 0;
           }else{
            $status_change->status = 1;
           }
        //$status_change->save;
           if($status_change->save()){
            return 1;
           } else{
            return 0;
           }    
    }

    public function info_image_delete($id){
          $info_image_delete = Image::findOrFail($id);
          $info_image_path ='uploads/' . $info_image_delete->images;
          unlink($info_image_path);
          $info_image_delete->delete();
          return back();
    }

    public function info_delete($id){
        $info_delete = Test::findOrFail($id);
        if($info_delete->imagess->isNotEmpty()){
        foreach ( $info_delete->imagess as $imag) {
            $image_path = 'uploads/' .   $imag->images;
            unlink($image_path); 
            $imag->delete();
        }
    }
        $info_delete->delete();
        return response()->json(['status'=>'success']);
    }


    public function user_data1(){
        $users= User::all(); 
        return response()->json(['user'=>$users]);
    }

    public function user_data(){
        $api_data = User::all();
        return view('user',compact('api_data'));
        // return response()->json($api_data, Response::HTTP_OK);

     }
     public function test_api(){
        $product = Apiproject::all();
        return response()->json(['product'=>$product]);
     }
     public function api_data(){
        $product = Apiproject::all();
        return view('user',compact('product'));
     
}

}