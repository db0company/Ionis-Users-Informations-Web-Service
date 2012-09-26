<?php

class		Cast
{
  private	$bdd;
  private	$name; // string
  private	$id; // int
  private	$children; // array Cast
  private	$valid; // bool
  private	$depth; // int
  private	$members = false; // array string
  public	$par; // Cast

  public function	__construct($bdd, $info, $get_children = true, $depth = 0, $par = '')
  // name (string) or id (int)
  // or array ('name' => string, 'id' => int
  {
    $this->bdd = $bdd;
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

  private function	generateChildren()
  {
    if (!$this->isValid())
      return (array());
    // todo: only one request?
    $req = $this->bdd->prepare('SELECT * FROM group_assoc WHERE id_parent=?');
    $req->execute(array($this->id));
    while ($child = $req->fetch())
      {
	$this->children[] = new Cast($this->bdd, $child['id_child'], true, ($this->depth + 1), $this);
      }
  }

  public function	isValid()
  {
    return ($this->valid);
  }

  public function	getName()
  {
    return ($this->isValid() ? $this->name : '');
  }

  public function	getId()
  {
    return ($this->isValid() ? $this->id : 0);
  }

  public function	getDepth()
  {
    return ($this->isValid() ? $this->depth : 0);
  }

  public function	getChildren()
  {
    return ($this->isValid() ? $this->children : array());
  }

  public function	addChild($name) // string
  {
    if (!$this->isValid())
      return (false);
    // todo: check name validity, return false
    $req = $this->bdd->prepare('INSERT INTO group_name(name) VALUES(?)');
    if (!($req->execute(array($name))))
      return (false);
    $req = $this->bdd->prepare('INSERT INTO group_assoc(id_parent, id_child) VALUES(?, ?)');
    if (!($req->execute(array($this->id, $this->bdd->lastInsertId()))))
      return (false);
    $this->children[] = new Cast($this->bdd, $name, true, ($this->depth + 1), $this);
    return (true);
  }

  public function	deleteChild($child)
  {
    if (!$this->isValid())
      return ;
    $req = $this->bdd->prepare('DELETE FROM group_assoc WHERE id_parent=? AND id_child=?');
    $req->execute(array($this->id, $child->getId()));
    // create a new array of children without this one
    $newChildren = array();
    foreach ($this->children as $mychild)
      if ($mychild->getId() != $child->getId())
	$newChildren[] = $mychild;
    $this->children = $newChildren;
  }

  public function	delete()
  {
    if (!$this->isValid())
      return ;
    if (!empty($this->children))
      foreach ($this->children as $child)
	$child->delete();
    $req = $this->bdd->prepare('DELETE FROM group_assoc WHERE id_parent=?');
    $req->execute(array($this->id));
    $req = $this->bdd->prepare('DELETE FROM group_name WHERE id=?');
    $req->execute(array($this->id));
    $this->par->deleteChild($this);
    $this->valid = false;
  }

  public function	addMember($username) //string
  {
    global		$iui;

    $this->getMembers();
    if (!$this->isValid() || !$iui->isLogin($username))
      return (false);
    $req = $this->bdd->prepare('INSERT INTO group_member(id_group, login) VALUES(?, ?)');
    if (!($req->execute(array($this->id, $username))))
      return (false);
    $this->members[] = $username;
    return (true);    
  }

  public function	delMember($username) //string
  {
    $this->getMembers();
    if (!$this->isValid())
      return false;
    $req = $this->bdd->prepare('DELETE FROM group_member WHERE id_group = ? AND login = ?');
    if (!($req->execute(array($this->id, $username))) || !$req->rowCount())
      return false;
    $new_members = array();
    if (!empty($this->members))
      foreach ($this->members as $member)
	if ($member != $username)
	  $new_members[] = $member;
    $this->members = $new_members;
    return true;
  }

  public function	getMembers()
  {
    if ($this->members === false)
      {
	$this->members = array();
	$req = $this->bdd->prepare('SELECT login FROM group_member WHERE id_group = ? ORDER BY login');
	if (!($req->execute(array($this->id))))
	  return $this->members;
	while ($member = $req->fetch())
	  $this->members[] = $member['login'];
      }
    return ($this->isValid() ? $this->members : array());
  }
}
