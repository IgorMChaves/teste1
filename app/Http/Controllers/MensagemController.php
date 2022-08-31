<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MensagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mensagens = Mensagem::all();
        return view("restrict/mensagem", compact('mensagens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("restrict/mensagem/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|max:255',
            'url' => 'required|max:255',
            'assunto' => 'required|max:255',
        ]);
        if ($validated) {
            //print_r($request->get('topico));
            $mensagem = new Mensagem();
            $mensagem-> user_id = Auth::user()->id;
            $mensagem->numero = $request->get('numero');
            $mensagem->nome = $request->get('nome');
            $mensagem->url = $request->get('url');
            $mensagem->assunto = $request->get('assunto');
            $mensagem->save();
            return redirect('mensagem');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function show(Mensagem $mensagem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function edit(Mensagem $mensagem)
    {
        return view("restrict/mensagem/edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensagem $mensagem)
    {
        $validated = $request->validate([
            'numero' => 'required|max:255',
            'nome' => 'required|max:255',
            'url' => 'required|max:255',
            'assunto' => 'required|max:255',
        ]);
        if ($validated) {
            $mensagem->numero = $request->get('numero');
            $mensagem->nome = $request->get('nome');
            $mensagem->url = $request->get('url');
            $mensagem->assunto = $request->get('assunto');
            $mensagem->save();
            return redirect('mensagem');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mensagem  $mensagem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mensagem $mensagem)
    {
        $mensagem->delete();
        return redirect("mensagem");
    }
}