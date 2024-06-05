<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 210mm;
            height: 297mm;
            padding: 10mm;
            box-sizing: border-box;
        }
        .label {
            width: 90mm;
            height: 50mm;
            margin: 5mm;
            padding: 5mm;
            border: 1px solid #000;
            box-sizing: border-box;
            font-size: 12pt;
            display: inline-block;
            vertical-align: top;
        }
        .container {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="container">
            @foreach($etiquettes as $etiquette)
                <div class="label">
                    <strong>{{ $etiquette['name'] }}</strong><br>
                    {{ $etiquette['address'] }}<br>
                    {{ $etiquette['city'] }}
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
