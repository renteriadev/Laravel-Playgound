@component('mail::message')
# Introduction

Dear {{$email}}

The order has been accepted!

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent