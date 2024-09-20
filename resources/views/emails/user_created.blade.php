<x-mail::message>
# Welcome, {{ $user->name }}

Thank you for registraring with us.

<x-mail::button :url="url('/verify-email', $user->id)" color="success">
Click Here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
