<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\clerk\Bundles;
use App\Models\clerk\Items;
use App\Models\clerk\SubCategories;
use App\Models\user\User;
use App\Models\user\Notification;
use App\Models\admin\Stores;
use Illuminate\Http\Request;

class BundlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Bundles';
        $data['bundles'] = Bundles::where('store_id',$store_id)->get();
        $data['section'] = "Bundles";

        return view('clerk/bundles/list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Bundles';
        $data['section'] = "Bundles";
        $data['sub_categories']=SubCategories::all();
        $data['items']=Items::where('store_id',$store_id)->get();
        return view('clerk/bundles/new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Africa/Cairo');


        $validatedData = $request->validate([
            'bundle_name_ar' => 'required|min:3|max:255',
            'bundle_name' => 'required|min:3|max:255',
            'description' => 'required|max:1000',
            'description_ar' => 'required|max:1000',
            'sub_category_id' => 'required|max:255',
            'items' => 'required|max:255',
            'price' => 'required',
            'total_after_discount' => 'required',
            'img' => 'required',
            'stock' => 'required',


        ]);

        $imageName = time().'.'.$request->img->extension();
        $store_id=$request->session()->get('store_id');
        $request->img->move(public_path('images/items'), $imageName);

        $bundel = Bundles::create([
            'bundle_name_ar'=> $request->bundle_name_ar,
            'bundle_name'=>$request->bundle_name,
            'sub_category_id'=>$request->sub_category_id,
            'items'=>serialize($request->items),
            'price'=>$request->price,
            'status'=>$request->status??0,
            'stock'=>$request->stock,
            'store_id'=>$store_id,
            'total_after_discount'=>$request->total_after_discount,
            'created_at'=>date('Y-m-d H:i:s'),
            'img'=>$imageName
        ]);

        $users = User::get();
        $store = Stores::find($store_id);
        $msg = $store->en_name." Added a new offer.";
        $type = 1;
        foreach ($users as $key => $user) {
          if($user->device_type == 0){
            $sendNotification = $this->sendPushNotification($user->device_token,$msg,$type,$data=array());
          }

          if($user->device_type == 1){
            $sendNotification = $this->iospushnotification($user->device_token,$msg,$type,$data=array());
          }
          $notification = new Notification;
          $notification->message = $msg;
          $notification->user_id = $user->id;
          $notification->type = $type;
          $notification->image = $imageName;
          $notification->notification_data = json_encode($bundel);
          $notification->save();

        }
        
        $request->session()->flash('message', 'Successfully Add New Bundle !');

        return redirect('clerk/bundles/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clerk\Bundles  $bundles
     * @return \Illuminate\Http\Response
     */
    public function show(Bundles $bundles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clerk\Bundles  $bundles
     * @return \Illuminate\Http\Response
     */
    public function edit(Bundles $bundles,Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Bundles';
        $data['section'] = "Bundles";
        $data['storeitems']=Items::where('store_id',$store_id)->get();
        $data['bundles'] = Bundles::where('id', $request->segment(3))->where('store_id',$store_id)->first();
        $data['sub_categories']=SubCategories::all();
        return view('clerk/bundles/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clerk\Bundles  $bundles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bundles $bundles)
    {
        date_default_timezone_set('Africa/Cairo');
        $validatedData = $request->validate([
            'bundle_name_ar' => 'required|min:3|max:255',
            'bundle_name' => 'required|min:3|max:255',
            'description' => 'required|min:20|max:1000',
            'description_ar' => 'required|min:20|max:1000',
            'sub_category_id' => 'required|max:255',
            'items' => 'required|max:255',

            'price' => 'required',
            'total_after_discount' => 'required',
            'stock' => 'required',

        ]);


        if(!empty($request->logo)){

            $imageName = time().'.'.$request->img->extension();
            $request->img->move(public_path('images/items'), $imageName);

        }else{
            $imageName=$request->img_src  ;
        }

        $items=Bundles::find($request->segment(3))  ;

        $items->bundle_name_ar= $request->bundle_name_ar;
        $items->bundle_name=$request->bundle_name;
        $items->description= $request->description;
        $items->description_ar=$request->description_ar;
        $items->sub_category_id=$request->sub_category_id;
        $items->items=serialize($request->items);
        $items->price=$request->price;
        $items->total_after_discount=$request->total_after_discount;
        $items->status=$request->status??0;
        $items->stock=$request->stock;
        $items->updated_at=date('Y-m-d H:i:s');
        $items->img=$imageName ;

        $items->save();


        $request->session()->flash('message', 'Successfully Update Bundle !');

        return redirect('clerk/bundles/'.$request->segment(3).'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clerk\Bundles  $bundles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bundles $bundles,Request $request)
    {
        Bundles::destroy($request->segment(3));
        return redirect('clerk/bundles');
    }



    public function sendPushNotification($token,$msg="",$type,$data=array()) {
       $url = 'https://fcm.googleapis.com/fcm/send';
       $fields = array(
           "registration_ids" => array(
               $token
           ),
           "notification" => array(
               "body" => $msg,
               "sendby" => "Grabit",
               "establishment_detail" => "Grabit",
               "type" => "Grabit",
               "content-available" => 1,
               "badge" => 0,
               "sound" => "default",
           ),
           "data" => array(
               "body" => $msg,
               "sendby" => "Grabit",
               "establishment_detail" => "Grabit",
               "content-available" => 1,
               "badge" => 0,
               "sound" => "default",
               "type"=> $type,
               "data"=>$data,
               "base_url"=>url("/")
           ),
           "priority" => 1
       );

       $fields = json_encode($fields);
       
       $headers = array(
           'Authorization: key=' . "AAAA5Rj4RBU:APA91bECTiRSo3HsokP01DMjPGf7_W8WiyYwjJY70gVUsINmeSQ0aKpuq4DSAfkcRG2pfrbb2pu7uvYIsmRitfY4dDUf5n3YuK_jHnjpxOu1rr-iifuU2LwYWUCIsLAelbqo1hzHaVz0",
           'Content-Type: application/json'
       );
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

       $result = curl_exec($ch);
       curl_close($ch);

       return $result;
   }

   public function iospushnotification($token,$msg="",$type,$data=array()) {
       // echo "<pre>";print_r($data);die;
       $url = 'https://fcm.googleapis.com/fcm/send';
       $notification = [
           'sound' => 'Default',
               "data"=>"test",
               "base_url"=>url("/"),
           "body" => $msg,
           "type" => $type,
           "data"=>$data
       ];
       $fields = array(
           'to' => $token,
           'notification' => $notification,
           
       );
       $fields = json_encode($fields);
       $headers = array(
           'Authorization: key=' . "AAAA5Rj4RBU:APA91bECTiRSo3HsokP01DMjPGf7_W8WiyYwjJY70gVUsINmeSQ0aKpuq4DSAfkcRG2pfrbb2pu7uvYIsmRitfY4dDUf5n3YuK_jHnjpxOu1rr-iifuU2LwYWUCIsLAelbqo1hzHaVz0",
           'Content-Type: application/json'
       );
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
       $result = curl_exec($ch);
       curl_close($ch);
       // print_r($result);die;
       return $result;
   }
}
