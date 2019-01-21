@component('mail::message')
# Witaj w Rodzinnym losowaniu

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>
                        Losowanie osób do prezentów na Wigilię {{  date("Y") }} zostało rozpoczęte, zapraszamy do losowania na naszej stronie
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>
                        Zaloguj się za pomocą swojego maila i ostatnio ustawionego hasła
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@component('mail::button', ['url' => \URL::to('/'), 'color' => 'success'])
Rodzinne losowanie
@endcomponent


Z pozdrowieniami,<br>
{{ config('app.name') }}
@endcomponent
