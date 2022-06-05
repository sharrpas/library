<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function signup(Request $request)
    {

        $validated_data = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:App\Models\User,email|email',
            'password' => [Password::required(), Password::min(4)->numbers(), 'confirmed'],
        ]);
        if ($validated_data->fails())
            return response()->json(['error' => true, 'data' => $validated_data->errors()]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['error' => false, 'data' => 'ثبت نام شما با موفقیت انجام شد']);

    }


    public function login(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validated_data->fails())
            return response()->json(['error' => true, 'data' => $validated_data->errors()]);


        if (!$user = User::query()->where('email', $request->email)->first()) {
            return response()->json([
                'error' => true,
                "data" => ["یوزر پیدا نشد"]
            ]);
        }

        $pass_check = Hash::check($request->password, User::query()->where('email', $request->email)->firstOrFail()->password);

        if ($user && $pass_check) {
            $isAdmin = false;
            if ($user->email == 'admin@gmail.com') $isAdmin = true;
            return response()->json([
                'error' => false,
                'isAdmin' => $isAdmin,
                'data' => 'با موفقیت وارد شدید',
                'token' => $user->createToken('token_base_name')->plainTextToken
            ]);
        } else {
            return response()->json(['error' => true, 'نام کاربری یا رمز عبو اشتباه است']);
        }

    }


    public function logout()
    {
        /** @var User $user */
        $user = auth()->user();

        $user->tokens()->delete();

        return response()->json(['data' => 'logged out']);
    }


    public function changePass(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'oldpass' => 'required',
            'newpass' => 'required',
        ]);
        if ($validated_data->fails())
            return response()->json(['error' => true, 'data' => $validated_data->errors()]);


        $pass_check = Hash::check($request->oldpass, User::query()->where('id', '=', auth()->id())->firstOrFail()->password);
        if ($pass_check) {
            User::query()->where('id', '=', auth()->id())->update([
                'password' => Hash::make($request->newpass)
            ]);
            return response()->json(['error' => false, 'data' => 'رمز شما تغییر یافت به  ' . $request->newpass]);
        } else {
            return response()->json(['error' => true, 'data' => 'رمز اشتباه است']);
        }
    }

    public function info()
    {
        $user = auth()->user();
        return response()->json([
            'data' => $user
        ]);
    }
}
