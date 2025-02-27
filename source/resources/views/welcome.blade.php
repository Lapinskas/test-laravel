<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Lendflow Assessment</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #1a1a1a;
            font-family: 'Arial', sans-serif;
            color: #ffffff;
        }
        .card {
            background-color: #2a2a2a;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #e0e0e0;
        }
        .author {
            font-size: 16px;
            color: #bbbbbb;
            margin-bottom: 20px;
        }
        .author a {
            color: #1e90ff;
            text-decoration: none;
            transition: color 0.3s;
        }
        .author a:hover {
            color: #63b3ed;
        }
        .links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .links a {
            color: #1e90ff;
            text-decoration: none;
            font-size: 16px;
            padding: 8px;
            border-radius: 6px;
            transition: background-color 0.3s, color 0.3s;
        }
        .links a:hover {
            background-color: #3a3a3a;
            color: #ffffff;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Welcome to Lendflow Assessment</h1>
    <p class="author">Author: <a href="mailto:vlad.lapinskas@gmail.com">Vladas Lapinskas</a></p>
    <div class="links">
        <a href="/api/v1.0/documentation">Swagger API Documentation</a>
        <a href="https://developer.nytimes.com/docs/books-product/1/routes/lists/best-sellers/history.json/get">NYT API Documentation</a>
        <a href="https://github.com/Lapinskas/test-laravel">Source Repository (private)</a>
    </div>
</div>
</body>
</html>
