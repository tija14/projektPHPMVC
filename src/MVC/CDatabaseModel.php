<?php

namespace Anax\MVC;
 

/**
 * Model for Users.
 *
 */
class CDatabaseModel implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
	\Anax\MVC\TRedirectHelpers;
	
	
	
	 
/**
 * Get the table name.
 *
 * @return string with the table name.
 */
public function getSource()
{
    return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
}
/**
 * Find and return all.
 *
 * @return array
 */
public function findAll()
{
    $this->db->select()
             ->from($this->getSource())
			 ;
 
    $this->db->execute();
    $this->db->setFetchModeClass(__CLASS__);
    return $this->db->fetchAll();
}
/**
 * Get object properties.
 *
 * @return array with object properties.
 */
public function getProperties()
{
    $properties = get_object_vars($this);
    unset($properties['di']);
    unset($properties['db']);
 
    return $properties;
}

 
    /** 
     * Set object properties. 
     * 
     * @param array $properties with properties to set. 
     * 
     * @return void 
     */ 
 public function setProperties($properties) 
    { 
        // Update object with incoming values, if any 
        if (!empty($properties)) { 
            foreach ($properties as $key => $val) { 
                $this->$key = $val; 
            } 
        } 
    } 
/**
 * List user with id.
 *
 * @param int $id of user to display
 *
 * @return void
 */
public function idAction($id = null)
{
    $this->users = new \Anax\Users\User();
    $this->users->setDI($this->di);
 
    $user = $this->users->find($id);
 
    $this->theme->setTitle("View user with id");
    $this->views->add('users/view', [
        'user' => $user,
    ]);
}

/**
 * Find and return specific.
 *
 * @return this
 */
public function find($id)
{
    $this->db->select()
             ->from($this->getSource())
             ->where("id = ?");
 
    $this->db->execute([$id]);
    return $this->db->fetchInto($this);
	/*
	$res = $this->query() 
        ->where('id = ?') 
        ->execute([$id]);  
		return $res;*/
	
}

public function findAcronym($acronym)
{
    $this->db->select()
             ->from($this->getSource())
             ->where("acronym = ?");
 
    $this->db->execute([$acronym]);
    return $this->db->fetchInto($this);
}

public function login($acronym)
{
	 $this->db->select() 
        ->from($this->getSource()) 
        ->where("acronym = ?");
        //->andWhere('password = ?'); 
		
		
		$this->db->execute([$acronym]);  
        $res = $this->db->fetchInto($this); 
		return $res;
		
		/*
		$sql = "
		SELECT *
		FROM user
		WHERE acronym = ?
		";
		
		$params = array($acronym);
		$res = $this->db->executeFetchAll($sql, $params);
		return $res;*/
		
		

}



/**
 * Save current object/row.
 *
 * @param array $values key/values to save or empty to use object properties.
 *
 * @return boolean true or false if saving went okey.
 */
public function save($values = [])
{
    $this->setProperties($values);
    $values = $this->getProperties();
	
    if (isset($values['id'])) {
        return $this->update($values);
    } else {
        return $this->create($values);
    }
}

/**
 * Create new row.
 *
 * @param array $values key/values to save.
 *
 * @return boolean true or false if saving went okey.
 */
public function create($values)
{
    $keys   = array_keys($values);
    $values = array_values($values);
 
    $this->db->insert(
        $this->getSource(),
        $keys
    );
 
    $res = $this->db->execute($values);
 
    $this->id = $this->db->lastInsertId();
	
 
    return $res;
}

/**
 * Update row.
 *
 * @param array $values key/values to save.
 *
 * @return boolean true or false if saving went okey.
 */
public function update($values)
{
    $keys   = array_keys($values);
    $values = array_values($values);
 
    // Its update, remove id and use as where-clause
    unset($keys['id']);
    $values[] = $this->id;
 
    $this->db->update(
        $this->getSource(),
        $keys,
        "id = ?"
    );
 
    return $this->db->execute($values);
}

/**
 * Delete row.
 *
 * @param integer $id to delete.
 *
 * @return boolean true or false if deleting went okey.
 */
public function delete($id)
{
    $this->db->delete(
        $this->getSource(),
        'id = ?'
    );
 
    return $this->db->execute([$id]);
	/*
	$sql = "
	DELETE *
	FROM comment
	WHERE id = ?
	";
	
	$params = array($id);
	$this->db->executeFetchAll($sql, $params);*/
}

