@foreach($students as $student)
<tr>
    <td><img src="{{ url($student->idpicture) }}" style="height: 96px; width: 96px; object-fit: scale-down"></td>
    <td>{{ $student->lastname }}</td>
    <td>{{ $student->firstname }}</td>
    <td>{{ $student->middleinitial }}</td>
    <td>{{ $student->idnumber }}</td>
    <td>{{ $student->courseyear }}</td>
    <td>
        <a href="{{ route('students.view', $student->idnumber) }}" class="btn btn-info btn-sm">View</a>
        <form action="{{ route('students.archive', $student->idnumber) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to archive this student?');">Archive</button>
        </form>
    </td>
</tr>
@endforeach