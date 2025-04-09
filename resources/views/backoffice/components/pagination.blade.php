<div class="table-footer">
    <form action="{{ $action ?? route('backoffice.index') }}" method="GET">
        <div class="footer-left">
            <select name="rowsPerPage" class="form-control form-control-sm" style="width: auto;" onchange="this.form.submit()">
                <option value="25" {{ $paginator->perPage() == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $paginator->perPage() == 50 ? 'selected' : '' }}>50</option>
                <option value="75" {{ $paginator->perPage() == 75 ? 'selected' : '' }}>75</option>
                <option value="100" {{ $paginator->perPage() == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span>lignes / page</span>
        </div>
        @foreach(request()->except('rowsPerPage') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
    <div class="footer-center">
        De {{ $paginator->firstItem() }} à {{ $paginator->lastItem() }} sur {{ $paginator->total() }} lignes
    </div>
    <div class="footer-right">
        {{ $paginator->appends(request()->query())->links() }}
    </div>
</div> 