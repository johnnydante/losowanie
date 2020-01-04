@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-{{ Auth::user()->isAdmin() ? '8' : '4' }}">
					<div class="card">
						@auth
							<div class="card-header">
								<h5 style="float: left; margin-top: 10px;">Uczestnicy losowania</h5>
									{{--<form action="{{ route('home') }}" method="get">
										<button type="submit" class="btn btn-outline-primary" style="float: right; margin-right: 10px; margin-top: 3px;">Powrót</button>
									</form>--}}
								@if(Auth::user()->isAdmin())
									<form action="{{ route('history') }}" method="get" style="float: right; margin-top: 3px;">
										<button type="submit" class="btn btn-outline-dark" id="shuffle">Historia losowań</button>
									</form>
									<form action="{{ route('register') }}" method="get">
										<button id="addUser" type="submit" class="btn btn-outline-success" style="float: right; margin-top: 3px;">Dodaj uczestnika</button>
									</form>
								@endif
							</div>
							<div class="card-body inner-users">

								@include('flash-messages')
								<table class="table">
									<thead>
										<tr>
											@if(Auth::user()->isAdmin() AND !\Globals::isMobile())
												<th scope="col">ID</th>
											@endif
											<th scope="col">Imię</th>
											@if(Auth::user()->isAdmin() AND !\Globals::isMobile())
												<th scope="col">Email</th>
											@endif
											<th scope="col">Wylosował/a?</th>
											@if(Auth::user()->isAdmin() AND !\Globals::isMobile())
												<th scope="col">Akcje</th>
											@endif

										</tr>
									</thead>
									<tbody>
										@foreach($users as $key => $user)
											<tr>
												@if(Auth::user()->isAdmin() AND !\Globals::isMobile())
													<th scope="row" class="tableId" >{{ $user->id }}</th>
												@endif
												<td>
													{{ $user->name }}
													@if($user->roles == 'admin' ||  $user->roles == 'superadmin')
														<span style="color: darkgreen;">(A) </span>
													@endif
												</td>
												@if(Auth::user()->isAdmin() AND !\Globals::isMobile())
													<td class="tableMail">
														<span class="oldMail">{{ $user->email }}</span>
														<form class="editUserForm" id="{{ $user->id }}" action="{{ route('saveEditUser', ['id' => $user->id]) }}" method="get">
															<div class="form-group row">
																<label for="email" ></label>
																<div class="col-md-10">
																	<input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} email" value="{{ $errors->has('email') ? old('email') : $user->email }}"  name="email">
																	<input type="hidden" value="{{ $user->id }}" name="userId">
																</div>

																<button type="submit" class="saveEditUser btn" >
																	<i class="fas fa-save"></i>
																</button>

															</div>
														</form>
														<span class="invalid-feedback users-span" id="alert-{{ $user->id }}">
															<strong>{{ $errors->first('email') }}</strong>
														</span>
													</td>
												@endif
												@if(Auth::user()->canTakeName())
													@if($user->hasTaken($user))
														<td style="color: green; padding-left: 40px;"><b>TAK</b></td>
													@else
														<td style="color: darkred; padding-left: 40px;">NIE</td>
													@endif
												@else
														<td style="padding-left: 40px;"> - </td>
												@endif
												@if(Auth::user()->isAdmin() AND !\Globals::isMobile())
													<td>
														@if(Auth::user()->isSuperAdmin() && $user->roles != 'admin')
															<span class="editUser">
																<i class="fas fa-edit"></i>
															</span>
														@endif
														@if($user->roles == 'admin' &&  Auth::user()->id == $user->id)
															<span class="editUser">
																<i class="fas fa-edit"></i>
															</span>
														@endif
														<span class="cancelEdit">
															<b>A n u l u j</b>
														</span>
														@if($user->roles != 'admin' && $user->roles != 'superadmin')
															@if(!Auth::user()->isSuperAdmin())
																<span class="editUser">
																	<i class="fas fa-edit"></i>
																</span>
															@endif
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
															<a onclick="return confirm('Czy napewno chcesz usunąć tego użytkownika?')"
															   href="{{ route('deleteUser', ['id' => $user->id]) }}" class="deleteUser">
																<i class="fas fa-times"></i>
															</a>
															@if(Auth::user()->canTakeName())
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
																<a href="{{ route('sendMail', ['id' => $user->id]) }}" class="sendMail">
																	<i class="far fa-envelope"></i>
																</a>
															@endif
															&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
															@if(Auth::user()->isSuperAdmin())
																<a onclick="return confirm('Czy napewno chcesz nadać temu użytkownikowi rolę admina?')"
																   href="{{ route('doAdmin', ['id' => $user->id]) }}" class="doAdmin">
																	<i class="fas fa-user-graduate"></i>
																</a>
																&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
															@endif
														@elseif(Auth::user()->isSuperAdmin() && $user->roles != 'superadmin')
															<a onclick="return confirm('Czy napewno chcesz usunąć temu użytkownikowi rolę admina?')"
															   href="{{ route('deleteAdmin', ['id' => $user->id]) }}" class="deleteAdmin">
																<i class="fas fa-user-graduate"></i>
															</a>
														@endif
													</td>
												@endif
											</tr>
										@endforeach
									</tbody>
								</table>
								<p style="color: darkgreen;">(A) - Administrator</p>
							</div>
						@endauth
					</div>
				</div>
			</div>
		</div>
	</main>
