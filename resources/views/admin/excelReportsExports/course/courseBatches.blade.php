<h3>{{$course->category->name}}</h3>
<h4>{{$course->name}}</h4>

<table>
    <tr>
        <th>SN</th>
        <th>Batch Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Fee</th>
        <th>Discount</th>
        <th>Time</th>
        <th>Status</th>
        <th>Total Students</th>
        <th>Verified Students</th>
        <th>Created On</th>
        <th>Modified On</th>
    </tr>
    @php($i=1)
    @forelse($reports as $report)
        <tr>
            <td>{{$i}}</td>
            <td>{{$report->name}}</td>
            <td>{{date('Y-m-d',strtotime($report->start))}}</td>
            <td>{{date('Y-m-d',strtotime($report->end))}}</td>
            <td>{{$report->fee}}</td>
            <td>{{$report->discount}}</td>
            <td>{{$report->time}}</td>
            <td>{{$report->status}}</td>
            <td>{{$report->totalstds}}</td>
            <td>{{$report->verifiedstds}}</td>
            <td>{{date('Y-m-d',strtotime($report->created_at))}}</td>
            <td>{{date('Y-m-d',strtotime($report->updated_at))}}</td>
        </tr>
        @php($i++)
    @empty
        <tr><td colspan="12">No Batches Found</td></tr>
    @endforelse
</table>
