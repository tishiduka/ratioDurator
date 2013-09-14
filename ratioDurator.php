<?php
// 原点からの距離的な数字をある程度のランダムさで返すクラス
// 0に近い値ほど出やすく、遠くなるほど出にくくなる。
// 浮動少数の精度とかは一切無視

class ratioDurator {
	// 定数
	const DEFAULT_RATIO       = 1.1;   // 外れる確率を調整する幅
	const DEFAULT_PROBABILITY = 0.5;   // 外れる確率
	const DEFAULT_LIMIT       = 10;    // カンスト上限値
	const DEFAULT_SCORE       = 0;     // 最低値
	const DEFAULT_ABS_MODE    = FALSE; // 絶対値モード

	// プロパティ
	private $flg         = TRUE;  // 判定フラグ
	private $ratio       = null;  // 外れる確率を調整する割合
	private $probability = null;  // 外れる確率
	private $limit       = null;  // 最大値
	private $score       = null;  // スコア
	private $abs_mode    = null; // 絶対値モードフラグ TRUEにするとscoreから負に向かう値も扱う

	public function __construct() {
		// 初期設定
		$this->ratio       = $this::DEFAULT_RATIO;
		$this->probability = $this::DEFAULT_PROBABILITY;
		$this->limit       = $this::DEFAULT_LIMIT;
		$this->score       = $this::DEFAULT_SCORE;
		$this->score       = $this::DEFAULT_SCORE;
		$this->abs_mode    = $this::DEFAULT_ABS_MODE;
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

	// スコア初期値を設定
	public function setScore($value) {
		if(!(is_numeric($value)))
		{
			return FALSE;
		}
		$this->score = $value;
	}

	// 絶対値モード設定
	public function setAbsMode($mode) {
		$this->abs_mode = $mode;
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
		} while($this->flg && ($this->limit >= $this->score));
		// 外れるかカンストするまで続ける

		// 絶対値モードONの場合、府の値も取りうる。
		if($this->abs_mode) {
			if((mt_rand(1,2) % 2) === 0)
			{
				$this->score *= -1;
			}
		}
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
