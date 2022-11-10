<table>
    <tr>
        <th><b>SN</b></th>
        <th><b>Name</b></th>
        <th><b>Email</b></th>
        <th><b>Contact</b></th>
        <th><b>Qualification</b></th>
        <th><b>Experiences</b></th>
        <th><b>Courses</b></th>
        <th><b>Status</b></th>
        <th><b>Created On</b></th>
        <th><b>Updated On</b></th>
    </tr>
    @php($i=1)
    @forelse($reports as $rep)
        <tr>
            <td>{{$i}}</td>
            <td>{{$rep->name}}</td>
            <td>{{$rep->email}}</td>
            <td>{{$rep->contact}}</td>
            <td>{{$rep->qualification}}</td>
            <td>{{$rep->experience}}</td>
            <td>{{$rep->courses}}</td>
            <td>{{$rep->status}}</td>
            <td>{{date('Y/m/d',strtotime($rep->created_at))}}</td>
            <td>{{date('Y/m/d',strtotime($rep->updated_at))}}</td>
        </tr>
        @php($i++)
    @empty
        <tr><td colspan="12">No Tutor Details Found</td></tr>
    @endforelse
</table>
