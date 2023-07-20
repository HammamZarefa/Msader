<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\ProviderLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = ProviderLog::all();
        return view('admin.pages.log.show', compact('logs'));
    }

    public function search(Request $request)
    {
        $search = $request->all();
        $logs = ProviderLog::when(isset($search['url']), function ($query) use ($search) {
            if ($search['url'] != -1) {
                return $query->where('url', 'LIKE', "%{$search['url']}%");
            }
        })
            ->when(isset($search['date']), function ($query) use ($search) {
                return $query->whereDate("created_at", $search['date']);
            })
            ->orderBy('created_at', 'desc')->get();
        $providers = ApiProvider::all();
        return view('admin.pages.log.show', compact('providers', 'logs'));
    }

}
