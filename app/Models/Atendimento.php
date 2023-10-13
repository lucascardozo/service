<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    use HasFactory;

    protected $fillable = ['categoria_id','user_id','descricao','dt_prazo','status'];

    public function rules(){
        return [
            'categoria_id' => 'required',
            'user_id' => 'required',
            'descricao' => 'required',
            'dt_prazo' => 'required',
            'status' => 'required',
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo é obrigatório',
        ];
    }

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
