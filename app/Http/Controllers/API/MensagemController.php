<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mensagem;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MensagemController extends Controller
{
    use ApiResponse;
    /**
     */
    public function index()
    {
        $mensagens = Mensagem::select(['id', 'titulo', 'mensagem', 'imagem', 'created_at', 'user_id'])
            ->with(['topicos:id,topico', 'user:id,name'])
            ->orderBy('created_at', 'DESC')
            ->get();
        return $this->success($mensagens);
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
            'titulo' => 'required|max:255',
            'mensagem' => 'required|max:255',
            'topico' => 'array|exists:App\Models\Topico,id'
        ]);
        if ($validated) {
            try{
                $mensagem = new Mensagem();
                $mensagem->user_id = Auth::user()->id;
                $mensagem->titulo = $request->get('titulo');
                $mensagem->mensagem = $request->get('mensagem');
                if ($request->get('imagem')) {
                    $image_base64 = base64_decode($request->get('imagem'));
                    Storage::disk('s3')->put($request->get('file'), $image_base64, 'public');
                    $path = Storage::disk('s3')->url($request->get('file'));
                    $mensagem->imagem = $path;
                }
                $mensagem->save();
                $mensagem->topicos()->attach($request->get('topico'));
                return $this->success($mensagem);
            } catch (\Throwable $th) {
                return $this->error("Erro ao cadastrar mensagem!!", 401, $th->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $mensagem = Mensagem::where('id', $id)->with('topicos')->get();
            return $this->success($mensagem[0]);
        } catch (\Throwable $th) {
            return $this->errorr("Mensagem não encontrada!!", 401, $th->getMessage());
        }
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