<?php

include_once($def_class_dir.'Rights.class.php');
include_once($def_class_dir.'Cast.class.php');

class		CastManager {
  private	$tree /* Cast */;
  private	$root /* string */;
  private	$rights /* Rights */;

  /* In most situation, it's not a good idea to initialize the CastManager with something else than the root / and its children */
  public function	__construct($bdd /* PDO Database */, $root = '/', $get_children = true) {
    $this->root = $root;
    if ($root == 'root')
      $root = '/';
    $this->rights = new Rights($bdd, $this);
    $this->tree = new Cast($bdd, $this->rights, $root, $get_children);
  }

  /* This function allow you to easily browse the tree using a lambda and an argument */
  public function	browseTree($fun /* See below */, $tree /* Cast */, &$arg = '' /* mixed */) {
    // fun must be a function :
    // - first argument : the node
    // - second argument : the argument
    $fun($tree, $arg);
    $children = $tree->getChildren();
    if (!empty($children))
      foreach ($children as $child)
	$this->browseTree($fun, $child, $arg);
  } /* No return value */

  /* Pretty print the tree */
  public function	debug_ShowTree($html = true) {
    if ($html)
      echo '<br />';
    echo "\n", '== Pretty Tree printer ==', "\n";
    if ($html)
      echo '<br />';
    $arg['html'] = $html;
    $this->browseTree(function ($cast, &$arg) {
	for ($i = 0; $i < $cast->getDepth(); $i++)
	  echo '-- ';
	echo '[',$cast->getId(),'] ';
	echo $cast->getName();
	if ($arg['html'])
	  echo '<br />';
	echo "\n";
	if (!($cast->isValid()))
	  echo 'Invalid branch';
      }, $this->tree, $arg);
    if ($html)
      echo '<br />';
    echo "\n", '== End ==', "\n";
    if ($html)
      echo '<br />';
  } /* No return value */

  /* Return an array of strings containing the tree with '--' to indent */
  public function	getPrintableArray() {
    $arg['result'] = array();
    $this->browseTree(function ($cast, &$arg) {
	if (!$cast->isValid())
	  return ;
	for ($i = 0; $i < $cast->getDepth(); $i++)
	  $name .= '-- ';
	$name .= $cast->getName();
	$arg['result'][$cast->getId()] = $name;
      }, $this->tree, $arg);
    return $arg['result'];
  } /* string array */

  /* Return an array containing the tree, a sort of flatten version of the tree */
  public function	getCastsArray($cast_root = false) {
    if ($cast_root === false)
      $cast_root = $this->tree;
    $arg = array();
    $this->browseTree(function ($cast, &$arg) {
	if (!$cast->isValid())
	  return ;
	$arg[] = $cast;
      }, $cast_root, $arg);
    return $arg;
  } /* cast array */

  private function	aux_getSimpleTree($tree /* Cast */) {
    if (!$tree->isValid())
      return ;
    $children_cast = $tree->getChildren();
    if (empty($children_cast))
      $children = array();
    else {
      foreach ($children_cast as $child)
	$children[$child->getName()] = $this->aux_getSimpleTree($child);
    }
    return $children;
  } /* string tree */

  /* Return a string only tree */
  public function	getSimpleTree() {
    return array($this->root => $this->aux_getSimpleTree($this->tree));
  } /* string tree */

  /* Return a Cast from a string name. You'd better use getCast. */
  public function	getCastFromName($name /* string */) {
    $arg = array('name'	=> $name);
    $this->browseTree(function ($cast, &$arg) {
	if (!($cast->isValid()))
	  return ;
	if ($cast->getName() == $arg['name'])
	  $arg['result'] = $cast;
      }, $this->tree, $arg);
    return $arg['result'];
  } /* Cast */

  /* Return a Cast from an int id. You'd better use getCast. */
  public function	getCastFromId($id /* int */) {
    $arg = array('id'	=> $id);
    $this->browseTree(function ($cast, &$arg) {
	if ($cast->getId() == $arg['id'])
	  $arg['result'] = $cast;
      }, $this->tree, $arg);
    return $arg['result'];
  } /* Cast */

  /* Take an information about the cast (name, id, ...) and return the corresponding Cast */
  public function	getCast($info = false/* name (string) || id (int) || array || Cast */) {
    if ($info === false)
      $info = $this->tree;
    elseif (is_object($info));
    elseif (is_array($info))
      $info = $this->getCastFromName($info['name']);
    elseif (is_numeric($info))
      $info = $this->getCastFromId($info);
    else
      $info = $this->getCastFromName($info);
    if (empty($info) || !($info->isValid()))
      return false;
    return $info;
  } /* Cast || false*/

  /* Check if the cast exists and return true or false */
  public function	isCast($info /* mixed */) {
    return $this->getCast($info) !== false;
  } /* bool */

  /* Add a sub-cast to a cast */
  public function	addCast($login /* string */, $parent_info /* mixed */, $name /* string */) {
    if (!($parent_info = $this->getCast($parent_info)))
      return false;
    return ($parent_info->addChild($login, $name));
  } /* bool */

  /* Delete a cast */
  public function	deleteCast($login /* string */, $info /* mixed */) {
    if (!($info = $this->getCast($info)))
      return false;
    return $info->delete($login);
  } /* bool */

  /* Add a member to a cast */
  public function	addCastMember($login /* string */, $cast /* mixed */, $login_to_add /* string */) {
    if (!($cast = $this->getCast($cast)))
      return false;
    return $cast->addMember($login, $login_to_add);
  } /* bool */

  /* Delete a member from a cast */
  public function	deleteCastMember($login /* string */, $cast /* mixed */, $login_to_del /* string */) {
    if (!($cast = $this->getCast($cast)))
      return false;
    return $cast->delMember($login, $login_to_del);
  } /* bool */

  /* Take a login and return an array containing all casts he is member of */
  public function	getMemberCasts($login /* string */) {
    $arg['casts'] = array();
    $arg['login'] = $login;
    $this->browseTree(function ($cast, &$arg) {
	if (!($cast->isValid()))
	  return ;
	$members = $cast->getMembers();
	if (in_array($arg['login'], $members))
	  $arg['casts'][] = $cast;
      }, $this->tree, $arg);
    return $arg['casts'];
  } /* Cast array */

}
