<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Articles PDF</title>
    <style>
        body{
            font-family: Arial, sans-serif;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        th,td{
            border:1px solid #000;
            padding:8px;
            text-align: left;
        }
        th{
            background: #eee;
        }
    </style>
</head>
<body>
    <h2>Articles List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Body</th>
                <th>Author</th>
                <th>Category</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
            <tr>
                <td>{{$article->id}}</td>
                <td>{{$article->title}}</td>
                <td>{{$article->body}}</td>
                <td>{{$article->author->name}}</td>
                <td>{{$article->category->name}}</td>
                <td>{{$article->is_published ? 'Published':'Draft'}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
