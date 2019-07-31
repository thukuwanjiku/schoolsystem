@extends('layouts.admin_layout')

@section('title', 'Students Register')

@section('content')

    <div class="main-content">
        <div class="col-sm-12">
            <fieldset>
                <legend>Search Register</legend>

                <form action="{{ route('search_register') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                >

                    @csrf
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Select Class</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="class_id" required>
                                <option disabled selected>Select</option>
                            @foreach($classes as $class)
                                    <option value="{!! $class->id !!}">{!! ucwords($class->name) !!}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-2 control-label">Select Date</label>
                        <div class="col-sm-4">
                            <input name="register_date" placeholder="Select Date" class="form-control date-input" data-language='en'>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">View Register</button>
                        @if($isClassTeacher)
                        <a href="{{ route('register_today') }}" class="btn btn-lime">Today's Register</a>
                        @endif
                    </div>
                </form>

            </fieldset>
            <br>
        </div>
    </div>

@endsection
@section('extra_js')

    <script>

        $(document).ready(function(){

            $('.date-input').datepicker({
                language:"English",
            });

        });

    </script>

@endsection