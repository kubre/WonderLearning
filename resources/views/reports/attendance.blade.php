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
            @foreach ($classes as $admission_id => $attendances)
                <tr>
                    <th>{{ $attendances['name'] }}
                        ({{ $attendances['prn'] }})</th>
                    @for ($day = 1; $day <= $days; $day++)
                        <td>{{ $attendances[$day] ?? '' }}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
