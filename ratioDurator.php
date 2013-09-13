<?php
// 原点からの距離的な数字をある程度のランダムさで返すクラス
// 0に近い値ほど出やすく、遠くなるほど出にくくなる。
// 浮動少数の精度とかは一切無視

class ratioDurator {
	// 定数
	const DEFAULT_RATIO       = 1.1; // 外れる確率を調整する幅
	const DEFAULT_PROBABILITY = 0.5; // 外れる確率
	const DEFAULT_LIMIT       = 10;  // カンスト値

	// プロパティ
	private $probability = null; // 外れる確率
	private $ratio       = null; // 外れる確率を調整する割合
	private $flg         = TRUE; // 判定フラグ
	private $score       = 0;    // スコア
	private $limit       = null; // 最大値

	public function __construct() {
		// 初期設定
		$this->ratio       = $this::DEFAULT_RATIO;
		$this->probability = $this::DEFAULT_PROBABILITY;
		$this->limit       = $this::DEFAULT_LIMIT;
	}

	// 外れ確率調整量を設定
	public function setRatio($value) {
		if(!(is_numeric($value)))
		{
			return FALSE;
		}
		$this->ratio = $value;
	}

	// 外れ確率を設定
	public function setProbability($value) {
		if(!(is_numeric($value)))
		{
			return FALSE;
		}
		$this->probability = $value;
	}

	// カンスト値を設定
	public function setLimit($value) {
		if(!(is_numeric($value)))
		{
			return FALSE;
		}
		$this->limit = $value;
	}

	// 重み付けを考慮したランダム値を出力
	public function getValue() {
		// probabilityの確率でTRUEが返る。
		// TRUEだったらスコアをインクリメント
		// FALSEだったら終わる
		// カンストした時も終わる
		do
		{
			// 外れ判定
			$this->flg = $this->_check($this->probability);

			// 外れていなかったら？
			if($this->flg)
			{
				// 外れ確率アップ
				$this->probability *= $this->ratio;

				// スコア加算
				$this->score++;
			}
		} while($this->flg && ($this->limit > $this->score));
		// 外れるかカンストするまで続ける

		return $this->score;
	}

	// 外れ確率を取得
	public function getProbability()
	{
		return $this->probability;
	}

	// 外れる確率を渡してBOOLを返す
	private function _check($probability){
		$val = mt_rand(0,100);
		return ($val >= ((double)$probability * 100) ? TRUE : FALSE);
	}
}
