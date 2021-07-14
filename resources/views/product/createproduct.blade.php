<!DOCTYPE html>
<head>
    <meta charset='utf-8'>
    <title> create your product </title>
</head>
<body>
    
    <form action = "saveproduct" method = "POST" enctype="multipart/form-data">
        @csrf
        <label>ProductName</label><br>
        <input type = "text" name = "productname"><br>
        <label>Type</label><br>
        <input type = "text" name = "type"><br>
        <label>Price</label><br>
        <input type = "text" name = "price"><br>
        <label>Picture</label><br>
        <input type = "file" name = "picture"><br>
        <input type = "submit" name = "submit"><br>

    </form>
</body>
<html>