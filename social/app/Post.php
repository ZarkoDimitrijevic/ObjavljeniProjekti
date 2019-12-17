<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";// - ovo se navodi ako je ime modela razlicito od imena tabele u bazi: Laravel sam prepoznaje kada pises model jednina a naziv tabele mnozina, sam zna, ali ako ti tako ne radis, kucas ovo preotected i tako mu objasnjavas koja je tabela u pitanju
    protected $id = 'id';// - ovo se navodi ukoliko primarni kljuc nije kolona id ovo nije eksplicitno potrebno da se navodi
}
