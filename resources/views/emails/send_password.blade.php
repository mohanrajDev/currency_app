@component('mail::message')
Hello {{ $user->name }},

Your are account details,
<p><b>Email / Username : </b> {{ $user->email }}</p>
<p><b>Password : </b> {{ $password }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent