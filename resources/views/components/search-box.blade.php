@props([
    'placeholder' => 'Buscar...',
    'route' => '',
    'value' => ''
])

<div class="search-section">
    <div class="search-box">
        <input type="text" 
               placeholder="{{ $placeholder }}" 
               id="searchInput" 
               value="{{ $value }}">
        <button id="searchButton">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    if (searchButton && searchInput) {
        searchButton.addEventListener('click', function() {
            const searchTerm = searchInput.value;
            window.location.href = "{{ route($route) }}?q=" + encodeURIComponent(searchTerm);
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchButton.click();
            }
        });
    }
});
</script>