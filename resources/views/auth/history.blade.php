@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6">
					<div class="card">
						@auth
							<div class="card-header">
								<h5 style="float: left; margin-top: 10px;">Historia losowań</h5>
								<form action="{{ route('home') }}" method="get">
									<button type="submit" class="btn btn-outline-primary" style="float: right; margin-top: 3px;">Powrót</button>
								</form>
								@if(Auth::user()->isSuperAdmin())
									<form action="{{ route('saveHistory') }}" method="post">
										@csrf
										<button id="save-history" type="submit" class="btn btn-outline-success" style="float: right; margin-top: 3px;">Zapisz aktualne losowanie</button>
									</form>
								@endif
							</div>
							<div class="card-body inner-users">
								@include('flash-messages')

								@foreach($years as $year)
									<div class="row">
										<div class="col-md-6">
											<h4 style="color: #000075; float: left">Losowanie {{ $year }}:</h4>
										</div>
										<div class="col-md-3">
											<button id="buttonShow{{ $year }}" class="btn btn-outline-success myButton-show" style="float: right; margin-top: -8px">Rozwiń <i class="fas fa-arrow-down"></i></button>
											<button id="buttonHide{{ $year }}" class="btn btn-outline-danger myButton-hide" style="float: right; margin-top: -8px">Zwiń <i class="fas fa-arrow-up"></i></button>
										</div>
									</div>
									<table id="table-{{ $year }}" class="table">
										<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col">Osoba losująca</th>
											<th scope="col">Osoba wylosowana</th>

										</tr>
										</thead>
										<tbody>
										@foreach(\App\History::where('year', $year)->get() as $historyShuffle)
											<tr>
												<td></td>
												<td>
													{{ $historyShuffle->name }}
												</td>
												<td>
													{{ $historyShuffle->pair }}
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								@endforeach
							</div>
						@endauth
					</div>
				</div>
			</div>
		</div>
	</main>

	<script>
        $( document ).ready(function() {
            $('.table').hide();
            $('.myButton-hide').hide();

            $('.myButton-show').click(function () {
				var id = this.getAttribute('id');
				var year = id.substr(id.length - 4);
				$('#table-'+year).show();
                $('#buttonShow'+year).hide();
                $('#buttonHide'+year).show();
			});
            $('.myButton-hide').click(function () {
                var id = this.getAttribute('id');
                var year = id.substr(id.length - 4);
                $('#table-'+year).hide();
                $('#buttonShow'+year).show();
                $('#buttonHide'+year).hide();
            });

            $('#save-history').on('click', function () {
                var a = confirm('Czy napewno chcesz zapisać aktualne losowanie?');
                if(a == true) {
                    return true;
                } else {
                    return false;
                }
            });
        });
	</script>

@endsection

