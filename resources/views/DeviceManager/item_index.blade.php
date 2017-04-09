@extends('Layout')
@section('meta')
<link href="/public/css/item.css" rel="stylesheet"/>

@stop
@section('content')
    <article class="container" >
       <h2> {{$device->title}} </h2>
       <img class="col-md-6" style="float:left" src=<?= "images/".$device->id."?rnd=".rand() ?> > 
       <section> {{$device->description}} </section>
       <section id="amount">В наличии {{$device->amount}} шт.</section>
        @can('manage')
       <a style="position:absolute; top:0; right:5%;" href=<?= "/edit?id=".$device->id?>><span class="glyphicon glyphicon-wrench"></span> Редактировать</a>
        <a style="position:absolute; top:0; right:20%;" href=<?= "/lend?id=".$device->id?>><span class="glyphicon glyphicon-pencil"></span> Выдать</a>
        @endcan
    </article>


@stop