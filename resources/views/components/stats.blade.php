<div class="mb-3">
    <legend class="text-black px-4 mb-0">
        {{ $title }}
    </legend>
    <div class="row mb-2 g-3 g-mb-4">
        @foreach ($metrics as $metric)
            <div class="col">
                <a href="{{ $metric['link'] ?? '#' }}">
                    <div class="p-4 bg-white rounded shadow-sm h-100">
                        <small class="text-muted d-block mb-1">{{ $metric['title'] }}</small>
                        <p class="h3 text-black fw-light">
                            {{ $metric['value'] }}
                        </p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
