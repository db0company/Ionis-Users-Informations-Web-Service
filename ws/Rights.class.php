<?php

class		Rights {
  private	$bdd /* PDO Database */;
  private	$casts /* CastManager */;
  private	$types /* string array */;

  public function	__construct($bdd /* PDO Database */, $casts /* CastManager */) {
    $this->bdd = $bdd;
    $this->casts = $casts;
    $this->types = $this->getRightTypesFromDB();
  }

  /* Get right types from DB. You'd better use getRightType, it's faster */
  public function	getRightTypesFromDB() {
    // get rights
    $req = $this->bdd->prepare('SELECT name FROM right_type ORDER BY name');
    $req->execute();
    while ($right_type = $req->fetch())
      $right_types[] = $right_type['name'];

    // get combo rights
    $req = $this->bdd->prepare('SELECT name FROM right_combo ORDER BY name');
    $req->execute();
    while ($right_type = $req->fetch())
      $right_types[] = $right_type['name'];

    $this->types = $right_types;
    return $right_types;
  } /* string array */

  /* Get right types */
  public function	getRightTypes() {
    return $this->types;
  } /* string array */

  /* return an array containing all rights of a cast */
  public function	getCastRights($cast /* mixed */) {
    if (!($cast = $this->casts->getCast($cast)))
      return false;
    // this request is getting the name of the cast, so if the cast has been deleted, the right will not be return, so it's safe to not delete right while deleting casts
    $req = $this->bdd->prepare('SELECT r.*, c.name FROM rights AS r JOIN group_name AS c WHERE c.id=r.id_cast AND r.id_cast=?');
    $req->execute(array($cast->getId()));
    $rights = $req->fetchAll();
    $result_rights = array();
    foreach ($rights as $right) {
      $right['details'] =
	$this->getRealRightDetails($right['right_type'],
				   $right['details']);
      $result_rights[] = $right;
    }
    return $result_rights;
  } /* array ('right_type' => string,
              'id_cast' => int,
	      'name' => string,
	      'details' => array);
    || false */

  /* Take the type of the rights and the string for the details and return an array of detail_type => detail */
  private function	getRightDetails($right_type /* string || int */, $detailsinfos /* array */) {
    if (!$detailtypes = $this->getRightDetailTypes($right_type))
      return false;
    try { $result = array_combine($detailtypes, $detailsinfos); }
    catch (Exception $e) { return false; }
    if (!$this->checkRightDetailsValidity($result))
      return false;
    return $result;
  } /* (string => string) array || false */

  /* Get right details and transform to their real usable values */
  public function	getRealRightDetails($right_type /* string */, $details /* string */) {
    $details_raw =
      $this->getRightDetails($right_type, $this->smtoarr($details));
    if ($details_raw === false)
      return false;
    $details = array();
    foreach ($details_raw as $detail_type => $detail) {
      if ($detail_type == 'cast')
	$details[$detail_type] = $this->casts->getCast($detail);
      elseif ($detail_type == 'right_type')
	$details[$detail_type] = $detail;
    }
    return $details;
  } /* (string => mixed) array || false */

  /* Check if the right exists and return true or false */
  public function	isRight($right_type /* string */) {
    return $this->getRightDetailTypes($right_type) !== false;
  } /* bool */
  
  /* Take an array of detail_type => detail_content and check if its valid (example: check if cast exists) */
  public function	checkRightDetailsValidity($details /* (string => string) array */) {
    if (!empty($details)) {
      foreach ($details as $detail_type => $detail) {
	if ($detail_type == 'cast') {
	  if ($this->casts->getCast($detail) === false)
	    return false;
	}
	elseif ($detail_type == 'right_type') {
	  if (!$this->isRight($detail))
	    return false;
	}
	else
	  return false;
      }
    }
    return true;
  } /* bool */

  /* Take a string with words separated by semicolomns and return an array of words */
  private function	smtoarr($text /* string */) {
    return explode(';', $text);
  } /* string array */

  /* Take an array of words and return a string with words separated by semicolomns */
  private function	arrtosm($arr /* string array */) {
    return implode(';', $arr);
  } /* string */

  private function	aux_getRightDetailTypes_check_db($db /* string */, $right_type /* string */) {
    $req = $this->bdd->prepare('SELECT details FROM '.$db.' WHERE name=?');
    try { $req->execute(array($right_type)); }
    catch (Exception $e) { return false; }
    $result = $req->fetchAll(PDO::FETCH_COLUMN, 0);
    if (empty($result))
      return false;
    return reset($result); /* get the first element */
  } /* string || false */

  /* Take a right name and return an array containing required details */
  public function	getRightDetailTypes($right_type /* string */) {
    if ((!($result = $this->aux_getRightDetailTypes_check_db('right_type', $right_type))
	 && !($result = $this->aux_getRightDetailTypes_check_db('right_combo', $right_type))))
      return false;
    return $this->smtoarr($result);
  } /* string array || false */

  /* Take a right type, check if its a combo, return false if not, otherwise return an array containing right_types of the combo */
  public function	getCombo($right_type /* string */) {
    $req = $this->bdd->prepare('SELECT contain from right_combo WHERE name=?');
    $req->execute(array($right_type));
    $result = $req->fetchAll(PDO::FETCH_COLUMN, 0);
    if (empty($result))
      return false;
    return $this->smtoarr(reset($result));
  } /* string array || false */

  private function	aux_addRight($right_type /* string */, $cast /* Cast */, $details /* string */) {
    $req = $this->bdd->prepare('INSERT INTO rights(right_type, id_cast, details) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE id=id');
    try { $req->execute(array($right_type, $cast->getId(), $details)); }
    catch (Exception $e) { echo $e;return false; }
    return true;
  } /* bool */

