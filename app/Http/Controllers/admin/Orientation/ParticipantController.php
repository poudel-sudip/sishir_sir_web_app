<?php

namespace App\Http\Controllers\admin\Orientation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orientation;
use App\Models\OrientationParticipant;

class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Orientation $orientation)
    {
        $participants = $orientation->participants;
        // dd($orientation,$participants);
        return view('admin.orientation.participant.index',compact('orientation','participants'));
    }

    public function destroy(Orientation $orientation, OrientationParticipant $participant)
    {
        // dd($orientation,$participant);
        $participant->delete();
        return redirect('/admin/orientations/'.$orientation->id.'/participants');
    }
}
