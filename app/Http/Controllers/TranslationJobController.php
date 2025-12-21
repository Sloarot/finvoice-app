<?php

namespace App\Http\Controllers;

use App\Models\TranslationJob;
use Illuminate\Http\Request;

class TranslationJobController extends Controller
{
    public function index()
    {
        $jobs = TranslationJob::with('client')->latest()->paginate(10);
        return view('translation-jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('translation-jobs.create');
    }
}
