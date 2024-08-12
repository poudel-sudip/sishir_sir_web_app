<main style="font-family: Arial, sans-serif;">
    <h1 style="color:#ff0000; text-align:center;">{{ucwords($exam->name)}}</h3>
    <table width="100%" style="font-size: 17px;">
        <tr>
            <td style="width: 40%; text-align: left; vertical-align: top;">
                <h6>Date: {{ date('Y-m-d') }} <br>Time: {{ $exam->exam_solve_time }} <br>Total Questions: {{ $exam->question_count }}</h6>
            </td>
            <td style="width: 30%;"></td>
            <td style="width: 40%; text-align: left; vertical-align: top;">
                <h6>Marks Per Question: {{ $exam->marks_per_question }} <br>Negative Marks Per Question: {{ $exam->negative_marks }}</h6>
            </td>
        </tr>
    </table>  
    <hr style="color:red; height:3px;">   
    @php($i=1)
    @foreach($exam->questions as $row)
        <span style="page-break-inside: avoid;">
            <h5>{{$i}}. {!! strip_tags($row->name) !!}</h5>
            <ol type="A" style="font-size: 14px;">
                <li style="@if(strtolower($row->opt_correct) == 'a') color:red; @endif " >{!! strip_tags($row->opt_a) !!}</li>
                <li style="@if(strtolower($row->opt_correct) == 'b') color:red; @endif " >{!! strip_tags($row->opt_b) !!}</li>
                <li style="@if(strtolower($row->opt_correct) == 'c') color:red; @endif " >{!! strip_tags($row->opt_c) !!}</li>
                <li style="@if(strtolower($row->opt_correct) == 'd') color:red; @endif " >{!! strip_tags($row->opt_d) !!}</li>
                @if(trim(strip_tags($row->rationale)))    
                    <br>  
                    <h5 style="color: #008afc;" >Rationale:</h5>
                    <div style="font-size: 12px;">{!! strip_tags($row->rationale) !!}</div>
                @endif         
            </ol>           
        </span>       
        @php($i++)
    @endforeach 
</main>



