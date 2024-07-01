<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
class NotificationController extends Controller
{
    public function index(){
        $notifications = Auth()->user()->notifications()->paginate(10); // Adjust the number as needed
        return view('backend.notification.index', compact('notifications'));
    }
    public function show(Request $request){
        $notification=Auth()->user()->notifications()->where('id',$request->id)->first();
        if($notification){
            $notification->markAsRead();
            return redirect($notification->data['actionURL']);
        }
    }
    public function delete($id){
        $notification=Notification::find($id);
        if($notification){
            $status=$notification->delete();
            if($status){
                session()->flash('success','Notification successfully deleted');
                return back();
            }
            else{
                session()->flash('error','Error please try again');
                return back();
            }
        }
        else{
            session()->flash('error','Notification not found');
            return back();
        }
    }
}
