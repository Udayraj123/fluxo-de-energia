<?php
namespace Helpers;
use Log;


$answerHauts=array('','A','C','D','C','B','A','04','03','02','16','19','16','B','B','*','D','A','B','B','A','D','D','D','D');
$answerJuniors=array('','C','D','C','C','D','B','D','A','C','19','02','03','07','A','B','D','C','B','D','A','C','A');

Class Techanalysis{

	protected static $juniors=array(
	'1'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>2,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>2,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>6),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>3,'Analysis'=>4) ),

	'2'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>3),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>5) ),

	'3'=>array( 'A'=> array('OutBox'=>3,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>3),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>6,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>6),
				'D'=> array('OutBox'=>3,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>3) ),

	'4'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>3,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>3),
				'C'=> array('OutBox'=>6,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>6),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'5'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>4,'Analysis'=>4) ),

	'6'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>3,'Analysis'=>5),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'7'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>2,'Analysis'=>3),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>6) ),

	'8'=>array( 'A'=> array('OutBox'=>2,'Maths'=>0,'Crypto'=>0,'Logic'=>5,'Analysis'=>5),
				'B'=> array('OutBox'=>1,'Maths'=>0,'Crypto'=>0,'Logic'=>3,'Analysis'=>3),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'9'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>2,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>2,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>6,'Logic'=>0,'Analysis'=>2),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>2,'Logic'=>0,'Analysis'=>6) ),

	'10'=>array( '19'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>4,'Analysis'=>5),
				'20'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'21'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'22'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'23'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'24'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'25'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'26'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'27'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'28'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'29'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'30'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'31'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'32'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'33'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'34'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'35'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'36'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'37'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'38'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0)),

	'11'=>array( '02'=> array('OutBox'=>6,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>4),
				'03'=> array('OutBox'=>6,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>2) ),

	'12'=>array( '03'=> array('OutBox'=>0,'Maths'=>8,'Crypto'=>0,'Logic'=>0,'Analysis'=>4),
				'04'=> array('OutBox'=>0,'Maths'=>6,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'05'=> array('OutBox'=>0,'Maths'=>4,'Crypto'=>0,'Logic'=>0,'Analysis'=>1) ),

	'13'=>array( '07'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>7),
				'08'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>3,'Analysis'=>4) ),

	'14'=>array( 'A'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>3,'Analysis'=>3),
				'B'=> array('OutBox'=>0,'Maths'=>1,'Crypto'=>0,'Logic'=>1,'Analysis'=>1),
				'C'=> array('OutBox'=>0,'Maths'=>1,'Crypto'=>0,'Logic'=>1,'Analysis'=>1),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'15'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>2,'Maths'=>0,'Crypto'=>0,'Logic'=>3,'Analysis'=>3),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'16'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>3,'Maths'=>3,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'17'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>10,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'18'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>2,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>6,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>2,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>2,'Logic'=>0,'Analysis'=>0) ),

	'19'=>array( 'A'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>4,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'D'=> array('OutBox'=>0,'Maths'=>8,'Crypto'=>0,'Logic'=>0,'Analysis'=>4) ),

	'20'=>array( 'A'=> array('OutBox'=>0,'Maths'=>6,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'B'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'C'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'D'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>1) ),

	'21'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>1,'Analysis'=>1),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>3,'Analysis'=>3),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>5,'Analysis'=>5),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'22'=>array( 'A'=> array('OutBox'=>8,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'B'=> array('OutBox'=>2,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'C'=> array('OutBox'=>3,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) )

	);

	protected static $hauts=array(
	'1'=>array( 'A'=> array('OutBox'=>0,'Maths'=>3,'Crypto'=>0,'Logic'=>0,'Analysis'=>4),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'2'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>1,'Maths'=>3,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'C'=> array('OutBox'=>2,'Maths'=>5,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'3'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>4,'Analysis'=>4) ),

	'4'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>6,'Crypto'=>0,'Logic'=>0,'Analysis'=>3),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'5'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>2,'Analysis'=>7),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>1,'Analysis'=>2),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>1,'Analysis'=>2),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>1,'Analysis'=>2) ),

	'6'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>5,'Analysis'=>5),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'7'=>array( '04'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>3,'Analysis'=>3),
				'05'=> array('OutBox'=>0,'Maths'=>1,'Crypto'=>0,'Logic'=>1,'Analysis'=>1) ),

	'8'=>array( '03'=> array('OutBox'=>0,'Maths'=>6,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'04'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'9'=>array( '02'=> array('OutBox'=>6,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>4),
				'03'=> array('OutBox'=>6,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>2) ),

	'10'=>array( '16'=> array('OutBox'=>6,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>6),
				'14'=> array('OutBox'=>3,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>3) ),

	'11'=>array( '19'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>4,'Analysis'=>5),
				'20'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'21'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'22'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'23'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'24'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'25'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'26'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'27'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'28'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'29'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'30'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'31'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'32'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'33'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'34'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'35'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'36'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'37'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0),
				'38'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>4,'Analysis'=>0) ),

	'12'=>array( '16'=> array('OutBox'=>10,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>2) ),

	'13'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>4,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>6,'Logic'=>0,'Analysis'=>2),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>3,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>2,'Logic'=>0,'Analysis'=>0) ),

	'14'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>4,'Crypto'=>0,'Logic'=>0,'Analysis'=>3),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>3,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),
	//Q15 is bonus
	'15'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'16'=>array( 'A'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>4,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'D'=> array('OutBox'=>0,'Maths'=>8,'Crypto'=>0,'Logic'=>0,'Analysis'=>4) ),

	'17'=>array( 'A'=> array('OutBox'=>0,'Maths'=>6,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'B'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'C'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'D'=> array('OutBox'=>0,'Maths'=>2,'Crypto'=>0,'Logic'=>0,'Analysis'=>1) ),

	'18'=>array( 'A'=> array('OutBox'=>0,'Maths'=>1,'Crypto'=>0,'Logic'=>0,'Analysis'=>1),
				'B'=> array('OutBox'=>2,'Maths'=>4,'Crypto'=>0,'Logic'=>0,'Analysis'=>5),
				'C'=> array('OutBox'=>1,'Maths'=>3,'Crypto'=>0,'Logic'=>0,'Analysis'=>3),
				'D'=> array('OutBox'=>0,'Maths'=>1,'Crypto'=>0,'Logic'=>0,'Analysis'=>1) ),

	'19'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>8,'Crypto'=>0,'Logic'=>0,'Analysis'=>2),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'20'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>7,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'21'=>array( 'A'=> array('OutBox'=>0,'Maths'=>1,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>1,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>4,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>8,'Crypto'=>0,'Logic'=>0,'Analysis'=>0) ),

	'22'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>2,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>6,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>3,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>8,'Analysis'=>0) ),

	'23'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>3,'Logic'=>3,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>3,'Logic'=>3,'Analysis'=>4) ),

	'24'=>array( 'A'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'B'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'C'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0),
				'D'=> array('OutBox'=>0,'Maths'=>0,'Crypto'=>3,'Logic'=>3,'Analysis'=>0) )


	);

	public static function MaxHauts()
	{	
		$Max=array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0);
		foreach(Techanalysis::$hauts as $key=>$value)
			if(preg_replace('/\s+/','',$answerHauts[$key])=='C'||preg_replace('/\s+/','',$answerHauts[$key])=='A'||preg_replace('/\s+/','',$answerHauts[$key])=='B'||preg_replace('/\s+/','',$answerHauts[$key])=='D'||is_numeric(preg_replace('/\s+/','',$answerHauts[$key])))
			{	global $hauts,$answerHauts;
				$Max['OutBox']+=$hauts[$key][$answerHauts[$key]]['OutBox'];
				$Max['Maths']+=$hauts[$key][$answerHauts[$key]]['Maths'];
				$Max['Crypto']+=$hauts[$key][$answerHauts[$key]]['Crypto'];
				$Max['Logic']+=$hauts[$key][$answerHauts[$key]]['Analysis'];
				$Max['Analysis']+=$hauts[$key][$answerHauts[$key]]['Analysis'];

			}

			return $Max;
	}

	public static function MaxJuniors()
	{	
		
		$Max=array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0);
		foreach(Techanalysis::$juniors as $key=>$value)
			if(preg_replace('/\s+/','',$answerJuniors[$key])=='C'||preg_replace('/\s+/','',$answerJuniors[$key])=='A'||preg_replace('/\s+/','',$answerJuniors[$key])=='B'||preg_replace('/\s+/','',$answerJuniors[$key])=='D'||is_numeric(preg_replace('/\s+/','',$answerJuniors[$key])))
			{
				$Max['OutBox']+=$juniors[$key][$answerJuniors[$key]]['OutBox'];
				$Max['Maths']+=$juniors[$key][$answerJuniors[$key]]['Maths'];
				$Max['Crypto']+=$juniors[$key][$answerJuniors[$key]]['Crypto'];
				$Max['Logic']+=$juniors[$key][$answerJuniors[$key]]['Analysis'];
				$Max['Analysis']+=$juniors[$key][$answerJuniors[$key]]['Analysis'];

			}

			return $Max;
	}

	public static function TechnalysisJuniors($resp)
	{	
		// global $juniors,$answerJuniors;
		$score=array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0);
		$juniors = Techanalysis::$juniors;
		foreach(Techanalysis::$juniors as $key=>$values)
		{
			Log::info('QNo:'.$key.'\n'.$resp->roll.'\n');
			
			try{
			if(preg_replace('/\s+/','',$resp->{'q'.$key}) == '')
				continue;

			else if(is_numeric(preg_replace('/\s+/','',$resp->{'q'.$key})))
			{ 
				foreach($juniors[$key] as $k=>$v)
					if(intval($k)==intval($resp->{'q'.$key}))
					{
						$score['OutBox']+=$juniors[$key][$k]['OutBox'];
						$score['Maths']+=$juniors[$key][$k]['Maths'];
						$score['Crypto']+=$juniors[$key][$k]['Crypto'];
						$score['Logic']+=$juniors[$key][$k]['Logic'];
						$score['Analysis']+=$juniors[$key][$k]['Analysis'];
					}
			}

			else
			{
				if(preg_replace('/\s+/','',$resp->{'q'.$key})=='A')
					{
						$score['OutBox']+=$juniors[$key]['A']['OutBox'];
						$score['Maths']+=$juniors[$key]['A']['Maths'];
						$score['Crypto']+=$juniors[$key]['A']['Crypto'];
						$score['Logic']+=$juniors[$key]['A']['Logic'];
						$score['Analysis']+=$juniors[$key]['A']['Analysis'];

					}

				elseif(preg_replace('/\s+/','',$resp->{'q'.$key})=='B')
					{
						$score['OutBox']+=$juniors[$key]['B']['OutBox'];
						$score['Maths']+=$juniors[$key]['B']['Maths'];
						$score['Crypto']+=$juniors[$key]['B']['Crypto'];
						$score['Logic']+=$juniors[$key]['B']['Logic'];
						$score['Analysis']+=$juniors[$key]['B']['Analysis'];

					}

				elseif(preg_replace('/\s+/','',$resp->{'q'.$key})=='C')
					{
						$score['OutBox']+=$juniors[$key]['C']['OutBox'];
						$score['Maths']+=$juniors[$key]['C']['Maths'];
						$score['Crypto']+=$juniors[$key]['C']['Crypto'];
						$score['Logic']+=$juniors[$key]['C']['Logic'];
						$score['Analysis']+=$juniors[$key]['C']['Analysis'];

					}

				elseif(preg_replace('/\s+/','',$resp->{'q'.$key})=='D')
					{
						$score['OutBox']+=$juniors[$key]['D']['OutBox'];
						$score['Maths']+=$juniors[$key]['D']['Maths'];
						$score['Crypto']+=$juniors[$key]['D']['Crypto'];
						$score['Logic']+=$juniors[$key]['D']['Logic'];
						$score['Analysis']+=$juniors[$key]['D']['Analysis'];

					}
			}
			}catch(Exception $e){}
		}

	return $score;
	}

	public static function TechnalysisHauts($resp)
	{	
		// global $hauts,$answerHauts;
		$score=array('OutBox'=>0,'Maths'=>0,'Crypto'=>0,'Logic'=>0,'Analysis'=>0);
		$hauts = Techanalysis::$hauts;
		foreach(Techanalysis::$hauts as $key=>$values)
		{
			Log::info('QNo:'.$key.'\n'.$resp->roll.'\n');

			try{
			if(preg_replace('/\s+/','',$resp->{'q'.$key}) == '' || $resp->{'q'.$key} == NULL)
				continue;

			else if(is_numeric(preg_replace('/\s+/','',$resp->{'q'.$key})))
			{ 
				foreach($hauts[$key] as $k=>$v)
					if(intval($k)==intval($resp->{'q'.$key}))
					{
						$score['OutBox']+=$hauts[$key][$k]['OutBox'];
						$score['Maths']+=$hauts[$key][$k]['Maths'];
						$score['Crypto']+=$hauts[$key][$k]['Crypto'];
						$score['Logic']+=$hauts[$key][$k]['Logic'];
						$score['Analysis']+=$hauts[$key][$k]['Analysis'];
					}
			}

			else
			{
				if(preg_replace('/\s+/','',$resp->{'q'.$key})=='A')
					{
						$score['OutBox']+=$hauts[$key]['A']['OutBox'];
						$score['Maths']+=$hauts[$key]['A']['Maths'];
						$score['Crypto']+=$hauts[$key]['A']['Crypto'];
						$score['Logic']+=$hauts[$key]['A']['Logic'];
						$score['Analysis']+=$hauts[$key]['A']['Analysis'];

					}

				elseif(preg_replace('/\s+/','',$resp->{'q'.$key})=='B')
					{
						$score['OutBox']+=$hauts[$key]['B']['OutBox'];
						$score['Maths']+=$hauts[$key]['B']['Maths'];
						$score['Crypto']+=$hauts[$key]['B']['Crypto'];
						$score['Logic']+=$hauts[$key]['B']['Logic'];
						$score['Analysis']+=$hauts[$key]['B']['Analysis'];

					}

				elseif(preg_replace('/\s+/','',$resp->{'q'.$key})=='C')
					{
						$score['OutBox']+=$hauts[$key]['C']['OutBox'];
						$score['Maths']+=$hauts[$key]['C']['Maths'];
						$score['Crypto']+=$hauts[$key]['C']['Crypto'];
						$score['Logic']+=$hauts[$key]['C']['Logic'];
						$score['Analysis']+=$hauts[$key]['C']['Analysis'];

					}

				elseif(preg_replace('/\s+/','',$resp->{'q'.$key})=='D')
					{
						$score['OutBox']+=$hauts[$key]['D']['OutBox'];
						$score['Maths']+=$hauts[$key]['D']['Maths'];
						$score['Crypto']+=$hauts[$key]['D']['Crypto'];
						$score['Logic']+=$hauts[$key]['D']['Logic'];
						$score['Analysis']+=$hauts[$key]['D']['Analysis'];

					}
			}
			} catch(Exception $e){}
		}

	return $score;
	}
	
}

?>