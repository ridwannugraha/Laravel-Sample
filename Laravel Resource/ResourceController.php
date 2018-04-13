<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Product;
use App\Categori;
use App\ProductPhoto;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'name'          => 'required|string|max:255',
            'price'         => 'required|string|max:1000000000',
            'foto.*'        => 'mimes:jpeg,png|max:1024',
            'categori_id'   => 'required|integer|max:1000000000',
            'etalase_id'    => 'required|integer|max:1000000000',
            'text'          => 'nullable|string|max:255'
        ]);

        // \Log::info($request->all());

        $this->authorize('create', 'App\Product');
        
        $UserToko = Auth::user()->toko()->first();

        $product = Product::create([
            'name'          => $request->name,
            'price'         => $request->price,
            'text'          => $request->text,
            'categori_id'   => $request->categori_id,
            'etalase_id'    => $request->etalase_id,
            'toko_id'       => $UserToko->id,
            'user_id'       => Auth::user()->id
        ]);

        if ($request->hasFile('foto')) {
            $foto = $this->saveFoto($request->file('foto'), $product->id);
        }

        return Product::where('id',$product->id)
                      ->where('toko_id', $UserToko->id)
                      ->with([
                            'users',
                            'etalases',
                            'categoris',
                            'toko',
                            'product_photo'
                      ])->firstOrFail();

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
    public function update(Request $request, Product $produk)
    {
        $this->validate($request, [
            'name'          => 'required|string|max:255',
            'price'         => 'required|string|max:1000000000',
            'foto.*'        => 'mimes:jpeg,png|max:1024',
            'foto_old.*'    => 'nullable|string|max:255',
            'categori_id'   => 'required|integer|max:1000000000',
            'etalase_id'    => 'required|integer|max:1000000000',
            'text'          => 'nullable|string|max:255'
        ]);

        // \Log::info($request->foto_old);

        $this->authorize('update', $produk);

        $produk->update([
            'name'          => $request->name,
            'price'         => $request->price,
            'text'          => $request->text,
            'categori_id'   => $request->categori_id,
            'etalase_id'    => $request->etalase_id,
            'user_id'       => Auth::user()->id
        ]);

        $this->updateFoto($request->foto_old, $produk->id);

        if ($request->hasFile('foto')) {
            $foto = $this->saveFoto($request->file('foto'), $produk->id);
        }

        return Product::where('id',$produk->id)
                      ->with([
                            'users',
                            'etalases',
                            'categoris',
                            'toko',
                            'product_photo'
                      ])->firstOrFail();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $produk)
    {

        $this->authorize('delete', $produk);
        
        $produk->delete();

        return $produk;

    }

    public function saveFoto($file, $id){

        $foto = collect([]);

        foreach ($file as $key => $value) {
            $foto->push([
                'name'       => $value->getClientOriginalName(),
                'src'        => Storage::disk('public')->put('product/img',$value),
                'product_id' => $id,
                'user_id'    => Auth::User()->id
            ]);
        };

        ProductPhoto::insert($foto->all());
    }

    public function updateFoto($file, $id){

        if ($file == null) { $file = []; };

        ProductPhoto::where('product_id',$id)->whereNotIn('id', $file)->delete();
        
    }
}
