<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['document_id','type'];
    //relacion muchos a muchos
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
    
}
