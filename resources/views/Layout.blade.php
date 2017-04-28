<DOCTYPE !html>
<head>
    <meta charset="utf-8"/>
     <link rel=stylesheet href="/public/css/header_footer.css">
    <link href="/public/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/public/datatables/css/dataTables.bootstrap.css"/>
  
    
  <script type="text/javascript" src="/public/js/jquery-3.1.1.js"></script>

<script type="text/javascript" src="/public/datatables/js/jquery.dataTables.js"></script>
 <script type="text/javascript" src="/public/datatables/js/dataTables.bootstrap.js"></script>  
      
    @yield('meta')
</head>
    <body>
        <header>
            
            <nav class="navbar navbar-default">
                <div class="collapse navbar-collapse container" >
                 <ul class="nav navbar-nav">
                     @if (Auth::check())
                     <li><a href="/">Главная</a></li>
                      @endif
                      @can('manage')
                     <li><a href="/records">Картотека</a></li>
                     <li><a href="/add"> Добавить</a></li>
<!--
                      @can('administrate')
                     <li><a href="/administrate"> Администрирование пользователей</a></li>
                     @endcan
-->
                     @endcan
                     </ul>
                       
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::check())
                           <li><a href="/profil">{{Auth::user()->fio}}</a></li>
                          <li><a href=/profil/logout>Выйти</a></li> 
                        @endif
                    </ul>
                </div>
            </nav>    
        </header>
        <main>
        @yield('content')
        </main>
        <footer>
            <aside>
                <p>Национальный исследовательский Томский политехнический университет.</p>
                <p>Кафедра автоматизации и компьютерной техники.</p>
                <p> г. Томск, проспект Ленина, 2</p>
                <p>Вопросы по работе сайта направлять на aics@tpu.ru</p>
            </aside>
            <img src="images/Logo_footer2.jpg">
        </footer>
    </body>