@extends('layouts.app')

@section('content')
	<main class="py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						@auth
							<div class="card-header">
								<h5 style="float: left; margin-top: 10px;">Witaj {{ Auth::user()->name }}</h5>
								@if(URL::current() != 'http://losowanie.local/changePassword')
									<form action="{{ route('passwordChange') }}" method="get">
										<button type="submit" class="btn btn-outline-primary" style="float: right; margin-top: 3px;">Zmień hasło</button>
									</form>
								@endif
							</div>

							<div class="card-body inner">
								@include('flash-messages')
								@if(Auth::user()->canTakeName())
									@if(!Auth::user()->hasTaken())
										<div style="text-align: center;">
										<form action="{{ route('getPair') }}" method="get">
											<button type="submit" class="btn btn-success" >Wylosuj dla mnie osobę</button>
										</form>
										</div>
									@else
											<h3>Osoba, którą
												@if(substr(Auth::user()->name, -1) == 'a')
													wylosowałaś,
												@else
													wylosowałeś,
												@endif
												 to: <b>{{ Auth::user()->getMyPair() }}</b> </h3>
										<div>
											@if(Auth::user()->getMyPairSuggestions())
												<h4 style="margin-top: 40px;">Podpowiedzi prezentów, które

													@if(substr(Auth::user()->getMyPair(), -1) == 'a')
														podała {{ Auth::user()->getMyPair() }},
													@else
														podał {{ Auth::user()->getMyPair() }},
													@endif

													 to: </h4>
												@if(Auth::user()->getMyPairSuggestions()->first)
													<h5>- {{ Auth::user()->getMyPairSuggestions()->first }}</h5>
												@endif
												@if(Auth::user()->getMyPairSuggestions()->second)
													<h5>- {{ Auth::user()->getMyPairSuggestions()->second }}</h5>
												@endif
												@if(Auth::user()->getMyPairSuggestions()->third)
													<h5>- {{ Auth::user()->getMyPairSuggestions()->third }}</h5>
												@endif
											@else
												<h4 style="margin-top: 40px;">

													@if(substr(Auth::user()->getMyPair(), -1) == 'a')
														{{ Auth::user()->getMyPair() }} nie podała
													@else
														{{ Auth::user()->getMyPair() }} nie podał
													@endif

													jeszcze żadnych podpowiedzi prezentów</h4>
											@endif
										</div>
											@if(!Auth::user()->hasAllSuggestions())
												<h5 style="margin-top: 40px; margin-bottom: 20px;">Możesz podać 3 podpowiedzi prezentu lub mniej dla osoby, która wylosuje Ciebie:</h5>
											@else
											<h4 style="margin-top: 40px;">Twoje podpowiedzi to:</h4>
											@endif
										<div>
											<form action="{{ route('postSuggestion') }}" method="post">
												@if(Auth::user()->hasFirstSuggestions())
													<div class="form-group row">
														<div class="col-md-7">
															<h5>

																<p style="margin-top: 22px;float: left;">
																	<a href='{{ route('changeOneSuggest', ['suggest' => 'first']) }}'
																	   class="btn btn-outline-danger" style="margin-right: 10px; float:left; border-style: none;"><i class="fas fa-times"></i></a>
																	1) {{ Auth::user()->getMyFirstSuggestion() }}
																</p>
															</h5>
														</div>
													</div>
												@else
													<div class="form-group row">
														<label for="first"></label>
														<div class="col-md-6" >
															<input type="text" class="form-control{{ $errors->has('first') ? ' is-invalid' : '' }}" value="{{ old('first') }}"
																		 placeholder="Wpisz pierwszą podpowiedź" id="first" name="first">
															@if ($errors->has('first'))
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $errors->first('first') }}</strong>
																</span>
															@endif
														</div>
													</div>
												@endif
												@if(Auth::user()->hasSecondSuggestions())
													<div class="form-group row">
														<div class="col-md-9" >
															<h5>

																<p style="float: left;">
																	<a href='{{ route('changeOneSuggest', ['suggest' => 'second']) }}'
																										   class="btn btn-outline-danger" style="margin-right: 10px; float:left; border-style: none;"><i class="fas fa-times"></i></a>
																	2) {{ Auth::user()->getMySecondSuggestion() }}
																</p>
															</h5>
														</div>
													</div>
												@else
													<div class="form-group row">
														<label for="second" ></label>
														<div class="col-md-6">
															<input type="text" class="form-control{{ $errors->has('second') ? ' is-invalid' : '' }}" value="{{ old('second') }}"
																		 placeholder="Wpisz drugą podpowiedź" id="second" name="second">
														</div>
														@if ($errors->has('second'))
															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('second') }}</strong>
															</span>
														@endif
													</div>
												@endif
												@if(Auth::user()->hasThirdSuggestions())
													<div class="form-group row">
														<div class="col-md-9" >
															<h5>

																<p style="float: left;">
																	<a href='{{ route('changeOneSuggest', ['suggest' => 'third']) }}'
																										   class="btn btn-outline-danger" style="margin-right: 10px; float:left; border-style: none;"><i class="fas fa-times"></i></a>
																	3) {{ Auth::user()->getMyThirdSuggestion() }}
																</p>
															</h5>
														</div>
													</div>
												@else
													<div class="form-group row">
														<label for="third" ></label>
														<div class="col-md-6">
															<input type="text" class="form-control{{ $errors->has('third') ? ' is-invalid' : '' }}" value="{{ old('third') }}"
																		 placeholder="Wpisz trzecią podpowiedź" id="third" name="third">
														</div>
														@if ($errors->has('third'))
															<span class="invalid-feedback" role="alert">
																<strong>{{ $errors->first('third') }}</strong>
															</span>
														@endif
													</div>
												@endif
												@if(!Auth::user()->hasAllSuggestions())
													<div class="form-group row">
														<div class="col-md-9">
															<button type="submit" class="btn btn-success">Prześij podpowiedzi</button>
														</div>
													</div>
												@endif
												@csrf
											</form>
										</div>
									@endif
								@else
									<h2 style="margin-top: 10px; margin-bottom: 120px; text-align: center;">Dane do nowego losowania jeszcze nie są dostępne</h2>

								@endif
							</div>
						@endauth
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection
