<!DOCTYPE html>

<head>
    <meta charset = "utf-8">
    <title>products page</title>
</head>
<body>
    
    @foreach ($product as $prod )

        {{$prod->productname}}
        <form method = 'POST' enctype="multipart/form-data" action="createorder">
            @csrf
            <input type="hidden" name="id" value="{{$prod['id']}}" >
            <input type="submit" name="purchase" >
        </form>
        <br><br>
    @endforeach

</body>

<html>