@extends('Layout')
@section('content')

@if(count($result)>0)

@foreach ($result->all() as $r)
 <article>
       <h2> {{$r->title}} </h2>
       <section> {{$r->description}} </section>
       <img src=<?= "public/images/".$r->picture ?> > 
       <section>{{$r->amount}} </section>
    </article>
@endforeach

@endif
@stop