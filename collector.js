$(document).ready(function(){
   var url = "http://localhost:80/mooculus.php";
   var startcoord;
   var endcoord;
   var testboxval;
   
   console.log("In collector");

   $("#hover").hover(
    function(e){
   	  var startleft = e.pageX - this.offsetLeft;
   	  var starttop = e.pageY- this.offsetTop;
   	  startcoord = startleft+', '+ starttop;
      $('#status2').html(startcoord);
    },
    function(e){
     	var endleft = e.pageX - this.offsetLeft;
     	var endtop = e.pageY - this.offsetTop;
     	endcoord = endleft+', '+endtop;
     	$('#status2').append(':'+ endcoord);
      var a = {};
      a['eventtype'] = "mouse";
      a['start'] = startcoord;
      a['end'] = endcoord;
      a['id'] = id;

      //alert(a.eventtype);
	    $.ajax(
      {
  	    type: "POST",
  	    url: url,
  	    //contentType: "application/json",
  	    data: a
      }
      ).done(function(eventtype){
        $("#msg").html(eventtype /*+"\nStart :"+ start +"\nEnd :"+ end*/);
      });
   }
   );

   $("#testbox").focus(function(){
      testboxval = $(this).val();
    });

   $("#testbox").blur(function(){
      if($(this).val() != testboxval)
      {
      var a = {};
      a['eventtype'] = "keyboard";
      a['old'] = testboxval;
      a['new'] = $(this).val();
      a['id'] = id;
      }
      $.ajax(
      {
        type: "POST",
        url: url,
        //contentType: "application/json",
        data: a
      }
      ).done(function(eventtype){
        $("#msg").html(eventtype /*+"\nStart :"+ start +"\nEnd :"+ end*/);
      });
    });

});