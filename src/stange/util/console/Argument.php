<?php

	namespace stange\util\console{

		class Argument{

			private	$name		=	NULL;
			private	$value	=	NULL;
			private	$type		=	NULL;

			public function __construct($name,$type=NULL,$value=NULL){

				$this->setName($name);
				$this->setType($type);
				$this->setValue($value);

			}

			public function setName($name){

				$this->name	=	$name;
				return $this;

			}

			public function getName(){

				return $this->name;

			}

			public function setValue($value){

				$this->value	=	$value;
				return $this;

			}

			public function getValue(){

				return $this->value;

			}

			public function setType($type){

				if(!in_array($type,Array('long','short'))){

					throw new \InvalidArgumentException('Invalid argument type, must be one of: long or short');

				}

				$this->type	=	$type;

				return $this;

			}

			public function getType(){

				return $this->type;

			}

			public function __toString(){

				return $this->getName();

			}

		}

	}
