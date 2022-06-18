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
            reversi($x,$y,$turn_num);
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
            
            reversi($x,$y,$turn_num);
            
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
            //右
            if(right_check($xx,$yy,$player_array)){
                return true;
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                return true;
            }
            //右下
            if(DownRight_check($xx,$yy,$player_array)){
                return true;
            }
            return false;

        /*(x_n,0)のとき左、左下、下、右下、右方向見る */
        case (0 < $zahyo[0] && $zahyo[0]< 8 ) && ($zahyo[1] === 0):
            //左
            if(left_check($xx,$yy,$player_array)){
                return true;
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                return true;
            }
            //右下
            if(DownRight_check($xx,$yy,$player_array)){
                return true;
            }
            return false;

        /*(x_max,0)のとき左、左下、下方向見る */
        case ($zahyo[0] === 8) && ($zahyo[1] === 0):
            //左
            if(left_check($xx,$yy,$player_array)){
                return true;
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                return true;
            }
            //左下
            if(DownLeft_check($xx,$yy,$player_array)){
                return true;
            }
            return false;

        /*(0,y_n)のとき上、右上、右、右下、下方向見る */
        case ($zahyo[0] === 0) && (0 < $zahyo[1] && $zahyo[1]< 8 ):
            //上
            if(up_check($xx,$yy,$player_array)){
                return true;
            }
            //右
            if(right_check($xx,$yy,$player_array)){
                return true;
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                return true;
            }
            //右上
            if(UpperRight_check($xx,$yy,$player_array)){
                return true;
            }
            return false;

        /*(x_max,y_n)のとき上、左上、左、左下、下方向見る */
        case ($zahyo[0] === 8) && (0 < $zahyo[1] && $zahyo[1]< 8 ):
            //上
            if(up_check($xx,$yy,$player_array)){
                return true;
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                return true;
            }
            //左
            if(left_check($xx,$yy,$player_array)){
                return true;
            }
            //左上
            if(UpperLeft_check($xx,$yy,$player_array)){
                return true;
            }
            //左下
            if(DownLeft_check($xx,$yy,$player_array)){
                return true;
            }
            return false;


        /*(0,y_max)のとき上、右上、右方向見る */
        case ($zahyo[0] === 0) && ($zahyo[1] === 8) :
            //上
            if(up_check($xx,$yy,$player_array)){
                return true;
            }

            //右
            if(right_check($xx,$yy,$player_array)){
                return true;
            }

            //右上
            if(UpperRight_check($xx,$yy,$player_array)){
                return true;
            }

        /*(x_n,y_max)のとき左、左上、上、右上、右方向見る */
        case (0 < $zahyo[0] && $zahyo[0]< 8 ) && ($zahyo[1] === 8) :

            //上
            if(up_check($xx,$yy,$player_array)){
                return true;
            }

            //左
            if(left_check($xx,$yy,$player_array)){
                return true;
            }

            //右
            if(right_check($xx,$yy,$player_array)){
                return true;
            }

            //右上
            if(UpperRight_check($xx,$yy,$player_array)){
                return true;
            }

            //左上
            if(DownLeft_check($xx,$yy,$player_array)){
                return true;
            }

        /*(x_max,y_max)のとき左、左上、上方向見る */
        case ($zahyo[0] === 8) && ($zahyo[1] === 8) :
            //上
            if(up_check($xx,$yy,$player_array)){
                return true;
            }

            //左
            if(left_check($xx,$yy,$player_array)){
                return true;
            }

            //左上
            if(UpperLeft_check($xx,$yy,$player_array)){
                return true;
            }

        /* 全方位判定*/
        case (0 < $zahyo[0] && $zahyo[0]< 8 ) && (0 < $zahyo[1] && $zahyo[1]< 8 ) :
            //全方位みて、相手の石があれば置ける　無ければ置けない
            //上
            if(up_check($xx,$yy,$player_array)){
                return true;
            }
            //下
            echo '1';  
            if(down_check($xx,$yy,$player_array)){
                
                return true;
            }
           
            //左
            if(left_check($xx,$yy,$player_array)){
                
                return true;
            }
            //右
            if(right_check($xx,$yy,$player_array)){
                
                return true;
            }
            
            //右上 
            if(UpperRight_check($xx,$yy,$player_array)){
                return true;
            }
            
            //右下
            if(DownRight_check($xx,$yy,$player_array)){
                return true;
            }
            
            //左上 
            if(UpperLeft_check($xx,$yy,$player_array)){
                return true;
            }
            
            //左下 
            if(DownLeft_check($xx,$yy,$player_array)){
                return true;
            }
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

