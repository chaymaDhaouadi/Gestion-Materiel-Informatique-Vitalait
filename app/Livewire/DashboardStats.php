<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\StockItem;
use App\Models\Affectation;
use Illuminate\Support\Facades\DB;

class DashboardStats extends Component
{
    public $totalArticles;
    public $availableCount;
    public $assignedCount;
    public $brokenCount;

    public $stockLabels = [];
    public $stockData = [];

    public $topArticles;

    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');

        $this->loadStats();
    }

    public function updatedStartDate()
    {
        $this->loadStats();
    }

    public function updatedEndDate()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalArticles = Article::count();

        $this->availableCount = StockItem::where('etat', 'disponible')->count();
        $this->assignedCount = StockItem::where('etat', 'affecté')->count();
        $this->brokenCount = StockItem::where('etat', 'en panne')->count();

        $this->stockLabels = ['Disponible', 'Affecté', 'En panne'];
        $this->stockData = [$this->availableCount, $this->assignedCount, $this->brokenCount];

        $this->topArticles = Affectation::select('article_id', DB::raw('count(*) as total'))
            ->whereBetween('date_affectation', [$this->startDate, $this->endDate])
            ->groupBy('article_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($row) {
                $article = Article::find($row->article_id);
                return [
                    'nom' => $article?->nom ?? 'Inconnu',
                    'total' => $row->total,
                ];
            });
    }

    public function render()
    {
        return view('livewire.dashboard-stats');
    }
}
