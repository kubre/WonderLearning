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
    <div class="d-flex mt-3 mb-2">
        <button type="submit" form="filters" class="btn btn-dark me-2">
            <x-orchid-icon path='filter' class='me-2'></x-orchid-icon>
            {{ __('Apply Filters') }}
        </button>
        @foreach ($filters as $filter)
        @if ($filter->display && $filter->isApply())
        <a href="{{ $filter->resetLink() }}" class="btn btn-danger px-4 me-2">
            <x-orchid-icon path='trash' class='me-2'></x-orchid-icon>
            Clear {{ $filter->value() }}
        </a>
        @endif
        @endforeach
    </div>
</div>