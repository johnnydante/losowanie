@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-{{ Auth::user()->isAdmin() ? '8' : '6' }}">
					<div class="card">
						@auth
							<div class="card-header">
								<h5 style="float: left; margin-top: 10px;">Uczestnicy losowania</h5>
									<form action="{{ route('home') }}" method="get">
										<button type="submit" class="btn btn-outline-primary" style="float: right; margin-right: 10px; margin-top: 3px;">Powrót</button>
									</form>
								@if(Auth::user()->isAdmin())
									<form action="{{ route('register') }}" method="get">
										<button type="submit" class="btn btn-outline-success" style="float: right; margin-right: 20px; margin-top: 3px;">Dodaj uczestnika</button>
									</form>
								@endif
							</div>
							<div class="card-body inner-users">

								@include('flash-messages')
								<table class="table">
									<thead>
										<tr>
											@if(Auth::user()->isAdmin())
												<th scope="col">ID</th>
											@else
												<th scope="col"></th>
											@endif
											<th scope="col">Imię</th>
											@if(Auth::user()->isAdmin())
												<th scope="col">Email</th>
											@endif
											<th scope="col">Wylosował/a?</th>
											@if(Auth::user()->isAdmin())
												<th scope="col">Akcje</th>
											@endif

										</tr>
									</thead>
									<tbody>
										@foreach($users as $user)
											<tr>
												@if(Auth::user()->isAdmin())
													<th scope="row" class="tableId">{{ $user->id }}</th>
												@else
													<th scope="row"></th>
												@endif
												<td>{{ $user->name }}</td>
												@if(Auth::user()->isAdmin())
													<td class="tableMail">
														<span class="oldMail">{{ $user->email }}</span>
														<form class="editUserForm" id="{{ $user->id }}" action="{{ route('saveEditUser', ['id' => $user->id]) }}" method="get">
															<div class="form-group row">
																<label for="email" ></label>
																<div class="col-md-8">
																	<input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} email" value="{{ $user->email }}"  name="email">
																	<input type="hidden" value="{{ $user->id }}" name="userId">
																</div>
																@if ($errors->has('email'))
																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $errors->first('email') }}</strong>
																	</span>
																@endif
																<button type="submit" class="saveEditUser btn" >
																	<i class="fas fa-save"></i>
																</button>
															</div>
														</form>
														@if ($errors->has('third'))
															<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('third') }}</strong>
													</span>
														@endif
													</td>
												@endif
												@if($user->hasTaken($user))
													<td style="color: green; padding-left: 40px;"><b>TAK</b></td>
												@else
													<td style="color: darkred; padding-left: 40px;">NIE</td>
												@endif
												@if(Auth::user()->isAdmin())
													<td>
														<span class="editUser">
															<i class="fas fa-edit"></i>
														</span>
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<a onclick="return confirm('Czy napewno chcesz usunąć tego użytkownika?')"
														   href="{{ route('deleteUser', ['id' => $user->id]) }}" class="deleteUser">
															<i class="fas fa-times"></i>
														</a>
													</td>
												@endif
											</tr>
										@endforeach
									</tbody>
								</table>
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
            var mail = $this.parent().parent().find('.oldMail').innerHTML;
            var oldMail = $this.parent().parent().find('.oldMail');
			var form = $this.parent().parent().find('.editUserForm');
			console.log(mail);
            form.show();
            oldMail.hide();
            $('.editUser').hide();
            $('.deleteUser').hide();
        });
        @if($errors->has('email'))

        	form.show();
//			oldMail.hide();
			$('.editUser').hide();
			$('.deleteUser').hide();
		@endif
    });

</script>
@endsection

