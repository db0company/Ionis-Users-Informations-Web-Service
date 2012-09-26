<?php

include_once($def_class_dir.'Cast.class.php');

class		CastManager
{
  private	$tree; // Cast
  private	$root;

  public function	__construct($bdd, $root = '/', $get_children = true)
  {
    $this->root = $root;
    if ($root == 'root')
      $root = '/';
    $this->tree = new Cast($bdd, $root, $get_children);
  }

  public function	browseTree($fun, $tree, &$arg = '')
  // fun must be a function :
  // - first argument : the node
  // - second argument : the argument
  {
    $fun($tree, $arg);
    $children = $tree->getChildren();
    if (!empty($children))
      foreach ($children as $child)
	$this->browseTree($fun, $child, $arg);
  }

  public function	debug_ShowTree()
  {
    echo "<br />== Pretty Tree printer ==<br />";
    $this->browseTree(function ($cast, $arg)
		      {
			for ($i = 0; $i < $cast->getDepth(); $i++)
			  echo '-- ';
			echo '[',$cast->getId(),'] ';
			echo $cast->getName().'<br />';
			if (!($cast->isValid()))
			  echo 'Invalid branch';
			$arg = $arg + 1;
		      }, $this->tree);
    echo "<br />== End ==<br />";
  }

  public function	getPrintableArray()
  {
    $arg['result'] = array();
    $this->browseTree(function ($cast, &$arg)
		      {
			if (!$cast->isValid())
			  return ;
			for ($i = 0; $i < $cast->getDepth(); $i++)
			  $name .= '-- ';
			$name .= $cast->getName();
			$arg['result'][$cast->getId()] = $name;
		      }, $this->tree, $arg);
    return ($arg['result']);
  }

  public function	getCastsArray()
  {
    $arg = array();
    $this->browseTree(function ($cast, &$arg)
		      {
			if (!$cast->isValid())
			  return ;
			$arg[] = $cast->getName();
		      }, $this->tree, $arg);
    return $arg;
  }

  private function getSimpleTree_aux($tree)
  {
    if (!$tree->isValid())
      return ;
    $children_cast = $tree->getChildren();
    if (empty($children_cast))
      $children = array();
    else {
      foreach ($children_cast as $child)
	$children[$child->getName()] = $this->getSimpleTree_aux($child);
    }
    return ($children);
  }

  public function	getSimpleTree()
  {
    return array($this->root => $this->getSimpleTree_aux($this->tree));
  }

  public function	getCastFromName($name)
  {
    $arg = array('name'	=> $name);
    $this->browseTree(function ($cast, &$arg)
		      {
			if ($cast->getName() == $arg['name'])
			  $arg['result'] = $cast;
		      }, $this->tree, $arg);
    return ($arg['result']);
  }

  public function	getCastFromId($id)
  {
    $arg = array('id'	=> $id);
    $this->browseTree(function ($cast, &$arg)
		      {
			if ($cast->getId() == $arg['id'])
			  $arg['result'] = $cast;
		      }, $this->tree, $arg);
    return ($arg['result']);
  }

  public function	addCast($parent_info,  // name (string) or id (int) or array or Cast object
				$name) // string
  {
    if (is_object($parent_info));
    elseif (is_array($parent_info))
      $parent_info = $this->getCastFromName($parent_info['name']);
    elseif (is_numeric($parent_info))
      $parent_info = $this->getCastFromId($parent_info);
    else
      $parent_info = $this->getCastFromName($parent_info);
    if (empty($parent_info) || !($parent_info->isValid()))
      return false;
    return ($parent_info->addChild($name));
  }

  public function	deleteCast($info) // name (string) or id (int) or array or Cast object
  {
    if (is_object($info));
    elseif (is_array($info))
      $info = $this->getCastFromName($info['name']);
    elseif (is_numeric($info))
      $info = $this->getCastFromId($info);
    else
      $info = $this->getCastFromName($info);
    if (empty($info) || !($info->isValid()))
      return (false);
    $info->delete();
    // todo: check rights
    return (true);
  }

  public function	getCastMembers($cast) // name (string) or id (int) or array or Cast object
  {
    if (is_object($cast));
    elseif (is_array($cast))
      $cast = $this->getCastFromName($cast['name']);
    elseif (is_numeric($cast))
      $cast = $this->getCastFromId($cast);
    else
      $cast = $this->getCastFromName($cast);
    if (empty($cast) || !($cast->isValid()))
      return false;
    return ($cast->getMembers());
  }

  public function	addCastMember($cast, $username) // same + string
  {    
    if (is_object($cast));
    elseif (is_array($cast))
      $cast = $this->getCastFromName($cast['name']);
    elseif (is_numeric($cast))
      $cast = $this->getCastFromId($cast);
    else
      $cast = $this->getCastFromName($cast);
    if (empty($cast) || !($cast->isValid()))
      return false;
    return ($cast->addMember($username));
  }

  public function	delCastMember($cast, $username)
  {
    if (is_object($cast));
    elseif (is_array($cast))
      $cast = $this->getCastFromName($cast['name']);
    elseif (is_numeric($cast))
      $cast = $this->getCastFromId($cast);
    else
      $cast = $this->getCastFromName($cast);
    if (empty($cast) || !($cast->isValid()))
      return false;
    return $cast->delMember($username);
    // todo: check rights
  }
}
