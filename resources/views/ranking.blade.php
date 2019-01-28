@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-4">
					<div class="card">
						@auth
							<div class="card-header">
								<h5 style="float: left; margin-top: 10px;">Ranking punktów snake</h5>
									<form action="{{ route('snake') }}" method="get">
										<button type="submit" class="btn btn-outline-primary" style="float: right; margin-right: 10px; margin-top: 3px;">Powrót</button>
									</form>
							</div>
							<div class="card-body inner-users">

								@include('flash-messages')
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Imię</th>

											<th scope="col">Punkty</th>
										</tr>
									</thead>
									<tbody>
										@foreach($users as $key => $user)
											<tr>

												<td style="padding-left: 20px;">
													{{ $user->name }}
												</td>

												<td style="color: darkblue; padding-left: 30px;">
													<b>{{ $points[$key] ? $points[$key] : '-' }}</b>
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

