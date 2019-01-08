<?php

namespace App\Http\Controllers;

use App\Events\RequestCreatePrivate;
use App\UserRequest;
use App\User;
use Illuminate\Http\Request;

class RequestController extends Controller
{
	public function __construct() {
        $this->middleware('auth');
    }

	public function createRequest(User $receiver, Request $request) {
		$params = $request->all();
        $me     = \Auth::user();
        $request = UserRequest::create($params);
		$request->sender()->associate($me);
        $request->receiver()->associate($receiver);
        $request->save();

        event(new RequestCreatePrivate($request));

        return $request->toJson();;
	}
}