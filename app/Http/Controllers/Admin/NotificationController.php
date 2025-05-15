<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index(){

        $notifications = Notification::when(request('message'), function ($query, $message) {
            return $query->where('message', 'LIKE', '%' . $message . '%');
        })->paginate(10);

        return view('notification.index', compact('notifications'));
        
    }

    public function create(){
        return view('notification.create');
    }

    public function store(Request $request){

        $request->validate(
            [
                'message' => 'required|string',
            ],
            [],
            [
                'message' => 'Message',
            ]
        );

        $notification=new Notification();
        $notification->message=$request->message;
        $notification->save();

        return redirect()->route('notification.index')->with('success', 'Notification send successfully');
    }

    public function edit(Notification $notification){

        return view('notification.edit', compact('notification'));

    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate(
            [
                'message' => 'required|string',
            ],
            [],
            [
                'message' => 'Message',
            ]
        );

        $notification->message=$request->message;
        $notification->save();

        return redirect()->route('notification.index')->with('success', 'Notification updated successfully');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('notification.index')->with('success', 'Notification deleted successfully');
    }
}
