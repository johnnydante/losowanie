@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-5">
					<div class="card">
						@auth
							<div class="card-header">
								<h5 style="float: left; margin-top: 10px;">Najbliższe urodziny</h5>
								{{--<form action="{{ route('home') }}" method="get">
									<button type="submit" class="btn btn-outline-primary" style="float: right; margin-right: 10px; margin-top: 3px;">Powrót</button>
								</form>--}}
							</div>
							<div class="card-body inner-users">

								@include('flash-messages')
								<table class="table">
									<thead>
										<tr>

											<th scope="col">Imię</th>

											<th scope="col">Data</th>

										</tr>
									</thead>
									<tbody>
										@foreach($users as $key => $user)
											<tr>
												<td>{{ $user->name }}</td>

												<td class="birthday" style="color: {{ $user->birthday ? ((date_diff(date_create(\Globals::getDateToDiff($user->birthday)),date_create(date('Y-m-d')))->days < 30 AND \Globals::getDateToDiff($user->birthday) >= date('Y-m-d')) ? 'red' : 'blue') : 'black' }};">
                                                    {!! $user->birthday ?
                                                        (\Globals::getDateToDiff($user->birthday) == date('Y-m-d') ?
                                                        '<b>TO DZISIAJ !</b>' :
                                                        '<b>'.\Globals::getBirthdayDate($user->birthday).'</b>') :
                                                    '<i>nie podano</i>'  !!}
                                                </td>

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
@endsection

