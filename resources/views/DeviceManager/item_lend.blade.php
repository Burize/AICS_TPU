@extends('Layout')
@section('meta')
<link rel="stylesheet" href="/public/css/lend.css"/>


<link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.ru.js"></script>


<script type="text/javascript">
 var str
     function SelectGroup(value)
    {
        $("#users").html("");
       
        str[1].forEach(function(element, index)
       {
            if(element.group_id == value)
                {
                      var opt = document.createElement('option');
                      opt.innerHTML = element.fio;
                    opt.onclick = function(){ $("#user").val(element.id);}
                      $("#users").append(opt);
                }
        })  
    }
    
    function SelectEmployees()
    {
         $("#users").html("");
       
        str[1].forEach(function(element, index)
       {
            if(element.group_id == null)
                {
                      var opt = document.createElement('option');
                      opt.innerHTML = element.fio;
                    opt.onclick = function(){ $("#user").val(element.id);}
                      $("#users").append(opt);
                }
        })  
    }
    
     function SelectStudents()
    {
         $("#users").html("");
       
        str[1].forEach(function(element, index)
       {
            if(element.group_id != null)
                {
                      var opt = document.createElement('option');
                      opt.innerHTML = element.fio;
                    opt.onclick = function(){ $("#user").val(element.id);}
                      $("#users").append(opt);
                }
        })  
    }
    

  $(document).ready(function(){
     $.fn.datepicker.defaults.language = 'ru';
     $.fn.datepicker.defaults.format = 'yyyy-mm-dd';
});

$(document).ready(function(){
     $('.datepicker').datepicker();
});
   
    
$(document).ready(function (){
    
       var token={'_token': '{{csrf_token()}}' };
              $.post("/getusers", token, function(data){                  
                  str = JSON.parse(data)
                  str[0].forEach(function(element,index)
                             {
                        var opt = document.createElement('option');
                       opt.innerHTML=element.title;
                      opt.value=element.id;
                      opt.onclick=function(){SelectGroup(opt.value);}
                       $("#groups").append(opt);   
                  });
                    SelectStudents();
                  }
                );   
       
            });
</script>
@stop
@section('content')



<div class="container">
<form method="post">
<select id="groups" size="20" required>
    <option value="employees" onclick="SelectEmployees()">Сотрудники</option>
    <option value="students" selected="selected" onclick="SelectStudents()">Студенты</option>
</select>
<select id="users"size="20" required></select>
    <br>
    <label for="lend_at" id="l_lend_at">Дата выдачи:</label>
    <input class="datepicker" name="lend_at" id="lend_at"value=<?= date('Y-m-d',time())?>><br>
    <label for="lend_to"  id="l_lend_to" >Дата возврата:</label>
    <input class="datepicker" name="lend_to" id="lend_to" > <br>
    <label for="amount">Количество: </label> <input type="number" name="amount" id="amount" min="0" max="{{$amount}}"> <br>
    <label id="cell">Ячейка: {{$cell}}</label>
    @if($amount>0)
    <input type="hidden" id="user" name="user_id" value="">
    <input type="hidden" name="device_id" value=<?= $_GET['id']?>>
     {{csrf_field()}}
    <input type="submit" value="Выдать" class=" btn btn-primary">
    @else
    <p id="not_available">Нет в наличии</p>
    @endif
</form>
    <section>
    <h2>{{$title}}</h2>
    <img   src=<?= "images/".$_GET['id']."?rnd=".rand() ?> /> 
    <p> В наличии {{$amount}} шт. </p>
    </section>
    @if (count($errors) > 0)
<ul>
    @foreach ($errors->all() as $error)
    @if($error == "Поле amount должно быть не менее 1.")
    <li> Предмета нет в наличии</li>
    @else
    <li> {{$error}} </li>
    @endif
    @endforeach
</ul>
@endif
</div>

@stop