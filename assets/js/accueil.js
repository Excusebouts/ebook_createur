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

    $('#addPage').click(function() {    	    	
    	Page.addPage();  	
	});

	$('#removePage').click(function() {    	    	
    	Page.removePage();  	
	});
});

