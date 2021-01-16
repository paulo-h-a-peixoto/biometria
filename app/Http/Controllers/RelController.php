<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Funcionarios;
use App\Models\Entrada_saida;
use App\Models\Relatorios;
use App\Models\Justificativa;
use App\Models\User;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;
use PDF;
class RelController extends Controller
{

    public function __construct(Request $request){
        $this->middleware('auth', ['except'=>[

        ]]);

    }

    public function home(){
        $data = [
            'admin' => Gate::allows('admin')
        ];
        return view('relatorio.home', $data);
    }
    public function index(){
        $data = [
            'admin' => Gate::allows('admin'),
            'rel' => DB::select('SELECT * FROM relatorios ORDER BY id DESC')
        ];
        return view('relatorio.relatorio', $data);
    }

    public function jrelatorio(){
        $data = [
            'admin' => Gate::allows('admin'),
            'rel' => DB::select('SELECT * FROM relatorios WHERE status = 0 ORDER BY id DESC')
        ];
        
        return view('relatorio.jrelatorio', $data);
    }
    public function jid(Request $request, $id){
        $rel = Relatorios::where('id', $id)->first();
        $user = Auth::user();
        $data = [
            'admin' => Gate::allows('admin'),
            'result' => DB::select('SELECT entrada_saida.id, entrada_saida.justify, entrada_saida.documento, entrada_saida.hora_entrada, entrada_saida.hora_saida, entrada_saida.data, funcionarios.nome_funcionario as nome, funcionarios.divisao as divisao FROM entrada_saida LEFT JOIN funcionarios ON entrada_saida.documento = funcionarios.codigo_funcionario WHERE entrada_saida.n_relatorio = :n_relatorio AND funcionarios.divisao = :divisao ORDER BY id', [
                'n_relatorio' => $rel->n_relatorio,
                'divisao' => $user->divisao
            ]),
            'id' => $id,
            'rel' => $rel
        ];
        
        return view('relatorio.jid', $data);

    }

    public function id(Request $request, $id){
        $rel = Relatorios::where('id', $id)->first();
        $data = [
            'admin' => Gate::allows('admin'),
            'result' => DB::select('SELECT entrada_saida.id, entrada_saida.justify, entrada_saida.documento, entrada_saida.hora_entrada, entrada_saida.hora_saida, entrada_saida.data, funcionarios.nome_funcionario as nome, funcionarios.divisao as divisao FROM entrada_saida LEFT JOIN funcionarios ON entrada_saida.documento = funcionarios.codigo_funcionario WHERE entrada_saida.n_relatorio = :n_relatorio ORDER BY id', [
                'n_relatorio' => $rel->n_relatorio
            ]),
            'id' => $id,
            'rel' => $rel
        ];
        
        return view('relatorio.id', $data);

    }

    public function idAction(Request $request, $id){

        

        $es = Entrada_saida::where('id', $request->input('id'))->first();
        $es->justify = $request->input('justify');
        $es->save();
        return redirect('/relatorio/id/'.$id)->with('alert', 'Justificativa salva com sucesso');
        
    }

    public function fin(Request $request, $id){
        $rel = Relatorios::where('id', $id)->first();
        $rel->status = 1;
        $rel->save();
        return redirect('/relatorio');
    }

    public function gerar(){
        $data = [
            'admin' => Gate::allows('admin')
        ];
        return view('relatorio.gerar', $data);
    }

    

