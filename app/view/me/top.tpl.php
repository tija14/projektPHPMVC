<?php if($this->session->get('userId')): ?>

<a href="<?=$this->url->create('login/logout')?>">Logga ut |</a>
<?php $id = $this->session->get('userId');?>
<a href="<?=$this->url->create('users/profile/'.$id)?>">Profil </a>
<?php endif; ?> 
<?php if(!$this->session->get('userId')) : ?>
<a href="<?=$this->url->create('login/login')?>">Logga in |</a>
<a href="<?=$this->url->create('login/add')?>">Registera dig</a>

           
<?php endif; ?>