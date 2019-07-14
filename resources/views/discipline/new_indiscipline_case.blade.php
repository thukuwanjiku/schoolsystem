@extends('layouts.admin_layout')

@section('title', 'New Discipline Report ')

@section('content')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

    <div class="main-content">

        <form action="{{ route('save_new_discipline_case') }}" method="POST" class="form-horizontal form-bordered">
            @csrf
            
            <div class="form-group">
                <label class="control-label col-sm-2">Student Admission No.</label>
                <div class="col-sm-3">
                    <input type="text" name="student_admission" value="{{ old('student_admission') }}" class="form-control" placeholder="Enter Student Admission No.">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Offenses Description</label>
                <div class="col-sm-9">
                    <textarea name="offense_desc" value="{{ old('offense') }}" class="form-control"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Punishment</label>
                <div class="col-sm-9">
                    <textarea name="punishment" value="{{ old('punishment') }}" class="form-control"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <a href="{{ route('medical') }}" class="btn btn-default">Cancel</a>
                <button class="btn btn-success" type="submit">Save Report</button>
            </div>
            
        </form>

    </div>

@endsection
@section('extra_js')
    <script>
        CKEDITOR.replace( 'offense_desc' );
        CKEDITOR.replace( 'punishment' );
    </script>

@endsection