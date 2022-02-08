<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBilling;
use App\Models\Client;
use App\Models\Billing;
use Illuminate\Http\Request;

class ClientBillingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client)
    {
        return view(
            'client.clientBilling.index',
            [
                'billings' => Billing::where('client_id', '=', $client->id)->orderBy('id')->cursorPaginate(10),
                'client' => $client
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {
        return view('client.clientBilling.create', ['client' => $client]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($clientId, StoreBilling $request)
    {

        $validatedData = $request->validated();
        $billing = Billing::make($validatedData);
        $billing->client_id = $clientId;
        $billing->save();

        $request->session()->flash('status', 'Billing  is successfully created');
        return redirect()->route('client.billing.index', ['client' => Client::find($clientId)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($clientId, Billing $billing)
    {
        return view('client.clientBilling.edit', ['client' => $clientId, 'billing' => $billing]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBilling $request, $clientId, $billingId)
    {
        $billing = Billing::findOrFail($billingId);
        $validatedData = $request->validated();
        $billing->fill($validatedData);
        $billing->save();
        $request->session()->flash('status', 'Billing with ID ' . $billingId . ' is successfully updated');
        return redirect()->route('client.billing.index', ['client' => Client::find($clientId)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($clientId, $billingId, Request $request)
    {
        Billing::where('id', $billingId)->delete();
        $request->session()->flash('status', 'Billing ID ' . $billingId . ' is successfully deleted');
        return redirect()->route('client.billing.index', ['client' => Client::find($clientId)]);
    }
}
