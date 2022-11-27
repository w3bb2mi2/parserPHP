<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="mb-3 mt-3">
            <!-- <form method="" enctype="multipart/form-data" action=""> -->
            <form method="post" enctype="multipart/form-data" action="http://localhost:8000/xmlParser">
                @csrf
                <label for="formFile" class="form-label">Выберите файл</label>
                <input class="form-control" type="file" id="formFile" name="file">
                <button type="submit" class="btn btn-primary mt-2">Отправить</button>
            </form>
          </div>
    </div>
    <script src="./index.js"></script>
</body>
</html>