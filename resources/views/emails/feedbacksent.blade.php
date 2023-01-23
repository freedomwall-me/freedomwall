<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
<h1>Thank you for your feedback!</h1>
<div>
    <span>We will get back to you as soon as possible.</span>
    <br>
    <span>Here is a copy of your message:</span>
</div>
<pre>{{ $body }}</pre>

<hr>
<p>
    <a href="https://freedomwall.me">freedomwall.me</a> is the place to share your thoughts and opinions with the world.
    Join us today!
</p>
</body>