  private function	detailsToArray($details /* string || array */) { 
    if (empty($details))
      $details = array();
    elseif (!is_array($details))
      $details = $this->smtoarr($details);
    return $details;
  } /* string array */

  // This function check if you have the right to add the right (rightception!)
  public function	aux_addRight_checkright($login /* string */, $right_type /* string*/,
						$cast /* Cast */) {
    // check me
    if ($this->checkRightFromLogin($login, 'GIVE_RIGHT_TO_CAST',
				   array('right_type' => $right_type,
					 'cast' => $cast->getId())))
      return true;
    // check my parents
    $parents = $cast->getParents();
    if (!empty($parents))
      foreach ($parents as $parent)
	if ($this->checkRightFromLogin($login, 'GIVE_RIGHT_TO_CAST',
				       array('right_type' => $right_type,
					     'cast' => $parent->getId())))
	  return true;
    return false;
  } /* bool */

  /* Add a right to a cast after checking its validity*/
  public function	addRight($login /* string */, $right_type /* string || int */, $cast /* mixed */, $details /* mixed */) {
    $details = $this->detailsToArray($details);

    // check cast validity
    if (($cast = $this->casts->getCast($cast)) == false)
      return false;

    // check right details validity
    // + it's also checking right_type validity
    if (!$this->getRightDetails($right_type, $details))
      return false;

    // check right to add this right
    if (!$this->aux_addRight_checkright($login, $right_type, $cast))
      return false;

    // if the right is to give a right to a combo
    if ($right_type == 'GIVE_RIGHT_TO_CAST'
	&& ($combo = $this->getCombo($details['right_type']))) {
      foreach ($combo as $right_type)
	if (!$this->aux_addRight('GIVE_RIGHT_TO_CAST',
				 $cast,
				 $this->arrtosm(array('right_type' => $right_type,
						      'cast' => $details['cast']))))
	  return false;
      return true;
    }
    $details = $this->arrtosm($details);

    // insert rights of the combo or single right
    if (($combo = $this->getCombo($right_type))) {
      foreach ($combo as $right_type)
	if (!$this->aux_addRight($right_type, $cast, $details))
	  return false;
      return true;
    }
    return $this->aux_addRight($right_type, $cast, $details);
  } /* bool */

  /* This function return the list of right you can delete */
  public function	getDeletableRights($login /* string */) {
    $casts = $this->casts->getMemberCasts($login);
    if (empty($casts))
      return array();
    // test for each cast I'm in
    foreach ($casts as $cast) {

      // get all give_right I have
      $req = $this->bdd->prepare('SELECT details FROM rights WHERE right_type=? AND id_cast=?');
      $req->execute(array('GIVE_RIGHT_TO_CAST', $cast->getId()));

      while ($right = $req->fetch()) {
	$details = $this->smtoarr($right['details']);
	$right_type = $details[0];
	$cast_right_deletable = $this->casts->getCast($details[1]);

	// get all sub casts rights deletable
	$children = $this->casts->getCastsArray($cast_right_deletable);
	$children[] = $cast_right_deletable;

	foreach ($children as $cast_right_deletable) {
	  $req_getrights = $this->bdd->prepare('SELECT r.*, c.name FROM rights AS r JOIN group_name AS c WHERE r.id_cast=c.id AND r.right_type=? AND r.id_cast=?');
	  $req_getrights->execute(array($right_type, $cast_right_deletable->getId()));
	  while ($right = $req_getrights->fetch()) {
	    $right['details'] =
	      $this->getRealRightDetails($right['right_type'],
					 $right['details']);
	    $rights[$cast_right_deletable->getName()][] = $right;
	  }
	}
      }
    }
    return $rights;
  } /* array ($cast_name => array('name' => $cast_name,
                                  'right_type' => string,
				  'details' => mixed array,
				  'id' => int))*/

  /* This function is called after checking if the right is deletable. It's deleting it. For real. */
  private function	aux_deleteRight($id /* int */) {
    $req = $this->bdd->prepare('DELETE FROM rights WHERE id=?');
    try { $req->execute(array(intval($id))); }
    catch (Exception $e) { return false; }
    if (!$req->rowCount())
      return false;
    return true;
  }

  /* Delete a right using its id */
  public function	deleteRight($login /* string */, $id /* int */) {
    $id = intval($id);

    $deletable = $this->getDeletableRights($login);
    if (empty($deletable))
      return false;
    foreach ($deletable as $cast => $rights)
      if (!empty($rights))
	foreach ($rights as $right)
	  if ($right['id'] == $id)
	    return $this->aux_deleteRight($id);
    return false;
  } /* bool */

  /* Check if this cast has this right with these details */
  public function	checkRight($cast /* mixed */, $right_type /* string */, $details /* mixed */) {
    $cast = $this->casts->getCast($cast);
    $details = $this->detailsToArray($details);

    $tmp = ($this->casts->getCast($details['cast']));
    // echo '## Checking right for ', $cast->getName(), ' type ', $right_type,
    //   ' details: (cast) ', ($tmp->getName()), ' (right_type) ', $details['right_type'],'<br />';
    $req = $this->bdd->prepare('SELECT * FROM rights WHERE right_type=? AND id_cast=? AND details=?');
    $req->execute(array($right_type, $cast->getId(), $this->arrtosm($details)));
    return $req->rowCount() ? true : false;
  } /* bool */

  /* Check if this login has this right with these details */
  public function	checkRightFromLogin($login /* string */, $right_type /* string */, $details /* mixed */) {
    $casts = $this->casts->getMemberCasts($login);
    if (empty($casts))
      return false;
    foreach ($casts as $cast)
      if ($this->checkRight($cast, $right_type, $details))
	return true;
    return false;
  } /* bool */

  }
