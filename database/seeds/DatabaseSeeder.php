<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;
use App\Models\Storage;
use App\Models\User;
use App\Models\Group;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DevicesSeeder::class);
    }
}

class DevicesSeeder extends Seeder
{
    public function run()
    {
         // DB::table('lends')->delete();
        // DB::table('storages')->delete();
      //   DB::table('users')->delete();
      //  DB::table('devices')->delete();
       // DB::table('groups')->delete();
   
           
       $st = new User;
        $st->login='root';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Администратор";
        $st->user_type="admin";
        $st->email="your@email.ru";
        $st->save();
        
        $st = new Group;
        $st->title="8И4А";
        $st->save();
        
        $st = new User;
        $st->login='dkh1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Хурсевич Дмитрий Константинович";
        $st->Group()->associate(Group::where('title','=','8И4А')->first() );
        $st->email="dkh1@tpu.ru";
        $st->save();
        
        $st = new Device;
        $st->title="Микроконтроллеры STM32 VS1003B";
        $st->description="Серийный данных и интерфейс управления; интерфейс SPI, ведет провода управляющего сигнала, 1 х наушников и интерфейс аудио, 1 х микрофон для записи, 1 х Линейный вход; Бортовой 3.3V / 2.5V LDO 1117; Максимальное обеспечение 800 мА; Один источник питания: DC 5V конденсатор фильтра; 12.288MHz кристалла.";
        $st->save();
          
        $st = new Storage;
        $st->Devices()->associate(Device::where('title','=','Микроконтроллеры STM32 VS1003B')->first() ); 
        $st->cell="F1";
        $st->amount=1;
        $st->save();
        
        
        
      /*  $st = new User;
        $st->login='tma1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Абишев Тимерлан Меиргазиевич";
        $st->group="8И4А";
        $st->email="atm1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='soa1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Аспомбитов Сабыржан Олегович";
        $st->group="8И4А";
        $st->email="soa1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='mha1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Ахмеров Максим Шамильевич";
        $st->group="8И4А";
        $st->email="mha1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='aab1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Бакунчева Анастасия Андреевна";
        $st->group="8И4А";
        $st->email="aab1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='dvg1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Герасимов Дмитрий Викторович";
        $st->group="8И4А";
        $st->email="dvg1@tpu.ru";
        $st->save();
        
           $st = new User;
        $st->login='eeg1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Голубчикова Елизавета Евгеньевна";
        $st->group="8И4А";
        $st->email="eeg1@tpu.ru";
        $st->save();
           $st = new User;
        $st->login='drg1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Гузиков Даниил Родионович";
        $st->group="8И4А";
        $st->email="drg1@tpu.ru";
        $st->save();
       $st = new User;
        $st->login='kod1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Джо Карина Олеговна";
        $st->group="8И4А";
        $st->email="kod1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='avk1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Климкович Александр Вадимович";
        $st->group="8И4А";
        $st->email="avk1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='mik1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Красноусова Мария Игоревна";
        $st->group="8И4А";
        $st->email="mik1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='alp1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Леонова Арина Петровна";
        $st->group="8И4А";
        $st->email="apl1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='aio1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Осипюк Александр Игоревич";
        $st->group="8И4А";
        $st->email="aio1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='ner1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Рожкова Надежда Евгеньевна";
        $st->group="8И4А";
        $st->email="ner1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='dkh1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Хурсевич Дмитрий Константинович";
        $st->group="8И4А";
        $st->email="dkh1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='kac1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Чеснокова Ксения Андреевна";
        $st->group="8И4А";
        $st->email="kac1@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='eoh1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Щубкин Егор Олегович";
        $st->group="8И4А";
        $st->email="eoh1@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='diu1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Юрканский Даниил Яковлевич";
        $st->group="8И4А";
        $st->email="diu1@tpu.ru";
        $st->save(); 
        
          $st = new User;
        $st->login='asa1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Астахова Алина Сергеевна";
        $st->group="8И4Б";
        $st->email="asa1@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='asz1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Захваткин Александр Сергеевич";
        $st->group="8И4Б";
        $st->email="asz1@tpu.ru";
        $st->save();
          $st = new User;
        $st->login='tvk1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Кузнецова Татьяна Викторовна";
        $st->group="8И4Б";
        $st->email="tvk1@tpu.ru";
        $st->save();
          $st = new User;
        $st->login='anp1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Попова Анна Николаевна";
        $st->group="8И4Б";
        $st->email="anp1@tpu.ru";
        $st->save();
          $st = new User;
        $st->login='asf1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Фоминский Александр Сергеевич";
        $st->group="8И4Б";
        $st->email="asf1@tpu.ru";
        $st->save();
          $st = new User;
        $st->login='vsf1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="Фоминский Виталий Сергеевич";
        $st->group="8И4Б";
        $st->email="vsf1@tpu.ru";   
        $st->save();*/
        
       /*  $st = new User;
        $st->login='test1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8И3Б";
        $st->email="test1@tpu.ru";
        $st->save();
        
          $st = new User;
        $st->login='test2';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8И3А";
        $st->email="test2@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test3';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8Т4Б";
        $st->email="test3@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='test4';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8Т4Б";
        $st->email="test4@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='test5';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8Т4А";
        $st->email="test5@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='test6';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8А31";
        $st->email="test6@tpu.ru";
        $st->save();
          $st = new User;
        $st->login='test7';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8А32";
        $st->email="test7@tpu.ru";
        $st->save();
        
          $st = new User;
        $st->login='test8';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8Т52";
        $st->email="test8@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test9';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8Т51";
        $st->email="test9@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test10';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8Т62";
        $st->email="test10@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test11';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8Т61";
        $st->email="test11@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test12';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8И61";
        $st->email="test12@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test13';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8И62";
        $st->email="test13@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test14';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8И51";
        $st->email="test14@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test15';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8И52";
        $st->email="test15@tpu.ru";
        $st->save();
         $st = new User;
        $st->login='test16';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8ВМ64";
        $st->email="test16@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='test17';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8АМ61";
        $st->email="test17@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='test18';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8К61";
        $st->email="test18@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='test19';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8К62";
        $st->email="test19@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='test20';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8К51";
        $st->email="test20@tpu.ru";
        $st->save();
        $st = new User;
        $st->login='test21';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";
        $st->group="8К52";
        $st->email="test21@tpu.ru";
        $st->save();
        
        $st = new User;
        $st->login='mss1';
        $st->password=password_hash("password",PASSWORD_DEFAULT);
        $st->FIO="ФИО";    
        $st->email="mss1@tpu.ru";
        $st->save();*/
     /*   $d1 = new Device;
        $d1->title = 'Device #1';    
        $d1->description = 'Description #1';
        $d1->picture = 'path to picture #1';     
        $d1->save();
        $s1 = new Storage;
        $s1->cell=1;
        $s1->amount=2;
        $d1->Storage()->save($s1);*/
        
    }
}
