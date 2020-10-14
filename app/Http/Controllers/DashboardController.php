<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserAction;
use App\Testimoni;
use App\Portofolio;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['landing']);
    }

    public function index()
    {
        return view('dashboard.index');
    }

    public function activity()
    {
        $activities = UserAction::all()->sortByDesc('created_at');

        return view('dashboard.activity', compact(['activities']));
    }

}