<script>


    $( document ).ready(function() {
        $('.editUser').click(function () {
            var $this = $(this);
            var oldMail = $this.parent().parent().find('.oldMail');
			var form = $this.parent().parent().find('.editUserForm');
			var cancel = $this.parent().parent().find('.cancelEdit');
			cancel.show();
            form.show();
            oldMail.hide();
            $('.editUser').hide();
            $('.doAdmin').hide();
            $('.deleteAdmin').hide();
            $('.deleteUser').hide();
            $('.sendMail').hide();
        });

        $('.cancelEdit').click(function () {
            var $this = $(this);
            var oldMail = $this.parent().parent().find('.oldMail');
            var form = $this.parent().parent().find('.editUserForm');
            $('.cancelEdit').hide();
            form.hide();
            oldMail.show();
            $('.editUser').show();
            $('.doAdmin').show();
            $('.deleteAdmin').show();
            $('.deleteUser').show();
            $('.sendMail').show();
        });

        @if($errors->has('email'))
			var form = $('#{{ old('userId') }}');
        	form.show();
        	var oldMail = form.parent().find('.oldMail');
        	var email = '{{ old('email') }}';
			oldMail.hide();
			$('.editUser').hide();
			$('.doAdmin').hide();
        	$('.deleteAdmin').hide();
			$('.deleteUser').hide();
			$('#alert-{{ old('userId') }}').show();
		@endif

		$('.sendMail').on('click', function () {
            var a = confirm('Czy napewno chcesz wysłać e-mail z zaproszeniem do tego uczestnika?');
            if(a == true) {
                $('#mainCard').parent().append("<div class='card-body' style='opacity:0.7; top: 30px;'>" +
                    "<main class='py-4'>"+
                    "<div class='container'>"+
                    "<div class='row justify-content-center'>"+
                    "<div class='col-md-5'>"+
                    "<div class='card' style='min-height:200px;'>"+
                    "<div class='loader' style='padding: 30px; margin: auto; margin-top: 50px;'></div>" +
                    "<h4 style='text-align: center; padding: 20px; margin-top: 30px;'>Proszę czekać, trwa wysyłanie e-maila</h4>"+
                    "</div>"+
                    "</div>"+
                    "</div>"+
                    "</div>"+
                    "</main>");
                $('#mainCard').hide();
                $('#navi').hide();
            } else {
                return false;
            }
        });

    });

</script>
@endsection

