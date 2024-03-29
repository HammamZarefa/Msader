<?php

namespace App\Http\Controllers;

use App\ExternalProviders\AbstractOperation;
use App\Models\ApiProvider;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Stevebauman\Purify\Facades\Purify;
use Validator;

class ApiProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $api_providers = ApiProvider::orderBy('id', 'DESC')->get();
        foreach ($api_providers as $provider) {
            $this->balanceUpdate($provider->id);
        }
        return view('admin.pages.api_providers.show', compact('api_providers'));
    }

    public function create()
    {
        $availableProviders = AbstractOperation::getAvialableProviders();
        foreach ($availableProviders as $key => $provider) {
            $providerData[$provider] = app()->make($provider)->getProviderSettings();
            $providerData[$provider]['api_name'] = $key;
            $providerData[$provider]['url'] = $providerData[$provider][0]['options'][0]['value'];
        }
        return view('admin.pages.api_providers.add', compact('providerData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $apiProviderData = Purify::clean($request->all());
        $rules = [
            'api_name' => 'sometimes|required',
            'api_key' => 'sometimes|required',
            'url' => 'sometimes|required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $ApiProvider = new ApiProvider();
        $ApiProvider->api_name = $apiProviderData['api_name'];
        $ApiProvider->api_key = $apiProviderData['api_key'];
        $ApiProvider->url = $apiProviderData['url'];
        $ApiProvider->slug = $apiProviderData['slug'];
//        $apiLiveData = Curl::to($apiProviderData['url'])->withData(['key' => $apiProviderData['api_key'], 'action' => 'balance'])->post();
//        $currencyData = json_decode($apiLiveData);
//        if (isset($currencyData->balance)):
//            $ApiProvider->balance = $currencyData->balance;
//            $ApiProvider->currency = $currencyData->currency;
//        elseif (isset($currencyData->error)):
//            $error = $currencyData->error;
//        else:
//            $error = "Please Check your API URL Or API Key";
//        endif;
        $ApiProvider->status = $apiProviderData['status'];
        $ApiProvider->description = $apiProviderData['description'];
//        if (isset($error)):
//            return back()->with('error', $error)->withInput();
//        endif;
        $ApiProvider->save();
        return back()->with('success', 'successfully updated');
    }

    public function activeMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');
            return response()->json(['error' => 1]);
        } else {
            $ids = explode(",", $request->strIds);
            $apiProvider = ApiProvider::whereIn('id', $ids);
            $apiProvider->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Updated Successfully!');
            return response()->json(['success' => 1]);
        }

    }

    public function deActiveMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');
            return response()->json(['error' => 1]);
        } else {
            $ids = explode(",", $request->strIds);
            $apiProvider = ApiProvider::whereIn('id', $ids);
            $apiProvider->update([
                'status' => 0,
            ]);
            session()->flash('success', 'Updated Successfully.');
            return response()->json(['success' => 1]);
        }
    }


    public function edit(ApiProvider $apiProvider)
    {
        $provider = ApiProvider::find($apiProvider->id);
        return view('admin.pages.api_providers.edit', compact('provider'));
    }


    public function update(Request $request, ApiProvider $apiProvider)
    {
        $rules = [
            'api_name' => 'sometimes|required',
            'api_key' => 'sometimes|required',
            'url' => 'sometimes|required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $provider = ApiProvider::find($apiProvider->id);
        $provider->api_name = $request['api_name'];
        $provider->api_key = $request['api_key'];
        $provider->url = $request['url'];
        $apiLiveData = Curl::to($request['url'])->withData(['key' => $request['api_key'], 'action' => 'balance'])->post();
//        $currencyData = json_decode($apiLiveData);
//        if (isset($currencyData->balance)):
//            $provider->balance = $currencyData->balance;
//            $provider->currency = $currencyData->currency;
//        elseif (isset($currencyData->error)):
//            $error = $currencyData->error;
//        else:
//            $error = "Please Check your API URL Or API Key";
//        endif;
        $provider->status = $request['status'];
        $provider->description = $request['description'];
        if (isset($error)):
            return back()->with('error', $error)->withInput();
        endif;
        $provider->save();
        return back()->with('success', 'successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApiProvider $apiProvider)
    {
        $apiProvider->delete();
        return back()->with('success', 'Successfully Deleted');;
    }

    /*
     ** multiple delete
     */
    public function deleteMultiple(Request $request)
    {
        $ids = $request->strIds;
        ApiProvider::whereIn('id', explode(",", $ids))->delete();
        return back()->with('success', 'Delete Success');
    }

    public function changeStatus($id)
    {
        $apiProvider = ApiProvider::find($id);
        if ($apiProvider['status'] == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $apiProvider->status = $status;
        $apiProvider->save();
        return back()->with('success', 'Successfully Changed');
    }


    public function priceUpdate($id)
    {
        dd(1);
        $provider = ApiProvider::with('services')->findOrFail($id);
        $apiLiveData = Curl::to($provider->url)->withData(['key' => $provider->api_key, 'action' => 'services'])->post();
        $currencyData = json_decode($apiLiveData);
        foreach ($provider->services as $k => $data) {
            if (isset($data->price)) {
                $data->update([
                    'api_provider_price' => collect($currencyData)->where('service', $data->api_service_id)->pluck('price')[0] ?? $data->api_provider_price ?? $data->price,
                    'price' => collect($currencyData)->where('service', $data->api_service_id)->pluck('price')[0] ?? $data->price
                ]);
            }
        }
        return back()->with('success', 'Successfully updated');
    }

    public function balanceUpdate($id)
    {
        $provider = ApiProvider::findOrFail($id);
        if (isset($provider->slug))
            $providerBalance = app()->make($provider->slug)->setProvider(mapProvider($provider))->getUserBalance();
        else {
            $apiLiveData = Curl::to($provider->url)->withData(['key' => $provider->api_key, 'action' => 'balance'])->post();
            $providerBalance = json_decode($apiLiveData, 1);
        }
        $provider->update([
            'balance' => $providerBalance['balance'] ?? $provider->balance,
        ]);
        return back()->with('success', 'Successfully updated');
    }


    public function getApiServices(Request $request)
    {
        $rules = [
            'api_provider_id' => 'required|string|max:150'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $provider = ApiProvider::find($request->api_provider_id);
        if (isset($provider->slug)) {
            $apiServiceLists = app()->make($provider->slug)->setProvider(mapProvider($provider))->getServices();
            $apiServiceLists = collect($apiServiceLists)->map(function ($array) {
                return (object)$array;
            })->toArray();;
        } else {
            $apiLiveData = Curl::to($provider['url'])->withData(['key' => $provider['api_key'], 'action' => 'services'])->get();
            $apiServiceLists = json_decode($apiLiveData);
        }
        return view('admin.pages.services.show-api-services', compact('apiServiceLists', 'provider'));
    }

    public function import(Request $request)
    {
        $req = $request->all();
        $all_category = Category::all();
        $services = Service::all();
        $insertCat = 1;
        $existService = 0;
        if (isset($req['category']))
            foreach ($all_category as $categories):
                if ($categories->category_title == $req['category']):
                    $insertCat = 0;
                endif;
            endforeach;
        if ($insertCat == 1):
            $cat = new Category();
            $cat->category_title = $req['category'] ?? $req['name'];
            $cat->status = 1;
            $cat->save();
        endif;
        foreach ($services as $service):
            if ($service->api_provider_id == $req['id']):
                $existService = 1;
            endif;
        endforeach;
        if ($existService != 1):
            $service = new Service();
            $idCat = Category::where('category_title', $req['category'] ?? $req['name'])->first()->id;
            $service->service_title = $req['name'];
            $service->category_id = $idCat;
            $service->min_amount = $req['min'] ?? 1;
            $service->max_amount = $req['max'] ?? 1;
            $increased_price = (@$req['rate'] * $req['price_percentage_increase']) / 100;
            $service->price = @$req['rate'] + $increased_price;
            $service->service_status = 1;
            $service->api_provider_id = $req['provider'];
            $service->api_service_id = @$req['id'];
            $service->drip_feed = @$req['dripfeed'];
            $service->api_provider_price = @$req['rate'];
            $service->save();
            return redirect()->route('admin.service.show');
        else:
            return redirect()->route('admin.service.show')->with('success', 'Already Have this service');
        endif;

    }

    public function importMulti(Request $request)
    {
        $req = $request->all();
        $provider = ApiProvider::find($req['provider']);
        if (isset($provider->slug)) {
            $apiServiceLists = app()->make($provider->slug)->setProvider(mapProvider($provider))->getServices();
            $apiServicesData = collect($apiServiceLists)->map(function ($array) {
                return (object)$array;
            })->toArray();
        } else {
            $apiLiveData = Curl::to($provider['url'])
                ->withData(['key' => $provider['api_key'], 'action' => 'services'])->post();
            $apiServicesData = json_decode($apiLiveData);
        }
        $count = 0;
        foreach ($apiServicesData as $apiService):
            $all_category = Category::all();
            $services = Service::all();
            $insertCat = 1;
            $existService = 0;
            if (isset($apiService->category)) {
                foreach ($all_category as $categories):
                    if ($categories->category_title == $apiService->category):
                        $insertCat = 0;
                    endif;
                endforeach;
                if ($insertCat == 1):
                    $cat = new Category();
                    $cat->category_title = $apiService->category;
                    $cat->status = 1;
                    $cat->save();
                endif;
            } else {
                $cat = Category::firstOrCreate(["category_title" => "new Imported products"]);
                $apiService->category = $cat->category_title;
            }
            foreach ($services as $service):
                if ($service->api_service_id == $apiService->service && $provider->id == $service->api_provider_id):
                    $existService = 1;
                endif;
            endforeach;
            if ($existService != 1):
                $service = new Service();
                $idCat = Category::where('category_title', @$apiService->category)->first()->id;
                $service->service_title = $apiService->name;
                $service->category_id = $idCat;
                $service->min_amount = $apiService->min ?? 1;
                $service->max_amount = $apiService->max ?? 1;
                $increased_price = ($apiService->rate * 10) / 100;
                $increased_price = ($apiService->rate * $req['price_percentage_increase']) / 100;
                $service->price = $apiService->rate + $increased_price;
                $service->service_status = 1;
                $service->api_provider_id = $req['provider'];
                $service->api_service_id = $apiService->service;
                $service->drip_feed = @$apiService->dripfeed;
                $service->api_provider_price = $apiService->rate;

                if (isset($apiService->desc)) {
                    $service->description = @$apiService->desc;
                } else {
                    $service->description = @$apiService->description;
                }
                $service->save();
            endif;
            $count++;
            if ($req['import_quantity'] == 'all'):
                continue;
            elseif ($req['import_quantity'] == $count):
                break;
            endif;
        endforeach;
        return redirect()->route('admin.service.show');

    }

    public
    function providerShow(Request $request)
    {
        $provider = ApiProvider::where('api_name', 'LIKE', "%{$request->data}%")->get()->pluck('api_name');
        return response()->json($provider);
    }

    public
    function search(Request $request)
    {
        $search = $request->all();
        $api_providers = ApiProvider::when(isset($search['provider']), function ($query) use ($search) {
            return $query->where('api_name', 'LIKE', "%{$search['provider']}%");
        })->when(isset($search['status']), function ($query) use ($search) {
            return $query->where('status', $search['status']);
        })->get();
        $api_providers->append($search);
        return view('admin.pages.api_providers.show', compact('api_providers'));
    }

    public
    function smsActivateGetCountries($product)
    {
        $provider = ApiProvider::where('slug', 'smsactivate')->first();
        $countries = Curl::to($provider['url'])->withData(['api_key' => $provider['api_key'], 'action' => 'getTopCountriesByService', 'service' => $product])->get();
        $countries = json_decode($countries);
        foreach ($countries as $country) {
            $country->name = getDataFromCountry($country->country)['eng'];
        }
        return $countries;
    }
}
