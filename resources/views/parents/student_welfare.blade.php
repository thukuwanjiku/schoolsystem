@extends('layouts.parents_layout')

@section('title', 'Student Welfare')

@section('content')

    <br>
    <div class="main-content">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#attendance">Attendance</a></li>
            <li><a data-toggle="tab" href="#discipline">Discipline</a></li>
            <li><a data-toggle="tab" href="#medical">Medical History</a></li>
        </ul>

        <div class="tab-content">
            <div id="attendance" class="tab-pane fade in active">
                <div class="col-sm-12">
                    <p>Your child, <strong>{!! session()->get('parent_auth')->student->name !!}</strong> was absent on the following dates:</p>
                </div>

                <div class="col-sm-12">
                    <div class="col-sm-4">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($absent_dates->count())
                                @foreach($absent_dates as $date)
                                    <tr>
                                        <td>{!! \Carbon\Carbon::parse($date->created_at)->toFormattedDateString() !!}</td>
                                        <td><span class="badge badge-danger">absent</span></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="2">No absent dates</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="m-t-20">&nbsp;</div>
            </div>
            <div id="discipline" class="tab-pane fade">
                <div class="col-sm-12 p-20">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Offense</th>
                            <th>Punishment</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($discipline_cases->count())
                            @foreach($discipline_cases as $case)
                                <tr>
                                    <td>{!! \Carbon\Carbon::parse($case->created_at)->toFormattedDateString() !!}</td>
                                    <td>{!! $case->offense !!}</td>
                                    <td>{!! $case->punishment !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="3">No discipline cases</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="m-t-20">&nbsp;</div>
            </div>
            <div id="medical" class="tab-pane fade">
                <div class="col-sm-12 p-20">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nurse</th>
                            <th>Diagnosis</th>
                            <th>Prescription</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($medical_history->count())
                            @foreach($medical_history as $case)
                                <tr>
                                    <td>{!! \Carbon\Carbon::parse($case->created_at)->toFormattedDateString() !!}</td>
                                    <td>{!! $case->nurse->name !!}</td>
                                    <td>{!! $case->diagnosis !!}</td>
                                    <td>{!! $case->prescription !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="3">No medical history</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="m-t-20">&nbsp;</div>
            </div>
        </div>

    </div>

@endsection