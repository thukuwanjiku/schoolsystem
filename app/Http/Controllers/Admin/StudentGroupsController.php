<?php

namespace App\Http\Controllers\Admin;

use App\DB\Students\StudentGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentGroupsController extends Controller
{
    public function index(){
        //fetch all student groups from database
        $groups = StudentGroup::latest()->get();

        //return a page displaying all the groups
        return view('admin.student-classes')->with([
            'groups' => $groups
        ]);
    }

    public function add(Request $request)
    {
        $validation = $request->validate([
            'group_name' => 'required',
        ], [
            'group_name.required' => "Please enter the class name",
        ]);

        //create a new student group
        StudentGroup::create([
            'name' => $request['group_name'],
            'is_completed' => false
        ]);

        //fetch all student groups from database
        $groups = StudentGroup::all();

        session()->flash('status', 'Successfully added student group');
        //return back to students page
        return back()->with([
            'groups' => $groups
        ]);
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'group_id' => 'required',
            'group_name' => 'required',
        ], [
            'group_name.required' => "Please enter the class name",
        ]);

        //find the group with the id given
        if($group = StudentGroup::where('id', $request['group_id'])->first()){
            //there is such a group, update it
            $group->name = $request['group_name'];
            $group->is_completed = !empty($request['is_completed']) ? true : false;
            $group->year_completed = !empty($request['year_completed']) ? $request['year_completed'] : $group->year_completed;
            $group->save();

            session()->flash('status', 'Successfully updated student group');
            return redirect()->route('groups');
        }

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        //find the group with the id given
        if($group = StudentGroup::where('id', $request['group_id'])->first()){
            //there is such a group, delete it
            $group->delete();

            session()->flash('status', 'Successfully deleted student group');
            return redirect()->route('groups');
        }

        return redirect()->back();
    }
}
