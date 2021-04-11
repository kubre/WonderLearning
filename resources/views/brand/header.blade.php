<p class="h3 n-m font-thin v-center text-center">
    @empty(session('school')->logo)
        <img style="max-height: 80px; max-width: 100%;" src="{{ session('school')->logo }}" alt="Logo">
        @push('head')
            <link href="{{ session('school')->logo }}" id="favicon" rel="icon">
        @endpush
    @else
        <x-orchid-icon path="book-open" />
        <span class="ml-4 d-none d-sm-block">
            Wonder
            <small class="v-top opacity">System</small>
        </span>
        @push('head')
            <link href="/images/logo.svg" id="favicon" rel="icon">
        @endpush
        @endif
    </p>
