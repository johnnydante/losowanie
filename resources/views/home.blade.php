@extends('layouts.app')

@section('content')
				@if(Auth::user()->canTakeName())
                    @if(!Auth::user()->hasTaken())
                        <form action="{{ route('getPair') }}" method="get">
                            <button type="submit" class="btn btn-outline-success">Wylosuj dla mnie osobę</button>
                        </form>
                    @else
							<h3>Osoba, którą
								@if(substr(Auth::user()->name, -1) == 'a')
									wylosowałaś,
								@else
									wylosowałeś,
								@endif
								 to: <b><i>{{ Auth::user()->getMyPair() }}</i></b> </h3>
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
										<div class="col-md-9">
											<h5>
												<p style="margin-top: 7px;float: left;">1) {{ Auth::user()->getMyFirstSuggestion() }}</p>
												<a href='{{ route('changeOneSuggest', ['suggest' => 'first']) }}'
												   class="btn btn-outline-primary" style="margin-left: 10px; float:right;">Cofnij</a>
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
												<p style="margin-top: 7px;float: left;">2) {{ Auth::user()->getMySecondSuggestion() }}</p>
												<a href='{{ route('changeOneSuggest', ['suggest' => 'second']) }}'
												   class="btn btn-outline-primary" style="margin-left: 10px; float: right;">Cofnij</a>
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
												<p style="margin-top: 7px;float: left;">3) {{ Auth::user()->getMyThirdSuggestion() }}</p>
												<a href='{{ route('changeOneSuggest', ['suggest' => 'third']) }}'
												   class="btn btn-outline-primary" style="margin-left: 10px; float:right;">Cofnij</a>
											</h5>
										</div>
									</div>
                                @else
									<div class="form-group row">
										<label for="third" ></label>
										<div class="col-md-6">
											<input type="text" class="form-control{{ $errors->has('third') ? ' is-invalid' : '' }}" value="{{ old('third') }}"
														 placeholder="Wpisz trzecią podpowiedzź" id="third" name="third">
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
											<button type="submit" class="btn btn-outline-success">Prześij podpowiedzi</button>
										</div>
									</div>
                                @endif
                                @csrf
                            </form>
                        </div>
                    @endif
				@else
					<h4 style="margin-top: 10px;">Dane do nowego losowania jeszcze nie są dostępne</h4>
				@endif
@endsection
