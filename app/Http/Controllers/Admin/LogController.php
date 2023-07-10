<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            when(isset($search['order']), function ($query) use ($search) {
                if ($search['order'] != -1) {
                   return $query->where('order_id', 'LIKE', "%{$search['order']}%");
                }
             })
             -> when(isset($search['url']), function ($query) use ($search) {
                if ($search['url'] != -1) {
                   return $query->where('url', 'LIKE', "%{$search['url']}%");
                }
             })
             -> when(isset($search['method']), function ($query) use ($search) {
                if ($search['method'] != -1) {
                   return $query->where('method', 'LIKE', "%{$search['method']}%");
                }
             })
            ->get();

            $logs = ProviderLog::all();
            return view('admin.pages.log.show', compact('logs','logs_searchs'));

    }

}
