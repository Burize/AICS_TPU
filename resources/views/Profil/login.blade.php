@extends('Layout')
@section('meta')
<link rel="stylesheet" href="/public/css/login.css"/>
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script> 
    $(function(){
        $('#loginform').submit(function(e){
            e.preventDefault();
             $.post("/login",$('#loginform').serialize(), function (response) {
            switch(response)
                {
                    case 'invalid':
                        $('#error').show("drop", { direction: "down" }, "slow" );
                        break;
                    case'OK':
                        window.location.replace("/"); 
                        break;
                } 
                });
        });
    });
    
</script>
@stop
@section('content')
<div class="container list-group"  id="all">  
    <img  id="logo" src="images/logo.png"> 
 <div class ="PopUp" id="enter" >
            <form id="loginform" >
            <label for="login">Логин</label><br>
            <input type="text" name="login"/><br>
            <label for="password">Пароль</label><br>
            <input type="password" name="password"/><br>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <input type="submit" value="Войти"/>
            </form>
           <p id="error" >Неверный логин или пароль</p>
        </div>
</div>
@stop