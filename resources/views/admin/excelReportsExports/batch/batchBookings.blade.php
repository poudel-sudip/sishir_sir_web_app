<h1>{{$batch->course->name}}</h1>
<h3>{{$batch->name}}</h3>
<h5>
    Start On: {{date('Y/m/d',strtotime($batch->startDate))}}
    | End On: {{date('Y/m/d',strtotime($batch->endDate))}}
    | Duration: {{$batch->duration.' '.$batch->durationType}}
    | Time: {{$batch->timeSlot}}
    | Fee: {{$batch->fee}}
    | Discount: {{$batch->discount}}
    | Status: {{$batch->status}}
</h5>
<table>
    <tr>
        <th><b>SN</b></th>
        <th><b>Date</b></th>
        <th><b>Name</b></th>
        <th><b>Email</b></th>
        <th><b>Contact</b></th>
        <th><b>Payment Amount</b></th>
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
            <td>{{$rep->amount}}</td>
            <td>{{$rep->mode}}</td>
            <td>{{$rep->account}}</td>
            <td>{{$rep->status}}</td>
        </tr>
        @php($i++)
    @empty
        <tr><td colspan="9">No Booking Details Found</td></tr>
    @endforelse
</table>
