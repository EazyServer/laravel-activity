<?php namespace Dmyers\Activity\Adapter;

// currently unused

abstract class Base
{
	abstract public function find(array $params);
	
	abstract public function create(array $params);
	
	abstract public function update($id, array $params);
	
	abstract public function delete($id);
}