<div>
    <input id="from_date" type="hidden" value="{{ $from_date }}">
    <input id="to_date" type="hidden" value="{{ $to_date }}">
    <input id="student_id" type="hidden" value="{{ $student->id }}">
    <input id="user_id" type="hidden" value="{{ $teacher->id }}">
    <div id="chatScreen">
    </div>
</div>
@push('scripts')
    <script src="/js/backend.js"></script>
@endpush
