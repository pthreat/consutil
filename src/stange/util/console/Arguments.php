<?php

	namespace stange\util\console{

		use \stange\util\console\Argument;

		class Arguments{

			private	$parsedArguments	=	Array();
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
					$isShort	=	substr($value,0,1) == $this->separators['short'];

					if($isLong){

						return 'long';

					}

					if($isShort){

						return 'short';

					}

					return NULL;

			}

			private function __parseArguments(Array $arguments){

				foreach($arguments as $num=>$value){

					$type	=	$this->__isOption($value);

					switch($type){

						case 'short':
							$name		=	substr($value,1);
							$value	=	isset($arguments[$num+1]) ? $arguments[$num+1]	:	NULL;
						break;

						case	'long':
							$name		=	substr($value,2);
							$equal	=	strpos($name,'=');
							$value	=	$equal	?	substr($name,$equal+1)	:	NULL;
							$name		=	$equal	?	substr($name,0,$equal)	:	$name;
						break;

					}

					if($this->__isOption($value)){

						$value	=	NULL;

					}

					$this->parsedArguments[]	=	new Argument($name,$type,$value);

				}

			}

			public function getParsedArguments(){

				return $this->parsedArguments;

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

			public function find($name){

				foreach($this->options as $num=>$option){

					foreach($this->arguments as $arg){

						if($isShort && $arg->getShortName() == $option){

							$option->validate($value);

						}

					}

				}

			}

		}

	}

