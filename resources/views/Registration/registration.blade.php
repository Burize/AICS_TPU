@extends('Layout')

@section('content')
<form method="post">
    <label for="name">Имя</label><br>
    <input type="text" name="name"/><br>
    <label for="password">Пароль</label><br>
    <input type="text" name="password"/>  <br>
    <label for="password_confirm">Подтверждение пароля</label><br>
    <input type="text" name="password_confirmation"/>  <br>
    <label for="email">Адрес</label><br>
    <input type="text" name="email"/><br>
    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    <input type="submit" value ="Отправить"/>
</form>

@if (count($errors) > 0)
<ul>
    @foreach ($errors->all() as $error)
    <li> {{$error}} </li>
    @endforeach
</ul>
@endif
@if (Session::has('message'))
   <div class="alert alert-info">{!! Session::get('message') !!}</div>
@endif
Для подтверждение регистрации, пройдите по <a href="http://aics.tpu/registration">ссылке</a>
@stop