@extends('layouts.admin_layout')

@section('title', 'Academics')

@section('extra_css')
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
@endsection

@section('content')

    <div class="main-content" id="app">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#subjects">Subjects</a></li>
            <li><a data-toggle="tab" href="#exams">Exams</a></li>
            <li><a data-toggle="tab" href="#subjects-allocation">Subjects Allocation</a></li>
            <li><a data-toggle="tab" href="#class-teachers">Class Teachers</a></li>
        </ul>

        <div class="tab-content">
            <div id="subjects" class="tab-pane fade in active">
                <div class="col-sm-12" style="padding-bottom: 20px;">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addSubjectModal">Add Subject</button>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Subject</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    @if(sizeof($subjects))
                        @foreach($subjects as $subject)
                            <tr>
                                <td>{{ ucwords($subject['label']) }}</td>
                                <td class="text-center">
                                    <button
                                            data-subject="{{ json_encode($subject) }}"
                                            class='btn btn-info btn-xs btn-update-subject'>
                                        <span class="glyphicon glyphicon-edit"></span>
                                        Edit</button>
                                    <button data-subject-id="{!! $subject->id !!}" class="btn btn-danger btn-xs btn-delete-subject">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        Del</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align:center">No subjects found</td>
                        </tr>
                    @endif
                </table>
            </div>

            <div id="exams" class="tab-pane fade in">
                <div class="col-sm-12" style="padding-bottom: 20px;">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addExamModal">Add Exam</button>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Exam</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    @if(sizeof($exams))
                        @foreach($exams as $exam)
                            <tr>
                                <td>{{ $exam['label'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($exam->start_date)->toFormattedDateString() }}</td>
                                <td>{{ \Carbon\Carbon::parse($exam->end_date)->toFormattedDateString() }}</td>
                                <td><span class="badge {!! $exam->is_active ? 'badge-success' : 'badge-danger' !!}">{!! $exam->is_active ? 'open' : 'closed' !!}</span></td>
                                <td class="text-center">
                                    {{--<button
                                            data-exam="{{ json_encode($subject) }}"
                                            class='btn btn-info btn-xs btn-update-exam'>
                                        <span class="glyphicon glyphicon-edit"></span>
                                        Edit</button>--}}
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="btn-update-exam" data-exam="{{ json_encode($exam) }}">Update</a></li>
                                            @if($exam->is_active)
                                            <li><a data-exam="{{ json_encode($exam) }}" data-action="deactivate" class="btn-update-exam-status" href="#">Deactivate</a></li>
                                            @else
                                            <li><a data-exam="{{ json_encode($exam) }}" data-action="activate" class="btn-update-exam-status" href="#">Activate</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align:center">No exams found</td>
                        </tr>
                    @endif
                </table>
            </div>

            <div id="subjects-allocation" class="tab-pane fade in">
                <div class="col-sm-12" style="padding-bottom: 20px;">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#allocateSubjectModal">Allocate Subject</button>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Teacher</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    @if(sizeof($subject_allocations))
                        @foreach($subject_allocations as $subject_allocation)
                            <tr>
                                <td>{{ ucwords($subject_allocation->teacher->name) }}</td>
                                <td>{{ ucwords($subject_allocation->student_class->name) }}</td>
                                <td>{{ ucwords($subject_allocation->subject->label) }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="btn-update-subject-allocation" data-allocation="{{ json_encode($subject_allocation) }}">Update</a></li>
                                            <li><a href="#" class="btn-delete-subject-allocation" data-allocation="{{ json_encode($subject_allocation) }}">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align:center">No subject allocations</td>
                        </tr>
                    @endif
                </table>
            </div>

            <div id="class-teachers" class="tab-pane fade in">
                <div class="col-sm-12" style="padding-bottom: 20px;">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#assignClassTeacherModal">Assign Class Teacher</button>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Class</th>
                        <th>Teacher</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    @if(sizeof($class_teachers))
                        @foreach($class_teachers as $class_teacher)
                            <tr>
                                <td>{{ ucwords($class_teacher->studentClass->name) }}</td>
                                <td>{{ ucwords($class_teacher->teacher->name) }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="btn-update-class-teacher" data-class_teacher="{{ json_encode($class_teacher) }}">Update</a></li>
                                            <li><a href="#" class="btn-delete-class-teacher" data-class_teacher="{{ json_encode($class_teacher) }}">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align:center">No class teachers</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        <div id="addSubjectModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Subject</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('subjects_add') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Subject Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="subject_name" class="form-control" placeholder="Subject Name">
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

        <div id="updateSubjectModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Subject</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('subjects_update') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="subject_id" id="update-subject-id">
                                <label class="col-sm-3 control-label">Subject Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="subject_name" id="update-subject-name" class="form-control" placeholder="Subject Name">
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

        <!-- Delete Subject Modal -->
        <div id="deleteSubjectModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Subject</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('subjects_delete') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="subject_id" id="delete-subject-id">
                                <p style="padding:20px;">Are your sure you want to delete this subject?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-danger" type="submit">Delete</button></div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!--ADD EXAM MODAL -->
        <div id="addExamModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Exam</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('exams_add') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="subject_id" id="update-subject-id">
                                <label class="col-sm-3 control-label">Exam Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="exam_name" class="form-control" placeholder="Exam Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Exam Start Date</label>
                                <div class="col-sm-4">
                                    <el-date-picker
                                            name="start_date"
                                            v-model="startDate"
                                            type="date"
                                            value-format="yyyy-MM-dd"
                                            placeholder="Select Exam Start date">
                                    </el-date-picker>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Exam Start Date</label>
                                <div class="col-sm-4">
                                    <el-date-picker
                                            name="end_date"
                                            v-model="endDate"
                                            type="date"
                                            value-format="yyyy-MM-dd"
                                            placeholder="Select Exam end date">
                                    </el-date-picker>
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

        <!--UPDATE EXAM MODAL -->
        <div id="updateExamModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Exam</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('exams_update') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="exam_id" id="update-exam-id">
                                <label class="col-sm-3 control-label">Exam Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="exam_name" id="update-exam-name" class="form-control" placeholder="Exam Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Exam Start Date</label>
                                <div class="col-sm-4">
                                    <el-date-picker
                                            name="start_date"
                                            v-model="toUpdateExam.start_date"
                                            type="date"
                                            value-format="yyyy-MM-dd"
                                            placeholder="Select Exam Start date">
                                    </el-date-picker>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Exam Start Date</label>
                                <div class="col-sm-4">
                                    <el-date-picker
                                            name="end_date"
                                            v-model="toUpdateExam.end_date"
                                            type="date"
                                            value-format="yyyy-MM-dd"
                                            placeholder="Select Exam end date">
                                    </el-date-picker>
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

        <!--UPDATE EXAM STATUS MODAL -->
        <div id="updateExamStatusModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="update-exam-status-heading"></h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('exams_change-status') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <input type="hidden" name="exam_id" id="update-exam-status-id">

                            <div class="alert alert-danger m-b-0">
                                <h5><i class="fa fa-exclamation-triangle"></i> <span id="update-exam-status-subheading"></span>?</h5>
                                <p id="update-exam-status-desc"></p>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit" id="update-exam-status-button"></button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- ALLOCATE SUBJECT MODAL -->
        <div id="allocateSubjectModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Allocate Subject</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('subjects-allocation_allocate') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Teacher</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="teacher_id">
                                        <option selected disabled>Select</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{!! $teacher->id !!}">{!! ucwords($teacher->name) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Class</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="class_id">
                                        <option selected disabled>Select</option>
                                        @foreach($classes as $class)
                                            <option value="{!! $class->id !!}">{!! ucwords($class->name) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Subject</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="subject_id">
                                        <option selected disabled>Select</option>
                                        @foreach($subjects as $subject)
                                            <option value="{!! $subject->id !!}">{!! ucwords($subject->label) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Allocate</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- UPDATE SUBJECT ALLOCATION MODAL -->
        <div id="updateSubjectAllocationModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Allocate Subject</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('subjects-allocation_update') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <input type="hidden" name="allocation_id" id="update-allocation-id">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Teacher</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="teacher_id" id="update-allocation-teacher" disabled>
                                        @foreach($teachers as $teacher)
                                            <option value="{!! $teacher->id !!}">{!! ucwords($teacher->name) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Class</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="class_id" id="update-allocation-class">
                                        @foreach($classes as $class)
                                            <option value="{!! $class->id !!}">{!! ucwords($class->name) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Subject</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="subject_id" id="update-allocation-subject">
                                        @foreach($subjects as $subject)
                                            <option value="{!! $subject->id !!}">{!! ucwords($subject->label) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Update Allocation</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- ASSIGN CLASS TEACHER MODAL -->
        <div id="assignClassTeacherModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Assign Class Teacher</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('class-teacher_assign') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Class</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="class_id">
                                        <option selected disabled>Select</option>
                                        @foreach($classes as $class)
                                            <option value="{!! $class->id !!}">{!! ucwords($class->name) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Teacher</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="teacher_id">
                                        <option selected disabled>Select</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{!! $teacher->id !!}">{!! ucwords($teacher->name) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Assign Class Teacher</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- UPDATE CLASS TEACHER MODAL -->
        <div id="updateClassTeacherModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Class Teacher</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('class-teacher_update') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <input type="hidden" name="record_id" id="update-class-teacher-id">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Class</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="class_id" id="update-class-teacher-class-id">
                                        @foreach($classes as $class)
                                            <option value="{!! $class->id !!}">{!! ucwords($class->name) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select Teacher</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="teacher_id" id="update-class-teacher-teacher-id">
                                        @foreach($teachers as $teacher)
                                            <option value="{!! $teacher->id !!}">{!! ucwords($teacher->name) !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="submit">Update Record</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Delete Class Teacher Modal -->
        <div id="deleteClassTeacherModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Class Teacher</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('class-teacher_delete') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                        >

                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="record_id" id="delete-class-teacher-id">
                                <p style="padding:20px;">Are your sure you want to delete this class teacher entry?</p>
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

    <!-- import Vue before Element UI Library -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <!-- import ELEMENT UI KIT -->
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <script src="//unpkg.com/element-ui/lib/umd/locale/en.js"></script>

    <script>
        ELEMENT.locale(ELEMENT.lang.en);

        new Vue({
            el: '#app',
            data: function() {
                return {
                    startDate:null,
                    endDate:null,

                    toUpdateExam:{},
                }
            },
            mounted(){
                var vm = this;
                $(".btn-update-exam").on('click', function () {
                    var exam = JSON.parse(this.getAttribute("data-exam"));
                    vm.toUpdateExam = exam;


                    $("#update-exam-id").val(exam.id);
                    $("#update-exam-name").val(exam.label);

                    $("#updateExamModal").modal("show");
                });
            },
        })
    </script>

    <script>
        $(document).ready(function(){
            $("button[type='submit']").on('click', function () {
                $(this).hide();
            });

            $(".btn-update-subject").on('click', function(){
               var subject = JSON.parse(this.getAttribute('data-subject'));

               $("#update-subject-id").val(subject.id);
               $("#update-subject-name").val(subject.label);

               $("#updateSubjectModal").modal("show");
            });

            $(".btn-delete-subject").on('click', function(){
               var subjectId = this.getAttribute('data-subject-id');

               $("#delete-subject-id").val(subjectId);
               $("#deleteSubjectModal").modal("show");
            });

            $(".btn-update-exam-status").on('click', function () {
                var exam = JSON.parse(this.getAttribute("data-exam"));
                var action = this.getAttribute("data-action");
                console.log(action);

                $("#update-exam-status-id").val(exam.id);
                $("#update-exam-status-heading").html(action == 'activate' ? "Active Exam" : "Deactivate Exam");
                $("#update-exam-status-subheading").html(action == 'activate' ? "Active this Exam" : "Deactivate this Exam");
                $("#update-exam-status-desc").html(action == 'activate' ? "Are you sure you want to Activate this exam?" : 'Are you sure you want to Deactivate the exam? This will close the system from any marks entry');
                $("#update-exam-status-button").html(action == 'activate' ? "Activate" : 'Deactivate');

                $("#updateExamStatusModal").modal("show");
            });

            $(".btn-update-subject-allocation").on('click', function () {
                var allocation = JSON.parse(this.getAttribute('data-allocation'));

                $("#update-allocation-id").val(allocation.id);
                $("#update-allocation-teacher").val(allocation.teacher.id);
                $("#update-allocation-class").val(allocation.student_class.id);
                $("#update-allocation-subject").val(allocation.subject.id);

                $("#updateSubjectAllocationModal").modal("show");
            });

            $(".btn-update-class-teacher").on('click', function () {
                var class_teacher = JSON.parse(this.getAttribute('data-class_teacher'));

                $("#update-class-teacher-class-id").val(class_teacher.class_id);
                $("#update-class-teacher-id").val(class_teacher.id);
                $("#update-class-teacher-teacher-id").val(class_teacher.teacher_id);
                $("#updateClassTeacherModal").modal("show");
            });

            $(".btn-delete-class-teacher").on('click', function () {
                var class_teacher = JSON.parse(this.getAttribute('data-class_teacher'));

                $("#delete-class-teacher-id").val(class_teacher.id);
                $("#deleteClassTeacherModal").modal("show");
            })

        });
    </script>

@endsection