public function deleteParent($id){
	
	$sql = "
	
	SET FOREIGN_KEY_CHECKS = 0;
	drop table if comment;
	drop table if tag;
	drop table if comment2tag;
	SET FOREIGN_KEY_CHECKS = 1;
	";
	
	
	$params = array($id);
	$this->db->executeFetchAll($sql, $params);
	/*
	$sql = "
	DELETE *
	FROM comment2tag
	WHERE idComment = ?;
	";
	
	$params = array($id);
	$this->db->executeFetchAll($sql, $params);*/
	
	

}

public function deleteComments($id){
	
	$sql = "
	DELETE 
	FROM subcomment
	WHERE comment_id = ?
	";
	
	$params = array($id);
	$this->db->executeFetchAll($sql,$params);


}


/**
 * Build a select-query.
 *
 * @param string $columns which columns to select.
 *
 * @return $this
 */
public function query($columns = '*')
{
    $this->db->select($columns)
             ->from($this->getSource());
 
    return $this;
}

/**
 * Build the where part.
 *
 * @param string $condition for building the where part of the query.
 *
 * @return $this
 */
public function where($condition)
{
    $this->db->where($condition);
 
    return $this;
}

/**
 * Build the where part.
 *
 * @param string $condition for building the where part of the query.
 *
 * @return $this
 */
public function andWhere($condition)
{
    $this->db->andWhere($condition);
 
    return $this;
}

/**
 * Execute the query built.
 *
 * @param string $query custom query.
 *
 * @return $this
 */
public function execute($params = [])
{
    $this->db->execute($this->db->getSQL(), $params);
    $this->db->setFetchModeClass(__CLASS__);
 
    return $this->db->fetchAll();
}

public function getPage($pageId){

	/*$this->db->select()
             ->from($this->getSource())
             ->where("pageId = ?");
			 
 
    $this->db->execute([$pageId]);
    return $this->db->fetchInto($this);
	*/
	$res = $this->query() 
        ->where('pageId = ?')
		
        ->execute([$pageId]);  
		return $res;
}

public function getUsersLatestLogin(){
	
	$sql = "
	SELECT *
	FROM user
	ORDER BY active DESC
	";
	
	$res = $this->db->executeFetchAll($sql);
	return $res;


}

public function getMostActiveUsers(){
	
	$sql = "
	SELECT *
	FROM user
	ORDER BY count_loggedin DESC
	LIMIT 5
	";
	
	$res = $this->db->executeFetchAll($sql);
	return $res;


}


public function getMostPopularTags(){

	
	$sql = "
	SELECT DISTINCT tag,
	COUNT(idTag) AS count
	FROM tags
	JOIN comment2tag AS c2t
	ON tags.id = c2t.idTag
	GROUP BY tags.id
	ORDER BY count DESC
	";
	
	$res = $this->db->executeFetchAll($sql);
	return $res;

}

public function findQuestions(){


	$sql = "
	SELECT *
	FROM comment
	ORDER BY created DESC
	LIMIT 3
	
	";
	
	$res = $this->db->executeFetchAll($sql);
	return $res;
	
	}
	
public function findAllQuestions(){


	$sql = "
	SELECT *
	FROM comment
	ORDER BY created DESC
	
	
	";
	
	$res = $this->db->executeFetchAll($sql);
	return $res;
	
	}

public function getComment($id){

	$res = $this->query() 
        ->where('id = ?')
		
        ->execute([$id]);  
		return $res;
	
	

}
public function getAnswers($id){

	
	$sql = "
	SELECT sc.content, sc.created, user.email, user.acronym, sc.cid, sc.comment_id
	FROM comment
	JOIN subcomment AS sc
	ON comment.id = sc.comment_id
	INNER JOIN user 
	ON sc.user_id = user.id
	WHERE sc.type='answer'
	AND sc.comment_id = ?
	
	";
	
	
	$params = array($id);
	$subcomment = $this->db->executeFetchAll($sql, $params);
	/*$res = array();
	foreach($subcomment as $sub) {
		if($sub->comment_id == $id) {
			array_push($res, $sub);
		}
	}*/
	return $subcomment;

}
public function getCommentOnAnswer($commentId) {
	
	$aid = $this->getCommentId($commentId);
	$result = array();
	foreach($aid as $key => $value) {
		$result[] = $value->cid;
		
	}
	
	$res = array();
	
	foreach($result as $id)
	{
	$sql = "
	SELECT *
	FROM subcomment AS sc
	JOIN subcommentanswer AS sca
	ON sc.cid = sca.answer_id
	
	WHERE sc.cid = ?
	";
	$params = array($id);
	
	$subcomment = $this->db->executeFetchAll($sql, $params);
	
	foreach($subcomment as $key => $value) {
		
		$res[] = $value;
		
	}
	
	
	}
	
	return $res;
	}
	
	
	
	
	//JOIN user as u
	//ON sca.user_id = u.id


