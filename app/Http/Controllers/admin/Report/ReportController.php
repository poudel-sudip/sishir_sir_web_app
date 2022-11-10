<?php

namespace App\Http\Controllers\admin\Report;

use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.reports.index',[]);
    }

}
