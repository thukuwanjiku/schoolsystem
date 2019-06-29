@extends('layouts.admin_layout')

@section('title', 'Students')

@section('extra_css')

    <style>
        fieldset
        {
            border: 1px solid #ddd !important;
            margin: 0;
            min-width: 0;
            padding: 10px;
            position: relative;
            border-radius:4px;
            background-color:#f5f5f5;
            padding-left:10px!important;
        }

        legend
        {
            font-size:14px;
            font-weight:bold;
            margin-bottom: 0px;
            width: 20%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #ffffff;
        }
        .table{
            background: #ffffff;
            margin-top: 15px;
        }
    </style>

@endsection

@section('content')

    <div class="main-content">

        @if(sizeof($groups))
        <ul class="nav nav-tabs">
            @foreach($groups as $group)
                <li class="{!! $loop->index === 0 ? 'active' : '' !!}"><a data-toggle="tab" href="{!! '#group_'.$group->id !!}">{!! $group->name !!}</a></li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach($groups as $group)

                <div id="{!! 'group_'.$group->id !!}" class="tab-pane fade in {!! $loop->index === 0 ? 'active' : '' !!}">
                    <div class="col-sm-12" style="padding: 20px;">
                        <button data-group-id="{!! $group->id !!}" data-group-name="{!! $group->name !!}" class="btn btn-primary btn-add-student" type="button">Add Student</button>
                    </div>
                    {{--<h3>{{ $group->name }} Students here</h3>--}}
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Admission No</th>
                        <th>Student Name</th>
                        <th>Parent Name</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    @if(sizeof($students->where('group_id', $group->id)))
                    @foreach($students->where('group_id', $group->id) as $student)
                        <tr>
                            <td>{{ $student['admission_no'] }}</td>
                            <td>{{ $student['name'] }}</td>
                            <td>{{ $student->parent->name }}</td>
                            <td class="text-center">
                                <button
                                        data-student="{{ json_encode($student) }}"
                                        class='btn btn-info btn-xs btn-update-student'>
                                    <span class="glyphicon glyphicon-edit"></span>
                                    Edit</button>
                                <button data-student-id="{!! $student->id !!}" class="btn btn-danger btn-xs btn-delete-student" onclick="promptDelete(this)">
                                    <span class="glyphicon glyphicon-remove"></span>
                                    Del</button>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align:center">No students found</td>
                        </tr>
                    @endif
                </table>
            </div>
            @endforeach
        </div>
        @else
            <div class="container" style="padding:100px 50px;text-align: center;">
                No student classes found
            </div>
        @endif

        <div id="addStudentModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add <span id="add-modal-group-name"></span> Student</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('students_add') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Student Name</label>
                                <div class="col-sm-4">
                                    <input type="hidden" name="group_id" id="add-group-id">
                                    <input type="text" name="student_name" class="form-control" placeholder="Student Name">
                                </div>


                                <label class="col-sm-2 control-label">Admission No</label>
                                <div class="col-sm-4">
                                    <input type="text" name="admission_no" class="form-control" placeholder="Admission No.">
                                </div>
                            </div>
                            <div class="col-sm-12" style="padding:10px;">
                                <h4 class="">Parent's details</h4>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Parent Name</label>
                                <div class="col-sm-4">
                                    <input type="text" name="parent_name" placeholder="Parent Name" class="form-control">
                                </div>

                                <label class="col-sm-2 control-label">Parent Email</label>
                                <div class="col-sm-4">
                                    <input type="text" name="parent_email" placeholder="Parent Email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Phone Number</label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Phone Number" name="parent_phone_number" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Add</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div id="updateStudentModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Student</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('students_update') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Student Name</label>
                                <div class="col-sm-4">
                                    <input type="hidden" name="student_id" id="update-student-id">
                                    <input type="text" name="student_name" id="update-student-name" class="form-control" placeholder="Student Name">
                                </div>


                                <label class="col-sm-2 control-label">Admission No</label>
                                <div class="col-sm-4">
                                    <input type="text" id="update-student-admission-no" name="admission_no" class="form-control" placeholder="Admission No.">
                                </div>
                            </div>
                            <div class="col-sm-12" style="padding:10px;">
                                <h4 class="">Parent's details</h4>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Parent Name</label>
                                <div class="col-sm-4">
                                    <input type="text" id="update-student-parent-name" name="parent_name" placeholder="Parent Name" class="form-control">
                                </div>

                                <label class="col-sm-2 control-label">Parent Email</label>
                                <div class="col-sm-4">
                                    <input type="text"  id="update-student-parent-email" name="parent_email" placeholder="Parent Email" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Phone Number</label>
                                <div class="col-sm-4">
                                    <input type="text" id="update-student-parent-phone" placeholder="Phone Number" name="parent_phone_number" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Delete Student Modal -->
        <div id="deleteStudentModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Student</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('students_delete') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="student_id" id="delete-student-id">
                                <p style="padding:20px;">Are your sure you want to delete this student?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" type="submit">Delete</button></div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
@section('extra_js')

    <script>
        $(document).ready(function(){


            $(".btn-add-student").on('click', function(){
               var groupId  = this.getAttribute('data-group-id');
               var groupName  = this.getAttribute('data-group-name');

               $("#add-modal-group-name").html(groupName);
               $("#add-group-id").val(groupId);

               $("#addStudentModal").modal("show");
            });

            $(".btn-update-student").on('click', function(){
                var student = JSON.parse(this.getAttribute('data-student'));
                $("#update-student-id").val(student.id);
                $("#update-student-name").val(student.name);
                $("#update-student-admission-no").val(student.admission_no);
                $("#update-student-parent-name").val(student.parent.name);
                $("#update-student-parent-email").val(student.parent.email);
                $("#update-student-parent-phone").val(student.parent.phone_number);

                $("#updateStudentModal").modal("show");
            })

            $(".btn-delete-student").on('click', function(){
                var studentId = this.getAttribute('data-student-id');
                $("#delete-student-id").val(studentId);

                $("#deleteStudentModal").modal("show");
            })

        });
    </script>

@endsection