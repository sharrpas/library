<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    public function about()
    {
        return response()->json(['error' => false, 'data' => About::query()->select('title','text')->first()]);
    }

    public function contact()
    {
        return response()->json(['error' => false, 'data' => Contact::query()->select('title','text')->first()]);
    }
}
