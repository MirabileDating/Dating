

function getStates(country)
{
$(function(){
      var items="";

      $.getJSON("/dating/services/xml_zone_data.php?country="+country.value,function(data){
        $.each(data,function(index,item) 
        {
          items+="<option value='"+item.regionname+"'>"+item.regionname+"</option>";
        });
        $("#state").html(items); 
      });
    });
}

function getCities(country,state)
{
	
	$(function(){
	
	var srvc="/dating/services/xml_city_data.php?country="+country.value+"&state="+state.value;
      var items="";
      $.getJSON(srvc,function(data){
        $.each(data,function(index,item) 
        {
          items+="<option value='"+item.city+"'>"+item.city+"</option>";
        });
        $("#city").html(items); 
      });
    });
}
	


