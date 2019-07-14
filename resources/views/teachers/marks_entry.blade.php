@extends('layouts.admin_layout')

@section('title', 'Marks Entry')

@section('content')

    <div class="main-content">
        <div class="col-sm-8">
            <div class="note note-secondary note-purple m-b-15">
                <h4><b>Marks Entry</b></h4>
                <p><span style="font-weight:600;">Exam:</span> &nbsp; {!! $exam->label !!}</p>
                <p><span style="font-weight:600;">Subject:</span> &nbsp; {!! $subject->label !!}</p>
            </div>
        </div>


        <div class="col-sm-12 table-content">
            <form action="{{ route('exam_save_marks') }}" method="POST">
                @csrf
                <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                <table class="table table-striped custab" class="form-horizontal form-bordered">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>Points</th>
                    </tr>
                    </thead>
                    @foreach($students as $student)
                        @php
                            $marksEntry = $savedMarks->where('student_id', $student->id)->first();
                        @endphp

                        <tr>
                            <td>
                                {!! $student->name !!}
                                <input type="hidden" name="student_ids[]" value="{!! $student->id !!}">
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <input class="form-control" type="number" name="marks[]" placeholder="Marks"
                                           value="{!! !is_null($marksEntry) ? $marksEntry->marks : '' !!}"
                                    >
                                </div>
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="grades[]" placeholder="Grade" value="{!! !is_null($marksEntry) ? $marksEntry->grade : '' !!}">
                                </div>
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <input class="form-control" type="number" name="points[]" placeholder="Points" value="{!! !is_null($marksEntry) ? $marksEntry->points : '' !!}">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save Marks</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('extra_js')

    <script>

        $(document).ready(function(){



        });

    </script>

@endsection