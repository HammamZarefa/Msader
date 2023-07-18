<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\ProviderLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(){
        $logs = ProviderLog::all();
        return view('admin.pages.log.show', compact('logs'));
    }

    public function search(Request $request){
        $search = $request->all();
        $logs_searchs = ProviderLog::
            when(isset($search['url']), function ($query) use ($search) {
                if ($search['url'] != -1) {
                   return $query->where('url', 'LIKE', "%{$search['url']}%");
                }
             })
            ->orderBy('created_at', 'desc')->get();

            $logs = ProviderLog::all();
            $provider_api = ApiProvider::all();
            // dd($logs[55]['disclosure']['order_id']);
            return view('admin.pages.log.show', compact('provider_api','logs_searchs'));

    }

}
