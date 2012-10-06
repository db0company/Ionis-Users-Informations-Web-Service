<?php

/* This Cast need a global instance of the class ionisInfo called $iui. */
/* To edit a cast, you should use the CastManager class. */

class		Cast {
  private	$bdd /* PDO Database */;
  private	$name /* string */;
  private	$id /* int */;
  private	$children /* array Cast */;
  private	$valid /* bool */;
  private	$depth /* int */;
  private	$members = false /* array string */;
  private	$rights /* Rights */;
  public	$par /* Cast */;

  public function	__construct($bdd /* PDO Database */, $rights /* Rights*/, $info /* string (name) || int (id) || array ('name' => string, 'id' => int) */,
				    $get_children = true, $depth = 0, $par = '' /* Cast */) {
    $this->bdd = $bdd;
    $this->rights = $rights;
    if (!is_array($info))
      {
	if (is_numeric($info))
	  $req = 'SELECT * FROM group_name WHERE id=?';
	else
	  $req = 'SELECT * FROM group_name WHERE name=?';
	$req = $this->bdd->prepare($req);
	$req->execute(array($info));
	if (!($req->rowCount()))
	  {
	    $this->valid = false;
	    return ;
	  }
	$info = $req->fetch();
      }
    $this->name = $info['name'];
    $this->id = $info['id'];
    $this->depth = $depth;
    $this->valid = true;
    $this->par = $par;
    if ($get_children)
      $this->generateChildren();
  }

  /* Generate sub casts */
  private function	generateChildren() {
    if (!$this->isValid())
      return array();
    $req = $this->bdd->prepare('SELECT a.* FROM group_assoc AS a JOIN group_name AS n WHERE a.id_child=n.id AND a.id_parent=? ORDER BY n.name');
    $req->execute(array($this->id));
    while ($child = $req->fetch())
      $children[] = $child;
    if (!empty($children))
      foreach ($children as $child)
	$this->children[] = new Cast($this->bdd, $this->rights, $child['id_child'], true, ($this->depth + 1), $this);
  } /* No return value */

  public function	isValid() {
    return $this->valid;
  } /* bool */

  public function	getName() {
    return $this->isValid() ? $this->name : false;
  } /* string || false */

  public function	getId() {
    return $this->isValid() ? $this->id : false;
  } /* int || false */

  public function	getDepth() {
    return $this->isValid() ? $this->depth : false;
  } /* int || false */

  public function	getChildren() {
    return $this->isValid() ? $this->children : array();
  } /* Cast Array */

  private function	checkRightForSelfAndParents($login /* string*/, $right_type /* string */) {
    if ($this->rights->checkRightFromLogin($login, $right_type, $this->id))
      return true;
    $parents = $this->getParents();
    if (!empty($parents))
      foreach ($parents as $parent)
	if ($this->rights->checkRightFromLogin($login, $right_type, $parent->id))
	  return true;
    return false;
  }

  /* Add a new sub cast (in DB + in tree) + check right */
  public function	addChild($login /* string */, $name /* string */) {
    // check validity
    if (!$this->isValid())
      return false;
    $valid = array('-', '_');
    if(empty($name) || !ctype_alnum(str_replace($valid, '', $name)))
      return false;

    // check rights
    if (!$this->checkRightForSelfAndParents($login, 'ADD_DEL_CAST'))
      return false;

    // insert cast in db
    $req = $this->bdd->prepare('INSERT INTO group_name(name) VALUES(?)');
    try { $req->execute(array($name)); }
    catch (Exception $e) { return false; }

    // insert parent association in db
    $req = $this->bdd->prepare('INSERT INTO group_assoc(id_parent, id_child) VALUES(?, ?)');
    try { $req->execute(array($this->id, $this->bdd->lastInsertId())); }
    catch (Exception $e) { return false; }

    // update tree
    $this->children[] = new Cast($this->bdd, $this->rights, $name, true, ($this->depth + 1), $this);
    return true;
  } /* bool */

