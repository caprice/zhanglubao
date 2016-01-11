<?php
/**
 * 玩法数据类
 */
class PlayWayDataModel{
	
	/**
	 * 玩法ID
	 * 
	 * @var int
	 */
	private $id = '';
	
	/**
	 * 玩法名称
	 * 
	 * @var string
	 */
	private $name = '';
	
	/**
	 * 赔率类型，默认为固定赔率 1：固定赔率  2：浮动赔率
	 * int 
	 */
	private $oddsType =2;
	
	/**
	 * 浮动比率
	 * 
	 * @var folat
	 */
	private $floatPercent = 0;
	
	/**
	 * 固定赔率时投注下限
	 * 
	 * @var int
	 */
	private $bettingLowerLimit = 0;
	
	/**
	 * 固定赔率或浮动赔率时投注上限
	 * 
	 * @var int
	 */
	private $bettingUpperLimit = 0;
	
	/**
	 * 固定赔率时参与竞猜人数上限
	 * int
	 */
	private $playCountLimit = 0;
	
	/**
	 * 竞猜玩法参数
	 * @var PlayWayParameter
	 */
	private $parameter;
	
	/**
	 * 固定赔率时的赔率数据，竞猜选项参数名作键，赔率作值
	 */
	private $odds = array();
	
	/**
	 * 参与人数组
	 * @var array
	 */
	private $playCounts = array();
	
	/**
	 * 参与财富数组
	 * @var array
	 */
	private $playWealths = array();
	
	/**
	 *
	 * @return number $id
	 */
	public function getId(){
		return $this->id;
	}
	
	/**
	 *
	 * @param number $id        	
	 */
	public function setId($id){
		$this->id = $id;
	}
	
	/**
	 *
	 * @return string $name
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 *
	 * @param string $name        	
	 */
	public function setName($name){
		$this->name = $name;
	}
	
	/**
	 *
	 * @return string $oddsType
	 */
	public function getOddsType(){
		return $this->oddsType;
	}
	
	/**
	 *
	 * @param string $oddsType        	
	 */
	public function setOddsType($oddsType){
		$this->oddsType = $oddsType;
	}
	
	/**
	 *
	 * @return folat $floatPercent
	 */
	public function getFloatPercent(){
		return $this->floatPercent;
	}
	
	/**
	 *
	 * @param folat $floatPercent        	
	 */
	public function setFloatPercent($floatPercent){
		$this->floatPercent = $floatPercent;
	}
	
	/**
	 *
	 * @return number $bettingLowerLimit
	 */
	public function getBettingLowerLimit(){
		return $this->bettingLowerLimit;
	}
	
	/**
	 *
	 * @param number $bettingLowerLimit        	
	 */
	public function setBettingLowerLimit($bettingLowerLimit){
		$this->bettingLowerLimit = $bettingLowerLimit;
	}
	
	/**
	 *
	 * @return number $bettingUpperLimit
	 */
	public function getBettingUpperLimit(){
		return $this->bettingUpperLimit;
	}
	
	/**
	 *
	 * @param number $bettingUpperLimit        	
	 */
	public function setBettingUpperLimit($bettingUpperLimit){
		$this->bettingUpperLimit = $bettingUpperLimit;
	}
	
	/**
	 *
	 * @return number $playCountLimit
	 */
	public function getPlayCountLimit(){
		return $this->playCountLimit;
	}
	
	/**
	 *
	 * @param number $playCountLimit        	
	 */
	public function setPlayCountLimit($playCountLimit){
		$this->playCountLimit = $playCountLimit;
	}
	
	/**
	 *
	 * @return multitype: $odds
	 */
	public function getOdds(){
		return $this->odds;
	}
	
	/**
	 *
	 * @param multitype: $odds        	
	 */
	public function setOdds($odds){
		$this->odds = $odds;
	}
	
	/**
	 * 检查是否是正确的数据
	 * @return boolean
	 */
	public function isCorrectData(){
		return true;
	}
	
	/**
	 * 是否是固定赔率
	 * @return boolean
	 */
	public function isFixedOdds(){
		return $this->oddsType == Guess::ODDS_TYPE_FIXED;
	}
	
	/**
	 * 是否是浮动赔率
	 * @return boolean
	 */
	public function isFloatOdds(){
		return $this->oddsType == Guess::ODDS_TYPE_FLOAT;
	}
	
	/**
	 * 获取最高的赔率
	 * @return float
	 */
	public function getTheHighestOdds(){
		$highestOdds = 0;
	    foreach($this->getOdds() as $param=>$value){
			if($value > $highestOdds){
			    $highestOdds = $value;
			}
	    }
	    return $highestOdds;
	}
	
	/**
	 * 计算需要托管的金额
	 * @return int
	 */
	public function needKeepWealth(){
		if($this->isFixedOdds()){
			$highestOdds = $this->getTheHighestOdds();
			return $highestOdds * $this->getBettingUpperLimit() * $this->getPlayCountLimit();
		}
		return 0;
	}
	
	/**
	 * @return PlayWayParameter $parameter
	 */
	public function getParameter(){
		return $this->parameter;
	}

	/**
	 * @param PlayWayParameter $parameter
	 */
	public function setParameter($parameter){
		$this->parameter = $parameter;
	}
	
	/**
	 * @return multitype: $playCounts
	 */
	public function getPlayCounts(){
		return $this->playCounts;
	}
	
	public function getPlayCount($option){
		return $this->playCounts[$option]?$this->playCounts[$option]:0;
	}

	/**
	 * @return multitype: $playWealths
	 */
	public function getPlayWealths(){
		return $this->playWealths;
	}
	
	public function getPlayWealth($option){
		return $this->playWealths[$option]?$this->playWealths[$option]:0;
	}

	/**
	 * @param multitype: $playCounts
	 */
	public function setPlayCounts($playCounts){
		$this->playCounts = $playCounts;
	}

	/**
	 * @param multitype: $playWealths
	 */
	public function setPlayWealths($playWealths){
		$this->playWealths = $playWealths;
	}
	
	public function addPlayCount($option){
		if(isset($this->playCounts[$option])){
			$this->playCounts[$option] += 1;
		}else{
			$this->playCounts[$option] = 1;
		}
	}
	
	public function addPlayWealth($option, $wealth){
		if($this->playWealths[$option]){
			$this->playWealths[$option] += $wealth;
		}else{
			$this->playWealths[$option] = $wealth;
		}
	}
	
	public function getOptionOdds($option){
		if($this->isFixedOdds()){
			return $this->odds[$option];
		}else{
			$odds = ($this->getTotalPlayWealth() - $this->playWealths[$option]) * $this->getFloatPercent() / $this->playWealths[$option];
			if($odds){
				return $this->formatOods($odds, 2);
			}
			return 0;
		}
		return 0;	
	}
	
	public function getTotalPlayCount(){
		$totalCount = 0;
		foreach($this->playCounts as $count){
			$totalCount += $count;
		}
		return $totalCount;
	}
	
	public function getTotalPlayWealth(){
		$totalWealth = 0;
		foreach($this->playWealths as $wealth){
			$totalWealth += $wealth;
		}
		return $totalWealth;
	}
	
	protected function formatOods($oods, $countAfterDot = 2){
		$countAfterDot = (int)$countAfterDot;
		$pow = pow(10, $countAfterDot);
		$tmp = $oods * $pow;
		$tmp = floor($tmp)/$pow;
		$format = sprintf('%%.%df', (int)$countAfterDot);
		$result = sprintf($format,  (float)$tmp);
		return $result;
	}
}

?>