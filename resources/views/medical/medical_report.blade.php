@extends('layouts.admin_layout')

@section('title', 'Medical Department')

@section('content')

    <div class="main-content">

        <div class="col-sm-12" style="padding: 20px;">
            <a class="btn btn-primary" href="{{ route('new_medical') }}">New Medical Report</a>
        </div>

        <div class="col-sm-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Student</th>
                    <th>Diagnosis</th>
                    <th>Prescription</th>
                </tr>
                </thead>

                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($report->created_at)->toDayDateTimeString() }}</td>
                        <td>{{ $report->student->name }}</td>
                        <td>{!! $report->diagnosis !!}</td>
                        <td>{!! $report->prescription !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endsection
@section('extra_js')

    <script>



    </script>

@endsection