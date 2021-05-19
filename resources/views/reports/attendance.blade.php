<div class="bg-white px-4 py-5" style="overflow-x: scroll">
    <table class="table table-striped table-bordered table-responsive me-2">
        <thead>
            <tr>
                <th>Name</th>
                @for ($day = 1; $day <= $days; $day++)
                    <th>{{ $day }}</th>
                @endfor
            </tr>
        </thead>

        <tbody>
            @foreach ($attendances as $key => $student)
                <tr>
                    <th>{{ $student->first()->student_name }}
                        ({{ $admissions->whereStrict('student_id', $key)->first()->prn }})</th>
                    @for ($day = 1; $day <= $days; $day++)
                        <td>
                            {{ $student->get($day)->attendance ?? '' }}
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
