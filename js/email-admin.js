var weu = jQuery.noConflict();



weu(document).ready(function (){



   var table = weu('#example').DataTable({



     "lengthMenu": [ 10, 25, 50, 75, 100, 500, 1000, 2000 ],



   }); // for default table



   var table1 = weu('#example1').DataTable({



     "lengthMenu": [ 10, 25, 50, 75, 100, 500, 1000, 2000 ],



   }); // for table 1



    var table2 = weu('#example2').DataTable({



     "lengthMenu": [ 10, 25, 50, 75, 100, 500, 1000, 2000 ],



   }); // for table 2


    var table4 = weu('.data_list').DataTable({

           "lengthMenu": [ 10, 25, 50, 75, 100, 500, 1000, 2000 ],
      });



    var table3 = weu('.data_expo').DataTable({

     "lengthMenu": [ 10, 25, 50, 75, 100, 500, 1000, 2000 ],
      dom: 'Bfrtip',
        buttons: [

        {
                extend: 'copy',
                exportOptions: {
                    columns: [ 1, 2 ]
                },
                text: 'Copy <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>'
            },

        {
                extend: 'csv',
                exportOptions: {
                    columns: [ 1, 2 ]
                }
            },

             'excel', 

            {
                extend: 'print',
                exportOptions: {
                    columns: [ 1, 2 ]
                }
            }
      ],

    }); // for table 3


   var table4 = weu('#example4').DataTable({



     "lengthMenu": [ 10, 25, 50, 75, 100, 500, 1000, 2000 ],



   }); // for table 4



   var table5 = weu('#example5').DataTable({



     "lengthMenu": [10, 25, 50, 75, 100, 500, 1000, 2000 ],
     "order": [[ 6, "desc" ]],



   }); // for table 5


    weu('#example1_wrapper').hide();



   // Handle click on "Select all" control



    weu('#example-select-all').on('click', function(){



      // Check/uncheck all checkboxes in the table



      var rows = table.rows({ 'search': 'applied' }).nodes();



      weu('input[type="checkbox"]', rows).prop('checked', this.checked);



    });



    weu('#example-csv-select-all').on('click', function(){



      // Check/uncheck all checkboxes in the table



      var rows_csv = table1.rows({ 'search': 'applied' }).nodes();



      weu('input[type="checkbox"]', rows_csv).prop('checked', this.checked);



    });



    //csvlist



    weu('#example-select-all-import').on('click', function(){



      // Check/uncheck all checkboxes in the table



      var rows_csvlist = table2.rows({ 'search': 'applied' }).nodes();



      weu('input[type="checkbox"]', rows_csvlist).prop('checked', this.checked);



    });



    weu('#example-select-all-export').on('click', function(){



      // Check/uncheck all checkboxes in the table



      var rows_csvlist = table3.rows({ 'search': 'applied' }).nodes();



      weu('input[type="checkbox"]', rows_csvlist).prop('checked', this.checked);



    });


    weu('#example-responder').on('click', function(){



      // Check/uncheck all checkboxes in the table



      var rows_responder = table4.rows({ 'search': 'applied' }).nodes();



      weu('input[type="checkbox"]', rows_responder).prop('checked', this.checked);



    });



    // conformation prompt

    weu('.delete-email-indi').on('click', function(){

        if (confirm('This will also delete subscribers associated with this list. Are you sure want to delete list?')) {

            var CurrList = weu(this).val();

            weu('#delete-email-indi').val(CurrList);

            return true;

        } else {

            return false;

        }

    });



        // conformation prompt

    weu('.delete-member-indi').on('click', function(){

        if (confirm('Are you sure want to delete member?')) {

            return true;

        } else {

            return false;

        }

    });



    // Delete CSV File



    weu('.editor_remove').on('click', function(){



    var agree=confirm('Are you sure you want to delete this item?');



    if(agree){



    var csv_row = weu(this).parents('tr').find('.weu_csv').val();



    var data = {



      'key': 'delete',



      'del_csv' : 'del_csv',



      'action': 'weu_my_csv_action',



      'csv_file_title': csv_row



    };



    weu.post(ajaxurl, data, function(response){



      location.reload();



    });



  }



});



/*Edit csv*/



jQuery('.editor_edit').on('click', function(){



  var csv_row = jQuery(this).parents('tr').find('.weu_csv').val();



  jQuery('#weu_temp_update').val(csv_row);



    var data = {



      'key': 'edit',



      'edit_csv' : 'edit_csv',



      'action': 'weu_my_csv_action',



      'csv_file_title': csv_row



    };



    jQuery.post(ajaxurl, data, function(response){



    jQuery('#csv_textarea').html(response);



    });



})


// update CSV File



    weu('#editor_update').on('click', function(){



    var update_val = weu('#csv_textarea').val();



    var csv_row = weu('#weu_temp_update').val();


    var data = {



      'key': 'update',



      'update_csv' : 'update_csv',



      'update_val' : update_val,



      'action': 'weu_my_csv_action',



      'csv_file_title': csv_row



    };



    weu.post(ajaxurl, data, function(response){



     weu('#csv_textarea').val(response);



    });


});



function isUrl(s) {



   var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/



   return regexp.test(s);



}



//for wp email user



weu('#wau_template').change(function(){



var filename_id = weu('#wau_template').val();



var TemplateName = weu(this).val();



if( filename_id > 0 || filename_id != TemplateName ){



var data = {



      'temp_key' : 'template',



      'temp_sel_key': 'select_temp',



      'action': 'weu_my_action',



      'filetitle': filename_id



    };



weu.post(ajaxurl, data, function(response){



      tinyMCE.activeEditor.setContent(response);



});



}

if( isUrl(filename_id) ){



 weu.get(filename_id,function( data ){


    tinymce.init({selector:'textarea'});
    tinymce.activeEditor.setContent(data);


  });



}

});



// for template page



weu('#wau_template_single').click(function(){



var filename_id = weu('#wau_template_single').val();



var TemplateName = weu(this).val();



if(filename_id > 0 || filename_id != TemplateName){



var data = {



      'temp_key' : 'template',



      'temp_sel_key': 'select_temp',



      'action': 'weu_my_action',



      'filetitle': filename_id



    };



    weu.post(ajaxurl, data, function(response){



     tinyMCE.activeEditor.setContent(response);



  });



}



if( isUrl(filename_id) ){



  weu.get(filename_id,function( data ){



      tinyMCE.activeEditor.setContent(data);



  });



}



});



/*for Autoresponder Page Template Send Email for */



weu('#email_role').click(function(){



var filename_id = weu('#email_role').val();



if(filename_id=='5-User Role Changed' || filename_id=='4-Password Reset'){



        weu('#drop_hide').hide();



        weu('#example4_wrapper').hide();



        weu('#wau_user_responder').hide();



}



else{



        weu('#drop_hide').show();



        weu('#example4_wrapper').show();

}



});

//});



/*--End---*/

// for template delete



weu('#weu_delete_template').click(function(){



var filename_id = weu('#wau_template_single').val();



var data = {



      'temp_key' : 'template',



      'action': 'weu_my_action',



      'temp_del_key': 'delete_temp',



      'filetitle': filename_id



    };



    weu.post(ajaxurl, data, function(response){



      tinyMCE.activeEditor.setContent(response);



  });



});



});

