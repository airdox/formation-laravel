<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) : JsonResponse
    {
        if($request->name)
            $response = Customer::where("name", $request->name)->get();
        else if($request->id && $request->products)
            $response = Customer::find($request->id)->products()->get();
        else
            $response = Customer::all();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) : JsonResponse
    {
        $customer = Customer::create([
            "name" => $request->name
        ]);

        return response()->json($customer->save());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id = null) : JsonResponse
    {
        return response()->json(Customer::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id) : JsonResponse
    {
        $customer = Customer::find($id);
        if($request->product_attach)
            $update = $customer->products()->attach($request->product_attach);
        else if ($request->product_detach)
            $update = $customer->products()->detach($request->product_detach);
        else
            $update = $customer->update([
            "name" => $request->name,
            "wallet" => $request->wallet,
            "nbPurchasedProducts" => $request->nbPurchasedProducts
            ]);
        return response()->json($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : JsonResponse
    {
        $customer = Customer::find($id);
        return response()->json($customer->delete());
    }
}
