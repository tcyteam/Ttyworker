<?php $menu = new Menu();?>
<div id="sidebar">
			<ul>
				<li>
					<div id="search" >
					<form method="get" action="#">
						<div>
							<input type="text" name="s" id="search-text" value="" />
							<input type="submit" id="search-submit" value="GO" />
						</div>
					</form>
					</div>
					<div style="clear: both;">&nbsp;</div>
				</li>
				<li>
					<h2>Informations</h2>
					<p>Aucune version stable disponible pour BlogFrame.</p>
				</li>
				<li>
					<h2>Ttyworker</h2>
					<ul>
						<li><a href="#">Themes</a></li>
						<li><a href="#">Modules</a></li>
						<li><a href="#">Core add-on</a></li>
						<li><a href="#">Wiki</a></li>
					</ul>
				</li>
				<?php
				if($_SESSION['co'])
				{
				?>
				<li>
					<h2>Administration</h2>
					<ul class=class="adn_module">
						<?php
                        $menu->AdnConnectMenu();
						?>
					</ul>
				</li>				
				<?php	
				}
				else
				{
				
				?>
				<li>
					<h2>Connexion</h2>
					<ul>
					<div class="adn_module" >
						<?php
						$menu->AdnConnect();						
						?>
					</div>
					</ul>
				</li>
				<?php
				}
				?>
				<div style="clear: both;">&nbsp;</div>
				<li>
					<h2>Projets</h2>
					<ul>
						<li><a href="#">Tty cms</a></li>
						<li><a href="#">BlogFrame</a></li>
						<li><a href="#">Simple wiki</a></li>
					</ul>
				</li>
			</ul>
		</div>