<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\Request;

class AdminDashboardController
{
    public function index()
    {
        $submissions = FormSubmission::orderBy('created_at', 'desc')->get();

        return view('admin-dashboard-excel', [
            'submissions' => $submissions
        ]);
    }
}
