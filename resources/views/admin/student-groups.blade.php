@extends('layouts.admin_layout')

@section('title', 'Student Groups')

@section('extra_css')

    <style>
        fieldset
        {
            border: 1px solid #ddd !important;
            margin: 0;
            min-width: 0;
            padding: 10px;
            position: relative;
            border-radius:4px;
            background-color:#f5f5f5;
            padding-left:10px!important;
        }

        legend
        {
            font-size:14px;
            font-weight:bold;
            margin-bottom: 0px;
            width: 20%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #ffffff;
        }
        .table{
            background: #ffffff;
            margin-top: 15px;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .hidden{
            display:none;
        }
    </style>

@endsection

@section('content')

    <div class="main-content">
        <div class="col-sm-8">
            <fieldset>
                <legend>Add Group</legend>

                <form action="{{ url('/admin/student-groups/add') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                >

                    @csrf
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Group Name</label>
                        <div class="col-sm-4">
                            <input type="text" name="group_name" class="form-control" placeholder="Group Name">
                        </div>

                        <div class="col-sm-2">
                            <button class="btn btn-success" type="submit">Add Group</button>
                        </div>
                    </div>
                </form>

            </fieldset>
        </div>


        <div class="col-sm-12 table-content">
            <table class="table table-striped custab">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Group Name</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $group['id'] }}</td>
                        <td>{{ $group['name'] }}</td>
                        <td class="text-center">
                            <button
                                    data-id="{{ $group['id'] }}"
                                    data-name="{{ $group['name'] }}"
                                    data-completed="{!! $group->is_completed ? 'true' : 'false' !!}"
                                    data-year-completed="{!! $group->year_completed !!}"
                                    class='btn btn-info btn-xs' onclick="promptUpdate(this)">
                                <span class="glyphicon glyphicon-edit"></span>
                                Edit</button>
                            <button data-id="{{ $group['id'] }}" data-name="{{ $group['name'] }}" class="btn btn-danger btn-xs" onclick="promptDelete(this)">
                                <span class="glyphicon glyphicon-remove"></span>
                                Del</button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <!-- Update Group Modal -->
    <div id="updateGroupModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Group</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/student-groups/update') }}" method="POST" class="form-add-group form-horizontal form-bordered" enctype="multipart/form-data"
                    >

                        @csrf
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Group Name</label>
                            <div class="col-sm-6">
                                <input type="hidden" id="update-group-id" name="group_id" class="form-control">
                                <input type="text" id="update-group-name" name="group_name" class="form-control" placeholder="Group Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Has Completed</label>
                            <div class="col-sm-6">
                                <!-- Rounded switch -->
                                <label class="switch">
                                    <input type="checkbox" id="complete-switch" name="is_completed">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group hidden" id="year-completed-div">
                            <label class="col-sm-4 control-label">Year completed</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Year completed" id="year-completed" name="year_completed" class="form-control">
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

    <!-- Delete Group Modal -->
    <div id="deleteGroupModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Group</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/student-groups/delete') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                    >

                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="group_id" id="delete-group-id">
                            <p style="padding:20px;">Are your sure you want to delete <span id="delete-group-name"></span> group</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="submit">Delete</button></div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('extra_js')

    <script>

        $(document).ready(function(){

            $("#complete-switch").on('change', function(){
               if($(this).is(":checked")){
                   $("#year-completed-div").removeClass('hidden');
               }else{
                   $("#year-completed-div").addClass('hidden');
               }
            });

        });

        function promptUpdate(element){
            var groupID = element.getAttribute('data-id');
            var groupName = element.getAttribute('data-name');
            var isCompleted = element.getAttribute('data-completed') === 'true' ? true : false;
            var yearCompleted = element.getAttribute('data-year-completed');

            document.getElementById("update-group-id").value = groupID;
            document.getElementById("update-group-name").value = groupName;
            document.getElementById("year-completed").value = yearCompleted;
            $("#complete-switch").prop('checked', isCompleted);
            if(isCompleted){
                $("#year-completed-div").removeClass('hidden');
            }else{
                $("#year-completed-div").addClass('hidden');
            }
            $("#updateGroupModal").modal("show");
        }

        function promptDelete(element){
            var groupID = element.getAttribute('data-id');
            var groupName = element.getAttribute('data-name');

            document.getElementById("delete-group-id").value = groupID;
            document.getElementById("delete-group-name").innerHTML = groupName;
            $("#deleteGroupModal").modal("show");
        }

    </script>

@endsection