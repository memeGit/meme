<?php
/*
 * Created on 2012-3-15
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require "config.php"
?>

<div id="headbar-wrap">
   <div id="searchbar_container">
		<div id="searchbar_wrapper">
			<div id="header_searchbar"  style="display:none;">
				<div id="search_wrapper">
					<form action="./search">
							<input id="sitebar_search_header" type="text" class="search search_input" name="query" tabindex="1" placeholder="Search"/>
					</form>
				</div>
			</div>
		</div>
		</div>

  <div id="head-bar">
                <h1><a class="snowman" href="./9gag_static/www.facebook.com/9gag" target="_blank" onclick="_gaq.push(['_trackEvent', 'Facebook-Page', 'Clicked', 'Nav', 1]);">Facebook</a><a href="default.htm">9GAG</a></h1>
				<ul class="main-menu" style="overflow:visible">
					<li><a class="current" href="./index.php"><?=$text_hot?></a></li>
										<li><a href="fast" onclick="_gaq.push(['_trackEvent', 'Lab', 'Clicked', 'Go', 1]); "><?=$text_fast?></a></li>
										<li><a class="add-post " href="submit.php" onclick="_gaq.push(['_trackEvent', 'New-Post', 'Clicked', 'Headbar', 1]);"><?=$text_upload?></a></li>
				</ul>
				<ul class="main-2-menu">
			<?//nemo
				if ($_Session['islogin']==1){
					echo '<li><a href="./login。php" class="button">Login</a></li>';

				}else{
					echo '<li><div id="profile-menu" class="profile-menu">
						<a id="profile-username" href="onedream87" class="profile-button">onedream87</a>
						<ul>
							<li><a href="./9gag_static/https@9gag.com/settings">控制面板</a></li>
							<li><a href="logout">退出</a></li>
						</ul>
						</div>
					</li>';
				}
				?>

					<li><a class="shuffle-button" href="random"><strong><?=$text_random?></strong></a></li>
					<li><a class="search-button search-toggler" href="javascript:void(0);"><strong>搜索</strong></a></li>

				</ul>


            </div><!--end div#head-bar -->
</div><!--end headbar-wrap-->
