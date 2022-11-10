<table>
    <tr><td colspan="15"><b>Monthly Bookings on : {{date('F, Y',strtotime($date))}}</b></td></tr>
    <tr>
        <th><b>SN</b></th>
        <th><b>Date</b></th>
        <th><b>Booked By</b></th>
        <th><b>Email</b></th>
        <th><b>Contact</b></th>
        <th><b>Course</b></th>
        <th><b>Batch</b></th>
        <th><b>Discounted Price</b></th>
        <th><b>Duration</b></th>
        <th><b>Start On</b></th>
        <th><b>End On</b></th>
        <th><b>Payment Amt.</b></th>
        <th><b>Mode</b></th>
        <th><b>Account No</b></th>
        <th><b>Status</b></th>
    </tr>
    @php($i=1)
    @forelse($reports as $rep)
        <tr>
            <td>{{$i}}</td>
            <td>{{date('Y/m/d',strtotime($rep->created_at))}}</td>
            <td>{{$rep->name}}</td>
            <td>{{$rep->email}}</td>
            <td>{{$rep->contact}}</td>
            <td>{{$rep->mybatch->course->name ?? ''}}</td>
            <td>{{$rep->mybatch->name ?? ''}}</td>
            <td>@if($rep->mybatch->fee ?? '') Rs. {{$rep->mybatch->fee-$rep->mybatch->discount}} @endif</td>
            <td>@if($rep->mybatch->duration ?? '') {{$rep->mybatch->duration.' '.$rep->mybatch->durationType}} @endif</td>
            <td>@if($rep->mybatch->startDate ?? '') {{date('Y/m/d',strtotime($rep->mybatch->startDate))}} @endif</td>
            <td>@if($rep->mybatch->endDate ?? '') {{date('Y/m/d',strtotime($rep->mybatch->endDate))}} @endif</td>
            <td>Rs. {{$rep->amount}}</td>
            <td>{{$rep->mode}}</td>
            <td>{{$rep->account}}</td>
            <td>{{$rep->status}}</td>
        </tr>
        @php($i++)
    @empty
        <tr><td colspan="15">No Booking Details Found</td></tr>
    @endforelse
</table>
