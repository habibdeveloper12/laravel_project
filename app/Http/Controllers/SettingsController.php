<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function settings()
    {
        $user = auth('admin')->user();
        if($user) {
            $settings = Settings::first();
            return view('backend.settings.settings', compact('settings'));
        }else{
            return redirect()->route('user.auth');
        }
    }

    public function settingsUpdate(Request $request)
    {
        $user = auth('admin')->user();
        if($user) {
            $settings = Settings::first();
            $settings = Settings::first();
            $this->validate($request, [
                'banner' => 'required',
                'banner_title' => 'string|required',
                'banner_description' => 'string|required',
                'carousel_title' => 'string|required',
                'meta_description' => 'string|nullable',
                'meta_keywords' => 'string|nullable',
                'logo' => 'required',
                'favicon' => 'nullable',
                'address' => 'string|required',
                'email' => 'string|required',
                'phone' => 'string|required',
                'about' => 'string|required',
                'workflow_image' => 'nullable|string',
                'workflow_background' => 'required',
                'facebook_url' => 'nullable',
                'twitter_url' => 'nullable',
                'instagram_url' => 'nullable',

            ]);
            $status = $settings->update([
                'banner' => $request->banner,
                'banner_title' => $request->banner_title,
                'banner_description' => $request->banner_description,
                'carousel_title' => $request->carousel_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                'logo' => $request->logo,
                'favicon' => $request->favicon,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'about' => $request->about,
                'workflow_image' => $request->workflow_image,
                'workflow_video' => $request->workflow_video,
                'workflow_background' => $request->workflow_background,
                'facebook_url' => $request->facebook_url,
                'twitter_url' => $request->twitter_url,
                'instagram_url' => $request->instagram_url,
            ]);

            if ($status) {
                return back()->with('success', 'Setting successfully updated');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        }else{
            return redirect()->route('user.auth');

        }
    }

    public function payment()
    {
        $user = auth('admin')->user();
        if($user) {
            return view('backend.settings.payment');
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function withdraw()
    {
        $user = auth('admin')->user();
        if($user) {
            $settings = Settings::first();
            return view('backend.settings.withdraw', compact('settings'));

        }else{
            return redirect()->route('user.auth');
        }
    }

    public function withdrawUpdate( Request $request)
    {
        $user = auth('admin')->user();
        if($user) {
            $this->validate($request, [
                'withdraw_fee' => 'required|numeric|between:1,100',
                'withdraw_min' => 'required|numeric',
                ]);


            $status =Settings::first()->update([
                'withdraw_fee' => $request->withdraw_fee,
                'withdraw_min' => $request->withdraw_min,
            ]);

            if($status){
                return back()->with('success', 'Updated Successfully');

            }else{
                return back()->with('error', 'Try again, Something went wrong');

            }

        }else{
            return redirect()->route('user.auth');
        }
    }
    //paypal

    public function paypalUpdate(Request $request)
    {
        foreach ($request->types as $key=>$type){
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $settings = Settings::first();

        if($request->has('paypal_sandbox')){
            $settings->paypal_sandbox= 1;
            $settings->save();
        }
        else{
            $settings->paypal_sandbox=0;
            $settings->save();
        }
        return back()->with('success', 'Payment settings updated');
    }

    public function overWriteEnvFile($type, $val){
        if(env('DEMO_MODE') != 'On'){
            $path = base_path('.env');

            if(file_exists($path)){
                $val ='"'.trim($val). '"';

                if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type)>= 0){
                    file_put_contents($path, str_replace(
                        $type. '="' .env($type). '"', $type. '=' .$val, file_get_contents($path)
                    ));
                }else{
                     file_put_contents($path, file_get_contents($path). "\r\n" .$type. '=' .$val);
                }
            }
        }
    }
}
