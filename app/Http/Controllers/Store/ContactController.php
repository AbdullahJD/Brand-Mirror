<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('Store.pages.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Mail::raw("
            Name: {$request->name}
            Email: {$request->email}

            Message:
            {$request->message}
        ", function ($mail) use ($request) {

            $mail->to('abdullah.o.aljuaidi@gmail.com') //  غيرها لإيميلك
                 ->subject($request->subject);
        });

        return back()->with('success', __('messages.flash_message_sent'));
    }
}