function checkFunction(){
var group = document.myform.toggler;

  for (var i = 0; i < group.length; i++) {



        if (group[i].checked)



            break;

    }

    if (i == group.length)



        return alert("No radio button is checked");



    var radio_value = i + 1;


    if (radio_value == 1) {

      weu('#blk-1').show();

      weu('#blk-2').hide();

      weu('#blk-3').hide();

      weu('#save_temp').val('1');

      //weu('#temp_name_req').prop('required', false);

      return false;


    }
    else if(radio_value == 2)
    {

      weu('#blk-1').hide();

      weu('#blk-2').show();

      weu('#blk-3').hide();

      weu('#save_temp').val('2');

      //weu('#temp_name_req').prop('required', true);

    }
    else
    {

      weu('#blk-1').hide();

      weu('#blk-2').hide();

      weu('#blk-3').show();

      //weu('#temp_name_req').prop('required', false);

      weu('#save_temp').val('3');

    }




}


weu(document).ready(function(){
  weu('.dt-buttons').prepend("<span class='export-text'>Export To: </span>");
});

function radioFunction(){

    var group = document.myform.rbtn;
    


    for (var i = 0; i < group.length; i++) {



        if (group[i].checked)

            break;

    }


    if (i == group.length)



        return alert("No radio button is checked");



    var radio_value = i + 1;



    if (radio_value == 1) {



       weu('.wau_user_toggle').show();



        weu('#example_wrapper').show();



        weu('#example1_wrapper').hide();



        weu('#wau_user_role').hide();

        weu('#nickname').show();

        weu('#lname').show();

        weu('#dname').show();




        return false;



    }else if(radio_value == 2) {


        weu('.wau_user_toggle').hide();



        weu('#wau_user_role').show();

        weu('#nickname').show();

        weu('#lname').show();

        weu('#dname').show();




    }



    else {



       weu('#example_wrapper').hide();



       weu('#wau_user_role').hide();



        weu('.wau_user_toggle').show();


        weu('#example1_wrapper').show();

        weu('#nickname').hide();

        weu('#lname').hide();

        weu('#dname').hide();


    }

}



