<?php

use function DeepCopy\deep_copy;

/*変数宣言*/
$banmen=[[' ',' ',' ',' ',' ',' ',' ',' '],
        [' ',' ',' ',' ',' ',' ',' ',' '],
        [' ',' ',' ',' ',' ',' ',' ',' '],
        [' ',' ',' ','○','●',' ',' ',' '],
        [' ',' ',' ','●','○',' ',' ',' '],
        [' ',' ',' ',' ',' ',' ',' ',' '],
        [' ',' ',' ',' ',' ',' ',' ',' '],
        [' ',' ',' ',' ',' ',' ',' ',' '],
        ];

$turn_num=1;
$player=true; //Trueが黒、Falseが白
/*ーーーーーー ここまで ーーーーーー*/

main();

/*メイン関数(ここでメインの処理を行う)*/
function main()
{
    global $banmen,$player,$turn_num;
    while(1)
    {
        /*ゲーム終了条件に合致してるか判定処理書く */

        /*ーーーーーー ここまで ーーーーーー*/
        echo "$turn_num"."ターン目の盤面を表示します\n";
        show();
        if(($turn_num % 2) === 1)
        {

            //whileで囲む
            while(1){
                echo "黒色のターンです\n";
                echo "どこに石を置くか入力してください\n";
                echo "横:";
                $x=(int)fgets(STDIN);
                echo "縦:";
                $y=(int)fgets(STDIN);
                echo "\n";
                

                //指定した座標に石を置けるか判定 置けなかったら再入力
                if(check_set($x,$y,$turn_num))
                {
                    break;
                }
                echo "再入力してください\n";
                //ここまで
            }
            echo "($x,$y)に石を置きます\n";
            $banmen[$y-1][$x-1] = '●';

            //終了前にplayerを相手に変更する
            $turn_num++;
        }
        else{
            while(1){
                echo "白色のターンです\n";
                echo "どこに石を置くか入力してください\n";
                echo "横:";
                $x=(int)fgets(STDIN);
                echo "縦:";
                $y=(int)fgets(STDIN);
                echo "\n";
                //指定した座標に石を置けるか判定 置けなかったら再入力
                if(check_set($x,$y,$turn_num))
                {
                    break;
                }
                echo "再入力してください\n";
                //ここまで
            }
            echo "($x,$y)に石を置きます\n";
            $banmen[$y-1][$x-1] = '○';


            //終了前にplayerを相手に変更する
            $turn_num++;
        }
    }
}


/*盤面表示させる関数 */
function show()
{
    global $banmen;
    echo ' ';
    for($i=1; $i<=count($banmen); $i++)
    {
        echo '｜';
        echo "$i";
    }
    echo '｜';
    echo "\nーーーーーーーーーーーーー\n";
    for($y=0; $y<count($banmen); $y++)
    {
        $yy=$y+1;
        echo "$yy";
        for($x=0; $x<count($banmen[$y]); $x++)
        {
            echo '｜';
            echo $banmen[$y][$x];
            
        }
        echo '｜';
        echo "\n";

        echo 'ーーーーーーーーーーーーー';
        echo "\n";
    }
}

/*盤面に置いてある石を数える関数 */
function result()
{

}

/*盤面の状態をリセットする */
function reset_banmen()
{
    global $banmen;
}

