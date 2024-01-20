<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function settingIndex()
    {

        return view('admin.setting.index');

    }

    public function settingShow(){
        $data = Setting::first();

        return response()->json($data,200);
    }

    public function store(Request $request)
{
    // $settingId = $request->input('hiddenSettingId');
    $settingId = $request->hiddenSettingId;
    $date = now()->format('his') + rand(1000, 9999);
    $date1 = now()->format('his') + rand(1000, 9999);

    $logoPath = null;
    $faviconPath = null;

    if ($request->hasFile('company_logo')) {
        $logo = $request->file('company_logo');
        $extension = $logo->getClientOriginalExtension();
        $logoName = $date . '.' . $extension;
        $path = public_path('assets/images/users/company-logo');
        $logo->move($path, $logoName);
        $logoPath = $logoName;
    } else {
        $logoPath = $settingId ? Setting::findOrFail($settingId)->company_logo : null;
    }

    if ($request->hasFile('favicon')) {
        $favicon = $request->file('favicon');
        $extension = $favicon->getClientOriginalExtension();
        $faviconName = $date1 . '.' . $extension;
        $path = public_path('assets/images/users/favicon');
        $favicon->move($path, $faviconName);
        $faviconPath = $faviconName;
    } else {
        $faviconPath = $settingId ? Setting::findOrFail($settingId)->favicon : null;
    }

    if ($settingId == 0) {
        // Create a new setting
        $setting = Setting::create([
            'company_name' => $request->input('company_name'),
            'company_address' => $request->input('company_address'),
            'website' => $request->input('website'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'facebook' => $request->input('facebook'),
            'site_title' => $request->input('site_title'),
            'linkedIn' => $request->input('linkedIn'),
            'instagram' => $request->input('instagram'),
            'meta_description' => $request->input('meta_description'),
            'company_logo' => $logoPath,
            'favicon' => $faviconPath,
        ]);

        return response()->json([
            'msg' => 'Setting stored successfully',
            'setting' => $setting,
            'success' => true,
        ], 200);
    } else {
        // Update an existing setting
        $setting = Setting::findOrFail($settingId);
        $setting->company_name = $request->input('company_name');
        $setting->company_address = $request->input('company_address');
        $setting->website = $request->input('website');
        $setting->email = $request->input('email');
        $setting->phone = $request->input('phone');
        $setting->facebook = $request->input('facebook');
        $setting->site_title = $request->input('site_title');
        $setting->linkedIn = $request->input('linkedIn');
        $setting->instagram = $request->input('instagram');
        $setting->meta_description = $request->input('meta_description');
        $setting->company_logo = $logoPath;
        $setting->favicon = $faviconPath;
        $setting->update();

        return response()->json([
            'msg' => 'Setting updated successfully',
            'setting' => $setting,
            'success' => true,
        ], 200);
    }
}



}
