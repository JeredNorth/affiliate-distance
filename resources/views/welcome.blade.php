<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gambling.com code test</title>
</head>

<style>
    body {
        background-color: #444;
        color: white;
    }

    .header {
        text-align: center;
    }

    .affiliate-list-item{
        margin-bottom: 5px;
        font-size: 20px;
    }
</style>

<body>
    <h1 class="header">Affiliates!</h1>


    <ul>
        @foreach ($affiliates as $affiliate)
        <li class="affiliate-list-item">{{ $affiliate->affiliate_id }}, {{$affiliate->name}}</li>
        @endforeach
    </ul>

</body>
</html>