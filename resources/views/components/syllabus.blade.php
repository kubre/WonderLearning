<div>
    <input id="from_date" type="hidden" value="{{ $from_date }}">
    <input id="to_date" type="hidden" value="{{ $to_date }}">
    <div id="syllabusApp">
    </div>
</div>
@push('scripts')
    <script src="/js/backend.js"></script>
@endpush
