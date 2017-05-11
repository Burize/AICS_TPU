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
             $("#AddModal").modal('show');
        });
        
        $("#add_std").submit(function(e){
            e.preventDefault();
            
              $.post("administrate/add_user",$(this).serialize(), function (response) {
                  
            switch(response)
                {
                    case 'exist_user':
                        alert("Пользователь с указанными ФИО и группой уже существует.");
                        break;
                    case 'exist_login':
                        alert("Указанный логин уже используется.");
                        break;
                    case 'exist_email':
                        alert("указанный адрес уже используется.");
                        break;
                    case 'wrong_password':
                        alert("пароль должен состоять только из символов русского/английского алфавитов цифр и быть не менее 6 символов длиной.");
                        break;
                    case 'exist_token':
                        alert("Указанный токен уже используется");
                        break;
                    case 'invalid_token':
                        alert("Токен должен состоять только из цифр и символов латинского алфавита и иметь длину равную 6.");
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
                            $("#update_std input[name='token']").val(res['token']);
                            $("#UpdateModal").modal('show');
                             break;
                     }
                   
                 
                  
             });
            
        });
        
        $("#update_std").submit(function(e){
            e.preventDefault();
    
          
          var data =  $(this).serializeArray();
           data.push({name:"id", value: $("#user").val() });
            $.post("administrate/update_user",data, function (response) {
                  
            switch(response)
                {
                   case 'exist_user':
                        alert("Пользователь с указанными ФИО и группой уже существует.");
                        break;
                    case 'exist_login':
                        alert("Указанный логин уже используется.");
                        break;
                    case 'exist_email':
                        alert("указанный адрес уже используется.");
                        break;
                    case 'wrong_password':
                        alert("пароль должен состоять только из символов русского/английского алфавитов цифр и быть не менее 6 символов длиной.");
                        break;
                    case 'exist_token':
                        alert("Указанный токен уже используется");
                        break;
                    case 'invalid_token':
                        alert("Токен должен состоять только из цифр и символов латинского алфавита и иметь длину равную 6.");
                        break;
                    case'OK':
                        window.location.reload();
                        break;
                } 
                });
        });
    
      
        $("#btn_del").click(function( ){
            if(!$("#user").val()){
                alert("Выберите пользователя.");
                return;
            } 
            var id = $("#user").val();
            var fio;
            str[1].forEach(function(element, index)
       {
            if(element.id == id)
                      fio = element.fio;
 
        })  
             var question = "Вы уверены, что хотите удалить пользователя \n ("+fio+") \n ?"
        $('#DeleteModal .question').html(question);
             $("#DeleteModal").modal('show');
//            
        });
        
        $("#DeleteModal .btn-danger").click(function(){
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
     
             var question = "Вы уверены, что хотите убрать пользователя \n ("+fio+") \n из управляющего состава?"
        $('#RemoveModal .question').html(question);
             $("#RemoveModal").modal('show');
        
        $("#RemoveModal .btn-danger").off();
         
        $("#RemoveModal .btn-danger").click(function(){
       
            $.post("administrate/remove",{_token: '{{csrf_token()}}', user_id:id}, function(data){
            document.location.reload();
            });
        });
    }

</script>
@stop
@section('content')
<div class="modal fade" id="AddModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Добавить пользователя</h4>      
        </button>
      </div>
      <div class="modal-body">
          
      <form class="form-horizontal" id="add_std">
  <div class="form-group">
    <label for="inputEmail" class="col-xs-2 control-label"> Группа:</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" name="group" autocomplete="off" placeholder="Введите группу студента">
    </div>
  </div>
  
          <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">ФИО:</label>
    <div class="col-xs-10">
      <input type="text" required name="fio" autocomplete="off" class="form-control"  placeholder="Введите ФИО пользователя">
    </div>
  </div>
          
           <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">Почта:</label>
    <div class="col-xs-10">
      <input type="text" required name="email" autocomplete="off"  class="form-control"  placeholder="Введите электронный адрес пользователя">
    </div>
  </div>
          
           <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">Логин:</label>
    <div class="col-xs-10">
      <input type="text" required name="login" autocomplete="off" class="form-control"  placeholder="Введите логин">
    </div>
  </div>
          
           <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">Пароль:</label>
    <div class="col-xs-10">
      <input type="password" required   name="_password" autocomplete="new-password" class="form-control"  placeholder="Введите пароль">
    </div>
  </div>
          
              <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">Токен:</label>
    <div class="col-xs-10">
      <input type="text"  name="token" autocomplete="off" class="form-control"  placeholder="Введите токен {AV1cdF}">
    </div>
  </div>
          
  
  <div class="form-group">
    <div class="col-xs-offset-2 col-xs-10">
      <button type="submit" class="btn btn-primary">Добавить</button>
    </div>
  </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
</form>
      </div>
 
    </div>
  </div>
</div>

<div class="modal fade" id="UpdateModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
           <h4 class="modal-title">Обновить информацию</h4>
      </div>
      <div class="modal-body">
          
      <form class="form-horizontal" id="update_std">
  <div class="form-group">
    <label for="inputEmail" class="col-xs-2 control-label"> Группа:</label>
    <div class="col-xs-10">
      <input type="text" class="form-control" name="group" autocomplete="off" placeholder="Введите группу студента">
    </div>
  </div>
  
          <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">ФИО:</label>
    <div class="col-xs-10">
      <input type="text" required name="fio" autocomplete="off" class="form-control"  placeholder="Введите ФИО пользователя">
    </div>
  </div>
          
           <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">Почта:</label>
    <div class="col-xs-10">
      <input type="text" required name="email" autocomplete="off"  class="form-control"  placeholder="Введите электронный адрес пользователя">
    </div>
  </div>
          
           <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">Логин:</label>
    <div class="col-xs-10">
      <input type="text" required name="login" autocomplete="off" class="form-control"  placeholder="Введите логин">
    </div>
  </div>
          
           <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">Пароль:</label>
    <div class="col-xs-10">
      <input type="password"   name="_password" autocomplete="new-password" class="form-control"  placeholder="Введите пароль">
    </div>
  </div>
  
              <div class="form-group">
    <label for="inputPassword" class="col-xs-2 control-label">Токен:</label>
    <div class="col-xs-10">
      <input type="text"   name="token" autocomplete="off" class="form-control" placeholder="Введите идентификатор пользователя {AV1cdF}">
    </div>
  </div>
          
  <div class="form-group">
    <div class="col-xs-offset-2 col-xs-10">
      <button type="submit" class="btn btn-primary">Обновить</button>
    </div>
  </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
</form>
      </div>
 
    </div>
  </div>
</div>

<div class="modal fade" id="DeleteModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
           <h4 class="modal-title">Удалить пользователя</h4>
      </div>
      <div class="modal-body">
          <p class="question"></p>
      </div>
    <div class="modal-footer">
            <button type="button" class="btn btn-danger">Удалить</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="RemoveModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
           <h4 class="modal-title">Убрать из управляющего состава</h4>
      </div>
      <div class="modal-body">
          <p class="question"></p>
      </div>
    <div class="modal-footer">
         <button type="button" class="btn btn-danger">Убрать</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
    
    <form method="post" action="/administrate/add">
        <select id="groups" size="20" required>
        <option value="employees" onclick="SelectEmployees()">Сотрудники</option>
        <option value="students" selected="selected" onclick="SelectStudents()">Студенты</option>
    </select>
        <select id="users"size="20" required></select> <br>
        <input type="hidden" id="user" name="user_id" value="" >    
            {{csrf_field()}}
        <input type="submit" value="Сделать управляющим" class="btn btn-success">
    </form>

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
   
    <div class="buttons">
        <button id="btn_del" class="btn btn-danger">Удалить пользователя</button> 
        <button id="btn_update"  class="btn btn-info">Обновить</button> 
        <button id="btn_add" class="btn btn-primary">Добавить пользователя</button>
    </div>
</div>



@stop