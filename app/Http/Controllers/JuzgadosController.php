<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\juzgados;

use App\distritos;




class JuzgadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()){
            return juzgados::where('user_id', auth()->id())->get();
        }else{
            return view('home');
        }
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distritos = distritos::all();
        return view('home', compact('distritos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nota = new juzgados();
        $nota->nombre_juzgado = $request->nombre_juzgado;
        $nota->estatus_juzgado = $request->estatus_juzgado;
        $nota->distrito_id = $request->distrito_id;
        $nota->user_id = auth()->id();
        $nota->save();

        return $nota;
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
        $nota = juzgados::find($id);
        $nota->nombre_juzgado = $request->nombre_juzgado;
        $nota->estatus_juzgado = $request->estatus_juzgado;
        $nota->distrito_id = $request->distrito_id;
        $nota->save();
        return $nota;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nota = juzgados::find($id);
        $nota->delete();
    }
}
