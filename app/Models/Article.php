<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;   // ✅ import manquant

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;            // ✅ si tu utilises soft delete
use App\Models\StockItem;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'nom',
        'description',
        'description_courte',
        'categorie_id',
        'quantite',
        'etat',
        'prix_unitaire',
        'numero_serie',
        'modele',
        'marque',
        'image', // 👈 important
    ];


    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
    public function stockItems()
    {
        return $this->hasMany(StockItem::class);
    }

    # Petit bonus : “quantité” calculée
    public function getStockCountAttribute()
    {
        return $this->stockItems()->where('etat', 'disponible')->count();
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
    public function stockDisponibles()
    {
        return $this->hasMany(StockItem::class)->where('etat', 'disponible');
    }
    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }
}
