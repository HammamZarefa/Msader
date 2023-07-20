<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(){
        $invoices = Invoice::orderBy('created_at','desc')->get();
        return view('admin.pages.invoices.show',compact('invoices'));
    }

    public function add(){
        return view('admin.pages.invoices.add_invoice');
    }

    public function create(StoreInvoiceRequest $request){
        Invoice::create($request->all());

        $invoices = Invoice::orderBy('created_at','desc')->get();
        return view('admin.pages.invoices.show',compact('invoices')); 
    }
    public function Edit(Invoice $Invoice){
        return view('admin.pages.invoices.edit',compact('Invoice')); 
    }

    public function update(UpdateInvoiceRequest $request ,Invoice $Invoice){
        $Invoice->update($request->all());
        $invoices = Invoice::orderBy('created_at','desc')->get();
        return view('admin.pages.invoices.show',compact('invoices')); 
    }

    public function destroy(Invoice $invoices){
        $invoices->delete();
        $invoices = Invoice::orderBy('created_at','desc')->get();
        return view('admin.pages.invoices.show',compact('invoices'))->with('success');
    }
}
