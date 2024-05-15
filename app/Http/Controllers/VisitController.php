<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;


class VisitController extends Controller
{
    public function index()
    {
        $visit = Visit::all();

        return Inertia::render('Dashboard', [
            'visit' => $visit, //
        ]);
    }
}
