<DOCTYPE html>
<head>
    <meta charset='utf-8'>
    <title> update the product </title>
</head>
<body>
    
    
    <form action = "updateproduct" method = "POST" enctype="multipart/form-data">
        @csrf
        <input name="id" type="hidden" value="{{$prod['id']}}">
        <label>ProducName</label><br>
        <input type = "text" name = "productname" value = "{{$prod['productname']}}"><br>
        <label>Type</label><br>
        <input type = "text" name = "type" value = "{{$prod['type']}}"><br>
        <label>Price</label><br>
        <input type = "text" name = "price" value = "{{$prod['price']}}"><br>
        <label>Picture</label><br>
        <input type = "file" name = "picture"><br>
        <input type = "submit" name = "submit"><br>

    </form>

</body>
<html>