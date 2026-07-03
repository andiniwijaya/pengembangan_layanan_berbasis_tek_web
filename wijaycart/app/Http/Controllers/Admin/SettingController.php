<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingUpdateRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'store_name' => Setting::get('store_name', 'WijayCart'),
            'store_email' => Setting::get('store_email'),
            'store_phone' => Setting::get('store_phone'),
            'store_address' => Setting::get('store_address'),
            'store_description' => Setting::get('store_description'),
            'shipping_cost' => Setting::get('shipping_cost', '15000'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(SettingUpdateRequest $request): RedirectResponse
    {
        foreach ($request->only(['store_name', 'store_email', 'store_phone', 'store_address', 'store_description', 'shipping_cost']) as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
