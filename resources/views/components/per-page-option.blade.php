<div>
    <!-- Per-page selector: preserve other query params but remove 'page' when perPage changes -->
    <select name="perPage" id="perPage" class="form-control" style="width: 100px"
        onchange="(function(e){
            const params = new URLSearchParams(window.location.search);
            params.delete('page');
            params.set('perPage', e.target.value);
            window.location.search = params.toString();
        })(event)">
        <option value="">Per page</option>
        @foreach ($perPageOptions as $item)
            <option value="{{ $item }}" {{ request()->query('perPage') == $item ? 'selected' : '' }}>{{ $item }}</option>
        @endforeach
    </select>
</div>