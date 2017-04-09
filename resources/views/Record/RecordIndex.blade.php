@extends('Layout')

@section('meta')
<link rel="stylesheet" href="/public/css/records.css"/>
<link rel="stylesheet" href="/public/css/hint/hint.css"/>
<script>
   $(document).ready(function(){
          $('#records').dataTable( {
        "language": {
            "lengthMenu": "Показано _MENU_ элементов на странице",
            "zeroRecords": "Записей, удовлетворяющих запросу, не найдено ...",
            "info": "Показана _PAGE_ страница из _PAGES_ ",
            "infoEmpty": "",//"Нет записей удовлетворяющий запросу",
            "infoFiltered": "",//"(Просмотрено _MAX_ записей)", 
            "paginate": {
                "first":      "Первая",
                "last":       "Последняя",
                "next":       "Следующая",
                "previous":   "Предыдущая"
        },
            "search":         "Поиск:",
        }
    } );
    });
   
   
    function Return(id, device_id)
    {       
        CloseReturn();
         $.post("records/return",{_token: "{{csrf_token()}}", _id:id,_device_id:device_id},function(data)
               {
         
             $('tr[id='+id+']').children("td[name='return_date']").html(data);
             $('tr[id='+id+']').children("td[name='return']").children("a:last-child").css("color","#32CD32");
        });
    }
    
    function ReturnForm(id)
    {
        {!!$lends!!}.forEach(function(element,index){
            if(element.id== id)
                {
                     $('#fio').html(element.fio);
                     $('#title').html(element.title);           
                   $('#button_return').unbind();
                    $('#button_return').click(function() {
        Return(element.id, element.device_id);
            });
                }
        });
       
       if( $('#PopUpreturn').css("display")=="none" )
           $('#PopUpreturn').fadeToggle();
    }
    
    function Message(name,id)
    {
        $('#namee').html(name);
        $('#subject').val("");
        $('#text').val("");
        $('#button_send').click(function() {
        Send(id);
            });
        if( $('#PopUp').css("display")=="none" )
           $('#PopUp').fadeToggle();
    }
    
    function CloseSend()
    {
       $('#namee').html("");
       $('#PopUp').fadeToggle();
    }
        
    function CloseReturn()
    {
      $('#fio').html();
      $('#title').html();
    $('#PopUpreturn').fadeToggle();
    }
    
    function Send(id)
    {
         CloseSend()
        var data = $('#form').serializeArray();
        data.push({name:'id',value:id});
        $.post("/records/mail",data, function (response) {
            $('#button_send').unbind();
                });
    }
</script>
@stop

@section('content')
<div class="container list-group">
@if(count($lends)>0)
    <table id="records">
        <thead>
            <tr>
            <th class="t_element">Элемент</th>
            <th class="t_cell">Ячейка</th>
            <th class="t_fio">ФИО</th>
            <th class="t_on">С</th>
            <th class="t_for">До</th>
            <th class="t_return">Возвращено</th>
            <th class="t_buttons"></th>
            </tr>
        </thead>
    <tbody>
@foreach($lends as $lend)
   <tr id="{{$lend->id}}">
    <td><a href=/item?id={{$lend->device_id}}>{{$lend->title}}</a></td>
    <td>{{$lend->cell}}</td>
    <td>{{$lend->fio}}</td>
    <td>{{$lend->lend_at}}</td>
    <td>{{$lend->lend_to}}</td>
    @if($lend->return_at)
    <td name="return_date">{{$lend->return_at}}</td>
    @else
    <td name="return_date">Не возвращено</td>
    @endif
    <td name="return">
        <a href="javascript:Message('{{$lend->fio}}',{{$lend->user_id}})">
            <span class="hint  hint--top  hint--info" data-hint="Отправить письсмо">
            <span class="glyphicon glyphicon-envelope "></span></a>
         @if($lend->return_at)
            <span class="hint  hint--top  hint--success" data-hint="Элемент уже возвращен"> 
                <span class="glyphicon glyphicon-ok" style="color:#32CD32"></span>
            </span>
            @else
            <a href="javascript:ReturnForm({{$lend->id}})">
                 <span class="hint  hint--top  hint--info" data-hint="Вернуть элемент"> 
                     <span class="glyphicon glyphicon-ok"></a>
                </span>
            @endif
    </td>
</tr>
@endforeach
   </tbody>
</table>
<div id="PopUp">
<form id="form" method='post'>
    <p>Кому: <span id="namee"></span></p><br>
    <label for="subject">Тема:</label>
    <input type="text" name="subject" id="subject"><br>
    <textarea cols="50" rows="10" name="text" id="text"></textarea> <br>
    {{csrf_field()}}
    <input id="button_send" type="button" value="Отправить" />
</form>
    <a id="close" href="javascript:CloseSend()"><span class="glyphicon glyphicon-remove"></span></a>
</div>
   <div id="PopUpreturn">
    <form id="form" method='post'>
    <p id="fio"></p><br>
    <p id="title"></p><br>
    {{csrf_field()}}
    <input id="button_return" type="button" value="Вернуть" />
</form>
    <a id="close" href="javascript:CloseReturn()"><span class="glyphicon glyphicon-remove"></span></a>
    </div>
    @else
    <h2>Записей нет</h2>
    @endif
 </div>
@stop