function up_check($xx,$yy,$player_array){
    global $banmen,$turn_num;
    if($banmen[$yy-1][$xx] === $player_array[($turn_num+1) % 2]){
        $h=$yy-1;
        echo "$h\n";
        while($h--){       
            
            if($h===-1){
                break;
            }
            // $s=(int)fgets(STDIN);
            // if ($h===1){
            //     continue;
            // }
            if ($banmen[$h][$xx] === $player_array[($turn_num) % 2]){
                return true;
            }
        }
        
    }
    return false;
}

function down_check($xx,$yy,$player_array){
    global $banmen,$turn_num;
    if ($banmen[$yy+1][$xx] === $player_array[($turn_num+1) % 2]){
        $h=$yy+1;
        while($h++){     
            
            // echo $h;
            if($h===8){
                break;
            }
             
            // $s=(int)fgets(STDIN);
            // if ($h===1){
                
            //     continue;
            // }
            
            if ($banmen[$h][$xx] === $player_array[($turn_num) % 2]){
                
                return true;
            }
        }
        
        
    }
    return false;
}

function left_check($xx,$yy,$player_array){
    global $banmen,$turn_num;
    if ($banmen[$yy][$xx-1] === $player_array[($turn_num+1) % 2]){
        $w=$xx-1;
        //バグ
        while($w--){
            // echo 'a';
            if($w===-1){
                break;
            }
            
            // if ($w===1){
            //     continue;
            // }
            if ($banmen[$yy][$w] === $player_array[($turn_num) % 2]){
                return true;
            }
        }
    }
    return false;
}

function right_check($xx,$yy,$player_array){
    global $banmen,$turn_num;
    if ($banmen[$yy][$xx+1] === $player_array[($turn_num+1) % 2]){
        for ($i=$xx+1; $i<8; $i++){
            // if ($i===7){
            //     continue;
            // }
            if ($banmen[$yy][$i] === $player_array[($turn_num) % 2]){
                return true;
            }
        }
    }
    return false;
}
function UpperRight_check($xx,$yy,$player_array){
    global $banmen,$turn_num;
    if ($banmen[$yy-1][$xx+1] === $player_array[($turn_num+1) % 2]){
        $w= $xx+1;
        $h= $yy-1;
        while($w<8 && $h>-1){
            // if ($w===6 && $h==1){
            //     //continue
            //     continue;
            // }
            if ($banmen[$h][$w] === $player_array[($turn_num) % 2]){
                return true;
            }
            $w++;
            $h--;
        }
    }
    return false;

}

function DownRight_check($xx,$yy,$player_array){
    global $banmen,$turn_num;
    if ($banmen[$yy+1][$xx+1] === $player_array[($turn_num+1) % 2]){
        $w= $xx+1;
        $h= $yy+1;
        while($w<8 && $h<8){
            
            //ここバグ
            // if ($w===7 && $h==7){
            //     //continue
                
            //     continue;
            // }
            echo 'a';
            if ($banmen[$h][$w] === $player_array[($turn_num) % 2]){
                return true;
            }
            $w++;
            $h++;
        }
    }
    return false;
}

function UpperLeft_check($xx,$yy,$player_array){
    global $banmen,$turn_num;
    if ($banmen[$yy-1][$xx-1] === $player_array[($turn_num+1) % 2]){
        $w= $xx-1;
        $h= $yy-1;
        while($w>-1 && $h>-1){
            // if ($w===6 && $h==6){
            //     //continue
            //     continue;
            // }
            if ($banmen[$h][$w] === $player_array[($turn_num) % 2]){
                return true;
            }
            $w--;
            $h--;
        }
    }
    return false;
}

function DownLeft_check($xx,$yy,$player_array){
    global $banmen,$turn_num;
    if ($banmen[$yy+1][$xx-1] === $player_array[($turn_num+1) % 2]){
        $w= $xx-1;
        $h= $yy+1;
        while($w>-1 && $h<8){
            // if ($w===1 && $h==6){
            //     //continue
            //     continue;
            // }
            if ($banmen[$h][$w] === $player_array[($turn_num) % 2]){
                return true;
            }
            $w--;
            $h++;
        }
    }
    return false;
        
}

