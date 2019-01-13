
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Witaj w losowaniu rodzinnym') }}</div>

                <div class="card-body">
                    <p>
                        Losowanie osób do prezentów na Wigilię {{  date("Y") }} zostało rozpoczęte, osobę można wylosować za pomocą systemu na stronie internetowej, do której prowadzi poniższy przycik
                    </p>

                    <form method="GET" action="{{ route('home') }}">
                        @csrf
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Rodzinne losowanie') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
