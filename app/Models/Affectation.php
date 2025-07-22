<?php

// app/Models/Affectation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    protected $fillable = [
        'employe_id',
        'article_id',
        'stock_item_id',
        'date_affectation',
        'quantite',
        'description',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class);
    }
}
