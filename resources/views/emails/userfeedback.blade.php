<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
<h3>Feedback from: {{ $email }}</h3>
<pre>{{ $body }}</pre>
</body>
