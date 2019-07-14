@extends('layouts.admin_layout')

@section('title', 'Students Register')

@section('content')

    <div class="main-content">
        <div class="col-sm-12">
            <div class="note note-secondary note-purple m-b-15">
                <h4><b>Students Register</b></h4>
                <p>
                    <strong>{!! $current_class->name !!}</strong> register for  <strong>{!! $register_date !!}</strong>
                </p>
                <div class="pull-right">
                    <a href="{!! route('register') !!}" class="btn btn-link"><i class="fa fa-search"></i>&nbsp;Search Register</a>
                </div>
            </div>

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
                        </td>
                        <td>
                            <div class="col-sm-6">
                                @if($student['is_present'])
                                    <span class="badge badge-success">present</span>
                                @else
                                    <span class="badge badge-danger">absent</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
@section('extra_js')

    <script>

        $(document).ready(function(){});

    </script>

@endsection