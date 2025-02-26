<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>

<body>
    <h1>Profile:</h1>
    <h3>ID: <?= $id ?></h3>
    <h3>Name: <?= $name ?></h3>
</body>