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
								@if(Auth::user()->isAdmin())
									<form action="{{ route('children') }}" method="get">
										<button id="children" type="submit" class="btn btn-outline-success" style="float: right; margin-top: 3px;">Dzieciaki</button>
									</form>
								@endif
							</div>
							<div class="card-body inner-birthday">

								@include('flash-messages')
								<table class="table" style="margin-bottom: 0px;">
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
												@if($user->name == 'Dawid')
												@endif
												<td class="birthday" style="color: {{ $user->birthday ? \Globals::getColorForBirthday($user->birthday) : 'black' }};">
                                                    {!! $user->birthday ?
                                                        (\Globals::getDateToDiff($user->birthday) == date('Y-m-d') ?
                                                        '<b>TO DZISIAJ !</b>' :
                                                        '<b>'.\Globals::getBirthdayDate($user->birthday).'</b>') :
                                                    '<i>nie podano</i>'  !!} {{ $user->roles == 'child' ? \Globals::getChildrenAge($user->birthday) : '' }}
                                                </td>

											</tr>
										@endforeach
									</tbody>
								</table>
								<b>
									Legenda:
								</b>
								<b>
									<div style="color: #dc0600; margin-bottom: -5px;"> - mniej niż 1 miesiąc do urodzin</div>
									<div style="color: purple; margin-bottom: -5px;"> - mniej niż 3 miesiące do urodzin</div>
									<div style="color: #0000b8; margin-bottom: -5px;"> - mniej niż 6 miesięcy do urodzin</div>
									<div style="color: #006700;"> - ponad pół roku do urodzin</div>
								</b>
							</div>
						@endauth
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection

