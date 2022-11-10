@foreach($categories as $category)
    <table>
        <tr>
            <th colspan="7"><h1><b>{{$category->name}}</b></h1></th>
        </tr>
        <tr>
            <th><b>SN </b> </th>
            <th><b>Course Name </b> </th>
            <th><b>Course Slug </b> </th>
            <th><b>Is Popular </b> </th>
            <th><b>Status </b> </th>
            <th><b>Created On </b> </th>
            <th><b>Modified On </b> </th>
        </tr>
        @php($i=1)
        @forelse($category->courseReport as $course)
            <tr>
                <td>{{$i}}</td>
                <td>{{$course->course}}</td>
                <td>{{$course->slug}}</td>
                <td>{{$course->isPopular}}</td>
                <td>{{$course->status}}</td>
                <td>{{$course->created_at}}</td>
                <td>{{$course->updated_at}}</td>
            </tr>
            @php($i++)
        @empty
            <tr><td colspan="7">No Courses Found</td></tr>
        @endforelse
    </table>

    <h1></h1>
@endforeach
