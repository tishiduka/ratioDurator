# ratioDurator
## 概要
原点からの距離的な整数をある程度のランダムさで返すPHPクラスです。

0（デフォルトor通常モード時）あるいはsetPeak()指定された値(絶対値モード時)で示される原点に近いほど出現確率が上がり、離れるごとに指数関数的に確率が下がります。

##使い方

インスタンス化して使ってください。

### コード
    <?php
        require_once('./duratedRandomizer.php');
 
        $obj = new duratedRandomizer;
        $obj->setProbability(0.5);
        $obj->setDuration(1.1);
        $obj->setLimit(10);
        $score = $obj->getValue();
        $dur = $obj->getDuration();

        // 結果表示
        echo "score : {$score}\n";
        echo "probability to dropout : " . (round(1 - $dur,3) * 100) . "%.\n";

        exit;

### 出力結果
    score : 0
    probability to dropout : 50%.

## メソッド
### setProbability($value)
0あるいは中心値から遠ざかった値が確定される確率の初期値を設定します。1未満の小数のみ有効です。この値を大きくすると、get()にって中心値に近い値が取得できる確率が高くなります。

$valueに数値として無効なものを指定した場合、FALSEを返します。

### setRatio($value)
0あるいは中心値から遠ざかるごとに変動する確定率の調整量を設定します。1より大きい整数あるいは小数が有効です。この値を大きくすると、get()にって中心値に近い値が取得できる確率が高くなります。

$valueに数値として無効なものを指定した場合、FALSEを返します。

### setUpperLimit($value)
カンスト上限値を設定します。1以上の整数が有効です。

$valueに正の整数として無効なものを指定した場合、またsetLowerLimit()あるいはsetPeak()で設定した値より小さい値を指定した場合、ALSEを返します。

### setLowerLimit($value)
カンスト下限値を設定します。1以上の整数が有効です。
$valueに正の整数として無効なものを指定した場合、またsetLowerLimit()あるいはsetPeak()で設定した値より大きい値を指定した場合、FALSEを返します。

通常モードの場合、ここで設定された値は無視されます。

### setPeak($value)
中心値を設定します。1以上の整数が有効です。$valueに正の整数として無効なものを指定した場合、FALSEを返します。

通常モードの場合、ここで設定された値は無視されます。

### setAbsMode($flag)
絶対値モードのON/OFFを切り替えます。booleanとして有効な値が指定できます。

絶対値モードをONにすると。1/2の確率で負の値が返ります。つまり、取りうる値の範囲はOFFの時と比べて倍の広さになります。

### get()
通常モードの場合、0からDEFAULT_UPPER_LIMITあるいはsetUpperLimit()で設定した値の間で、整数をある程度ランダムに返します。

絶対値モードの場合、DEFAULT_LOWER_LIMITあるいはsetLowerLimit()で設定した値とDEFAULT_UPPER_LIMITあるいはsetUpperLimit()で設定した値を範囲として、整数をある程度ランダムに返します。

### getDuration()
現在設定されている確定率を取得します。
