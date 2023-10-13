<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = "categoria";

    protected $fillable = ['nome'];

    public function getRulesForCreate()
    {
        return [
            'nome' => 'required|min:5|unique:categoria,nome',
        ];
    }

    public function rules($id){
        return [
            'nome' => 'required|min:5|unique:categoria,nome,'.$id.'',
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo é obrigatório',
            'nome.min' => 'A categoria deve ter mais de 5 caracteres',
            'nome.unique' => 'A categoria já foi cadastrada',
        ];
    }
}
