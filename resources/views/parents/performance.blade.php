@extends('layouts.parents_layout')

@section('title', 'Student Performance')

@section('content')

    <div style="padding-left: 20px;">

        <div class="col-sm-8">
            <fieldset>
                <legend>Fetch Performance</legend>

                <form action="{{ route('parents_performance') }}" method="GET" class="form-horizontal form-bordered" enctype="multipart/form-data"
                >

                    @csrf
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Select Exam</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="exam_id">
                                @foreach($exams as $exam)
                                    <option value="{!! $exam->id !!}">{!! ucwords($exam->label) !!}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <button class="btn btn-success" type="submit">Pull results</button>
                        </div>
                    </div>
                </form>

            </fieldset>
            <div class="m-t-20">&nbsp;</div>
        </div>

        @if(!is_null($data))
        <div class="col-sm-12 m-t-30">
            <p><strong>Student: </strong>{!! $data['student_name'] !!}</p>
            <p><strong>Exam</strong>: {!! $data['exam_name'] !!}</p>
            <p><strong>Average Points</strong>: {!! $data['avg_points'] !!} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <strong>Mean Grade: </strong> {!! $data['mean_grade'] !!}</p>

            <br>
            <div class="col-sm-6">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Grade</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($subject_marks->count())
                        @foreach($subject_marks as $mark)
                            <tr>
                                <td>{!! ucwords($mark->subject->label) !!}</td>
                                <td>{!! $mark->marks !!}</td>
                                <td>{!! $mark->grade !!}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="3">No results found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        @endif

    </div>

@endsection