<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
        'article_id',
        'employe_id',
        'stock_item_id',
        'destination',
        'date_affectation',
        'quantite',
        'description',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'date_affectation' => 'date',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}
