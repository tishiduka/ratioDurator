# ratioDurator
## 概要
原点からの距離的な数字をある程度のランダムさで返すクラスです。
setScore()で指定される、あるいは0（デフォルト）で示される原点に近いほど出現確率が上がり、離れるごとに指数関数的に確率が下がります。

##使い方

インスタンス化して使ってください。

### コード
    <?php
        require_once('./duratedRandomizer.php');
 
       obj = new duratedRandomizer;
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

## 設定項目

### DEFAULT_PROBABILITY
外れる確率を設定します。
setProbability()が呼ばれない場合、この値が初期値として使われます。

### DEFAULT_RATIO
外れ確率調整量を設定します。
setRatio()が呼ばれない場合、この値が初期値として使われます。

### DEFAULT_LIMIT
カンスト値を設定します。
setLimit()が呼ばれない場合、この値が初期値として使われます。

## メソッド
### setProbability($value)
インスタンス生成後に外れる確率を設定します。
$valueに数値として無効なものを指定した場合、FALSEを返します。

### setRatio($value)
インスタンス生成後に外れ確率調整量を設定します。
$valueに数値として無効なものを指定した場合、FALSEを返します。

### setLimit($value)
インスタンス生成後にカンスト値を設定します。
$valueに数値として無効なものを指定した場合、FALSEを返します。

### setScore($value)
インスタンス生成後スコア値を設定します。
$valueに数値として無効なものを指定した場合、FALSEを返します。

### setAbsMode($flag)
絶対値モードのON/OFFを切り替えます。
絶対値モードをONにすると。1/2の確率で負の値が返ります。つまり、取りうる値の範囲はOFFの時と比べて倍の広さになります。

### get()
0からDEFAULT_LIMITあるいはsetScore()で設定した値の間で、重み付けをされた整数をある程度ランダムに返します。

### getDuration()
現在設定されている外れ確率を取得します。
