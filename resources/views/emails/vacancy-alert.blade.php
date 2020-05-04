@component('mail::message')
# {{ $name }} - Job Vacancy At {{ $company }}

{{ $description }}

@component('mail::button', ['url' => config('app.app.url')])
{{ config('app.name') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
