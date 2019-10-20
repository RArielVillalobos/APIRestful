Hola {{$user->name}}
Gracias por crear una cuenta.Por favor verifiquela usando el siguiente link:
{{route('users.verify',$token)}}