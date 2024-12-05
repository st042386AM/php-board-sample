<?php
class SimpleCalculator
{
    //プロパティ：計算結果を保持
    private int $total;

    //コンストラクタ：初期値を設定
    public function __construct(int $initialValue)
    {
        //プロパティへの初期値を代入
        $this->total = $initialValue;
    }

    //メソッド：足し算をする
    public function add(int $value):int
    {
        $this->total += $value; //足し算処理
        return $this->total;   //現在の結果を返す
    }
}

$calculator = new SimpleCalculator(10);
echo $calculator->add(5);