  /* Delete one of my child (association only) */
  /* You'd better not use this function but use delete */
  public function	deleteChild($child /* Cast */) {
    // check validity
    if (!$this->isValid())
      return ;
    // delete assoc from db
    $req = $this->bdd->prepare('DELETE FROM group_assoc WHERE id_parent=? AND id_child=?');
    $req->execute(array($this->id, $child->getId()));
    // create a new array of children without this one
    $newChildren = array();
    foreach ($this->children as $mychild)
      if ($mychild->getId() != $child->getId())
	$newChildren[] = $mychild;
    $this->children = $newChildren;
  } /* No return value */

  /* Delete itself (in DB + in tree + delete members) */
  /* It's not deleting rights */
  public function	delete($login /* string */) {
    // todo: delete all rights
    // check validity
    if (!$this->isValid())
      return false;

    // check rights
    if (!$this->checkRightForSelfAndParents($login, 'ADD_DEL_CAST'))
      return false;

    // delete all children
    if (!empty($this->children))
      foreach ($this->children as $child)
	$child->delete();

    // delete members
    $this->getMembers();
    if (!empty($this->members))
      foreach ($this->members as $member)
	$this->delMember($member);

    // delete association with my children
    $req = $this->bdd->prepare('DELETE FROM group_assoc WHERE id_parent=?');
    $req->execute(array($this->id));
    // delete myself
    $req = $this->bdd->prepare('DELETE FROM group_name WHERE id=?');
    $req->execute(array($this->id));

    // delete association with my parent (i'm not your son anymore!)
    $this->par->deleteChild($this);

    // now I'm invalid
    $this->valid = false;
    return true;
  } /* bool */

  /* Add a member to the cast (+ check if login exists) */
  public function	addMember($login /* string */, $login_to_add /* string*/) {
    global $iui;
    if (!$this->checkRightForSelfAndParents($login, 'ADD_DEL_MEMBERS_CAST'))
      return false;
    $this->getMembers();
    if (!$this->isValid() || empty($login_to_add) || !$iui->isLogin($login_to_add))
      return false;
    $req = $this->bdd->prepare('INSERT INTO group_member(id_group, login) VALUES(?, ?)');
    try { $req->execute(array($this->id, $login_to_add)); }
    catch (Exception $e) { return false; }
    $this->members[] = $login_to_add;
    return true;
  } /* bool */

  /* Delete a member from the cast */
  public function	delMember($login, $login_to_del /* string */) {
    if (!$this->checkRightForSelfAndParents($login, 'ADD_DEL_MEMBERS_CAST'))
      return false;
    $this->getMembers();
    if (!$this->isValid())
      return false;
    $req = $this->bdd->prepare('DELETE FROM group_member WHERE id_group = ? AND login = ?');
    if (!($req->execute(array($this->id, $login_to_del))) || !$req->rowCount())
      return false;
    $new_members = array();
    if (!empty($this->members))
      foreach ($this->members as $member)
	if ($member != $login_to_del)
	  $new_members[] = $member;
    $this->members = $new_members;
    return true;
  } /* bool */

  /* Return an array containing the members of the cast */
  public function	getMembers() {
    if ($this->members === false)
      {
	$this->members = array();
	$req = $this->bdd->prepare('SELECT login FROM group_member WHERE id_group = ? ORDER BY login');
	if (!($req->execute(array($this->id))))
	  return $this->members;
	while ($member = $req->fetch())
	  $this->members[] = $member['login'];
      }
    return $this->isValid() ? $this->members : array();
  } /* string array */

  /* Return an array containing all the parents of the cast */
  public function	getParents() {
    $cast = $this;
    do {
      $par = $cast->par;
      if (!empty($par))
	$parents[] = $par;
      $cast = $cast->par;
    } while (!empty($par));
    if (empty($parents))
      return $parents;
    return array_reverse($parents);
  } /* Cast array */

  /* Return a string corresponding to all parents seperated by a / */
  public function	getParentsString() {
    $parents = $this->getParents();
    $str = '';
    if (!empty($parents))
      foreach ($parents as $par) {
	$str .= $par->getName().'/';
      }
    return $str;
  } /* string */

  /* Return the very first parent of the cast but not the root */
  /* Example: //Toto/Tata/TheCast return Toto (not /) */
  public function	getFirstParentName() {
    $parents = $this->getParents();
    if (empty($parents) || !isset($parents[1]))
      return $this->getName();
    return $parents[1]->getName();
  } /* string */

}
