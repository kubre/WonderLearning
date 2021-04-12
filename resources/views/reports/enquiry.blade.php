<div id="print-report" class="bg-white px-4 py-4">
    <table class="table table-bordered table-striped table-black">
        <thead>
            <tr>
                <th>Program Name</th>
                <th>Converted</th>
                <th>Not Converted</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Playgroup</td>
                <td>{{ $Playgroup->converted ?? 0 }}</td>
                <td>{{ $Playgroup->not_converted ?? 0 }}</td>
                <td>{{ $Playgroup->total ?? 0 }}</td>
            </tr>
            <tr>
                <td>Nursery</td>
                <td>{{ $Nursery->converted ?? 0 }}</td>
                <td>{{ $Nursery->not_converted ?? 0 }}</td>
                <td>{{ $Nursery->total ?? 0 }}</td>
            </tr>
            <tr>
                <td>Junior KG</td>
                <td>{{ $Junior_KG->converted ?? 0 }}</td>
                <td>{{ $Junior_KG->not_converted ?? 0 }}</td>
                <td>{{ $Junior_KG->total ?? 0 }}</td>
            </tr>
            <tr>
                <td>Senior KG</td>
                <td>{{ $Senior_KG->converted ?? 0 }}</td>
                <td>{{ $Senior_KG->not_converted ?? 0 }}</td>
                <td>{{ $Senior_KG->total ?? 0 }}</td>
            </tr>
        </tbody>
    </table>
</div>
