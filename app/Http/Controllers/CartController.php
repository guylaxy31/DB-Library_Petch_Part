<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Products;
use Cart;

class CartController extends Controller
{

    //

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::content();
        return view('create.cart',['data' => $cart]);
    }
    public function additem($id)
    {
        $product = Products::find($id);
        $cart = Cart::add(['id' => $product->productCode, 'name' => $product->productName, 'qty' => 1, 'price' => $product->buyPrice ,'options' =>[
            'size' => $product->productScale,
            'stock' => $product->quantityInStock,
        ]]);
        if($cart){
            return view('create.cart',['data' => Cart::content()]);
        }
    }

    public function removeId($id)
    {
        Cart::remove($id);
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cart::add($request->productCode,$request->productName,1,$request->buyPrice)->associa('App\Products');
        return redirect()->route('cart.index')->with('success_massage','Item wass added to your cart');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $qty = $request->newQty;
      $rowId = $request->rowID;
        
            Cart::update($rowId,$qty);
            echo "Cart updated successfully";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    

    

    
}
