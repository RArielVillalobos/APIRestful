Hola {{$user->name}}
Has cambiado el correo electronico.Por favor verifiquela usando el siguiente link:
{{route('users.verify',$user->verification_token)}}