@component('mail::message')
# Witaj w Rodzinnym losowaniu

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>
                        Losowanie osób do prezentów na Wigilię {{  date("Y") }} zostało rozpoczęte, osobę można wylosować za pomocą systemu na stronie internetowej, do której prowadzi poniższy przycik
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
                        Twój login na stronie, to Twój e-mail, a hasło do pierwszego logowania to <b style="color: black; font-size: 18px;">'mojehaslo'</b>, po zalogowaniu możesz zmienić swoje hasło na dowolne
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
