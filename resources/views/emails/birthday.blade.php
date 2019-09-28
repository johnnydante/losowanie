@component('mail::message')
# URODZINY!!

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>
                        Cześć, <br>
                        Kalendarz 'Rodzinnego losowania' podpowiada, że dzisiaj urodziny obchodzi <b>{{ $name }}!</b> <br>
                        Nie zapomnij złożyć życzeń ;)
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

Z życzeniami miłego dnia,<br>
{{ config('app.name') }}
@endcomponent