/*指定した座標に石を置けるか判定する */
function check_set($x,$y,$turn_num)
{
    global $banmen;
    $zahyo=[$x,$y];
    $xx=$x-1;
    $yy=$y-1;
    if(($turn_num % 2) === 1){
        $player='●';
    }
    else{
        $player='○';
    }
    $player_array=['○','●'];
    /*両プレイヤーが石を置いていないことをチェックする*/
    if ($banmen[$yy][$xx] === ' ')
    {

        /*置くマスに上下左右斜めに隣接する相手の色の石が存在すること */
        switch($zahyo)
        {

        /*(0,0)のとき右、右下、下方向見る */
        case ($zahyo[0] === 0) && ($zahyo[1] === 0):
            
            if($banmen[$yy][$xx+1] === $player){
                return true;
            }
            elseif ($banmen[$yy+1][$xx] === $player){
                return true;
            }
            elseif ($banmen[$yy+1][$xx+1] === $player){
                return true;
            }
            return true;

        /*(x_n,0)のとき左、左下、下、右下、右方向見る */
        case ($zahyo[0] !== 0 || $zahyo[0] !== 8 ) && ($zahyo[1] === 0):
            if($banmen[$yy][$xx-1] === $player){
                return true;
            }
            elseif ($banmen[$yy+1][$xx] === $player){
                return true;
            }
            elseif ($banmen[$yy+1][$xx+1] === $player){
                return true;
            }
            return false;

        /*(x_max,0)のとき左、左下、下方向見る */
        case ($zahyo[0] === 8) && ($zahyo[1] === 0):
            if($banmen[$yy][$xx-1] === $player){
                return true;
            }
            elseif ($banmen[$yy-1][$xx-1] === $player){
                return true;
            }
            elseif ($banmen[$yy+1][$xx] === $player){
                return true;
            }
            return true;

        /*(0,y_n)のとき上、右上、右、右下、下方向見る */
        case ($zahyo[0] === 0) && ($zahyo[1] !== 0 || $zahyo[1] !== 8 ):
            if($banmen[$yy+1][$xx] === $player){
                return true;
            }
            elseif ($banmen[$yy-1][$xx+1] === $player){
                return true;
            }
            elseif ($banmen[$yy][$xx+1] === $player){
                return true;
            }
            elseif ($banmen[$yy+1][$xx] === $player){
                return true;
            }
            return true;

        /*(x_max,y_n)のとき上、左上、左、左下、下方向見る */
        case ($zahyo[0] === 8) && ($zahyo[1] !== 0 || $zahyo[1] !== 8 ):
            if($banmen[$yy-1][$xx] === $player){
                return true;
            }
            elseif ($banmen[$yy-1][$xx-1] === $player){
                return true;
            }
            elseif ($banmen[$yy][$xx-1] === $player){
                return true;
            }
            elseif ($banmen[$yy+1][$xx-1] === $player){
                return true;
            }
            return true;


        /*(0,y_max)のとき上、右上、右方向見る */

        /*(x_n,y_max)のとき左、左上、上、右上、右方向見る */

        /*(x_max,y_max)のとき左、左上、上方向見る */

        /* 全方位判定*/
        case (0 < $zahyo[0] && $zahyo[0]< 8 ) && (0 < $zahyo[1] && $zahyo[1]< 8 ) :
            //全方位みて、相手の石があれば置ける　無ければ置けない
            //上
            if($banmen[$yy-1][$xx] === $player_array[($turn_num+1) % 2]){
                $h=$yy-1;
                while($h>-1){
                    if ($h===1){
                        continue;
                    }
                    if ($banmen[$h][$xx] === $player_array[($turn_num) % 2]){
                        return true;
                    }
                    $h--;
                }
                
            }
            //下
            elseif ($banmen[$yy+1][$xx] === $player_array[($turn_num+1) % 2]){
                for ($i=$yy+1; $i<8; $i++){
                    if ($i===7){
                        continue;
                    }
                    if ($banmen[$i][$xx] === $player_array[($turn_num) % 2]){
                        return true;
                    }
                }
            }
            //左
            elseif ($banmen[$yy][$xx-1] === $player_array[($turn_num+1) % 2]){
                $w=$xx-1;
                while($w>-1){
                    if ($w===1){
                        continue;
                    }
                    if ($banmen[$yy][$w] === $player_array[($turn_num) % 2]){
                        return true;
                    }
                    $w--;
                }
            }
            //右
            elseif ($banmen[$yy][$xx+1] === $player_array[($turn_num+1) % 2]){
                for ($i=$xx+1; $i<8; $i++){
                    if ($i===7){
                        continue;
                    }
                    if ($banmen[$yy][$i] === $player_array[($turn_num) % 2]){
                        
                        for ($j=$xx+1; $j<$i; $j++){
                            $banmen[$yy][$j] = $player_array[($turn_num) % 2];
                        }
                        return true;
                    }
                }
            }
            //右上 muzukasi
            elseif ($banmen[$yy-1][$xx+1] === $player_array[($turn_num+1) % 2]){
                $w= $xx+1;
                $h= $yy-1;
                while($w<8 && $h>-1){
                    if ($w===6 && $h==1){
                        //continue
                        continue;
                    }
                    if ($banmen[$h][$w] === $player_array[($turn_num) % 2]){
                        return true;
                    }
                    $w++;
                    $h--;
                }
            }
            //右下
            elseif ($banmen[$yy+1][$xx+1] === $player_array[($turn_num+1) % 2]){
                $w= $xx+1;
                $h= $yy+1;
                while($w<8 && $h<8){
                    if ($w===6 && $h==6){
                        //continue
                        continue;
                    }
                    if ($banmen[$h][$w] === $player_array[($turn_num) % 2]){
                        return true;
                    }
                    $w++;
                    $h++;
                }
            }
            //左上 
            elseif ($banmen[$yy-1][$xx-1] === $player_array[($turn_num+1) % 2]){
                $w= $xx-1;
                $h= $yy-1;
                while($w>-1 && $h>-1){
                    if ($w===6 && $h==6){
                        //continue
                        continue;
                    }
                    if ($banmen[$h][$w] === $player_array[($turn_num) % 2]){
                        return true;
                    }
                    $w--;
                    $h--;
                }
            }
            //左下 muzukasi
            elseif ($banmen[$yy+1][$xx-1] === $player_array[($turn_num+1) % 2]){
                $w= $xx-1;
                $h= $yy+1;
                while($w>-1 && $h<8){
                    if ($w===1 && $h==6){
                        //continue
                        continue;
                    }
                    if ($banmen[$h][$w] === $player_array[($turn_num) % 2]){
                        return true;
                    }
                    $w--;
                    $h++;
                }
            }
            // echo '想定されてない石の置き方\n';
            //条件に合う置き方が見つからなかったらfalseを返す
            echo "そこには置けません\n";
            return false;
        }
        
    }
    else
    {
        echo "すでに石が置いてあるので、指定した座標には置けません\n";
        return false;
    }
}

