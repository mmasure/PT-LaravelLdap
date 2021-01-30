@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title','Users Config')

@section('main-content')
    <input type="hidden" id="_token" value="{{ csrf_token() }}"/>
    <div class="row">
        <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
                <div class="box-header">
                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                            <div class="input-group-btn">
                                <button class="btn btn-xs btn-primary new-user"
                                        data-url="{{ route('user.store') }}">
                                    <span class="fa fa-user-plus"></span> New User
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Login</th>
                            <th>E-mail</th>
                            <th>LDAP</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr id="user-{{ $user->id }}">
                                <td class="name">{{ $user->name }}</td>
                                <td class="username">{{ $user->username }}</td>
                                <td class="email">{{ $user->email }}</td>
                                <td>
                                    @if(!is_null($user->guid))
                                        <span class="label label-success">enable</span>
                                    @else
                                        <span class="label label-danger">disable</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-primary delete-user"
                                            data-url="{{ route('user.delete',$user->id) }}">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                    <button class="btn btn-xs btn-primary edit-user"
                                            data-url="{{ route('user.update',$user->id) }}" data-id="{{ $user->id }}">
                                        <span class="fa fa-pencil"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            let _token = $('#_token').val();

            $('.table').DataTable();

            $('.delete-user').on('click', function (e) {
                e.preventDefault();
                let url = $(this).data('url');
                Swal.fire({
                    title: 'Are you sure you want to remove this user ?',
                    type: 'question',
                    showCancelButton: true,
                    confirmButton: true,
                }).then(() => {
                    $.ajax({
                        data: {_token: _token},
                        url: url,
                        method: 'DELETE',
                        success: function () {
                            document.location.reload(true)
                        }
                    });
                })
            });

            $('.edit-user').on('click', function (e) {
                let name = $('#user-'+$(this).data('id')+' td.name').text()
                let username = $('#user-'+$(this).data('id')+' td.username').text()
                let email = $('#user-'+$(this).data('id')+' td.email').text()
                let url = $(this).data('url');

                Swal.fire({
                    title: 'Edit user',
                    html: `<input type="text" id="name" class="swal2-input" placeholder="Name" value="`+name+`">
                           <input type="text" id="username" class="swal2-input" placeholder="Username" value="`+username+`">
                           <input type="email" id="email" class="swal2-input" placeholder="Email" value="`+email+`">
                           <input type="password" id="password" class="swal2-input" placeholder="Password">`,
                    confirmButtonText: 'Save',
                    focusConfirm: false,
                    preConfirm: () => {
                        const name = Swal.getPopup().querySelector('#name').value
                        const username = Swal.getPopup().querySelector('#username').value
                        const email = Swal.getPopup().querySelector('#email').value
                        const password = Swal.getPopup().querySelector('#password').value
                        if (!name && !username && !email) {
                            Swal.showValidationMessage(`Please do not send empty form`)
                        }
                        return {name: name, username: username, email:email, password:password}
                    }
                }).then((result) => {
                    console.log(result);
                    $.ajax({
                        data: {
                            _token: _token,
                            name: result.value.name,
                            username: result.value.username,
                            email: result.value.email,
                            password: result.value.password
                        },
                        url: url,
                        method: 'PATCH',
                        success: function (response) {
                            Swal.fire(`
                                User is updated
                              `.trim())
                            document.location.reload(true)
                        }
                    });
                })
            });

            $('.new-user').on('click', function (e) {
                let url = $(this).data('url');

                Swal.fire({
                    title: 'New user',
                    html: `<input type="text" id="name" class="swal2-input" placeholder="Name">
                           <input type="text" id="username" class="swal2-input" placeholder="Username" >
                           <input type="email" id="email" class="swal2-input" placeholder="Email">
                           <input type="password" id="password" class="swal2-input" placeholder="Password">`,
                    confirmButtonText: 'Save',
                    focusConfirm: false,
                    preConfirm: () => {
                        const name = Swal.getPopup().querySelector('#name').value
                        const username = Swal.getPopup().querySelector('#username').value
                        const email = Swal.getPopup().querySelector('#email').value
                        const password = Swal.getPopup().querySelector('#password').value
                        if (!name && !username && !email && !password) {
                            Swal.showValidationMessage(`Please do not send empty form`)
                        }
                        if (!validateEmail(email)) {
                            Swal.showValidationMessage(`Email is not valid`)
                        }
                        return { name: name, username: username, email:email, password:password }
                    }
                }).then((result) => {
                    console.log(result);
                    $.ajax({
                        data: {
                            _token: _token,
                            name: result.value.name,
                            username: result.value.username,
                            email: result.value.email,
                            password: result.value.password
                        },
                        url: url,
                        method: 'POST',
                        success: function (response) {
                            Swal.fire(`
                                User is registered
                              `.trim())
                            document.location.reload(true)
                        }
                    });
                })
            })
        })

        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
    </script>
@endsection
