<h1>BIENVENUE SUR LE FORUM</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<p> Hello <?php if(App\Session::getUser()) { echo App\Session::getUser()->getNickName(); }?></p>

<p> Role : <?php if(App\Session::getUser()) { echo App\Session::getUser()->getRole(); }?></p><br>

<a href="index.php?ctrl=forum&action=index">Liste des catégories</a>