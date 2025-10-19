<div>
    <!-- Filter input: preserve other query params but remove 'page' when searching -->
    <input type="text" name="{{ $term }}" id="{{ $term }}" class="form-control" placeholder="{{ $placeholder }}"
        value="{{ e(request($term)) }}"
        onkeydown="(function(e){ if(e.key === 'Enter'){ const params = new URLSearchParams(window.location.search); params.delete('page'); params.set('{{ $term }}', e.target.value); window.location.search = params.toString(); } })(event)">
</div>