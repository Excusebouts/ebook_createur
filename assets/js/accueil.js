$(document).ready(function() {

	var Page = {
		blocAddPage : new String(),	
		lastPage : $('#pageAdded2'),
		idNewPage : 'pageAdded',
		namePage : 'Page',
		nbPage : 2,

		addPage : function() {			
			this.nbPage++;
			this.generateBlocPage();			
			this.lastPage.after(this.blocAddPage);			
			this.prepareNextPage();
		},

		removePage : function() {
			if(this.nbPage > 2) {
				this.nbPage--;
				this.lastPage.remove();
				this.prepareNextPage();
			}
		},

		generateBlocPage : function() {
			this.blocAddPage += '<div id="';
			this.blocAddPage += this.idNewPage+this.nbPage;
			this.blocAddPage += '" class="form-group"><label>';		
			this.blocAddPage += this.namePage;
			this.blocAddPage += ' ';
			this.blocAddPage += this.nbPage;
			this.blocAddPage += '</label>';
			this.blocAddPage += '<input type="file" name="';
			this.blocAddPage += this.namePage;
			this.blocAddPage += this.nbPage;
			this.blocAddPage += '"/></div>';
		},

		prepareNextPage : function() {
			this.lastPage = $('#'+this.idNewPage+this.nbPage);	
			this.blocAddPage = '';
		}
	}

	function validateExtension(value) {
		return value.indexOf('.jpg') != -1 || value.indexOf('.png') != -1;
	}

	function validateTitle(title) {
		var reg = new RegExp("\\w");		
		return reg.test(title);
	}

	function validateForm(blocError) {
		var formValid = true;

		var inputTitle = $("input[name='titre']");
		var inputPage0 = $("input[name='Page0']");
		var inputPage1 = $("input[name='Page1']");
		var inputPage2 = $("input[name='Page2']");
		var inputPageEnd = $("input[name='PageEnd']");

		if(inputTitle.val() == "" || !validateTitle(inputTitle.val())){
			inputTitle.parent().addClass('has-error');			
			blocError.append('Le champ Titre est incorrect');			
			formValid = false;
		} else {	
			inputTitle.parent().removeClass('has-error');
			inputTitle.parent().addClass('has-success');	

			var inputsPage = $("input:file");

			for(var i=0 ; i < inputsPage.length; i++) {			
				if($(inputsPage[i]).val() == "") {
					blocError.append('Une image est manquante pour générer l\'ebook');
					formValid = false;				
					return;
				} else if(!validateExtension($(inputsPage[i]).val().toLowerCase())) {					
					blocError.append('Le format d\'une des images ajoutées n\'est pas correct. Veuillez utiliser une image du type jpg ou png');	
					formValid = false;
					return;
				}
			}
		}	
		
		return formValid;
	}

    $('#addPage').click(function() {    	    	
    	Page.addPage();  	
	});

	$('#removePage').click(function() {    	    	
    	Page.removePage();  	
	});

	$('#generateEbook').click(function() {
		var blocError = $('#generateError');
		blocError.html('');	

		if(validateForm(blocError) == true) {
			$('#formGenerateEbook').submit();
		}		
	})	

	if($("input[name='ebookCreate']").val() == "true") {
		$("#myModal").modal("show");
	}
});
