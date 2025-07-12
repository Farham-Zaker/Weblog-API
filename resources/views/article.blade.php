<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <style>
        @page {
            margin: 50px 40px;
        }

        body {
            font-family:  sans-serif;
            direction: rtl;
            text-align: right;
            line-height: 1.8;
            font-size: 14px;
            color: #333;
        }

        .container {
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #666;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            color: #2c3e50;
        }

        .meta {
            font-size: 12px;
            color: #777;
            margin-bottom: 25px;
        }

        .content {
            text-align: justify;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: gray;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $data["title"] }}</h1>
            <div class="meta">Author: {{ $data["author"] }} | Date: {{ $data["date"] }}</div>
        </div>

        <div class="content">
            <p>{{ $data["body"] }}</p>
        </div>
    </div>   
</body>
</html>