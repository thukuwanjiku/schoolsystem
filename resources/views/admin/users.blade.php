@extends('layouts.admin_layout')

@section('title', 'Staff')

@section('extra_css')

@endsection

@section('content')

    <div class="main-content">

        <div class="col-sm-12 table-content">
            <div class="col-sm-12" style="padding-bottom: 20px;">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addUserModal">Add Staff</button>
            </div>
            <table class="table table-striped custab">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                @if(sizeof($users))
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ ucwords($user->role->label) }}</td>
                        <td class="text-center">
                            <button
                                    data-id="{{ $user['id'] }}"
                                    data-name="{{ $user['name'] }}"
                                    data-email="{{ $user['email'] }}"
                                    data-role_id="{{ $user->role_id }}"
                                    class='btn btn-info btn-xs' onclick="promptUpdate(this)">
                                <span class="glyphicon glyphicon-edit"></span>
                                Edit</button>
                            <button data-id="{{ $user['id'] }}" data-name="{{ $user['name'] }}" class="btn btn-danger btn-xs" onclick="promptDelete(this)">
                                <span class="glyphicon glyphicon-remove"></span>
                                Del</button>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" style="text-align:center">No staff found</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Staff</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users_add') }}" method="POST" class="form-add-user form-horizontal form-bordered" enctype="multipart/form-data"
                    >

                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Role</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="role_id">
                                    @foreach($roles as $role)
                                        <option value="{!! $role->id !!}">{!! ucwords($role->label) !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">Add</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Update User Modal -->
    <div id="updateUserModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Staff Member</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users_update') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                    >

                        @csrf
                        <input type="hidden" name="user_id" id="update-user-id">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="name" id="update-user-name" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Role</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="role_id" id="update-user-role">
                                    @foreach($roles as $role)
                                        <option value="{!! $role->id !!}">{!! ucwords($role->label) !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="update-user-email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="password" placeholder="Password">
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

    <!-- Delete User Modal -->
    <div id="deleteUserModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Staff Member</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users_delete') }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data"
                    >

                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="user_id" id="delete-user-id">
                            <p style="padding:20px;">Are your sure you want to delete this Staff Member?</p>
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
        $(document).ready(function () {
            $(this).prop('disabled', true);
        });

        function promptUpdate(element){
            var userId = element.getAttribute('data-id');
            var userName = element.getAttribute('data-name');
            var userEmail = element.getAttribute('data-email');
            var roleId = element.getAttribute('data-role_id');

            document.getElementById("update-user-id").value = userId;
            document.getElementById("update-user-name").value = userName;
            document.getElementById("update-user-email").value = userEmail;
            document.getElementById("update-user-role").value = roleId;

            $("#updateUserModal").modal('show');
        }

        function promptDelete(element){
            var user_id = element.getAttribute('data-id');

            document.getElementById("delete-user-id").value = user_id;
            $("#deleteUserModal").modal("show");
        }

    </script>

@endsection