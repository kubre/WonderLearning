<div class="bg-white px-3 py-4 shadow-sm">
    @forelse ($items as $item)
        <div class="item mt-1 {{ $item->type }} px-4 py-2 rounded d-flex align-items-center">
            <div class="flex-fill">
                {{ $item->type === 'chapter' ? 'Chapter: ' : '' }} {{ $item->name }}
            </div>
            <div>
                @if ($item->children->isEmpty() && $item->type !== 'chapter')
                    <button type="button" data-item="{{ $item->toJson() }}" data-bs-toggle="modal"
                        data-bs-target="#markModal" class="btn btn-default rounded-pill btn-sm">
                        <x-orchid-icon class="me-2" path='check'></x-orchid-icon>
                        Mark finished
                    </button>
                @endif
            </div>
        </div>
    @empty
        <strong>No information availble</strong>
    @endforelse

    <div class="modal fade" id="markModal" tabindex="-1" aria-labelledby="markModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-3 py-2">
                    <input type="hidden" id="school_id" name="school_id" value="{{ school()->id }}">
                    <input type="hidden" id="teacher_name" name="teacher_name" value="{{ auth()->user()->name }}">
                    <input type="hidden" id="syllabus_id" name="syllabus_id" value="">
                    <div class="mb-3">
                        <label for="completed_at" class="form-label">Completion Date</label>
                        <input type="date" class="form-control" id="completed_at" name="completed_at">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closeModal" type="button" class="btn btn-default btn-sm"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" onclick="markCompleted()" id="btnSubmit" class="btn btn-primary btn-sm">
                        Mark as Finished
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var url = "{{ route('teacher.subjects.book', ['method' => 'markComplete', 'syllabus' => $book_id]) }}";

        document.body.onload = function init() {
            var markModal = document.getElementById('markModal');
            markModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                item = JSON.parse(button.getAttribute('data-item'));
                document.getElementById('markModalLabel').innerText = 'Mark ' + item.name + ' as complete';
                document.getElementById('syllabus_id').value = item.id;
            })
        }

        function markCompleted() {
            document.getElementById('btnSubmit').setAttribute('disabled', 'true');
            axios.post(url, {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'syllabus_id': document.getElementById('syllabus_id').value,
                    'completed_at': document.getElementById('completed_at').value,
                    'school_id': document.getElementById('school_id').value,
                    'teacher_name': document.getElementById('teacher_name').value,
                })
                .then(function(res) {
                    document.getElementById('btnSubmit').removeAttribute('disabled');
                    document.getElementById('completed_at').classList.remove('is-invalid');
                    document.getElementById('closeModal').click();
                    window.location.reload();
                })
                .catch(function(err) {
                    document.getElementById('btnSubmit').removeAttribute('disabled');
                    document.getElementById('completed_at').classList.add('is-invalid');
                });
        }

    </script>
@endpush

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .item {
            color: #111;
        }

        .chapter {
            background: #a9ffe9;
        }

        .topic {
            background: #ffd0a9;
            margin-left: 20px;
        }

        .subtopic {
            background: #f0b6ff;
            margin-left: 40px;
        }

    </style>
@endpush