/*csv Page*/



function radioFunction_csv(){



   weu('#wau_role_csv').hide();



    var group_csv = document.export_form.rbtn_csv;



    for (var i = 0; i < group_csv.length; i++) {



        if (group_csv[i].checked)



            break;



    }



    if (i == group_csv.length)



        return alert("No radio button is checked");



    var radio_value = i + 1;



    if (radio_value == 1) {



        weu('#example3_wrapper').show();


        return false;



    }else if(radio_value == 2) {



        weu('#example3_wrapper').hide();



        weu('#wau_role_csv').show();



    }



}


/*Autoresponder Email Page Radio Button function*/



function radioFunction_responder(){



   weu('#wau_user_responder').hide();



    var group_csv = document.autoresponder.rbtn_respond;



    for (var i = 0; i < group_csv.length; i++) {



        if (group_csv[i].checked)



            break;



    }



    if (i == group_csv.length)



        return alert("No radio button is checked");



    var radio_value = i + 1;



    if (radio_value == 1) {



       weu('.wau_user_toggle').show();



       // weu('#example4_wrapper').show();



        return false;



    }else if(radio_value == 2) {



        weu('.wau_user_toggle').hide();



        weu('#wau_user_responder').show();



    }



}

/*----------End-------------*/

/* onsubmit validate function-main Page  */

var testresults
function checkemail(){
var str=document.myform.wau_from_email.value
var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
if (filter.test(str)){
  document.getElementById('errfn').innerHTML="";

testresults=true
}
else{

  document.getElementById('errfn').innerHTML="Please enter a valid email address!";
testresults=false
}
return (testresults)
}


function myFunction(){

  if (document.layers||document.getElementById||document.all)
return checkemail()
else
  document.getElementById('errfn').innerHTML="";
return true
}

    function validation() {


      var radio_val = weu('input[name=toggler]:checked', '#myForm').val(); 

      if(radio_val == 2){

      var wau_template = document.getElementById("wau_template");
        if (wau_template.value == "") {
            //If the "Please Select" option is selected display error.
            document.getElementById('errfn1').innerHTML="Please choose email template!";
            return false;
        }
      }else if(radio_val == 1){

        var temp_name_req = document.getElementById("temp_name_req");
        if (temp_name_req.value == "") {
            //If the "Please Select" option is selected display error.
            document.getElementById('errfn1').innerHTML="Please enter template name!";
            return false;
        }
      }


      /*-------------------User-------------------*/
    var user_val=weu('#user_role').prop( "checked" );

    var chk_val=weu('.select-all:checked').index();

    if(chk_val== -1 && user_val== true){

        document.getElementById('errfn1').innerHTML="Please choose atleast One User!";

        return false;
    }
    else
     {
                document.getElementById('errfn1').innerHTML="";
     }

      /*-------------------End-------------------*/

      /*-------------------Role-------------------*/

    var role_val = weu('#r_role').prop( "checked" );

    var wau_role=weu('#wau_role option:selected').index();

    if(role_val== true && wau_role == 0){

        document.getElementById('errfn1').innerHTML="Please choose atleast oneUser role!";

         return false;

     }
     else
     {
                document.getElementById('errfn1').innerHTML="";
     }

      /*-------------------End-------------------*/

      /*-------------------List-------------------*/

    var wau_list=weu('#check_list').prop("checked");

    var csv_val = weu('.select-all:checked').index();

    if(csv_val== -1 && wau_list == true){

        document.getElementById('errfn1').innerHTML="Please choose atleast one Subscribers list!";

         alert("Please choose atleast one Subscribers list!");

         return false;
     }
     else
     {
                document.getElementById('errfn1').innerHTML="";
     }

      /*-------------------End-------------------*/
}



/* Autoresponder Email send Page */



 function validation_responder() {



    var user_val=weu('#user_role_email').prop( "checked" );



    var chk_val=weu('.select-all:checked').index();



    if(chk_val== -1 && user_val== true){



    }



    var role_val = weu('#r_role_email').prop( "checked" );



    var wau_role=weu('#wau_role option:selected').index();



    if(role_val== true && wau_role == 0){



     }

}


/*end*/