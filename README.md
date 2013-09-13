# ratioDurator
原点からの距離的な数字をある程度のランダムさで返すクラス

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
### setProbability()
インスタンス生成後に外れる確率を設定します。
数値として無効なものを指定した場合、FALSEを返します。

### setRatio()
インスタンス生成後に外れ確率調整量を設定します。
数値として無効なものを指定した場合、FALSEを返します。

### setLimit()
インスタンス生成後にカンスト値を設定します。
数値として無効なものを指定した場合、FALSEを返します。

### get()
0からDEFAULT_LIMITあるいはsetLimit()で設定した値の間で、重み付けをされた整数をある程度ランダムに返します。

### getDuration()
現在設定されている外れ確率を取得します。