    public function gerarAction(Request $request){
        if($request->hasFile('acesso')){
            if($request->file('acesso')->isValid()){
                $rules = [
                    'names' => 'mimes:txt'
                ];
                
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()){
                    return redirect('/relatorio/gerar')->withErrors($validator);
                }
                $acesso = file($request->file('acesso'));
                
                // Filtro para organizar o arquivo com os acesso dos funcionarios
                $filter = array_filter($acesso, function($item){ 
                    if(strlen($item) == 40){
                        return true;
                    } else {
                        return false;
                    }
                });
                // Verificar se a data do primeiro item e a do último item do array são iguais, o relátorio precisa ser no max 1 dia
                if(substr(array_shift($filter), 10, 8) == substr(array_pop($filter), 10, 8)){
                    if($request->input('tipo') == '0'){
                        $n_relatorio = date('dmyhms');
                        $newRel = new Relatorios;
                        $newRel->n_relatorio = $n_relatorio;
                        $newRel->status = 0;
                        $newRel->tolerancia = $request->input('tolerancia');
                        $newRel->data = date('d/m/Y');
                        $newRel->tipo = $request->input('tipo');
                        $newRel->save();
    
                        for($i=0; $i < count($acesso); $i++){ 
                            if(strlen($acesso[$i]) == 40){
                                $data = substr($acesso[$i], 10, 8);
                                $data = substr_replace($data, '/', 2, 0);
                                $data = substr_replace($data, '/', 5, 0);
                                $hora = substr($acesso[$i], 18, 4);
    
                                $exist = DB::select('SELECT * FROM entrada_saida WHERE documento = :documento AND data = :data AND n_relatorio = :n_relatorio ORDER BY id DESC LIMIT 1', [
                                    'documento' => substr($acesso[$i], 22, 12),
                                    'data' => $data,
                                    'n_relatorio' => $n_relatorio
                                    ]);
                                if(count($exist) == 0){
                                    $newEntrada = new Entrada_saida;
                                    $newEntrada->n_relatorio = $n_relatorio;
                                    $newEntrada->cod = substr($acesso[$i], 0, 10);
                                    $newEntrada->documento = substr($acesso[$i], 22, 12);
                                    $newEntrada->hora_entrada = substr_replace($hora, ':', 2, 0);
                                    $newEntrada->data = $data;
                                    $newEntrada->save();
                                }else{
                                    if($exist[0]->hora_saida == ''){
                                        $update = Entrada_saida::where('id', $exist[0]->id)->first();
                                        $update->hora_saida = substr_replace($hora, ':', 2, 0);
                                        $update->save();
                                    }else{
                                        $newEntrada = new Entrada_saida;
                                        $newEntrada->n_relatorio = $n_relatorio;
                                        $newEntrada->cod = substr($acesso[$i], 0, 10);
                                        $newEntrada->documento = substr($acesso[$i], 22, 12);
                                        $newEntrada->hora_entrada = substr_replace($hora, ':', 2, 0);
                                        $newEntrada->data = $data;
                                        $newEntrada->save();
                                    }
                                }
                            }
                        } 
                        $result = DB::select('SELECT entrada_saida.id, entrada_saida.justify, entrada_saida.documento, entrada_saida.hora_entrada, entrada_saida.hora_saida, entrada_saida.data, funcionarios.nome_funcionario as nome, funcionarios.divisao as divisao FROM entrada_saida LEFT JOIN funcionarios ON entrada_saida.documento = funcionarios.codigo_funcionario WHERE entrada_saida.n_relatorio = :n_relatorio ORDER BY id', [
                            'n_relatorio' => $n_relatorio
                        ]);

                        $consulta = array();
                        foreach($result as $item){
                            $consulta[] = $item->documento;
                        }
                        
                        $funcionarios = DB::select('SELECT * FROM funcionarios');
                        $funcArray = [];
                        foreach($funcionarios as $key => $item){
                            $funcArray[] = [
                                'id' => $item->id,
                                'codigo_funcionario' => $item->codigo_funcionario,
                                'nome_funcionario' => $item->nome_funcionario,
                                'divisao' => $item->divisao
                            ];
                        }

                        foreach($funcArray as $key => $item){
                            for($i=0; $i < count($consulta); $i++){
                                if($item['codigo_funcionario'] == $consulta[$i]){
                                    unset($funcArray[$key]);
                                }
                            }
                        }
                       
                        foreach($funcArray as $item){
                            
                            
                            $jus = DB::select('SELECT * FROM justificativa WHERE codigo_funcionario = :codigo_funcionario AND tipoDispensa != "5" AND :dataRelatorio between dataInicio AND dataFinal ORDER BY id DESC LIMIT 1',[
                                'codigo_funcionario' => $item['codigo_funcionario'],
                                'dataRelatorio' => date("Y-d-m", strtotime($result[0]->data))
                            ]);
                            if($jus){
                                $newEntrada = new Entrada_saida;
                                $newEntrada->n_relatorio = $n_relatorio;
                                $newEntrada->cod = '';
                                $newEntrada->documento = $item['codigo_funcionario'];
                                $newEntrada->hora_entrada = '';
                                $newEntrada->data = '';
                                $newEntrada->justify = $jus[0]->tipoDispensa;
                                $newEntrada->save();
                            }else{
                                $newEntrada = new Entrada_saida;
                                $newEntrada->n_relatorio = $n_relatorio;
                                $newEntrada->cod = '';
                                $newEntrada->documento = $item['codigo_funcionario'];
                                $newEntrada->hora_entrada = '';
                                $newEntrada->data = '';
                                $newEntrada->save();
                            }
                            
                        }

                        return redirect('/relatorio/gerar')->with('warning', 'Relatório gerado com sucesso');
                    }else{
                        $n_relatorio = 0;
                        for($i=0; $i < count($acesso); $i++){
                            if(strlen($acesso[$i]) == 40){
                                $data = substr($acesso[$i], 10, 8);
                                $data = substr_replace($data, '/', 2, 0);
                                $data = substr_replace($data, '/', 5, 0);
                                $hora = substr($acesso[$i], 18, 4);
                                if($n_relatorio == 0){
                                    $result = DB::select('SELECT n_relatorio FROM entrada_saida WHERE documento = :documento AND data = :data ORDER BY id DESC LIMIT 1', [
                                        'documento' => substr($acesso[$i], 22, 12),
                                        'data' => $data
                                    ]);
                                    $n_relatorio = $result[0]->n_relatorio;
                                }
                                $exist = DB::select('SELECT * FROM entrada_saida WHERE documento = :documento AND data = :data AND n_relatorio = :n_relatorio AND cod = :cod ORDER BY cod DESC LIMIT 1', [
                                    'documento' => substr($acesso[$i], 22, 12),
                                    'data' => $data,
                                    'n_relatorio' => $n_relatorio,
                                    'cod' => substr($acesso[$i], 0, 10)
                                    ]);
                                if(count($exist) == 0){
                                    $exist2 = DB::select('SELECT * FROM entrada_saida WHERE documento = :documento AND data = :data AND n_relatorio = :n_relatorio ORDER BY id DESC LIMIT 1', [
                                        'documento' => substr($acesso[$i], 22, 12),
                                        'data' => $data,
                                        'n_relatorio' => $n_relatorio
                                        ]);
                                    if(count($exist2) == 0){
                                        $newEntrada = new Entrada_saida;
                                        $newEntrada->n_relatorio = $n_relatorio;
                                        $newEntrada->cod = substr($acesso[$i], 0, 10);
                                        $newEntrada->documento = substr($acesso[$i], 22, 12);
                                        $newEntrada->hora_entrada = substr_replace($hora, ':', 2, 0);
                                        $newEntrada->data = $data;
                                        $newEntrada->save();
                                    }else{
                                        if($exist2[0]->hora_saida == ''){
                                            $update = Entrada_saida::where('id', $exist2[0]->id)->first();
                                            $update->hora_saida = substr_replace($hora, ':', 2, 0);
                                            $update->save();
                                        }else{
                                            $newEntrada = new Entrada_saida;
                                            $newEntrada->n_relatorio = $n_relatorio;
                                            $newEntrada->cod = substr($acesso[$i], 0, 10);
                                            $newEntrada->documento = substr($acesso[$i], 22, 12);
                                            $newEntrada->hora_entrada = substr_replace($hora, ':', 2, 0);
                                            $newEntrada->data = $data;
                                            $newEntrada->save();
                                        }
                                    }
                                }
                            }
                        }
                        return redirect('/relatorio/gerar')->with('warning', 'Relatório gerado com sucesso');                                  
                    }
                }else{
                    return redirect('/relatorio/gerar')->with('error', 'ERROR - O registro dos funcionarios no relátorio precisa ser no máximo 24 horas');
                } 
            }
        }
    }  

    public function justify(Request $request){
        $es = DB::select('SELECT * FROM entrada_saida WHERE id = :id', ['id'=>$request->input('id')]);
        $newJust = new Justificativa;
        if($request->input('opcoes') != '5'){
            $newJust->codigo_funcionario = $es[0]->documento;
            $newJust->dataInicio = $request->input('dataInicio');
            $newJust->dataFinal = $request->input('dataFinal');
            $newJust->tipoDispensa = $request->input('opcoes');
            $newJust->descricao = $request->input('justificativa');
            $newJust->save();

            $update = Entrada_saida::where('id', $request->input('id'))->first();
            $update->justify = $request->input('opcoes');
            $update->save();
            return redirect('/relatorio/id/'.$request->input('rel'))->with('alert', 'Justificativa adicionada com sucesso!');
        }else{
            $newJust->codigo_funcionario = $es[0]->documento;
            $newJust->tipoDispensa = $request->input('opcoes');
            $newJust->descricao = $request->input('justificativa');
            $newJust->save();

            $update = Entrada_saida::where('id', $request->input('id'))->first();
            $update->justify = $request->input('justificativa');
            $update->save();
            return redirect('/relatorio/id/'.$request->input('rel'))->with('alert', 'Justificativa adicionada com sucesso!');
        }
    }
    public function justify2(Request $request){
        $es = DB::select('SELECT * FROM entrada_saida WHERE id = :id', ['id'=>$request->input('id')]);
        $newJust = new Justificativa;
        if($request->input('opcoes') != '5'){
            $newJust->codigo_funcionario = $es[0]->documento;
            $newJust->dataInicio = $request->input('dataInicio');
            $newJust->dataFinal = $request->input('dataFinal');
            $newJust->tipoDispensa = $request->input('opcoes');
            $newJust->descricao = $request->input('justificativa');
            $newJust->save();

            $update = Entrada_saida::where('id', $request->input('id'))->first();
            $update->justify = $request->input('opcoes');
            $update->save();
            return redirect('/relatorio/jid/'.$request->input('rel'))->with('alert', 'Justificativa adicionada com sucesso!');
        }else{
            $newJust->codigo_funcionario = $es[0]->documento;
            $newJust->tipoDispensa = $request->input('opcoes');
            $newJust->descricao = $request->input('justificativa');
            $newJust->save();

            $update = Entrada_saida::where('id', $request->input('id'))->first();
            $update->justify = $request->input('justificativa');
            $update->save();
            return redirect('/relatorio/jid/'.$request->input('rel'))->with('alert', 'Justificativa adicionada com sucesso!');
        }
    }
    
    public function print(Request $request, $id){
        $data = [];
        $rel = Relatorios::where('id', $id)->first();
        $data['result'] = DB::select('SELECT entrada_saida.id, entrada_saida.justify, entrada_saida.documento, entrada_saida.hora_entrada, entrada_saida.hora_saida, entrada_saida.data, funcionarios.nome_funcionario as nome, funcionarios.divisao as divisao FROM entrada_saida LEFT JOIN funcionarios ON entrada_saida.documento = funcionarios.codigo_funcionario WHERE entrada_saida.n_relatorio = :n_relatorio ORDER BY id', [
            'n_relatorio' => $rel->n_relatorio
        ]);

        $data['horario'] = $rel->tolerancia;
        $data['qt'] = ['1' => 0, '2' => 0, '3' => 0, '4' => 0];
        $consulta = array();
        foreach($data['result'] as $item){
            $consulta[] = $item->documento;
        }
        
        $funcionarios = DB::select('SELECT * FROM funcionarios');
        $funcArray = [];
        foreach($funcionarios as $key => $item){
            $funcArray[] = [
                'id' => $item->id,
                'codigo_funcionario' => $item->codigo_funcionario,
                'nome_funcionario' => $item->nome_funcionario,
                'divisao' => $item->divisao
            ];
        }

        foreach($funcArray as $key => $item){
            for($i=0; $i < count($consulta); $i++){
                if($item['codigo_funcionario'] == $consulta[$i]){
                    unset($funcArray[$key]);
                }
            }
        }

       
        $data['result_2'] = $funcArray;
        $data['id'] = $rel->n_relatorio;
        // $pdf = PDF::loadView('relatorio.print', $data);
        // return $pdf->download('teste.pdf');
        return view('relatorio.print', $data);
    }

    public function update(){
        $data = [
            'admin' => Gate::allows('admin')
        ];
        return view('relatorio.atualizar', $data);
    }

    public function updateAction(Request $request){
        // $arquivo = $_FILES['arquivo']['tmp_name']; // Eu recebo o arquivo do html e armazeno nessa variavel
        // $arquivo_acc = $_FILES['arquivo_acc']['tmp_name']; // Eu recebo o arquivo do html e armazeno nessa variavel
       
        if($request->hasFile('names')){
            if($request->file('names')->isValid()){
                $rules = [
                    'names' => 'mimes:txt'
                ];
                
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()){
                    return redirect('/relatorio/update')->withErrors($validator);
                }
                DB::delete('DELETE FROM funcionarios');
                $names = file($request->file('names'));
                
                for($i=0; $i < count($names); $i++){ 
                    $nome = substr($names[$i], 19, -8);
                    while (strpos($nome, "[") !== false){ // É para retirar os [ e numeros do nome
                    $nome = substr($nome, 0, -1);
                    }
                    if(strpos($nome, "!") == true){
                    $nome_divisao = explode('!', $nome);
                    }
                    if(strpos($nome, "!") == false){
                    $nome_divisao = array(
                        $nome,
                        'Não informado'
                    );
                    
                    }
                    $codigo = substr($names[$i], 6, 12); // É o código do funcionario
                    
                    $new = new Funcionarios;
    
                    $new->codigo_funcionario = $codigo;
                    $new->nome_funcionario = utf8_encode($nome_divisao[0]);
                    $new->divisao = utf8_encode($nome_divisao[1]);
                    $new->save();

                    
                
                }   
                return redirect('/relatorio/update')->with('warning', 'Lista de integrantes atualizada com sucesso');
            }
        }else{
            return redirect('/relatorio/update')->with('error', 'ERROR - Nenhum arquivo foi localizado');
        }        

    }

    public function usuarios(){
        $data = [
            'admin' => Gate::allows('admin'),
            'usuarios' => User::all()
        ];
        return view('relatorio.usuarios', $data);
    }
}
