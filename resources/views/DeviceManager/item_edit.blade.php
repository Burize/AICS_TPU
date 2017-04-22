@extends('Layout')
@section('meta')
<link rel="stylesheet" href="/public/css/edit.css"/>
<script>
 function Confirm() {
        $('#confirm').show();
    }

    function Accept()
    {
        $.post("/item/delete",{_token: '{{csrf_token()}}', id:{{$device->id}}}, function(data){
            // window.location.replace("http://aics.tpu/"); 
             window.location.replace(window.location.origin ); 
        });
    }
    
    function Cancel()
    {
        $('#confirm').hide();
     
    }
</script>
@stop
@section('content')
<div class="container">
<form method="post" enctype="multipart/form-data">
    <label for="title">Название</label><br>
    <input type="text" name="title"  value="{{$device->title}}" style="width:600px;"><br>
    <label for="decsription">Описание</label><br>
    <textarea name="description" rows="10" cols="100" >{{$device->description}}</textarea>
    
   <section id="amount_cell">
       <label for="amount">Количество</label>
    <input type="number" name="amount"  value=<?= $device->amount ?> /><br>
    <label for="cell">Номер ячейки</label>
    <input type="text" name="cell" value=<?= $device->cell ?>>
    </section>
    <br>
    <label for="photo" >Фотография</label><br>
    <img src=<?= "images/".$device->id."?rnd=".rand() ?> ><br>
     <input type="file" name="photo" accept="image/*"/><br>
    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    <input type="submit" value="Отправить"/>
    </form>
    <a id="delete" href="javascript:Confirm()">Удалить <span class="glyphicon glyphicon-trash"></span></a>
   
</div>

<div id="confirm">
<span id='question'>Удалить элемент?</span>
    <button id="b1" onclick="javassript:Accept()">Да</button>
    <button id="b2" onclick="javassript:Cancel()">Отмена</button>
</div>
@if (count($errors) > 0)
<ul>
    @foreach ($errors->all() as $error)
    <li> {{$error}} </li>
    @endforeach
</ul>
@endif
@stop