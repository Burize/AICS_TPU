@extends('Layout')
@section('meta')
<link rel="stylesheet" href="/public/css/admin.css" />
<script>
    var str;
    
    $(document).ready(function(){
    
        var token= {_token: '{{csrf_token()}}'};
              $.post("/getusers", token,function(data){                  
                  str = JSON.parse(data)
                 str[1].forEach(function(element,index)
                             {       
                                 
                     if(element.user_type =='manager')
                         {
                      var tr = document.createElement('tr');
                      var td = document.createElement('td');
                      td.innerHTML =element.fio;
                      var tdd = document.createElement('a');
                     tdd.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";
                     tdd.onclick = function(){
                         Confirm(element.id,element.fio);
                     }
                      tr.appendChild(td);
                     tr.appendChild(tdd);
                      $("tbody").append(tr);
                         }
                        });
                  
                   str[0].forEach(function(element,index)
                             {  
                             
                       var opt = document.createElement('option');
                       opt.innerHTML=element.title;
                      opt.value=element.id;
                      opt.onclick=function(){SelectGroup(opt.value);}
                       $("#groups").append(opt);       
                        });          
                  SelectStudents();
              });   
        
        
        $("#btn_add").click(function(){
            $("#add_std").show();
        });
        
        $("#add_std form").submit(function(e){
            e.preventDefault();
            
              $.post("administrate/add_user",$(this).serialize(), function (response) {
                  
            switch(response)
                {
                    case 'exist':
                        alert("Пользователь с указанными ФИО и группой уже существует.");
                        break;
                    case 'login':
                        alert("Указанный логин уже используется.");
                        break;
                    case 'email':
                        alert("указанный адрес уже используется.");
                        break;
                    case 'password':
                        alert("пароль должен состоять только из символов русского/английского алфавитов цифр и быть не менее 6 символов длиной.");
                        break;
                    case'OK':
                        window.location.reload();
                        break;
                } 
                });
        });
          
        
        $("#update_std form").submit(function(e){
            e.preventDefault();
    
          
          var data =  $(this).serializeArray();
            console.log(data.push({name:"id", value: $("#user").val() }));
            $.post("administrate/update_user",data, function (response) {
                  
            switch(response)
                {
                    case 'exist':
                        alert("Пользователь с указанными ФИО и группой уже существует.");
                        break;
                    case 'login':
                        alert("Указанный логин уже используется.");
                        break;
                    case 'email':
                        alert("указанный адрес уже используется.");
                        break;
                    case 'password':
                        alert("пароль должен состоять только из символов русского/английского алфавитов цифр и быть не менее 6 символов длиной.");
                        break;
                    case'OK':
                        window.location.reload();
                        break;
                } 
                });
        });
        $('#btn_update').click(function(){
             if(!$("#user").val()){
                alert("Выберите пользователя.");
                return;
            } 
            
           
             $.post("administrate/get_user",{_token: "{{csrf_token()}}", id:$("#user").val()}, function(res){
                 
                 switch(res)
                     {
                         case 'err':
                             alert("ошибка при подключении к базе данных.");
                             break;
                         default:
                             
                             
                            $("#update_std input[name='fio']").val(res['fio']);
                            $("#update_std input[name='group']").val(res['group']);
                            $("#update_std input[name='login']").val(res['login']);
                             $("#update_std input[name='email']").val(res['email']);
                                  $("#update_std").show();
                             break;
                     }
                   
                 
                  
             });
            
        });
        
        $("#btn_del").click(function(){
            if(!$("#user").val()){
                alert("Выберите пользователя.");
                return;
            } 
            $.post("administrate/delete_user",{_token: "{{csrf_token()}}", id:$("#user").val()}, function(res){
                switch(res)
                    {
                        case 'err':
                            alert("ошибка при удалении записи из базы данных.");
                            break;
                        case 'OK':
                            window.location.reload();
                            break;
                    }
            })
        });
        
  
    });
    
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
    
    function Confirm(id,fio) {
    
        CloseReturn();
        CloseReturn2();
     var question = "Вы уверены, что хотите убрать пользователя \n ("+fio+") \n из управляющего состава?"
        $('#question').html(question);
        $('#confirm').show();
        $('#confirm .b1').click(function(){ Accept(id);});
    }

    function Accept(id)
    {
        $.post("administrate/remove",{_token: '{{csrf_token()}}', user_id:id}, function(data){
            document.location.reload();
        });
    }
    
    function Cancel()
    {
        $('#confirm').hide();
        $('#question').html();
    }
    
    function CloseReturn()
    {
     
      $('#add_std input').not("input[type='submit']").not("input[type='hidden']").val("");
    $('#add_std').hide();
    }
    
    function CloseReturn2()
    {
       
      $('#update_std input').not("input[type='submit']").not("input[type='hidden']").val("");
    $('#update_std').hide();
    }

</script>
@stop
@section('content')
<div class="container">
<table class="col-md-4">
    <caption>Управляющие</caption>
    <thead>
        <tr>
    <th>ФИО</th>
            <th></th>
            </tr>
    </thead>
    <tbody>
    </tbody>
</table>
    <form method="post" action="/administrate/add">
<select id="groups" size="20" required>
    <option value="employees" onclick="SelectEmployees()">Сотрудники</option>
    <option value="students" selected="selected" onclick="SelectStudents()">Студенты</option>
</select>
<select id="users"size="20" required></select> <br>
         <input type="hidden" id="user" name="user_id" value="">    
        {{csrf_field()}}
    <input type="submit" value="Добавить">
</form>
    
   
</div>
 <button id="btn_del">Удалить пользователя</button>
<button id="btn_update">Обновить</button>
 <button id="btn_add">Добавить пользователя</button>
<div id="confirm">
<span id='question'></span>
    <button class="b1" >Да</button>
    <button class="b2" onclick="javassript:Cancel()">Отмена</button>
</div>
<div id="add_std">
    <a id="close" href="javascript:CloseReturn()"><span class="glyphicon glyphicon-remove"></span></a>
<form autocomplete="off">
    <label>
        Группа: <input type="text"  name="group" autocomplete="off">
    </label>
    <label>
        ФИО:<input type="text" required name="fio" autocomplete="off">
    </label>
    <label>
        Почта:<input type="text" required name="email" autocomplete="off">
    </label>
    <label>
        Логин:<input type="text" required name="login" autocomplete="off">
    </label>
    <label>
        Пароль:<input type="password" required name="_password" autocomplete="new-password">
    </label>
    <input type="submit" value="Добавить">
      <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    </form>
</div>
<div id="update_std">
    <a id="close" href="javascript:CloseReturn2()"><span class="glyphicon glyphicon-remove"></span></a>
<form autocomplete="off">
    <label>
        Группа: <input type="text"  name="group" autocomplete="off">
    </label>
    <label>
        ФИО:<input type="text" required name="fio" autocomplete="off">
    </label>
    <label>
        Почта:<input type="text" required name="email" autocomplete="off">
    </label>
    <label>
        Логин:<input type="text" required name="login" value=""autocomplete="off">
    </label>
    <label>
        Пароль:<input type="password" name="_password" value="" autocomplete="new-password">
    </label>
    <input type="submit" value="Добавить">
      <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    </form>
</div>
@stop