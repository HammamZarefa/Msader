<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Models\PaymentHistory;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        $page_title = "Payment History";
        $payments = PaymentHistory::orderBy('created_at', 'desc')->get();
        return view('admin.pages.payment_history.index', compact('payments', 'page_title'));
    }

    public function create()
    {
        $page_title = "Payment History";
        return view('admin.pages.payment_history.create', compact('page_title'));
    }

    public function store(StoreInvoiceRequest $request)
    {
        $validated = $request->validated();
        $payment = PaymentHistory::create($validated);
        if (!$payment) {
            throw new \Exception('Unexpected error! Please try again.');
        }
        return redirect()->route('admin.payment-history.index')->with('success', 'Payment data has been saved.');
    }

    public function edit($id)
    {
        $payment = PaymentHistory::findorfail($id);
        return view('admin.pages.payment_history.edit', compact('payment'));
    }
    public function show($id)
    {

    }
    public function update(UpdateInvoiceRequest $request, $id)
    {
        $payment = PaymentHistory::findorfail($id);
        $payment = $payment->update($request->all());
        if (!$payment) {
            throw new \Exception('Unexpected error! Please try again.');
        }
        return back()->with('success', 'payment data has been updated.');
    }

    public function destroy($id)
    {
        $payment = PaymentHistory::findorfail($id);
        $payment->delete();
        return redirect()->route('admin.payment-history.index')->with('success', 'Payment data has been deleted.');
    }
}
