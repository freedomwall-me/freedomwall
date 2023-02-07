<?php

namespace App\Http\Controllers;

use App\Http\HttpResponse;
use App\Mail\FeedbackSentMail;
use App\Mail\UserFeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class EmailController extends BaseController
{
    use HttpResponse;

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'body' => 'required',
        ]);

        \Mail::to(config('mail.support'))->send(new UserFeedbackMail($data));
        \Mail::to($data['email'])->send(new FeedbackSentMail($data));

        return $this->success('Feedback sent successfully.', [
            'email' => $data['email'],
            'body' => $data['body'],
        ]);
    }
}
