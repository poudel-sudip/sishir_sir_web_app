<table>
    <tr>
        <th colspan="12"><b>{{$tutor->name}}</b></th>
    </tr>
    <tr>
        <th colspan="12"><b> Email: {{$tutor->email}}  |  Contact: {{$tutor->contact}}  |  Qualification: {{$tutor->qualification}}  |
                Experience: {{$tutor->experience}}  |  Created On: {{date('Y/m/d',strtotime($tutor->created_at))}}  |
                Modified On: {{date('Y/m/d',strtotime($tutor->updated_at))}}  </b></th>
    </tr>
    <tr>
        <th><b>SN</b></th>
        <th><b>Course</b></th>
        <th><b>Batch</b></th>
        <th><b>Start On</b></th>
        <th><b>End On</b></th>
        <th><b>Duration</b></th>
        <th><b>Time</b></th>
        <th><b>Status</b></th>
        <th><b>Payment Amount</b></th>
    </tr>
    @php($i=1)
    @forelse($reports as $rep)
        <tr>
            <td>{{$i}}</td>
            <td>{{$rep->mybatch->course->name}}</td>
            <td>{{$rep->mybatch->name}}</td>
            <td>{{date('Y/m/d',strtotime($rep->mybatch->startDate))}}</td>
            <td>{{date('Y/m/d',strtotime($rep->mybatch->endDate))}}</td>
            <td>{{$rep->mybatch->duration.' '.$rep->mybatch->durationType}}</td>
            <td>{{$rep->mybatch->timeSlot}}</td>
            <td>{{$rep->mybatch->status}}</td>
            <td>{{$rep->price}}</td>
        </tr>
        @php($i++)
    @empty
        <tr><td colspan="12">No Booking Details Found</td></tr>
    @endforelse
</table>
