<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    public function about(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'text' => 'required',
        ]);
        if ($validated_data->fails())
            return response()->json(['error' => true, 'data'=>$validated_data->errors()]);

        About::query()->updateOrCreate(['title' => 'About us'],['text' => $request->text]);

        return response()->json(['error' => false, 'data' => 'درباره ثبت شد']);

    }

    public function contact(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'text' => 'required',
        ]);
        if ($validated_data->fails())
            return response()->json(['error' => true, 'data'=>$validated_data->errors()]);

        Contact::query()->updateOrCreate(['title' => 'Contact Us'],['text' => $request->text]);

        return response()->json(['error' => false, 'data' => 'تماس با ما ثبت شد']);

    }
}
