<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function toggle(Request $request): JsonResponse
    {
        if (Auth::check()) {
            Auth::user()->update(['dark_mode' => $request->boolean('dark_mode')]);
        }

        return response()->json(['success' => true]);
    }
}
