<div class="shadow bg-white px-5 py-4">
    <h5>Fees Rate Card {{ get_academic_year_formatted(working_year()) }}</h5>
    <span class="small text-muted">Please add fees from account section if not added.</span>
    <table class="table text-center">
        <thead>
            <tr>
                <th>Playgroup</th>
                <th>Nursery</th>
                <th>Junior KG</th>
                <th>Senior KG</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>₹ {{ optional($fees)->playgroup_total ?? '--' }}</td>
                <td>₹ {{ optional($fees)->nursery_total ?? '--' }}</td>
                <td>₹ {{ optional($fees)->junior_kg_total ?? '--' }}</td>
                <td>₹ {{ optional($fees)->senior_kg_total ?? '--' }}</td>
            </tr>
        </tbody>
    </table>
</div>
