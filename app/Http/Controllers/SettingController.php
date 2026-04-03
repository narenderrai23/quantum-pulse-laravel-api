<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Setting::all(['key', 'value']));
    }

    // Public endpoint — only exposes safe keys for the frontend
    public function public(): JsonResponse
    {
        $keys = ['site_name', 'logo_url', 'favicon_url'];
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key');
        return response()->json($settings);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'key'   => 'required|string',
            'value' => 'nullable|string',
        ]);

        Setting::set($request->key, $request->value ?? '');

        return response()->json(['message' => 'Setting updated.']);
    }

    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:logo,favicon',
            'file' => 'required|file|mimes:png,jpg,jpeg,gif,svg,ico|max:2048',
        ]);

        $type = $request->type;
        $path = $request->file('file')->store("uploads/{$type}", 'public');
        $url  = Storage::url($path);

        $key = $type === 'logo' ? 'logo_url' : 'favicon_url';
        Setting::set($key, $url);

        return response()->json(['url' => $url]);
    }
}
