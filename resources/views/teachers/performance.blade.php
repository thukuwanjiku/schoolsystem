@extends('layouts.admin_layout')

@section('title', 'Exam Marks')

@section('content')

    <div class="main-content">
        <div class="col-sm-12">
            <fieldset>
                <legend>Exam Marks Entry</legend>

                <form action="{{ route('exam_marks-entry-selections') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                >

                    @csrf
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Select Exam</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="exam_id" required>
                                <option disabled selected>Select</option>
                            @foreach($exams as $exam)
                                    <option value="{!! $exam->id !!}">{!! ucwords($exam->label) !!}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-2 control-label">Select Class</label>
                        <div class="col-sm-4">
                            <select class="form-control"
                                    name="class_id" id="class-id"
                                    data-allocations="{{ json_encode($allocations) }}"
                                    data-subjects="{{ json_encode($subjects) }}"
                                    required
                            >
                                <option disabled selected>Select</option>
                            @foreach($allocations->unique(function($allocation){return $allocation->class_id;}) as $allocation)
                                    <option value="{!! $allocation->student_class->id !!}">{!! ucwords($allocation->student_class->name) !!}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-2 control-label">Select Subject</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="subject_id" id="subject-id" required>
                                <option disabled selected>Select</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>

            </fieldset>
        </div>

    </div>

@endsection
@section('extra_js')

    <script>

        $(document).ready(function(){

            $("#class-id").on('change', function () {
                var class_id = $(this).val();
                var allocations = JSON.parse(this.getAttribute('data-allocations'));
                var subjects = JSON.parse(this.getAttribute('data-subjects'));

                var options = '<option disabled selected>Select</option>';
                allocations.filter(function(allocation){
                    return allocation.class_id == class_id;
                })
                    .forEach(allocation => {
                        options += '<option value="'+ allocation.subject_id +'">'+ subjects.find(subject => subject.id === allocation.subject_id).label + '</option>';
                    });

                $("#subject-id").empty().append(options);
            })

        });

    </script>

@endsection