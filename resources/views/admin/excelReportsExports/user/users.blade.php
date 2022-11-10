<table>
    <tr>
        <th><b>SN</b></th>
        <th><b>Name</b></th>
        <th><b>Email</b></th>
        <th><b>Contact</b></th>
        <th><b>District</b></th>
        <th><b>City</b></th>
        <th><b>Interests</b></th>
        <th><b>Role</b></th>
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
            <td>{{$rep->district}}</td>
            <td>{{$rep->city}}</td>
            <td>{{$rep->interests}}</td>
            <td>{{$rep->role}}</td>
            <td>{{$rep->status}}</td>
            <td>{{date('Y/m/d',strtotime($rep->created_at))}}</td>
            <td>{{date('Y/m/d',strtotime($rep->updated_at))}}</td>
        </tr>
        @php($i++)
    @empty
        <tr><td colspan="8">No User Details Found</td></tr>
    @endforelse
</table>
