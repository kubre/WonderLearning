<div class="col-md-12 py-3 bg-white mb-2" data-controller="screen--filter">
    <div class="container">
        {!! $filters->where('display', true)->first()->render() !!}
        <div class="dropdown-divider"></div>
        <button type="submit" form="filters" class="btn btn-sm btn-default">
            {{ __('Apply') }}
        </button>
    </div>
    @foreach ($filters as $filter)
        @if ($filter->display && $filter->isApply())
            <a href="{{ $filter->resetLink() }}" class="badge badge-light mr-1 p-1">
                {{ $filter->value() }}
            </a>
        @endif
    @endforeach
</div>
