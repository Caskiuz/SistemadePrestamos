@props([
    'title' => '',
    'subtitle' => '',
    'backUrl' => null,
    'status' => null
])

<div class="mobile-header">
    <div class="mobile-header-content">
        @if($backUrl)
        <a href="{{ $backUrl }}" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        @endif
        <div class="header-info">
            <h1><i class="fa fa-money"></i> {{ $title }}</h1>
            @if($subtitle)
            <p>{{ $subtitle }}</p>
            @endif
        </div>
        @if($status)
        <div class="status-badge status-{{ $status }}">
            {{ ucfirst($status) }}
        </div>
        @endif
    </div>
</div>