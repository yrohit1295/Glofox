<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\User;

class Controller extends BaseController {

    protected $obj;

    public function __construct() {
        $this->obj = new User();
    }

    public function classes(Request $request) {
        return $this->obj->createClasses($request);
    }

    public function bookings(Request $request) {
        return $this->obj->createBookings($request);
    }

}
