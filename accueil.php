<?php
	require_once('services/services.php');

	verificationConnexion();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EBook createur Dal'Alu</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
     <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>		
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="accueil.php">DAL'ALU</a> 
            </div>
            <form method="post" action="services/services.php">
				<div style="color: white;	padding: 15px 50px 5px 50px; float: right;font-size: 16px;"> Bonjour <?php echo Session::getSession()->getPseudo() ?> &nbsp; 				
	    			<input type="hidden" name="deconnexion" value="deconnexion">
					<button type="submit" class="btn btn-danger square-btn-adjust">Déconnexion</button> 				
				</div>
			</form>
        </nav>   
           <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
					<li class="text-center">
	                    <img src="assets/img/find_user.png" class="user-image img-responsive"/>
					</li>					
                    <li>
                        <a class="active-menu"  href="index.html"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>	
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Gestion des ebooks</h2>   
                        <h5>Bonjour <?php echo Session::getSession()->getPseudo() ?>, à partir de cette interface vous pouvez gérer vos ebooks. </h5>                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
             <div class="panel-group" id="accordion"> 
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">Créer un E-book</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse in" style="height: auto;">
                    	<form id="formGenerateEbook" method="post" action="services/services.php" enctype="multipart/form-data">
                    		<input type="hidden" name="creation" value="creation">
	                        <div class="panel-body">
								<div class="form-group">
									<label>Titre de l'E-book</label>
									<input class="form-control" name="titre"/>
								</div>
								<div class="form-group">
									<label>Premiere de couverture</label>
									<input type="file" name="Page0" />
								</div>
								<div class="form-group">
									<label>Page 1</label>
									<input type="file" name="Page1"/>
								</div>
								<div id="pageAdded2" class="form-group">
									<label>Page 2</label>
									<input type="file" name="Page2"/>
								</div>
								<div class="form-group">
									<label>Derniere de couverture</label>
									<input type="file" name="PageEnd"/>
								</div>
								<button type="button" id="addPage" class="btn btn-default">Ajouter une page</button>
								<button type="button" id="removePage" class="btn btn-primary">Supprimer une page</button>	
								<div class="form-group" style="margin-top:20px;">
									<button id="generateEbook" type="button" class="btn btn-primary btn-lg col-md-2">
									  Générer l'E-book
									</button>
									<p class="text-danger col-md-10" id="generateError"></p>
									
								</div>							
							</form>							 
						</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Historique des E-books</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                        <?php
							$liste_ebooks = recupererListeEbook();			
							if(sizeof($liste_ebooks) > 0) {								
						?>
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>Titre</th>
										<th>Téléchargement</th>
										<th>Visualisation</th>
										<th>Supression</th>
									</tr>
								</thead>
								<tbody>	
									<?php										
										foreach($liste_ebooks as $ebook) {											
									?>								
									<tr class="odd">
										<td><?php echo $ebook->getTitre() ?></td>
										<td class="center">
											<form style="display:inline-block;" method="post" action="services/services.php" target="_blank">										
												<input type="hidden" name="pdf" value="<?php echo $ebook->getTitre() ?>">
												<button type="submit" class="btn btn-primary btn-xs">PDF</button>
											</form>
											<form style="display:inline-block;" method="post" action="services/services.php" target="_blank">											
												<input type="hidden" name="zip" value="<?php echo $ebook->getTitre() ?>">
												<button type="submit" class="btn btn-primary btn-xs">Ebook</button>
											</form>
										</td>
										<td class="center">
											<form method="post" action="services/services.php" target="_blank">
												<input type="hidden" name="lire_ebook" value="<?php echo $ebook->getTitre() ?>">
												<button type="submit" class="btn btn-success btn-xs">Visualiser</button>
											</form>
										</td>
										<td class="center">
											<form method="post" action="services/services.php">
												<input type="hidden" name="suppression" value="<?php echo $ebook->getTitre() ?>">
												<button type="submit" class="btn btn-danger btn-xs">Supprimer</button>
											</form>
										</td>
									</tr>		
									<?php
										}
									?>							
								</tbody>
							</table>
						</div>
						<?php
							} else {
						?>
						<div class="col-md-12">
							Aucun ebook n'a été créé.
						</div>
						<?php
							} 
						?>
						</div>
                    	</div>
                	</div>
				</div>
    		</div>						
     <!-- /. PAGE INNER  -->
    	</div>
 <!-- /. PAGE WRAPPER  -->
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-show="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Création de l'ebook</h4>
				</div>
				<div class="modal-body">
					Félicitation ! Votre ebook a bien été créé.
				</div>
				<div class="modal-footer">
					<form method="post" action="services/services.php" target="_blank">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>					
						<input type="hidden" name="lire_ebook" value="<?php echo $_GET[Parametres::SERVICE_EBOOK_CREE_NOM] ?>">
						<button type="submit" class="btn btn-primary">Visualiser</button>
					</form>
				</div>
			</div>
		</div>
	</div>	
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>

    <script src="assets/js/accueil.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>   
    <?php
		if(!empty($_GET[Parametres::SERVICE_EBOOK_CREE])) {
			echo '<input type="hidden" name="ebookCreate" value="true">';
		} else {
			echo '<input type="hidden" name="ebookCreate" value="false">';
		}
	?>
</body>
</html>
