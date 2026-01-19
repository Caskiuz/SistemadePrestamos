@props([
    'filters' => [],
    'currentFilter' => null,
    'route' => '',
    'parameter' => 'status'
])

<div class="status-filters">
    <div class="filter-scroll">
        @foreach($filters as $key => $filter)
        <a href="{{ route($route, [$parameter => $key]) }}" 
           class="filter-btn {{ ($currentFilter == $key || (!$currentFilter && $loop->first)) ? 'active' : '' }}">
            <span class="filter-icon">●</span>
            <span class="filter-text">{{ $filter['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>