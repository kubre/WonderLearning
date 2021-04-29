<div class="col-md-12 p-3 bg-white mb-2" data-controller="screen--filter">
    <strong>Filter Data</strong>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
        @if ($filters->where('display', true)->count() >= 2)
            @foreach ($filters->where('display', true) as $idx => $filter)
                <div class="flex-fill me-2">
                    <a href="#" data-filter-index="{{ $idx }}" data-action="screen--filter#onFilterClick">
                        {{ $filter->name() }}
                    </a>
                    <div data-target="screen--filter.filterItem">
                        <div class="py-2 w-md">
                            {!! $filter->render() !!}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="flex-fill me-2">
                {!! $filters->where('display', true)->first()->render() !!}
            </div>
        @endif
    </div>
    <button type="submit" form="filters" class="btn btn-dark mt-3 mb-2 px-4">
        <x-orchid-icon path='filter' class='me-2'></x-orchid-icon>
        {{ __('Apply Filters') }}
    </button>
    <div class="px-2">
        <p class="text-muted">Note: Click to remove applied filters.</p>
        @foreach ($filters as $filter)
            @if ($filter->display && $filter->isApply())
                <a href="{{ $filter->resetLink() }}" class="badge badge-warning me-1 p-1">
                    {{ $filter->value() }}
                </a>
            @endif
        @endforeach
    </div>
</div>
