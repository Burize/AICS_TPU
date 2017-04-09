@extends('Layout')
@section('meta')
<link rel="stylesheet" href="/public/css/add.css">
@stop
@section('content')
<div class="container" >
    <div class="row" >

<form method="post" enctype="multipart/form-data" >
    <label for="title">Название</label><br>
    <input type="text" name="title"/><br>
    <label for="decsription">Описание</label><br>
    <textarea name="description" rows="15" ></textarea><br>
    <label for="photo">Фотография</label><br>
    <input type="file" name="photo" accept="image/*"/><br>
    <label for="amount">Количество</label><br>
    <input type="number" name="amount"/><br>
    <label for="cell">Номер ячейки</label><br>
    <input type="text" name="cell"/><br>
    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    <input type="submit" value="Добавить"/>
    </form>
    </div>
@if (count($errors) > 0)
<ul>
    @foreach ($errors->all() as $error)
    <li> {{$error}} </li>
    @endforeach
</ul>
@endif
</div>
@stop