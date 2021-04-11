<div class="col-md-12 py-3 bg-white mb-2" data-controller="screen--filter">
    <div class="container">
        @if ($filters->where('display', true)->count() >= 2)
            @foreach ($filters->where('display', true) as $idx => $filter)
                <a href="#" data-filter-index="{{ $idx }}" data-action="screen--filter#onFilterClick">
                    {{ $filter->name() }}
                </a>
                <div data-target="screen--filter.filterItem">
                    <div class="px-3 py-2 w-md">
                        {!! $filter->render() !!}
                    </div>
                </div>
            @endforeach
            <div class="dropdown-divider"></div>
            <button type="submit" form="filters" class="btn btn-sm btn-default">
                {{ __('Apply') }}
            </button>
        @else
            {!! $filters->where('display', true)->first()->render() !!}
            <div class="dropdown-divider"></div>
            <button type="submit" form="filters" class="btn btn-sm btn-default">
                {{ __('Apply') }}
            </button>
        @endif
    </div>
    @foreach ($filters as $filter)
        @if ($filter->display && $filter->isApply())
            <a href="{{ $filter->resetLink() }}" class="badge badge-light mr-1 p-1">
                {{ $filter->value() }}
            </a>
        @endif
    @endforeach
</div>
