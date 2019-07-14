@extends('layouts.admin_layout')

@section('title', 'Students Register')

@section('content')

    <div class="main-content">
        <div class="col-sm-12">
            <div class="note note-secondary note-purple m-b-15">
                <h4><b>Students Register</b></h4>
                <p>
                    <strong>{!! $current_class->name !!}</strong> register for  <strong>{!! \Carbon\Carbon::now()->toDateString() !!}</strong>
                </p>
            </div>

            <form action="{{ route('register_today_update') }}" method="POST">
                @csrf

                <input type="hidden" name="class_id" value="{!! $current_class->id !!}">
                <table class="table table-striped custab" class="form-horizontal form-bordered">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                {!! $student['student_name'] !!}
                                <input type="hidden" name="student_ids[]" value="{!! $student['student_id'] !!}">
                            </td>
                            <td>
                                <label class="checkbox">
                                    <input type="checkbox" name="{!! 'student_'.$student['student_id'] !!}" {!! (bool)$student['is_present'] ? 'checked' : '' !!}>
                                    <span class="info"></span>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Update Today's Register</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('extra_js')

    <script>

        $(document).ready(function(){});

    </script>

@endsection