<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Product;
use App\Models\StockRequestHeader;
use App\Models\StockRequestLine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = StockRequestHeader::with("user")->get();
        return response()->json($data);
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

        $sr = new StockRequestHeader();
        $counter = Counter::find(1);
        $user = User::where("nik", $request->head['nik'])->first();
        $sr->user_id = $user->id;
        $sr->code = "SR-" . str_pad($counter->current_value, 5, 0, STR_PAD_LEFT);
        $sr->date_requested = Carbon::parse($request->head['date_requested']);
        $sr->save();

        foreach($request->line as $item){
            $line = new StockRequestLine();
            $line->stock_request_header_id = $sr->id;
            $line->product_id = $item["barang"];
            $line->qty = $item["qty"];
            $line->notes = $item["keterangan"];
            $line->status = 1;
            $line->save();

            $product = Product::find($item["barang"]);
            $product->qty -= $line->qty;
            $product->save();
        }
        $counter->current_value +=1;
        $counter->save();
        return response()->json("Ok", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data["header"] = StockRequestHeader::find($id);
        $data["line"] = StockRequestLine::where("stock_request_header_id",$id)->get();
        return response()->json($data);
    }

    public function getHeader($id)
    {
        $data = StockRequestHeader::with("user.department")->find($id);
        return response()->json($data);
    }

    public function getLine($id)
    {
        $data = StockRequestLine::with("product.location","product.unit")->where("stock_request_header_id",$id)->get();
        return response()->json($data);
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
    public function update(Request $request, $id)
    {
        //
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
