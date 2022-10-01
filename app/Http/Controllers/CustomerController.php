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
    public function index() : JsonResponse
    {
        return response()->json(Customer::all());
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
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request = null, int $id = null) : JsonResponse
    {
        if($id != null)
            $response = Customer::find($id);
        else{
            $response = $request->whenHas("name", function ($request){
                return response()->Customer::where("name", "=", $request->name)->first()->limit(1)->get();
            });
        }
        return response()->json($response);
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
