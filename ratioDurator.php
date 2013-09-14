<?php
// 原点からの距離的な数字をある程度のランダムさで返すクラス
// 0に近い値ほど出やすく、遠くなるほど出にくくなる。
// 浮動少数の精度とかは一切無視

class ratioDurator {
	// 定数
	const DEFAULT_RATIO        = 1.1;   // 外れる確率を調整する幅
	const DEFAULT_PROBABILITY  = 0.25;   // 外れる確率
	const DEFAULT_UPPER_LIMIT  = 10;    // カンスト上限値
	const DEFAULT_LOWER_LIMIT  = 0;     // カンスト下限値
	const DEFAULT_PEAK         = 0;     // 中心値からの範囲絶対値
	const DEFAULT_ABS_MODE     = FALSE; // 絶対値モード

	// プロパティ
	private $flg         = TRUE;  // 判定フラグ
	private $ratio       = null;  // 外れる確率を調整する割合
	private $probability = null;  // 外れる確率
	private $upper_limit = null;  // カンスト上限値
	private $lower_limit = null;  // カンスト最大値
	private $score       = null;  // スコア
	private $peak        = null;  // 中心からの範囲絶対値
	private $abs_mode    = null; // 絶対値モードフラグ TRUEにするとscoreから負に向かう値も扱う

	public function __construct() {
		// 初期設定
		$this->ratio       = $this::DEFAULT_RATIO;
		$this->probability = $this::DEFAULT_PROBABILITY;
		$this->upper_limit = $this::DEFAULT_UPPER_LIMIT;
		$this->lower_limit = $this::DEFAULT_LOWER_LIMIT;
		$this->peak        = $this::DEFAULT_PEAK;
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

	// カンスト上限値を設定
	public function setUpperLimit($value) {
		if(
			!(is_int($value)) || 
			(int)$this->peak > (int)$value
		)
		{
			return FALSE;
		}
		$this->upper_limit = $value;
	}

	// カンスト下限限値を設定
	public function setLowerLimit($value) {
		if(
			!(is_int($value)) || 
			(int)$this->peak < (int)$value
		)
		{
			return FALSE;
		}
		$this->lower_limit = $value;
	}

	// 中心値を設定
	public function setPeak($value) {
		if(
			!(is_int($value)) ||
			(int)$this->upper_limit < (int)$value ||
			(int)$this->lower_limit > (int)$value
		)
		{
			return FALSE;
		}
		$this->peak = $value;
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
		$score = 0;
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
				$score++;
			}
			
			// 外れるかカンストするまで続ける
			if($this->abs_mode) {
				if ( 
					(($this->abs_mode) && abs((int)($this->upper_limit) - (int)($this->peak)) <= $score) &&
					(($this->abs_mode) && (abs((int)($this->lower_limit) - (int)($this->peak)) <= $score))
				)
				{
					break;
				}
			} else {
				if ((int)($this->upper_limit) <= (int)($score)) {
					break;
				}
			}
		} while($this->flg);

		// 中心値からのズレを計算
		if($this->abs_mode) {
			// 絶対値モード
			if((mt_rand(1,2) % 2) === 0){
				// 減らす方向
				$result = $this->peak - $score;
			} else {
				// 増やす方向
				$result = $this->peak + $score;
			}
		} else {
			// 通常モード
			$result = $this->peak + $score;
		}
		return $result;
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
