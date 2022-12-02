<?php

namespace App\Business\Email;

use Illuminate\Support\Facades\DB;

class FilterEmail {

    private $table;
    private $data, $remetente, $conteudo;

    public function __construct($table){
        $this->table = $table;
        $this->setFields();
    }
    public function filter($request){
        $filtros = $request->only('data', 'remetente', 'conteudo');
        $data = $this->getFields($filtros);
        return $this->getByFilter($data);
    }

    private function getByFilter($data){
        // Não Construir QUERYS NA BUSINESS FAZ ISSO NA MODEL ou USE uma CAMADA como a REPOSITORY 
        $query = '';
        $i = 0;
        foreach ($data as $key => $value){
            if ($value != ''){
                $where = ($i==0) ? 'WHERE' : 'AND';
                $query .= " $where ".$key." LIKE '".$value."%'";
                $i++;
            }
        }
        return DB::select('select * from ' . $this->table . '' .$query);
    }

    private function getFields($filtros){
        return [
            //ingles
            $this->data => $filtros['data'] ?? '' ,
            $this->remetente => $filtros['remetente'] ?? '',
            $this->conteudo => $filtros['conteudo'] ?? '' 
        ];
    }

    private function setFields(){
        $this->data = $this->table == 'receive_messages' ? 'received_message' : 'created_at';
        $this->remetente = $this->table == 'receive_messages' ? 'from_fullname_message' : 'to_message';
        $this->conteudo = $this->table == 'receive_messages' ? 'html_message' : 'content_message';
    }
}