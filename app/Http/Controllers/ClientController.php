<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClient;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.index', ['clients' => Client::orderBy('id')->cursorPaginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request, $clientId)
    {
        $validatedData = $request->validated();

        $oldClient = Client::findOrFail($clientId);
        $newClient = Client::make($validatedData);


        $hasFile = $request->hasFile('photo');
        if ($hasFile) {
            $path = $request->file('photo')->store('photos');
            $newClient->photo = $path;

            if ($oldClient->photo) {
                Storage::delete($oldClient->photo);
            }
        }

        $newClient->save();
        $request->session()->flash('status', 'Client is successfully created');
        return redirect()->route('client.index');
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
    public function edit($id)
    {
        return view('client.edit', ['client' => Client::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, StoreClient $request)
    {
        $client = Client::findOrFail($id);
        $validatedData = $request->validated();
        $client->fill($validatedData);

        $hasFile = $request->hasFile('photo');
        if ($hasFile) {
            $path = $request->file('photo')->store('photos');
            $client->photo = $path;
        }

        $client->save();
        $request->session()->flash('status', 'Client with ID ' . $id . ' is successfully updated');
        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $client = Client::findOrFail($id);
        if ($client->photo) {
            Storage::delete($client->photo);
        }
        $client->delete();
        $request->session()->flash('status', 'Client ID ' . $id . ' is successfully deleted');
        return redirect()->route('client.index');
    }
}
