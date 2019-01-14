@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						@auth
							@if(Auth::user()->isAdmin())
								<div class="card-header">
									<h5 style="float: left; margin-top: 10px;">Użytkownicy</h5>
										<form action="{{ route('home') }}" method="get">
											<button type="submit" class="btn btn-outline-primary" style="float: right;">Powrót</button>
										</form>
										<form action="{{ route('register') }}" method="get">
											<button type="submit" class="btn btn-outline-success" style="float: right; margin-right: 20px;">Dodaj użytkownika</button>
										</form>
								</div>

								<div class="card-body inner-users">
									@include('flash-messages')

									<table class="table">
										<thead>
											<tr>
												<th scope="col">ID</th>
												<th scope="col">Imię</th>
												<th scope="col">Email</th>
												<th scope="col">Wylosował/a?</th>
												<th scope="col">Akcje</th>
											</tr>
										</thead>
										<tbody>
											@foreach($users as $user)
												<tr>
													<th scope="row">{{ $user->id }}</th>
													<td>{{ $user->name }}</td>
													<td>{{ $user->email }}</td>
													@if($user->hasTaken($user))
														<td>TAK</td>
													@else
														<td>NIE</td>
													@endif
													<td>
														<span id="editUser"><i class="fas fa-edit"></i></span>
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<a onclick="return confirm('Czy napewno chcesz usunąć tego użytkownika?')"
														   href="{{ route('deleteUser', ['id' => $user->id]) }}" id="deleteUser">
															<i class="fas fa-times"></i>
														</a>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>

								</div>
							@endif
						@endauth
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection
