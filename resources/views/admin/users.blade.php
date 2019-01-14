@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						@auth
								<div class="card-header">
									<h5 style="float: left; margin-top: 10px;">Użytkownicy</h5>
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
												<th scope="col">Email</th>
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
													<td class="tableMail">
                                                        {{ $user->email }}
                                                        @if ($errors->has('third'))
                                                            <span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('third') }}</strong>
															</span>
                                                        @endif
                                                    </td>
													@if($user->hasTaken($user))
														<td style="color: green"><b>TAK</b></td>
													@else
														<td style="color: darkred">NIE</td>
													@endif
													@if(Auth::user()->isAdmin())
														<td>
                                                            <span class="editUser">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                            <a href="{{ route('saveEditUser', ['id' => $user->id]) }}" class="saveEditUser">
                                                                <i class="fas fa-save"></i>
                                                            </a>
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
            console.log($this);
            $('.editUser').hide();
            $this.next('.saveEditUser').show();
            var $mail = $this.parent().parent().find('.tableMail').innerHTML;
            var $id = $this.parent().parent().find('.tableId').innerHTML;
            $this.parent().parent().find('.tableMail').html('<form action="{{ route('saveEditUser', ['id' => $user->id]) }}" method="post">' +
                '<div class="form-group row">\n' +
                '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label for="mail" ></label>\n' +
                '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="col-md-6">\n' +
                '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control{{ $errors->has('mail') ? 'is-invalid' : '' }}" value="{{ old('mail') }}"\n' +
                '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t value="' + $mail + '" id="mail" name="mail">\n' +
                '\t\t\t\t\t\t\t\t\t\t\t\t\t\t</div>\n' +
                '\t\t\t\t\t\t\t\t\t\t\t\t\t</div>' +
                '</form>')
        });
    });
</script>
@endsection

