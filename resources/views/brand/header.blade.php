@guest
    @push('head')
        <style>
            body {
                background-image: url('/images/login-bg.jpg');
                background-size: cover;
            }

            .footer {
                color: white;
            }

            .footer a {
                color: #11aaff;
            }

        </style>
    @endpush
@endguest
<p class="h3 n-m font-thin v-center text-center">
    @empty(school()->logo)
        <x-orchid-icon path="book-open" />
        <span class="ml-4 d-none d-sm-block">
            Wonder
            <small class="v-top opacity">System</small>
        </span>
        @push('head')
            <link href="/images/logo.svg" id="favicon" rel="icon">
        @endpush
    @else
        <img style="max-height: 80px; max-width: 100%;" src="{{ school()->logo }}" alt="Logo">
        @push('head')
            <link href="{{ school()->logo }}" id="favicon" rel="icon">
        @endpush
    @endempty
</p>
