<div class="mb-3">
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
    </div>
</div>
