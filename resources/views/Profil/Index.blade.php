@extends('Layout')
@section('meta')
<link rel="stylesheet" href="/public/css/profil.css"/>
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
   </script>
@stop
@section('content')

<div class="container list-group">
@if(count($lends)>0)
    <table id="records">
        <thead>
            <tr>
            <th>Элемент</th>
            <th>С</th>
            <th>До</th>
            <th>Возвращено</th> 
            </tr>
        </thead>
    <tbody>
@foreach($lends as $lend)
   <tr>
    <td><a href=/item?id={{$lend->device_id}}>{{$lend->title}}</a></td>
    <td>{{$lend->lend_at}}</td>
    <td>{{$lend->lend_to}}</td>
    @if($lend->return_at)
    <td name="return_date">{{$lend->return_at}}</td>
    @else
    <td name="return_date">Не возвращено</td>
    @endif
</tr>
@endforeach
   </tbody>
</table>
@else
    <h3>Записей нет</h3>
@endif
@stop