public function getSubcomments($id){
  //WHERE type='comment';
  
  
	$sql = "
	SELECT *
	FROM comment
	JOIN subcomment
	ON comment.id = subcomment.comment_id
	INNER JOIN user 
	ON subcomment.user_id = user.id
	WHERE comment_id = ?
	AND type='comment'
	
	";
	$params = array($id);
	$subcomment = $this->db->executeFetchAll($sql, $params);

	return $subcomment;
}
public function getCommentId($commentId){
	
	$sql = "
	SELECT cid
	FROM subcomment
	WHERE comment_id = ?;
	
	";
	
	$params = array($commentId);
	$res = $this->db->executeFetchAll($sql, $params);
	
	return $res;



}



public function addSubcomment($id, $user, $content, $created, $type){

	$sql = "
	INSERT INTO subcomment (user_id, comment_id, content, created, type)
	VALUES (?,?,?,?, ?);
	";
	$params = array($user, $id, $content, $created, $type);
	$this->db->execute($sql, $params);
	
}

public function addSubcommentAnswer($id, $user, $content, $created, $name){
	
	$sql = "
	INSERT INTO subcommentanswer(user_id, answer_id, comment, created, name)
	VALUES (?,?,?,?, ?);
	";
	$params = array($user, $id, $content, $created, $name);
	$this->db->execute($sql, $params);
	

}

public function getUserComments($id){
	
	$res = $this->query() 
        ->where('user_id = ?') 
        ->execute([$id]);  
		return $res;
	
}

public function getUserSubcomments($id){

	$sql = "
	SELECT *
	FROM subcomment
	WHERE user_id = ?
	AND type = 'answer';
	";
	
	$params = array($id);
	$res = $this->db->executeFetchAll($sql,$params);
	return $res;

}
public function getUserCommentz($id) {
	
		$sql = "
	SELECT *
	FROM subcomment
	WHERE user_id = ?
	AND type = 'comment';
	";
	
	$params = array($id);
	$res = $this->db->executeFetchAll($sql,$params);
	return $res;


}



public function getTags(){

	/*$sql = "
	SELECT DISTINCT T.tag
	FROM tags AS T
	INNER JOIN comment2tag AS C2T
	ON T.id = C2T.idTag
	";*/
	
	$sql ="
	SELECT tag
	FROM tags
	";
	
	$res = $this->db->executeFetchAll($sql);
	return $res;

}

public function getQuestionsByTags($tag){
//GROUP_CONCAT(C.title) AS tag 
	$sql ="
	 SELECT 
		C.*
		FROM comment AS C
		LEFT OUTER JOIN comment2tag AS C2T
		  ON C.id = C2T.idComment
		INNER JOIN tags AS T
		  ON C2T.idTag = T.id
		  AND T.tag = ?;
		  ";
	$params = array($tag);
	$res = $this->db->executeFetchAll($sql, $params);
	return $res;
	

}
public function getTagId($tags){

	$sql ="
	SELECT id
	FROM tags
	WHERE tag = ?;
	";
	$params = array($tags);
	$res = $this->db->executeFetchAll($sql, $params);
	return $res;
	
	
}



public function saveTags($idComment, $tags){ 
	
	$taggar = explode(',', $tags);
	
	if($taggar != ""){
	foreach($taggar as $tag){
	 
	$res = $this->db->executeFetchAll('SELECT id FROM tags WHERE tag = ?', [$tag]); 
    $idTag = $res[0]->id; 
    $this->db->execute('INSERT INTO comment2tag (idComment, idTag) VALUES (?,?)', [$idComment, $idTag]); 
         
	}
	
	}
		
	

}
}
