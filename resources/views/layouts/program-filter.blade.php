<div class="mb-3">
    @if(request('filter.deleted'))
    <div class="alert alert-warning rounded">
        <h5 class="alert-heading">Notice</h5>
        <p>You are viewing deleted records. To view all records, Click on All Card.</p>
    </div>
    @endif
    <div class="row mb-2 g-3 g-mb-4">
        <div class="col text-end">
            <a href="{{ route($route, ['filter[program]' => 'Playgroup']) }}">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <small class="text-muted d-block mb-1">Playgroup</small>
                    <p class="h3 text-black fw-light">
                        {{ $count['Playgroup'] ?? 0 }}
                    </p>
                </div>
            </a>
        </div>
        <div class="col text-end">
            <a href="{{ route($route, ['filter[program]' => 'Nursery']) }}">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <small class="text-muted d-block mb-1">Nursery</small>
                    <p class="h3 text-black fw-light">
                        {{ $count['Nursery'] ?? 0 }}
                    </p>
                </div>
            </a>
        </div>
        <div class="col text-end">
            <a href="{{ route($route, ['filter[program]' => 'Junior KG']) }}">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <small class="text-muted d-block mb-1">Junior KG</small>
                    <p class="h3 text-black fw-light">
                        {{ $count['Junior KG'] ?? 0 }}
                    </p>
                </div>
            </a>
        </div>
        <div class="col text-end">
            <a href="{{ route($route, ['filter[program]' => 'Senior KG']) }}">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <small class="text-muted d-block mb-1">Senior KG</small>
                    <p class="h3 text-black fw-light">
                        {{ $count['Senior KG'] ?? 0 }}
                    </p>
                </div>
            </a>
        </div>
        <div class="col text-end">
            <a href="{{ route($route) }}">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <small class="text-muted d-block mb-1">All</small>
                    <p class="h3 text-black fw-light">
                        {{ ($count['Playgroup'] ?? 0) + ($count['Nursery'] ?? 0) + ($count['Junior KG'] ?? 0) + ($count['Senior KG'] ?? 0) }}
                    </p>
                </div>
            </a>
        </div>
        <div class="col text-end">
            <a href="{{ route($route, ['filter[deleted]' => true]) }}">
                <div style="background: rgba(240, 11, 11, 0.26)" class="p-4 rounded shadow-sm h-100">
                    <small class="d-block mb-1">Deleted</small>
                    <p class="h3 text-black fw-light">
                        {{ $count['deleted'] ?? 0 }}
                    </p>
                </div>
            </a>
        </div>
    </div>
</div>
