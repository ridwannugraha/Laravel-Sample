<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

use App\Suppliers;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date    = Carbon::now();
        $periode = $date->format('d/m/Y')." - ".$date->addDays(30)->format('d/m/Y');
        
        return view('datatables', [
            'periode' => $periode
        ]);
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
        //
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
        $Suppliers = Suppliers::find($id);
        return $Suppliers;
    }

    public function getData(Request $request){
        $periode  = collect(explode('-',$request->periode));
        
        $start    = Carbon::createFromFormat('d/m/Y', trim($periode->first()))->format('Y-m-d');
        $end      = Carbon::createFromFormat('d/m/Y', trim($periode->last()))->format('Y-m-d');

        $supplier = Suppliers::where(function ($query) use ($start, $end, $request) {
                        if ($request->name == 'all') {
                            $query->whereBetween('created_at', [$start, $end])->get();
                        }else{
                           $query->whereBetween('created_at', [$start, $end])->where('name', $request->name)->get(); 
                        };
                    });

        return Datatables::of($supplier)->make(true);
    }
}
