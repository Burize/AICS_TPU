@extends('Layout')

@section('meta')
<link href="/public/css/mainpage.css" rel="stylesheet"/>
<script> $(document).ready(function(){
          $('#table').dataTable( {
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
  </script>
@stop

@section('content')
<div class="container list-group">
<table id="table"  >
    <thead><tr>
            <th></th>
        </tr></thead>
    <tbody>
@foreach($devices as $device) 
        <tr><td>
   <a class="list-group-item row" href=<?= '/item?id='.$device->id ?>> 
       <img class="col-md-2" src=<?= "images/".$device->id."?rnd=".rand() ?> >  
       <h2 class="col-md-10"> {{$device->title}} </h2> 
       <section>В наличии {{$device->amount}} шт.</section> 
    </a>
            </td> 
         </tr>
@endforeach
    </tbody>
</table>
</div>
@stop