function reversi($x,$y,$turn_num){
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
    //test
    if ($banmen[$yy][$xx] === ' ')
    {

        /*置くマスに上下左右斜めに隣接する相手の色の石が存在すること */
        switch($zahyo)
        {

        // /*(0,0)のとき右、右下、下方向見る */
        case ($zahyo[0] === 0) && ($zahyo[1] === 0):
            //右
            if(right_check($xx,$yy,$player_array)){
                right_reversi($xx,$yy,$player_array);
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                down_reversi($xx,$yy,$player_array);
            }
            //右下
            if(DownRight_check($xx,$yy,$player_array)){
                DownRight_reversi($xx,$yy,$player_array);
            }

        // /*(x_n,0)のとき左、左下、下、右下、右方向見る */
        case (0 < $zahyo[0] && $zahyo[0]< 8 ) && ($zahyo[1] === 0):
            //左
            if(left_check($xx,$yy,$player_array)){
                left_reversi($xx,$yy,$player_array);
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                down_reversi($xx,$yy,$player_array);
            }
            //右下
            if(DownRight_check($xx,$yy,$player_array)){
                DownRight_reversi($xx,$yy,$player_array);
            }

        // /*(x_max,0)のとき左、左下、下方向見る */
        case ($zahyo[0] === 8) && ($zahyo[1] === 0):
            //左
            if(left_check($xx,$yy,$player_array)){
                left_reversi($xx,$yy,$player_array);
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                down_reversi($xx,$yy,$player_array);
            }
            //左下
            if(DownLeft_check($xx,$yy,$player_array)){
                DownLeft_reversi($xx,$yy,$player_array);
            }
            

        // /*(0,y_n)のとき上、右上、右、右下、下方向見る */
        case ($zahyo[0] === 0) && (0 < $zahyo[1] && $zahyo[1]< 8 ):
            //上
            if(up_check($xx,$yy,$player_array)){
                up_reversi($xx,$yy,$player_array);
            }
            //右
            if(right_check($xx,$yy,$player_array)){
                right_reversi($xx,$yy,$player_array);
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                down_reversi($xx,$yy,$player_array);
            }
            //右上
            if(UpperRight_check($xx,$yy,$player_array)){
                UpperRight_reversi($xx,$yy,$player_array);
            }
            

        // /*(x_max,y_n)のとき上、左上、左、左下、下方向見る */
        case ($zahyo[0] === 8) && (0 < $zahyo[1] && $zahyo[1]< 8 ):
            //上
            if(up_check($xx,$yy,$player_array)){
                up_reversi($xx,$yy,$player_array);
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                down_reversi($xx,$yy,$player_array);
            }
            //左
            if(left_check($xx,$yy,$player_array)){
                left_reversi($xx,$yy,$player_array);
            }
            //左上
            if(UpperLeft_check($xx,$yy,$player_array)){
                UpperLeft_reversi($xx,$yy,$player_array);
            }
            //左下
            if(DownLeft_check($xx,$yy,$player_array)){
                DownLeft_reversi($xx,$yy,$player_array);
            }
            


        // /*(0,y_max)のとき上、右上、右方向見る */
        case ($zahyo[0] === 0) && ($zahyo[1] === 8) :
            //上
            if(up_check($xx,$yy,$player_array)){
                up_reversi($xx,$yy,$player_array);
            }

            //右
            if(right_check($xx,$yy,$player_array)){
                right_reversi($xx,$yy,$player_array);
            }

            //右上
            if(UpperRight_check($xx,$yy,$player_array)){
                UpperRight_reversi($xx,$yy,$player_array);
            }

        // /*(x_n,y_max)のとき左、左上、上、右上、右方向見る */
        case (0 < $zahyo[0] && $zahyo[0]< 8 ) && ($zahyo[1] === 8) :

            //上
            if(up_check($xx,$yy,$player_array)){
                up_reversi($xx,$yy,$player_array);
            }

            //左
            if(left_check($xx,$yy,$player_array)){
                left_reversi($xx,$yy,$player_array);
            }

            //右
            if(right_check($xx,$yy,$player_array)){
                right_reversi($xx,$yy,$player_array);
            }

            //右上
            if(UpperRight_check($xx,$yy,$player_array)){
                UpperRight_reversi($xx,$yy,$player_array);
            }

            //左上
            if(DownLeft_check($xx,$yy,$player_array)){
                DownLeft_reversi($xx,$yy,$player_array);
            }

        /*(x_max,y_max)のとき左、左上、上方向見る */
        case ($zahyo[0] === 8) && ($zahyo[1] === 8) :
            //上
            if(up_check($xx,$yy,$player_array)){
                up_reversi($xx,$yy,$player_array);
            }

            //左
            if(left_check($xx,$yy,$player_array)){
                left_reversi($xx,$yy,$player_array);
            }

            //左上
            if(UpperLeft_check($xx,$yy,$player_array)){
                UpperLeft_reversi($xx,$yy,$player_array);
            }

        /* 全方位判定*/
        case (0 < $zahyo[0] && $zahyo[0]< 8 ) && (0 < $zahyo[1] && $zahyo[1]< 8 ) :
            //全方位みて、相手の石があれば置ける　無ければ置けない
            //上
            if(up_check($xx,$yy,$player_array)){
                up_reversi($xx,$yy,$player_array);
            }
            //下
            if(down_check($xx,$yy,$player_array)){
                down_reversi($xx,$yy,$player_array);
            }
            //左
            if(left_check($xx,$yy,$player_array)){
                left_reversi($xx,$yy,$player_array);
            }
            //右
            if(right_check($xx,$yy,$player_array)){
                right_reversi($xx,$yy,$player_array);
            }
            
            //右上 
            if(UpperRight_check($xx,$yy,$player_array)){
                UpperRight_reversi($xx,$yy,$player_array);
            }
            
            //右下
            if(DownRight_check($xx,$yy,$player_array)){
                DownRight_reversi($xx,$yy,$player_array);
            }
            
            //左上 
            if(UpperLeft_check($xx,$yy,$player_array)){
                UpperLeft_reversi($xx,$yy,$player_array);
            }
            
            //左下 
            if(DownLeft_check($xx,$yy,$player_array)){
                DownLeft_reversi($xx,$yy,$player_array);
            }
            
        }
        
    }
}
function up_reversi($xx,$yy,$player_array){
    global $banmen,$turn_num;
    for ($i=$yy-1; $i>-1; $i--){
                    
        if($banmen[$i][$xx] === $player_array[($turn_num) % 2]){
            break;
        }
        $banmen[$i][$xx] = $player_array[($turn_num) % 2];
    }
}

