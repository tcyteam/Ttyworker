function CreatElement(parent,tp,type,name,value)
{
   var divParent = document.getElementById(parent);
   var TempData = document.createElement(tp);
   TempData.setAttribute("type",type);
   TempData.setAttribute("name",name);
   TempData.setAttribute("value",value);
   divParent.appendChild(TempData); 
} 
function CreatElem(parent,tp,type,name)
{
   var divParent = document.getElementById(parent);
   var TempData = document.createElement(tp);
   TempData.setAttribute("type",type);
   TempData.setAttribute("name",name);
  divParent.appendChild(TempData);
} 
function limite(textarea,max)
{
	if(textarea.value.length >= max)
	{
		textarea.value = textarea.value.substring(0,max);
	}
	var reste = max - textarea.value.length;
	var affichage_reste = reste + ' caractères restants';
	document.getElementById('max_desc').innerHTML = affichage_reste;
}
/* Fonction chargement ajax avec animation, 
 * vous pouvez modifier la vitesse (slow, fast, 1500, ...) 
 * et l'effet (slideUp, fadeOut, ...) */
function ajax_page_advanced(ele,msg,url){
        $(ele).slideUp("slow", function(){
                $(ele).html(msg).show("slow", function(){
                        $(ele).load(url+" "+ele, null, function(){
                                var tampon = $(ele).html();
                                $(ele).html(msg).hide("slow",function(){
                                        $(ele).html(tampon);
                                        $(ele).slideDown("slow");
                                });
                        });
                });
        });
}
/* Fonction de chargement ajax simple */
function ajax_page(ele,msg,url){
        $(ele).html(msg).load(url+" "+ele);
}
/* Fonction de chargement ajax simple, mais avec un delai pour la demo */
function ajax_page_delayed(ele,msg,url){
	$(ele).html(msg);
	setTimeout(function(){
		$(ele).load(url);
	}, 1500)
}
function spam()
{
	document.getElementById('envois').style.visibility='hidden';
}
$(function() {
       	$("#helper").dialog({	
               width:'auto', 
   			height:'auto', 
   			position:'center', 
   			modal:true,
   			buttons:{ 
   			      "Connexion": function() {
   				         CreatElement("ids","input","hidden","adn","Connexion");
   			             jQuery("formulaire").submit();
   						 }
   					}	 
            });	
            //adn accordion
            $( "#adn_index" ).accordion({ autoHeight: false });
            $( ".tabs" ).tabs();
            $( "#accordion").accordion({ autoHeight: true });
            $( "#updatemember" ).accordion({ autoHeight: true });
            $( "#connect_menu" ).accordion({ autoHeight: false });
            $( "#updatedialog" ).dialog();
	        //Application du chargemetn ajax simple sur tous les liens se trouvant dans le conteneur "menu1"
	        $("a.info").click(function(){
	        });
            $("#group").tabs();
            $("#ids").formValidation({  
            alias       : "newpass",  
            required    : "accept",  
            err_list    : true  
            });
            
            jQuery("#update1").click(function() 
            { 
                $.post("/adn/updatemember");    
		    });
            //---------------------------------------
            
                        //Lien info click
            $(".info").submit(function() {
            s = $(this).serialize();
            $.ajax({
            type: "GET",
            data: s,
            url: $(this).attr("action"),
            success: function(retour){
            $("#messagerie").empty().append(retour);
            }
            });
            return false;
            });

});


