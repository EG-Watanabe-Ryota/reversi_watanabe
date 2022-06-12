<?php
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

// $turn_num=0;
$player=true; //Trueが黒、Falseが白
/*ーーーーーー ここまで ーーーーーー*/

main();

/*メイン関数(ここでメインの処理を行う)*/
function main()
{
    global $banmen,$player;
    $turn_num=1;
    while(1)
    {
        /*ゲーム終了条件に合致してるか判定処理書く */

        /*ーーーーーー ここまで ーーーーーー*/
        echo "$turn_num"."ターン目の盤面を表示します\n";
        show();
        if(($turn_num % 2) === 1)
        {

            //whileで囲む
            echo "黒色のターンです\n";
            echo "どこに石を置くか入力してください\n";
            echo "横:";
            $x=(int)fgets(STDIN);
            echo "縦:";
            $y=(int)fgets(STDIN);
            echo "\n";
            echo "($x,$y)に石を置きます\n";

            //指定した座標に石を置けるか判定
            if(check_set($x,$y,$turn_num))
            {
                break;
            }
            //ここまで

            //終了前にplayerを相手に変更する
            $turn_num++;
        }
        else{
            echo "白色のターンです\n";
            echo "どこに石を置くか入力してください\n";
            echo "横:";
            $x=(int)fgets(STDIN);
            echo "縦:";
            $y=(int)fgets(STDIN);
            echo "\n";
            echo "($x,$y)に石を置きます\n";

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
    /*両プレイヤーが石を置いていないことをチェックする*/
    if ($banmen[$y-1][$x-1] === ' ')
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
                return false;
            }
            elseif ($banmen[$yy+1][$xx+1] === $player){
                return false;
            }

        /*(x_n,0)のとき左、左下、下、右下、右方向見る */
        case ($zahyo[0] !== 0 || $zahyo[0] !== 8 ) && ($zahyo[1] === 0):
            if($banmen[$yy][$xx-1] === $player){
                return false;
            }
            elseif ($banmen[$yy+1][$xx] === $player){
                return false;
            }
            elseif ($banmen[$yy+1][$xx+1] === $player){
                return false;
            }

        /*(x_max,0)のとき左、左下、下方向見る */
        case ($zahyo[0] === 8) && ($zahyo[1] === 0):
            if($banmen[$yy][$xx-1] === $player){
                return false;
            }
            elseif ($banmen[$yy-1][$xx-1] === $player){
                return false;
            }
            elseif ($banmen[$yy+1][$xx] === $player){
                return false;
            }

        /*(0,y_n)のとき上、右上、右、右下、下方向見る */

        /*(x_max,y_n)のとき上、左上、左、左下、下方向見る */

        /*(0,y_max)のとき上、右上、右方向見る */

        /*(x_n,y_max)のとき左、左上、上、右上、右方向見る */

        /*(x_max,y_max)のとき左、左上、上方向見る */

        /* 全方位判定*/
        }
        return false;
    }
    else
    {
        return true;
    }
}