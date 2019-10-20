@component('mail::message')
# Hola {{$user->name}}
Gracias por crear una cuenta, Por favor verifiquela haciendo click en el siguiente botón:
@component('mail::button', ['url' => route('users.verify',$user->verification_token)])
Confirmar mi cuenta
@endcomponent
Gracias,<br>
{{ config('app.name') }}
@endcomponent


