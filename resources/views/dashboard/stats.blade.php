<div>
    <h1 style="color: green;">✅ Composant dashboard.stats affiché !</h1>

    <div class="row">
        <x-dashboard-card title="Articles" :value="$totalArticles" color="primary" icon="box" />
        <x-dashboard-card title="Disponibles" :value="$availableCount" color="success" icon="check-circle" />
        <x-dashboard-card title="Affectés" :value="$assignedCount" color="warning" icon="user-check" />
        <x-dashboard-card title="En Panne" :value="$brokenCount" color="danger" icon="tools" />
    </div>
</div>
