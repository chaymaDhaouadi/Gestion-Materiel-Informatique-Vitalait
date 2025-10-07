@props(['title', 'value', 'color' => 'primary', 'icon' => 'circle'])

<div class="col-md-3">
    <div class="card shadow-sm border-0 bg-{{ $color }} text-white">
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-{{ $icon }} fa-2x me-3"></i>
            <div>
                <div class="h5 mb-0">{{ $value }}</div>
                <small>{{ $title }}</small>
            </div>
        </div>
    </div>
</div>
