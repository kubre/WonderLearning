<template {{ $attributes }}>
    <div>
        <div class="shadow rounded bg-white px-3 mb-2 d-flex">
            <strong x-text='index + 1' class="py-2 pe-2"></strong>
            <input type="text" class="form-control flex-fill my-1 me-2" x-bind:placeholder="'Enter' + subject.type">
            <div class="d-flex flex-fill align-items-center">
                <button class="btn btn-sm rounded-pill btn-primary">
                    <x-orchid-icon class="me-2" path="plus" />
                    Book
                </button>
            </div>
        </div>

        {{-- Children --}}
        <div class="ms-3 mb-2 {{ empty(trim($slot)) ? '' : 'py-2' }}">
            {{ $slot }}
        </div>
    </div>
</template>
