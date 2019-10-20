@component('mail::message')
# Hola {{$user->name}}

Has cambiado el correo electronico.Por favor verifiquela usando el siguiente botón:

@component('mail::button', ['url' => route('users.verify',$user->verification_token)])
        Confirmar mi cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent


