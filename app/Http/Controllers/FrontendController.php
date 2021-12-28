<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function PrivacyPolicy()
    {
        return view('Frontend.privacy_policy');
    }
}
