<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $featuredServices = Service::featured()
            ->active()
            ->ordered()
            ->get();

        if ($featuredServices->isEmpty()) {
            $featuredServices = Service::active()->ordered()->get();
        }

        return view("frontend.home.index", compact("featuredServices"));
    }
}