function down_reversi($xx,$yy,$player_array){
    global $banmen,$turn_num;
    for ($i=$yy+1; $i<8; $i++){     
        if($banmen[$i][$xx] === $player_array[($turn_num) % 2]){
            break;
        }
        $banmen[$i][$xx] = $player_array[($turn_num) % 2];
    }
}

function left_reversi($xx,$yy,$player_array){
    global $banmen,$turn_num;
    for ($i=$xx-1; $i>-1; $i--){
                    
        if($banmen[$yy][$i] === $player_array[($turn_num) % 2]){
            break;
        }
        $banmen[$yy][$i] = $player_array[($turn_num) % 2];
    }
}

function right_reversi($xx,$yy,$player_array){
    global $banmen,$turn_num;
    for ($i=$xx+1; $i<8; $i++){
                    
        if($banmen[$yy][$i] === $player_array[($turn_num) % 2]){
            break;
        }
        $banmen[$yy][$i] = $player_array[($turn_num) % 2];
    }
}

function UpperRight_reversi($xx,$yy,$player_array){
    global $banmen,$turn_num;
    $h=$yy-1;
    $w=$xx+1;
    while($h>-1 && $w<8){
        if($banmen[$h][$w] === $player_array[($turn_num) % 2]){
            break;
        }
        $banmen[$h][$w] = $player_array[($turn_num) % 2];
        $h--;
        $w++;
    }
}

function DownRight_reversi($xx,$yy,$player_array){
    global $banmen,$turn_num;
    $h=$yy+1;
    $w=$xx+1;
    while($h<8 && $w<8){
        if($banmen[$h][$w] === $player_array[($turn_num) % 2]){
            break;
        }
        $banmen[$h][$w] = $player_array[($turn_num) % 2];
        $h++;
        $w++;
    }
}

function UpperLeft_reversi($xx,$yy,$player_array){
    global $banmen,$turn_num;
    $h=$yy-1;
    $w=$xx-1;
    while($h>-1 && $w>-1){
        if($banmen[$h][$w] === $player_array[($turn_num) % 2]){
            break;
        }
        $banmen[$h][$w] = $player_array[($turn_num) % 2];
        $h--;
        $w--;
    }
}

function DownLeft_reversi($xx,$yy,$player_array){
    global $banmen,$turn_num;
    $h=$yy+1;
    $w=$xx-1;
    while($h<8 && $w>-1){
        if($banmen[$h][$w] === $player_array[($turn_num) % 2]){
            break;
        }
        $banmen[$h][$w] = $player_array[($turn_num) % 2];
        $h++;
        $w--;
    }
}