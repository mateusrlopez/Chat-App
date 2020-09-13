@component('mail::message')
Dear, {{ $recipient['name'] }}

You've requested a password reset for your account in our site, click the link below to get the reset done.

@component('mail::button', ['url' => $url])
Reset password
@endcomponent

Regards, {{ config('app.name') }}
@endcomponent
