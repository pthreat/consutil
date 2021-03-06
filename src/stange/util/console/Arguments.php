<?php

	namespace stange\util\console{

		use \stange\util\console\Argument;

		class Arguments{

			private	$arguments			=	Array();
			private	$options				=	Array();
			private	$separators			=	Array('long'=>'--','short'=>'-');

			public function __construct(Array $options=Array(),$shortSeparator='-',$longSeparator='--'){

				if(empty($options)){

					$options	=	$_SERVER['argv'];

				}

				if($options[0]==$_SERVER['argv'][0]){

					unset($options[0]);

				}

				$this->__parseArguments($options);

			}

			private function __isOption($value){

					$isLong	=	substr($value,0,2) == $this->separators['long'];

					if($isLong){

						return 'long';

					}

					$isShort	=	substr($value,0,1) == $this->separators['short'];

					if($isShort){

						return 'short';

					}

					return NULL;

			}

			private function __parseArguments(Array $arguments){
	
				$arguments	=	array_values($arguments);
				$size			=	sizeof($arguments);

				for($num=0;$num<$size;$num++){

					$value	=	$arguments[$num];

					$type	=	$this->__isOption($value);

					if(!$type){

						continue;

					}

					switch($type){

						case 'short':

							$name		=	substr($value,1);

							if(isset($arguments[$num+1])){

								$value	=	$arguments[$num+1];
								$num++;

							}else{

								$value	=	NULL;

							}

						break;

						case	'long':
							$name		=	substr($value,2);
							$equal	=	strpos($name,'=');
							$value	=	$equal	?	substr($name,$equal+1)	:	NULL;
							$name		=	$equal	?	substr($name,0,$equal)	:	$name;
						break;

					}

					if($this->__isOption($value)){

						continue;

					}

					$this->arguments[]	=	new Argument($name,$type,$value);

				}

			}

			public function getArguments(){

				return $this->arguments;

			}

			private function __validateSeparatorType($type){

				if(!array_key_exists($type,$this->separators)){

					throw new \InvalidArgumentException(sprintf('Invalid separator type, must be one of: %s',implode(',',array_keys($this->separators))));

				}

				return $type;

			}

			public function setSeparator($separator,$type='short'){

				$this->separators[$this->__validateSeparatorType($type)]	=	$separator;
				return $this;

			}

			public function getSeparator($type){

				return $this->separators[$this->__validateSeparatorType($type)];

			}

			public function find($args){

				$args	=	func_get_args();

				foreach($this->arguments as $num=>$argument){

					if(in_array($argument->getName(),$args)){

						return $argument;

					}

				}

				return NULL;

			}

		}

	}

